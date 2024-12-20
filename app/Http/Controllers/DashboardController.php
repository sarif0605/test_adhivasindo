<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        $contentThisMonth = Content::whereMonth('created_at', Carbon::now()->month)
                                    ->whereYear('created_at', Carbon::now()->year)
                                    ->count();

        $monthlyContentCount = Content::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                                    ->whereYear('created_at', Carbon::now()->year)
                                    ->groupBy('month')
                                    ->orderBy('month')
                                    ->pluck('count', 'month')
                                    ->toArray();

        $contentData = array_fill(1, 12, 0);

        foreach ($monthlyContentCount as $month => $count) {
            $contentData[$month] = $count;
        }

        Log::info("message", $contentData);

        $dataBulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $dataBulan[] = Carbon::create()->month($i)->format('F');
        }

        Log::info("message", $dataBulan);

        return view('dashboard', [
            'contentThisMonth' => $contentThisMonth,
            'contentData' => $contentData,
            'labels' => $dataBulan,
        ]);
    }
}
