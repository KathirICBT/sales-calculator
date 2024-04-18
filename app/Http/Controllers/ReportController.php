<?php

namespace App\Http\Controllers;
use App\Models\Shift;
use App\Models\Cashdiffer;
use App\Models\Shop;
use App\Models\PaymentType;
use App\Models\PettyCashReason;
use App\Models\Petticash;
use App\Models\OtherExpense;
use App\Models\Department;
use App\Models\OtherIncome;
use App\Models\OtherIncomeDepartment;

use App\Models\Sale; 
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
    
    // public function generatePaymentReport(Request $request)
    // {
    //     $request->validate([
    //         'from_date' => 'required|date',
    //         'to_date' => 'required|date|after_or_equal:from_date',
    //         'payment_method_id' => 'required|exists:paymentmethods,id'
    //     ]);

    //     // Get shifts within the specified duration based on the start_date column
    //     $shifts = Shift::whereBetween('start_date', [$request->from_date, $request->to_date])->get();

    //     // Get paymentsales for the matching shifts and payment method
    //     $paymentSales = Paymentsale::whereIn('shift_id', $shifts->pluck('id'))
    //         ->where('paymentmethod_id', $request->payment_method_id)
    //         ->get();

    //     // Get all shops for displaying shop names
    //     $shops = Shop::all();

    //     // Organize data to calculate total amount by date and shop
    //     $shopTotalsByDate = [];

    //     foreach ($paymentSales as $sale) {
    //         $date = $sale->shift->start_date;
    //         $shopId = $sale->shift->shop_id;
    //         $amount = $sale->amount;

    //         // Initialize date total if not set
    //         if (!isset($shopTotalsByDate[$date])) {
    //             $shopTotalsByDate[$date] = [];
    //         }

    //         // Add amount to shop total for the date
    //         if (!isset($shopTotalsByDate[$date][$shopId])) {
    //             $shopTotalsByDate[$date][$shopId] = $amount;
    //         } else {
    //             $shopTotalsByDate[$date][$shopId] += $amount;
    //         }
    //     }

    //     // Pass the data to the same view along with the input dates and payment method
    //     return view('pages.reports.paymentMethodReport', [
    //         'shopTotalsByDate' => $shopTotalsByDate,
    //         'from_date' => $request->from_date,
    //         'to_date' => $request->to_date,
    //         'paymentMethods' => Paymentmethod::all(),
    //         'shops' => $shops,
    //         'paymentSales' => $paymentSales, // Pass the payment sales data to the view
    //     ]);
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

    // Get the selected payment method
    $selectedPaymentMethod = Paymentmethod::findOrFail($request->payment_method_id);
   

    // Pass the data to the view along with the input dates, payment method, and payment method name
    return view('pages.reports.paymentMethodReport', [
        'shopTotalsByDate' => $shopTotalsByDate,
        'from_date' => $request->from_date,
        'to_date' => $request->to_date,
        'paymentMethods' => Paymentmethod::all(),
        'shops' => $shops,
        'paymentSales' => $paymentSales,
        'selectedPaymentMethod' => $selectedPaymentMethod->payment_method, // Pass the payment method name
    ]);
}


