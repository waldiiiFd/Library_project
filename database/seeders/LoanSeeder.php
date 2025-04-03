<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Loan;
use App\Models\User;
use App\Models\Book;
use Illuminate\Support\Carbon;

class LoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('active', true)
            ->whereIn('type', ['estudiante', 'externo', 'docente'])
            ->get();

        $books = Book::all();
        $statusOptions = ['activo', 'devuelto', 'retrasado'];

        // Crear 100 préstamos
        for ($i = 0; $i < 100; $i++) {
            $user = $users->random();
            $book = $books->random();

            $loanDate = Carbon::now()->subDays(rand(1, 120));
            $expectedReturnDate = Carbon::parse($loanDate)->addDays(rand(7, 30));

            $status = $statusOptions[array_rand($statusOptions)];
            $returnDate = null;

            // Si el préstamo está devuelto, asignar fecha de devolución
            if ($status === 'devuelto') {
                $returnDate = Carbon::parse($expectedReturnDate)->subDays(rand(0, 5));
            }
            // Si el préstamo está retrasado, no hay fecha de devolución
            else if ($status === 'retrasado') {
                $expectedReturnDate = Carbon::now()->subDays(rand(1, 30));
            }

            Loan::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
                'loan_date' => $loanDate,
                'expected_return_date' => $expectedReturnDate,
                'return_date' => $returnDate,
                'status' => $status,
            ]);
        }
    }
}
