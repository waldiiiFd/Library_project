<?php

namespace App\Services;

use App\Models\Book;
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
}
