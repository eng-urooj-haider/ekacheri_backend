<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Complaint;
use App\Models\Ekachehri;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function dashboardStats(): JsonResponse
    {
        $totalKachehri = Ekachehri::count();

        $kachehriThisMonth = Ekachehri::whereBetween('created_at', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth(),
        ])->count();

        $totalComplaint = Complaint::count();

        $complaintThisMonth = Complaint::whereBetween('created_at', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth(),
        ])->count();

        return response()->json([
            'total_kachehri' => $totalKachehri,
            'kachehri_this_month' => $kachehriThisMonth,
            'total_complaint' => $totalComplaint,
            'complaint_this_month' => $complaintThisMonth,
        ]);
    }

    public function kachehriMonthly(): JsonResponse
    {
        $year = Carbon::now()->year;

        // Count kachehris per month for the current year, grouped by month number (1-12)
        $counts = Ekachehri::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->pluck('total', 'month'); // e.g. [1 => 8, 3 => 4, 7 => 12, ...]

        $data = $this->fillMonths($counts);

        return response()->json($data);
    }

    public function complaintMonthly(): JsonResponse
    {
        $year = Carbon::now()->year;

        // Count complaints per month for the current year, grouped by month number (1-12)
        $counts = Complaint::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->pluck('total', 'month');

        $data = $this->fillMonths($counts);

        return response()->json($data);
    }
    public function complaintStatus(): JsonResponse
    {
        $year = Carbon::now()->year;

        // Count complaints per month for the current year, grouped by month number (1-12)
        $openCounts = Complaint::where('status', 'Open')->count();
        $closeCounts = Complaint::where('status', 'Close')->count();


        return response()->json([
            'openCount' => $openCounts,
            'closeCounts' => $closeCounts
        ]);
    }
    public function totalCity(): JsonResponse
    {
        $city = City::count();
        return response()->json([
            'city' => $city,
        ]);
    }
    public function totalDfp(): JsonResponse
    {
        $dfp = User::where('roleId', 2)->count();
        return response()->json([
            'dfp' => $dfp,
        ]);
    }
    public function activeAnnouncement(): JsonResponse
    {
        $ekachehri = Ekachehri::latest()->first();

        return response()->json([
            'ekachehri' => 'SSGC E-KACHERI (' .
                Carbon::parse($ekachehri->kachehri_date)->format('l, F j, Y') .
                ')',
        ]);
    }
    public function getUser(): JsonResponse
    {
        $user = auth()->user()->name;

        return response()->json([
            'user' => $user
        ]);
    }
    /**
     * Fill in every month (1-12), even ones with zero count, so charts
     * always get exactly 12 data points instead of skipping empty months.
     */
    private function fillMonths($counts)
    {
        $monthLabels = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'May',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Aug',
            9 => 'Sep',
            10 => 'Oct',
            11 => 'Nov',
            12 => 'Dec',
        ];

        return collect($monthLabels)->map(function ($label, $monthNumber) use ($counts) {
            return [
                'month' => $label,
                'value' => $counts->get($monthNumber, 0),
            ];
        })->values();
    }
}
