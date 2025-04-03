<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Book;
use Illuminate\Support\Carbon;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('active', true)
            ->whereIn('type', ['estudiante', 'docente', 'externo'])
            ->get();

        $books = Book::all();
        $statusOptions = ['pendiente', 'completada', 'cancelada'];

        // Crear 50 reservaciones
        for ($i = 0; $i < 50; $i++) {
            $user = $users->random();
            $book = $books->random();

            $status = $statusOptions[array_rand($statusOptions)];

            // Determinar la fecha de reserva según el estado
            if ($status === 'pendiente') {
                $reservationDate = Carbon::now()->addDays(rand(1, 30));
            } else {
                $reservationDate = Carbon::now()->subDays(rand(1, 60));
            }

            Reservation::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
                'reservation_date' => $reservationDate,
                'status' => $status,
            ]);
        }
    }
}