public function generatePaymentReports(Request $request)
{
    $request->validate([
        'from_date' => 'required|date',
        'to_date' => 'required|date|after_or_equal:from_date',
    ]);

    // Get all payment methods
    $paymentMethods = Paymentmethod::all();

    // Initialize an array to store reports for each payment method
    $reports = [];

    // Iterate over each payment method and generate reports
    foreach ($paymentMethods as $method) {
        $paymentSales = Paymentsale::whereHas('shift', function ($query) use ($request) {
            $query->whereBetween('start_date', [$request->from_date, $request->to_date]);
        })->where('paymentmethod_id', $method->id)->get();

        $shopTotalsByDate = [];

        foreach ($paymentSales as $sale) {
            $date = $sale->shift->start_date;
            $shopId = $sale->shift->shop_id;
            $amount = $sale->amount;

            if (!isset($shopTotalsByDate[$date])) {
                $shopTotalsByDate[$date] = [];
            }

            if (!isset($shopTotalsByDate[$date][$shopId])) {
                $shopTotalsByDate[$date][$shopId] = $amount;
            } else {
                $shopTotalsByDate[$date][$shopId] += $amount;
            }
        }

        $shops = Shop::all();

        // Add report data to the array
        $reports[] = [
            'shopTotalsByDate' => $shopTotalsByDate,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'paymentMethod' => $method->payment_method,
            'shops' => $shops,
            'paymentSales' => $paymentSales,
        ];
    }

    $paymentMethods = Paymentmethod::all();

    // Pass the array of reports to the view
    return view('pages.reports.paymentMethodReport', compact('reports', 'paymentMethods'));
}




    public function showPaymentReport()
    {
        $paymentMethods = Paymentmethod::all();
        $shops = Shop::all();
        return view('pages.reports.paymentMethodReport', compact('paymentMethods','shops'));
    }

    // public function generateOwnerExpenseReport(Request $request)
    // {
    //     // Get the ID of the selected payment method from the request
    // $paymentTypeId = $request->input('payment_method_id');

    // // Retrieve the PaymentType object based on the ID
    // $paymentType = PaymentType::findOrFail($paymentTypeId);

    // // Now you have the PaymentType object, you can access its payment_type attribute
    // $paymentTypeValue = $paymentType->payment_type;
    //     dd($paymentTypeValue);
    //     // Validate the request data
    //     $request->validate([
    //         'from_date' => 'required|date',
    //         'to_date' => 'required|date|after_or_equal:from_date',
    //     ]);

    //     // Get shifts within the specified duration based on the start_date column
    //     $shifts = Shift::whereBetween('start_date', [$request->from_date, $request->to_date])->get();

    //     // Get other expenses within the specified duration
    //     $otherExpenses = OtherExpense::whereBetween('date', [$request->from_date, $request->to_date])->get();

    //     // Get petticashes (assuming this is related to payments) for all dates (optional if needed for calculation)
    //     $petticashes = Petticash::all();

    //     // Calculate shop totals by date for payment sales and other expenses
    //     $shopTotalsByDate = [];

    //     // Process petticashes (payments) for shop totals by date
    //     foreach ($shifts as $shift) {
    //         $petticashes = Petticash::where('shift_id', $shift->id)->get();

    //         foreach ($petticashes as $petticash) {
    //             $date = $shift->start_date;
    //             $shopId = $shift->shop_id;
    //             $amount = $petticash->amount;

    //             if (!isset($shopTotalsByDate[$date][$shopId])) {
    //                 $shopTotalsByDate[$date][$shopId] = 0;
    //             }

    //             $shopTotalsByDate[$date][$shopId] += $amount;
    //         }
    //     }

    //     // Process other expenses for shop totals by date
    //     foreach ($otherExpenses as $expense) {
    //         $date = $expense->date;
    //         $shopId = $expense->shop_id;
    //         $amount = $expense->amount;

    //         if (!isset($shopTotalsByDate[$date][$shopId])) {
    //             $shopTotalsByDate[$date][$shopId] = 0;
    //         }

    //         $shopTotalsByDate[$date][$shopId] += $amount;
    //     }

    //     // Pass the data to the same view along with the input dates and shops
    //     return view('pages.reports.ownerExpenseReport', [
    //         'otherExpenses' => $otherExpenses,
    //         'from_date' => $request->from_date,
    //         'to_date' => $request->to_date,
    //         'shops' => Shop::all(),
    //         'shopTotalsByDate' => $shopTotalsByDate
    //     ]);
    // }




    // public function generateOwnerExpenseReport(Request $request)
    // {
    //     // Validate the request data
    //     $request->validate([
    //         'from_date' => 'required|date',
    //         'to_date' => 'required|date|after_or_equal:from_date',
    //         'payment_method_id' => 'required|exists:payment_types,id', // Add validation for payment method
    //     ]);

    //     // Get the ID of the selected payment method from the request
    //     $paymentTypeId = $request->input('payment_method_id');

    //     // Retrieve the PaymentType object based on the ID
    //     $paymentType = PaymentType::findOrFail($paymentTypeId);

    //     // Now you have the PaymentType object, you can access its payment_type attribute
    //     $paymentTypeValue = $paymentType->payment_type;

    //     // Get shifts within the specified duration based on the start_date column
    //     $shifts = Shift::whereBetween('start_date', [$request->from_date, $request->to_date])->get();

    //     // Get other expenses within the specified duration
    //     $otherExpenses = OtherExpense::whereBetween('date', [$request->from_date, $request->to_date])
    //         ->where('paymenttype_id', $request->payment_method_id) // Filter by payment method
    //         ->get();

    //     // Get petticashes for all dates
    //     $petticashes = Petticash::all();

    //     // Calculate shop totals by date for payment sales and other expenses
    //     $shopTotalsByDate = [];

    //     // Process petticashes for shop totals by date
    //     foreach ($shifts as $shift) {
    //         $petticashes = Petticash::where('shift_id', $shift->id)->get();

    //         foreach ($petticashes as $petticash) {
    //             $date = $shift->start_date;
    //             $shopId = $shift->shop_id;
    //             $amount = $petticash->amount;

    //             if (!isset($shopTotalsByDate[$date][$shopId])) {
    //                 $shopTotalsByDate[$date][$shopId] = 0;
    //             }

    //             $shopTotalsByDate[$date][$shopId] += $amount;
    //         }
    //     }

    //     // Process other expenses for shop totals by date
    //     foreach ($otherExpenses as $expense) {
    //         $date = $expense->date;
    //         $shopId = $expense->shop_id;
    //         $amount = $expense->amount;

    //         if (!isset($shopTotalsByDate[$date][$shopId])) {
    //             $shopTotalsByDate[$date][$shopId] = 0;
    //         }

    //         $shopTotalsByDate[$date][$shopId] += $amount;
    //     }

    //     // Pass the data to the same view along with the input dates and shops
    //     return view('pages.reports.ownerExpenseReport', [
    //         'otherExpenses' => $otherExpenses,
    //         'from_date' => $request->from_date,
    //         'to_date' => $request->to_date,
    //         'shops' => Shop::all(),
    //         'shopTotalsByDate' => $shopTotalsByDate
    //     ]);
    // }


