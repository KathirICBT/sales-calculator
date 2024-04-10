<?php

namespace App\Http\Controllers;
use App\Models\Shift;
use App\Models\Cashdiffer;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function showForm()
    {
        return view('pages.reports.cashdifferReport');
    }

    
    // public function generateReport(Request $request)
    // {
    //     // Validate the request data
    //     $request->validate([
    //         'from_date' => 'required|date',
    //         'to_date' => 'required|date|after_or_equal:from_date',
    //     ]);
    
    //     // Get shifts within the specified duration based on the created_at column
    //     $shifts = Shift::whereBetween(DB::raw('DATE(created_at)'), [$request->from_date, $request->to_date])->get();
    
    //     // Get cash differences for the matching shifts
    //     $cashdiffers = Cashdiffer::whereIn('shift_id', $shifts->pluck('id'))->get();
    
    //     // Pass the data to the view along with the input dates
    //     return view('pages.reports.cashdifferReport', [
    //         'shifts' => $shifts,
    //         'cashdiffers' => $cashdiffers,
    //         'from_date' => $request->from_date,
    //         'to_date' => $request->to_date,
    //     ]);
    // }

//     public function generateReport(Request $request)
// {
//     // Validate the request data
//     $request->validate([
//         'from_date' => 'required|date',
//         'to_date' => 'required|date|after_or_equal:from_date',
//     ]);

//     // Get shifts within the specified duration based on the created_at column
//     $shifts = Shift::whereBetween(DB::raw('DATE(created_at)'), [$request->from_date, $request->to_date])->get();

//     // Get cash differences for the matching shifts
//     $cashdiffers = Cashdiffer::whereIn('shift_id', $shifts->pluck('id'))->get();

//     // Calculate total cash difference for each shop
//     $shopTotals = $cashdiffers->groupBy('shift.shop_id')->map(function($items) {
//         return $items->sum('cashdifference');
//     });

//     // Get all shops for displaying shop names
//     $shops = Shop::all();

//     // Pass the data to the view along with the input dates
//     return view('pages.reports.cashdifferReport', [
//         'shifts' => $shifts,
//         'cashdiffers' => $cashdiffers,
//         'shopTotals' => $shopTotals,
//         'shops' => $shops,
//         'from_date' => $request->from_date,
//         'to_date' => $request->to_date,
//     ]);
// }

    public function generateReport(Request $request)
    {
        // Validate the request data
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
        ]);

        // Get shifts within the specified duration based on the created_at column
        $shifts = Shift::whereBetween('start_date', [$request->from_date, $request->to_date])->get();

        // Get cash differences for the matching shifts
        $cashdiffers = Cashdiffer::whereIn('shift_id', $shifts->pluck('id'))->get();

        // Pre-process data to calculate total cash differ by date and shop
        $shopTotalsByDate = [];
        foreach ($shifts as $shift) {
            foreach ($cashdiffers->where('shift_id', $shift->id) as $cashdiffer) {
                $date = $shift->start_date;
                $shopId = $shift->shop_id;
                $cashDifference = $cashdiffer->cashdifference;
                // Add cash difference to existing total or initialize a new total
                $shopTotalsByDate[$date][$shopId] = isset($shopTotalsByDate[$date][$shopId])
                    ? $shopTotalsByDate[$date][$shopId] + $cashDifference
                    : $cashDifference;
            }
        }
        // Get all shops for displaying shop names
        $shops = Shop::all();


        // Pass the data to the view along with the input dates
        return view('pages.reports.cashdifferReport', [
            'shopTotalsByDate' => $shopTotalsByDate,
            'cashdiffers' => $cashdiffers,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'shifts' => $shifts,
            'shops' => $shops,
        ]);
    }
}
