<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fine;
use App\Models\Loan;
use Illuminate\Support\Carbon;

class FineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reasons = ['retraso', 'daño', 'pérdida'];

        // Obtener préstamos retrasados
        $delayedLoans = Loan::where('status', 'retrasado')->get();

        foreach ($delayedLoans as $loan) {
            $daysLate = Carbon::parse($loan->expected_return_date)->diffInDays(Carbon::now());
            $amount = $daysLate * 1.5; // $1.50 por día de retraso

            Fine::create([
                'loan_id' => $loan->id,
                'amount' => $amount,
                'reason' => 'retraso',
                'generation_date' => Carbon::now()->subDays(rand(1, 10)),
                'payment_date' => rand(0, 1) ? Carbon::now() : null, // 50% pagadas
            ]);
        }

        // Obtener algunos préstamos devueltos para multas por daño
        $returnedLoans = Loan::where('status', 'devuelto')
            ->take(10)
            ->get();

        foreach ($returnedLoans as $loan) {
            $reason = $reasons[array_rand($reasons)];

            // Montos según el tipo de razón
            $amount = match ($reason) {
                'daño' => rand(10, 50),
                'pérdida' => rand(50, 200),
                default => 0,
            };

            if ($amount > 0) {
                Fine::create([
                    'loan_id' => $loan->id,
                    'amount' => $amount,
                    'reason' => $reason,
                    'generation_date' => Carbon::parse($loan->return_date),
                    'payment_date' => rand(0, 2) ? Carbon::parse($loan->return_date)->addDays(rand(1, 15)) : null, // 66% pagadas
                ]);
            }
        }
    }
}