// public function generateOwnerExpenseReport(Request $request)
// {
//     // Validate the request data
//     $request->validate([
//         'from_date' => 'required|date',
//         'to_date' => 'required|date|after_or_equal:from_date',
//         'payment_method_id' => 'required|exists:payment_types,id', // Add validation for payment method
//     ]);

//     // Get the ID of the selected payment method from the request
//     $paymentTypeId = $request->input('payment_method_id');

//     // Retrieve the PaymentType object based on the ID
//     $paymentType = PaymentType::findOrFail($paymentTypeId);

//     // Now you have the PaymentType object, you can access its payment_type attribute
//     $paymentTypeValue = $paymentType->payment_type;

//     // Get shifts within the specified duration based on the start_date column
//     $shifts = Shift::whereBetween('start_date', [$request->from_date, $request->to_date])->get();

//     // Get other expenses within the specified duration
//     $otherExpenses = OtherExpense::whereBetween('date', [$request->from_date, $request->to_date])
//         ->where('paymenttype_id', $request->payment_method_id) // Filter by payment method
//         ->get();

//     // Get petticashes for all dates
//     $petticashes = Petticash::all();

//     // Calculate shop totals by date for payment sales and other expenses
//     $shopTotalsByDate = [];

//     // Process petticashes for shop totals by date
//     foreach ($shifts as $shift) {
//         $petticashes = Petticash::where('shift_id', $shift->id)->get();

//         foreach ($petticashes as $petticash) {
//             $date = $shift->start_date;
//             $shopId = $shift->shop_id;
//             $amount = $petticash->amount;
//             //$paymentTypeValue = strtolower($petticash->paymentType->payment_type);

//             // Check if the payment type includes the word 'cash' (case-insensitive)
//             if (strpos($paymentTypeValue, 'cash') === false) {
//                 // If payment type includes 'Cash', do not include the amount
//                 break;
//             }

//             if (!isset($shopTotalsByDate[$date][$shopId])) {
//                 $shopTotalsByDate[$date][$shopId] = 0;
//             }

//             $shopTotalsByDate[$date][$shopId] += $amount;
//         }
//     }

//     //dd($otherExpenses->all());

//     // Process other expenses for shop totals by date
//     foreach ($otherExpenses as $expense) {
//         $date = $expense->date;
//         $shopId = $expense->shop_id;
//         $amount = $expense->amount;

//         if (!isset($shopTotalsByDate[$date][$shopId])) {
//             $shopTotalsByDate[$date][$shopId] = 0;
//         }

//         $shopTotalsByDate[$date][$shopId] += $amount;
//     }

