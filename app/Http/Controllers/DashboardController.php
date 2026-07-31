<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Complaint;
use App\Models\Ekachehri;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    /**
     * Combined dashboard endpoint — returns everything the dashboard needs
     * in a single response instead of 6 separate requests. Reuses the same
     * query logic as the individual endpoints below (kept for backward
     * compatibility / other consumers if needed).
     */
    public function overview(): JsonResponse
    {
        return response()->json([
            'stats' => $this->buildStats(),
            'kachehriMonthly' => $this->buildMonthly(Ekachehri::class),
            'complaintMonthly' => $this->buildMonthly(Complaint::class),
            'complaintStatus' => $this->buildComplaintStatus(),
            'city' => City::count(),
            'dfp' => User::where('roleId', 2)->count(),
        ]);
    }

    public function dashboardStats(): JsonResponse
    {
        return response()->json($this->buildStats());
    }

    public function kachehriMonthly(): JsonResponse
    {
        return response()->json($this->buildMonthly(Ekachehri::class));
    }

    public function complaintMonthly(): JsonResponse
    {
        return response()->json($this->buildMonthly(Complaint::class));
    }

    public function complaintStatus(): JsonResponse
    {
        return response()->json($this->buildComplaintStatus());
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
        $user = auth()->user();

        return response()->json([
            'user' => $user
        ]);
    }

    public function verifyCustomer(Request $request)
    {
        $customerNumber = $request->input('customer_number');

        $response = \Illuminate\Support\Facades\Http::get(
            "https://viewbill.ssgc.com.pk/web/check_cust_number.php",
            ['q' => $customerNumber]
        );

        return response()->json($response->json());
    }

    public function complaintReopen($id)
    {
        $kachehri = Ekachehri::find($id);

        if (!$kachehri) {
            return response()->json([
                'message' => 'E-Kachehri not found.',
            ], 404);
        }

        $kachehri->update([
            'complaint_window_reset_at' => Carbon::now(),
        ]);

        return response()->json([
            'message' => 'Complaint window reopened for 48 hours.',
            'data' => $kachehri,
        ]);
    }

    /**
     * Shared: totals + this-month counts for kachehris and complaints.
     */
    private function buildStats(): array
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

        return [
            'total_kachehri' => $totalKachehri,
            'kachehri_this_month' => $kachehriThisMonth,
            'total_complaint' => $totalComplaint,
            'complaint_this_month' => $complaintThisMonth,
        ];
    }

    /**
     * Shared: per-month counts for the current year for a given model,
     * filled to always return exactly 12 entries.
     */
    private function buildMonthly(string $modelClass)
    {
        $year = Carbon::now()->year;

        $counts = $modelClass::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->pluck('total', 'month');

        return $this->fillMonths($counts);
    }

    /**
     * Shared: open/closed complaint counts.
     */
    private function buildComplaintStatus(): array
    {
        $openCounts = Complaint::where('status', 'Open')->count();
        $closeCounts = Complaint::where('status', 'Close')->count();

        return [
            'openCount' => $openCounts,
            'closeCounts' => $closeCounts,
        ];
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
