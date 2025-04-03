<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportService
{
    /**
     * Obtener los libros más populares en el último mes
     *
     * @return array
     */
    public function getPopularBooks(): array
    {
        $lastMonth = Carbon::now()->subMonth();

        $popularBooks = Book::select(
            'books.id',
            'books.title',
            'books.isbn',
            DB::raw('COUNT(loans.id) as loan_count')
        )
            // ---------------------------------------------------------------
            // JOIN books → loans: Conexión clave para contar préstamos por libro
            //
            // Estructura básica:
            // ->join('tabla_a_unir', 'tabla_origen.columna', '=', 'tabla_destino.columna')
            //
            // Componentes:
            // 1. 'loans' - Tabla de préstamos a relacionar
            // 2. 'books.id' - PK (Identificador único del libro)
            // 3. '=' - Operador que exige coincidencia exacta
            // 4. 'loans.book_id' - FK que referencia al libro prestado
            //
            // Relación resultante:
            // 1 libro → puede tener → múltiples préstamos (relación 1:N)
            //
            // Tipo de JOIN:
            // INNER JOIN (solo libros con préstamos registrados)
            //    - Excluye automáticamente libros sin préstamos
            //    - Para incluirlos: usar leftJoin()
            //
            // Equivalente SQL:
            // INNER JOIN loans ON books.id = loans.book_id
            // ---------------------------------------------------------------
            ->join('loans', 'books.id', '=', 'loans.book_id')
            ->where('loans.loan_date', '>=', $lastMonth)
            ->groupBy('books.id', 'books.title', 'books.isbn')
            ->orderByDesc('loan_count')
            ->get()
            ->map(function ($book) {

                return [
                    'id' => $book->id,
                    'title' => $book->title,
                    'isbn' => $book->isbn,
                    'loan_count' => $book->loan_count,
                ];
            })
            ->toArray();

        return $popularBooks;
    }

    /**
     * Obtener usuarios con multas pendientes
     *
     * @return array
     */
    public function getUsersWithFines(): array
    {
        $usersWithFines = User::select(
            'users.id',
            'users.code',
            'users.name',
            'users.email',
            DB::raw('COUNT(fines.id) as fine_count'),
            DB::raw('SUM(fines.amount) as total_amount')
        )
            ->join('loans', 'users.id', '=', 'loans.user_id')
            ->join('fines', 'loans.id', '=', 'fines.loan_id')
            ->whereNull('fines.payment_date')
            ->groupBy('users.id', 'users.code', 'users.name', 'users.email')
            ->orderByDesc('total_amount')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'code' => $user->code,
                    'name' => $user->name,
                    'email' => $user->email,
                    'fine_count' => $user->fine_count,
                    'total_amount' => $user->total_amount,
                    'total_formatted' => '$' . number_format($user->total_amount, 2),
                ];
            })
            ->toArray();

        return $usersWithFines;
    }

    /**
     * Obtener estadísticas de préstamos por categoría
     *
     * @return array
     */
    public function getLoansByCategory(): array
    {
        $loansByCategory = Category::select(
            'categories.id',
            'categories.name',
            DB::raw('COUNT(loans.id) as loan_count')
        )
            ->join('book_category', 'categories.id', '=', 'book_category.category_id')
            ->join('books', 'book_category.book_id', '=', 'books.id')
            ->join('loans', 'books.id', '=', 'loans.book_id')
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('loan_count')
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'loan_count' => $category->loan_count,
                ];
            })
            ->toArray();

        return $loansByCategory;
    }

    /**
     * Analizar eficiencia de devoluciones por categoría
     *
     * @return array
     */
    /**
     * Analizar eficiencia de devoluciones por categoría
     *
     * @return array
     */
    public function getReturnEfficiency(): array
    {
        $returnEfficiency = Category::select(
            'categories.id',
            'categories.name',
            DB::raw('SUM(CASE WHEN loans.return_date <= loans.expected_return_date THEN 1 ELSE 0 END) as on_time_returns'),
            DB::raw('SUM(CASE WHEN loans.return_date > loans.expected_return_date THEN 1 ELSE 0 END) as late_returns'),
            DB::raw('COUNT(loans.id) as total_returns')
        )
            ->join('book_category', 'categories.id', '=', 'book_category.category_id')
            ->join('books', 'book_category.book_id', '=', 'books.id')
            ->join('loans', 'books.id', '=', 'loans.book_id')
            ->whereNotNull('loans.return_date')
            ->groupBy('categories.id', 'categories.name')
            ->get()
            ->map(function ($category) {
                $efficiencyPercentage = $category->total_returns > 0
                    ? ($category->on_time_returns / $category->total_returns) * 100
                    : 0;

                return [
                    'category' => $category->name,
                    'on_time_returns' => (int)$category->on_time_returns,
                    'late_returns' => (int)$category->late_returns,
                    'efficiency_percentage' => number_format($efficiencyPercentage, 2) . '%'
                ];
            })
            ->toArray();

        return $returnEfficiency;
    }
}