//     // Pass the data to the same view along with the input dates and shops
//     return view('pages.reports.ownerExpenseReport', [
//         'otherExpenses' => $otherExpenses,
//         'from_date' => $request->from_date,
//         'to_date' => $request->to_date,
//         'shops' => Shop::all(),
//         'paymentTypes' => PaymentType::all(),
//         'shopTotalsByDate' => $shopTotalsByDate
//     ]);
// }

    public function generateOwnerExpenseReport(Request $request)
    {
        // Validate the request data
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'payment_method_id' => 'required|exists:payment_types,id', // Add validation for payment method
        ]);

        // Get the ID of the selected payment method from the request
        $paymentTypeId = $request->input('payment_method_id');

        // Retrieve the PaymentType object based on the ID
        $paymentType = PaymentType::findOrFail($paymentTypeId);

        // Now you have the PaymentType object, you can access its payment_type attribute
        $paymentTypeValue = strtolower($paymentType->payment_type);

        // Get shifts within the specified duration based on the start_date column
        $shifts = Shift::whereBetween('start_date', [$request->from_date, $request->to_date])->get();

        // Get other expenses within the specified duration
        $otherExpenses = OtherExpense::whereBetween('date', [$request->from_date, $request->to_date])
            ->where('paymenttype_id', $request->payment_method_id) // Filter by payment method
            ->get();

        // Get petticashes for all dates
        $petticashes = Petticash::all();

        // Calculate shop totals by date for payment sales and other expenses
        $shopTotalsByDate = [];

        // Process petticashes for shop totals by date
        foreach ($shifts as $shift) {
            $petticashes = Petticash::where('shift_id', $shift->id)->get();

            foreach ($petticashes as $petticash) {
                $date = $shift->start_date;
                $shopId = $shift->shop_id;
                $amount = $petticash->amount;

                // Check if the payment type includes the word 'cash' (case-insensitive)
                if (strpos($paymentTypeValue, 'cash') !== false) {
                    // If payment type includes 'Cash', include the amount
                    if (!isset($shopTotalsByDate[$date][$shopId])) {
                        $shopTotalsByDate[$date][$shopId] = 0;
                    }
                    $shopTotalsByDate[$date][$shopId] += $amount;
                }
            }
        }

        // Process other expenses for shop totals by date
        foreach ($otherExpenses as $expense) {
            $date = $expense->date;
            $shopId = $expense->shop_id;
            $amount = $expense->amount;

            // Include the amount regardless of payment type
            if (!isset($shopTotalsByDate[$date][$shopId])) {
                $shopTotalsByDate[$date][$shopId] = 0;
            }
            $shopTotalsByDate[$date][$shopId] += $amount;
        }

        $paymentTypeMethod = PaymentType::findOrFail($request->payment_method_id);

        // Pass the data to the same view along with the input dates and shops
        return view('pages.reports.ownerExpenseReport', [
            'otherExpenses' => $otherExpenses,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'shops' => Shop::all(),
            'paymentTypes' => PaymentType::all(),
            'shopTotalsByDate' => $shopTotalsByDate,
            'paymentTypeMethod' => $paymentTypeMethod->payment_type
        ]);
    }


    public function showOwnerExpenseReportForm()
    {
        $paymentTypes = PaymentType::all(); // Retrieve all payment methods
        $shops = Shop::all(); // Retrieve all shops

        return view('pages.reports.ownerExpenseReport', [
            'paymentTypes' => $paymentTypes,
            'shops' => $shops,
        ]);
    }


    // EXPENSE REPORT - EXPENSE REASON =======================================

    public function showExpenseReport()
    {
        $pettyCashReasons = PettyCashReason::all();
        $paymentMethods = PaymentMethod::all(); // Retrieve all payment methods
        $shops = Shop::all(); // Retrieve all shops

        return view('pages.reports.expenseReasonReport', [
            'paymentMethods' => $paymentMethods,
            'shops' => $shops,
            'pettyCashReasons'=>$pettyCashReasons,
        ]);
    }

    public function generateExpenseReport(Request $request)
    {
        // Validate the request data
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'petty_cash_reason_id' => 'required|exists:petty_cash_reasons,id',
        ]);

        // Get shifts within the specified duration based on the start_date column
        $shifts = Shift::whereBetween('start_date', [$request->from_date, $request->to_date])->get();

        // Get other expenses within the specified duration and for the specified petty cash reason
        $otherExpenses = OtherExpense::whereBetween('date', [$request->from_date, $request->to_date])
            ->where('expense_reason_id', $request->petty_cash_reason_id)
            ->get();

        // Get petticashes (assuming this is related to payments) for all dates (optional if needed for calculation)
        $petticashes = Petticash::all();

        // Calculate shop totals by date for payment sales and other expenses
        $shopTotalsByDate = [];

        // Process petticashes (payments) for shop totals by date
        foreach ($shifts as $shift) {
            $petticashes = Petticash::where('shift_id', $shift->id)
                ->where('petty_cash_reason_id', $request->petty_cash_reason_id)
                ->get();

            foreach ($petticashes as $petticash) {
                $date = $shift->start_date;
                $shopId = $shift->shop_id;
                $amount = $petticash->amount;

                if (!isset($shopTotalsByDate[$date][$shopId])) {
                    $shopTotalsByDate[$date][$shopId] = 0;
                }

                $shopTotalsByDate[$date][$shopId] += $amount;
            }
        }

        // Process other expenses for shop totals by date
        foreach ($otherExpenses as $expense) {
            $date = $expense->date;
            $shopId = $expense->shop_id;
            $amount = $expense->amount;

            if (!isset($shopTotalsByDate[$date][$shopId])) {
                $shopTotalsByDate[$date][$shopId] = 0;
            }

            $shopTotalsByDate[$date][$shopId] += $amount;
        }

        $expenseReason = PettyCashReason::findOrFail($request->petty_cash_reason_id);

        // Pass the data to the same view along with the input dates and shops
        return view('pages.reports.expenseReasonReport', [
            'otherExpenses' => $otherExpenses,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'shops' => Shop::all(),
            'pettyCashReasons'=> PettyCashReason::all(),
            'expenseReason' => $expenseReason -> reason,
            'shopTotalsByDate' => $shopTotalsByDate
        ]);
    }

    //========================================================================

    // public function generateCashMovementReport(Request $request)
    // {
    //     $request->validate([
    //         'from_date' => 'required|date',
    //         'to_date' => 'required|date|after_or_equal:from_date',
    //     ]);

    //     // Get all departments
    //     $departments = Department::all();

    //     // Initialize an array to store department reports
    //     $departmentReports = [];

    //     // Iterate over each department and generate reports
    //     foreach ($departments as $department) {
    //         // Get shift IDs within the specified date period for the current department
    //         $shifts = Shift::whereBetween('start_date', [$request->from_date, $request->to_date])
    //             ->pluck('id');

    //         // Get shops associated with the current department
    //         $shops = Shop::where('department_id', $department->id)->get();

    //         // Initialize array to store shop totals by date
    //         $shopTotalsByDate = [];
    //         // $sales= Sale::all();
    //         foreach ($shifts as $shift) {
    //                 $sales = Sale::where('shift_id', $shift->id)
    //                 ->get();

    //                 foreach ($sales as $sale) {
    //                     $salesId = Shift::findOrFail($sale);
    //                     $date = $shift->start_date;
    //                     $shopId = $shift->shop_id;
        
    //                     // Calculate shop total based on the shift details
    //                     // For illustration purpose, assuming a calculation logic based on shift data
                       
        
    //                     if (!isset($shopTotalsByDate[$date])) {
    //                         $shopTotalsByDate[$date] = [];
    //                     }
        
    //                     if (!isset($shopTotalsByDate[$date][$sale])) {
    //                         $shopTotalsByDate[$date][$sale] = $amount;
    //                     } else {
    //                         $shopTotalsByDate[$date][$sale] += $amount;
    //                     }
    //                 }
    
                
    //         }

    //         // Calculate shop totals by date for each shift in the department
            

    //         // Add department report data to the array
    //         $departmentReports[] = [
    //             'department' => $department,
    //             'shopTotalsByDate' => $shopTotalsByDate,
    //             'shops' => $shops,
    //             'from_date' => $request->from_date,
    //             'to_date' => $request->to_date,
    //         ];
    //     }

    //     // Pass the array of department reports to the view
    //     return view('pages.reports.cashmovementReport', compact('departmentReports'));
    // }



    public function showCashMoveReport()
    {
        $departments = Department::all();
        $shops = Shop::all(); // Retrieve all shops

        return view('pages.reports.cashmovementReport', [
            'departments' => $departments,
            'shops' => $shops,
            
        ]);
    }

    
