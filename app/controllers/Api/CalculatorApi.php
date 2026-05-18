<?php
namespace App\Controllers\Api;

use App\Core\Controller;

final class CalculatorApi extends Controller
{
    /** EMI = P * r * (1+r)^n / ((1+r)^n - 1) */
    public function emi(): void
    {
        $r = $this->request->all();
        $principal = (float)($r['principal'] ?? 0);
        $rate      = (float)($r['rate']      ?? 0) / 12 / 100;
        $months    = (int)($r['years'] ?? 0) * 12;

        if ($principal <= 0 || $rate <= 0 || $months <= 0) {
            $this->json(['ok' => false, 'message' => 'Invalid input'], 422);
        }

        $emi   = $principal * $rate * pow(1 + $rate, $months) / (pow(1 + $rate, $months) - 1);
        $total = $emi * $months;
        $this->json([
            'ok'         => true,
            'emi'        => round($emi),
            'totalPaid'  => round($total),
            'totalInterest' => round($total - $principal),
            'principal'  => $principal,
        ]);
    }

    /** Simple compound ROI projection */
    public function roi(): void
    {
        $r = $this->request->all();
        $invest = (float)($r['investment'] ?? 0);
        $apprec = (float)($r['appreciation'] ?? 8) / 100;
        $rental = (float)($r['rental_yield'] ?? 3) / 100;
        $years  = (int)($r['years'] ?? 5);

        if ($invest <= 0) $this->json(['ok' => false, 'message' => 'Invalid input'], 422);

        $futureValue = $invest * pow(1 + $apprec, $years);
        $rentalIncome = $invest * $rental * $years;
        $totalReturn  = $futureValue + $rentalIncome - $invest;

        $this->json([
            'ok' => true,
            'futureValue'  => round($futureValue),
            'rentalIncome' => round($rentalIncome),
            'totalReturn'  => round($totalReturn),
            'cagr'         => round((pow(($futureValue + $rentalIncome) / $invest, 1 / $years) - 1) * 100, 2),
        ]);
    }
}
