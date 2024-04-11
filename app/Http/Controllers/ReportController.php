<?php

namespace App\Http\Controllers;
use App\Models\Shift;
use App\Models\Cashdiffer;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\PaymentSale;
use App\Models\Paymentmethod;

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

   
    // public function paymentmethodReport(Request $request)
    // {
    //     if ($request->isMethod('post')) {
    //         $fromDate = $request->input('from_date');
    //         $toDate = $request->input('to_date');
    //         $paymentMethod = $request->input('payment_method');
    
    //         // Retrieve shift IDs and shop IDs within the specified date range
    //         // $shifts = Shift::whereBetween('start_date', [$fromDate, $toDate])
    //         //                ->with('shop')
    //         //                ->get();
    //          // Get shifts within the specified duration based on the created_at column
    //          $shifts = Shift::whereBetween('start_date', [$request->from_date, $request->to_date])->get();
    
    //         // Extract shift and shop IDs
    //         //$shiftShopIds = $shifts->pluck('shop.id', 'id');

    //          // Get cash differences for the matching shifts
    //         $PaymentSales = PaymentSale::whereIn('shift_id', $shifts->pluck('id'))->get();

    //         // Pre-process data to calculate total cash differ by date and shop
    //     $shopTotalsByDate = [];
    //     foreach ($shifts as $shift) {
    //         foreach ($PaymentSales->where('shift_id', $shift->id)->where('payment_method_id', $paymentMethod) as $PaymentSales) {
    //             $date = $shift->start_date;
    //             $shopId = $shift->shop_id;
    //             $paymentsaleAmount = $PaymentSales->amount;
    //             // Add cash difference to existing total or initialize a new total
    //             $shopTotalsByDate[$date][$shopId] = isset($shopTotalsByDate[$date][$shopId])
    //                 ? $shopTotalsByDate[$date][$shopId] + $paymentsaleAmount
    //                 : $paymentsaleAmount;
    //         }
    //     }
    
    //         // Retrieve payment sales details based on shift and shop IDs, and payment method
    //         // $payments = PaymentSale::whereIn('shift_id', $shiftShopIds->keys())
    //         //                        ->whereIn('shop_id', $shiftShopIds->values())
    //         //                        ->where('payment_method_id', $paymentMethod)
    //         //                        ->whereBetween('date', [$fromDate, $toDate])
    //         //                        ->get();
    
    //         // Format payments for display
    //         // $reportData = [];
    //         // foreach ($payments as $payment) {
    //         //     $date = $payment->date;
    //         //     $shopId = $payment->shop_id;
    //         //     $amount = $payment->amount;
    
    //         //     // Group payments by date and shop
    //         //     if (!isset($reportData[$date])) {
    //         //         $reportData[$date] = [];
    //         //     }
    //         //     if (!isset($reportData[$date][$shopId])) {
    //         //         $reportData[$date][$shopId] = 0;
    //         //     }
    //         //     $reportssData[$date][$shopId] += $amount;
    //         // }
    
    //         // Prepare data for view
    //         $paymentMethods = PaymentMethod::all();
    //         $shops = Shop::all();
    //         return view('pages.reports.paymentMethodReport', compact('paymentMethods'),[
    //             'shopTotalsByDate' => $shopTotalsByDate,
                
    //             'from_date' => $request->from_date,
    //             'to_date' => $request->to_date,
    //             'shifts' => $shifts,
    //             'shops' => $shops,
    //         ]);
            
    //     }
    //     $paymentMethods = Paymentmethod::all();
    //     $shops = Shop::all();
    //     return view('pages.reports.paymentMethodReport', compact('paymentMethods','shops'));

    // }
    
    public function generatePaymentReport(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'payment_method_id' => 'required|exists:paymentmethods,id'
        ]);

        // Get shifts within the specified duration based on the start_date column
        $shifts = Shift::whereBetween('start_date', [$request->from_date, $request->to_date])->get();

        // Get paymentsales for the matching shifts and payment method
        $paymentSales = Paymentsale::whereIn('shift_id', $shifts->pluck('id'))
            ->where('paymentmethod_id', $request->payment_method_id)
            ->get();

        // Get all shops for displaying shop names
        $shops = Shop::all();

        // Organize data to calculate total amount by date and shop
        $shopTotalsByDate = [];

        foreach ($paymentSales as $sale) {
            $date = $sale->shift->start_date;
            $shopId = $sale->shift->shop_id;
            $amount = $sale->amount;

            // Initialize date total if not set
            if (!isset($shopTotalsByDate[$date])) {
                $shopTotalsByDate[$date] = [];
            }

            // Add amount to shop total for the date
            if (!isset($shopTotalsByDate[$date][$shopId])) {
                $shopTotalsByDate[$date][$shopId] = $amount;
            } else {
                $shopTotalsByDate[$date][$shopId] += $amount;
            }
        }

        // Pass the data to the same view along with the input dates and payment method
        return view('pages.reports.paymentMethodReport', [
            'shopTotalsByDate' => $shopTotalsByDate,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'paymentMethods' => Paymentmethod::all(),
            'shops' => $shops,
            'paymentSales' => $paymentSales, // Pass the payment sales data to the view
        ]);
    }
    public function showPaymentReport()
    {
        $paymentMethods = Paymentmethod::all();
        $shops = Shop::all();
        return view('pages.reports.paymentMethodReport', compact('paymentMethods','shops'));
    }
}