// public function generateCashMovementReport(Request $request)
// {
//     $request->validate([
//         'from_date' => 'required|date',
//         'to_date' => 'required|date|after_or_equal:from_date',
//     ]);

//     // Get all departments
//     $departments = Department::all();

//     // Initialize an array to store department reports
//     $departmentReports = [];

//     // Iterate over each department and generate reports
//     foreach ($departments as $department) {
//         // Step 1: Retrieve Shift IDs within the Date Range
//         $shiftIds = Shift::whereBetween('start_date', [$request->from_date, $request->to_date])
//         ->pluck('id');

//         // Step 2: Retrieve Department IDs and Amounts from Sales Table
//         $sales = Sale::whereIn('shift_id', $shiftIds)
//         ->select('dept_id', 'amount')
//         ->get();

//         // Initialize arrays to store department totals
//         $normalDepartmentTotal = 0;
//         $otherTakingTotal = 0;
//         $fuelTotal = 0;

//         // Process each sale to calculate department totals based on conditions
//         foreach ($sales as $sale) {
//             $deptId = $sale->dept_id;
//             $amount = $sale->amount;

//             // Check department conditions
//             $departmentType = $this->getDepartmentType($deptId);

//             // Aggregate totals based on department type
//             switch ($departmentType) {
//                 case 'normal':
//                     $normalDepartmentTotal += $amount;
//                     break;
//                 case 'other_taking':
//                     $otherTakingTotal += $amount;
//                     break;
//                 case 'fuel':
//                     $fuelTotal += $amount;
//                     break;
//                 default:
//                     // Handle unrecognized department type
//                     break;
//             }
//         }
//         $shops = Shop::all(); 

