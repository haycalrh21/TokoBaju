<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\CheckOut;
use App\Models\CartItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{


    public function dashboard()
    {

         $jumlahProduct = Product::count();
         $jumlahAkun = User::count();
         $jumlahCo = CheckOut::count();
         $jumlahKeranjang = CartItems::count();



        $usersWithPayments = User::whereHas('checkOuts', function ($query) {
            $query->where('status', 'sudah bayar');
        })->with('checkOuts')->get();

        $totalPriceData = [];
        $processedCombinations = [];

        foreach ($usersWithPayments as $user) {
            foreach ($user->checkOuts as $checkOut) {
                // Create a unique identifier based on cart_id and totalPrice
                $combinationKey = $checkOut->cart_id . '_' . $checkOut->totalPrice;

                // Check if the combination is not already processed
                if (!isset($processedCombinations[$combinationKey])) {
                    // Extract the month and year from the created_at timestamp
                    $monthYear = date('F Y', strtotime($checkOut->created_at));

                    // Accumulate the total for each month
                    if (!isset($totalPriceData[$monthYear])) {
                        $totalPriceData[$monthYear] = 0;
                    }

                    $totalPriceData[$monthYear] += $checkOut->totalPrice;

                    // Mark the combination as processed
                    $processedCombinations[$combinationKey] = true;
                }
            }
        }

        // Add monthly totals to the data array
        foreach ($totalPriceData as $monthYear => $total) {
            $totalPriceData['labels'][] = $monthYear;
            $totalPriceData['values'][] = $total;
        }

        return view('admin.dashboard', compact('usersWithPayments',
         'totalPriceData','jumlahProduct','jumlahAkun','jumlahCo',
        'jumlahKeranjang'));
    }






    public function index()
    {
        $products = Product::all(); // Fetch all products from the database

        return view('user.index', ['products' => $products]);
    }


    public function order()
    {
        $keranjangs = CheckOut::with('pengiriman')->get();

        $usersWithPayments = User::whereHas('checkOuts', function ($query) {
            $query->where('status', 'sudah bayar')->with('products');
        })->with('checkOuts')->get();

        $totalPriceData = [];
        $processedCombinations = [];

        $totalPriceData = [];
        $processedCombinations = [];

        foreach ($usersWithPayments as $user) {
            foreach ($user->checkOuts as $checkOut) {
                // Create a unique identifier based on cart_id and totalPrice
                $combinationKey = $checkOut->cart_id . '_' . $checkOut->totalPrice;

                // Check if the combination is not already processed
                if (!isset($processedCombinations[$combinationKey])) {
                    // Extract the month and year from the created_at timestamp
                    $monthYear = date('F Y', strtotime($checkOut->created_at));

                    // Accumulate the total for each month
                    if (!isset($totalPriceData[$monthYear])) {
                        $totalPriceData[$monthYear] = 0;
                    }

                    $totalPriceData[$monthYear] += $checkOut->totalPrice;

                    // Mark the combination as processed
                    $processedCombinations[$combinationKey] = true;
                }
            }
        }

        return view('admin.order.index', compact('keranjangs', 'usersWithPayments', 'totalPriceData'));
    }

}
