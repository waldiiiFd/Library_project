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
}