//         // Add department report data to the array
//         $departmentReports[] = [
//             'department' => $department,
//             'normalDepartmentTotal' => $normalDepartmentTotal,
//             'otherTakingTotal' => $otherTakingTotal,
//             'fuelTotal' => $fuelTotal,
//             'from_date' => $request->from_date,
//             'to_date' => $request->to_date,
//             'shops' => Shop::all(),
//         ];
//     }

//     // Pass the array of department reports to the view
//     return view('pages.reports.cashmovementReport', compact('departmentReports', 'shops'));
// }
// public function generateCashMovementReport(Request $request)
// {
//     $request->validate([
//         'from_date' => 'required|date',
//         'to_date' => 'required|date|after_or_equal:from_date',
//     ]);

//     // Get all departments
//     $departments = Department::all();

//     // Initialize an array to store department reports
//     $departmentReports = [];

//     // Iterate over each department and generate reports
//     foreach ($departments as $department) {
//         // Step 1: Retrieve Shift IDs within the Date Range for the current department
//         // Step 1: Retrieve Shift IDs within the Date Range
//         $shiftIds = Shift::whereBetween('start_date', [$request->from_date, $request->to_date])
//         ->pluck('id');

//         // Step 2: Retrieve Department IDs and Amounts from Sales Table
//         $sales = Sale::whereIn('shift_id', $shiftIds)
//         ->select('dept_id', 'amount')
//         ->get();

//         // Initialize totals
//         $normalDepartmentTotal = 0;
//         $otherTakingTotal = 0;
//         $fuelTotal = 0;

//         // Process each sale to calculate department totals based on conditions
//         foreach ($sales as $sale) {
//             $deptId = $sale->dept_id;
//             $amount = $sale->amount;

//             // Determine the department type
//             $departmentType = $this->getDepartmentType($deptId);

//             // Aggregate totals based on department type
//             switch ($departmentType) {
//                 case 'normal':
//                     $normalDepartmentTotal += $amount;
//                     break;
//                 case 'other_taking':
//                     $otherTakingTotal += $amount;
//                     break;
//                 case 'fuel':
//                     $fuelTotal += $amount;
//                     break;
//                 default:
//                     // Handle unrecognized department type (optional)
//                     break;
//             }
//         }

//         // Add department report data to the array
//         $departmentReports[] = [
//             'department' => $department,
//             'normalDepartmentTotal' => $normalDepartmentTotal,
//             'otherTakingTotal' => $otherTakingTotal,
//             'fuelTotal' => $fuelTotal,
//             'from_date' => $request->from_date,
//             'to_date' => $request->to_date,
//         ];
//     }

//     // Get all shops (assuming this is needed in the view)
//     $shops = Shop::all();

//     // Pass the array of department reports and shops to the view
    
//     return view('pages.reports.cashmovementReport', [
        
//         'from_date' => $request->from_date,
//         'to_date' => $request->to_date,
//         'shops' => Shop::all(),
//         'departmentReports' => $departmentReports
//     ]);
// }

public function generateCashMovementReport(Request $request)
{
    // Validate the request
    $request->validate([
        'from_date' => 'required|date',
        'to_date' => 'required|date|after_or_equal:from_date',
    ]);

    // Retrieve all departments and shops
    $departments = Department::all();
    $shops = Shop::all();

    // Initialize an array to store shop-specific department totals
    $shopDepartmentTotals = [];

    // Iterate over each shop to initialize department totals
    foreach ($shops as $shop) {
        $shopDepartmentTotals[$shop->id]['normal'] = 0;
        $shopDepartmentTotals[$shop->id]['other_taking'] = 0;
        $shopDepartmentTotals[$shop->id]['fuel'] = 0;
    }

    // Process each department's sales data within the specified date range
    foreach ($departments as $department) {
        $departmentId = $department->id;

        // Retrieve Shift IDs within the Date Range for this department
        $shiftIds = Shift::whereBetween('start_date', [$request->from_date, $request->to_date])
            ->pluck('id');

        // Retrieve sales data for this department within the date range
        $sales = Sale::whereIn('shift_id', $shiftIds)
            ->where('dept_id', $departmentId)
            ->get();

        // Update shop-specific department totals based on sales
        foreach ($sales as $sale) {
            $amount = $sale->amount;
            $departmentType = $this->getDepartmentType($departmentId);
            $shopId = $sale->shift->shop_id;

            // Update the corresponding shop's department total
            $shopDepartmentTotals[$shopId][$departmentType] += $amount;
        }
    }

    // Initialize an array to store shop-specific other income totals
    $shopOtherIncomeTotals = [];

    // Retrieve other incomes within the specified date range and matching subcategory
    $otherIncomes = OtherIncome::whereBetween('date', [$request->from_date, $request->to_date])
        ->whereHas('otherIncomeDepartment', function ($query) {
            $query->where('subcategory', 'Direct Income');
        })
        ->get();

    // Process other incomes for each shop
    foreach ($otherIncomes as $income) {
        $shopId = $income->shop_id;
        $amount = $income->amount;

        if (!isset($shopOtherIncomeTotals[$shopId])) {
            $shopOtherIncomeTotals[$shopId] = 0;
        }

        // Add other income amount to the shop's total
        $shopOtherIncomeTotals[$shopId] += $amount;
    }

    $LoanTotals = [];

    // Retrieve other incomes within the specified date range and matching subcategory
    $otherIncomes = OtherIncome::whereBetween('date', [$request->from_date, $request->to_date])
    ->whereHas('otherIncomeDepartment.incomeCategory', function ($query) {
        $query->where('category', 'Loan');
    })
    ->get();

    // Process other incomes for each shop
    foreach ($otherIncomes as $income) {
        $shopId = $income->shop_id;
        $amount = $income->amount;

        if (!isset($LoanTotals[$shopId])) {
            $LoanTotals[$shopId] = 0;
        }

        // Add other income amount to the shop's total
        $LoanTotals[$shopId] += $amount;
    }

    // Return the view with required data
    return view('pages.reports.cashmovementReport', [
        'departments' => $departments,
        'from_date' => $request->from_date,
        'to_date' => $request->to_date,
        'shops' => $shops,
        'shopDepartmentTotals' => $shopDepartmentTotals,
        'shopOtherIncomeTotals' => $shopOtherIncomeTotals,
        'LoanTotals'=>$LoanTotals,
    ]);
}





    /**
     * Helper method to determine the type of a department based on its ID.
     *
     * @param int $deptId
     * @return string|null
     */
    private function getDepartmentType($deptId)
    {
        $department = Department::find($deptId);

        if ($department) {
            // Determine department type based on conditions (e.g., other_taking, fuel)
            if ($department->other_taking && !$department->fuel) {
                return 'other_taking';
            } elseif ($department->fuel && !$department->other_taking) {
                return 'fuel';
            } else {
                return 'normal';
            }
        }

        return null; // Handle case where department is not found
    }
}
