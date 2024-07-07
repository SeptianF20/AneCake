<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Saldo;
use App\Models\RiwayatTopup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TopupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Ambil data member yang sedang login
        $member = Auth::guard('member')->user();

        // Ambil saldo dari member yang sedang login berdasarkan user_id
        $saldo = Saldo::where('member_id', $member->id)->first();

        // Kirim data ke view
        return view('pages.landing.produk.topup', compact('member', 'saldo'));
    }

    public function getSnapToken(Request $request)
    {
        try {
            // Set midtrans configuration
            Config::$serverKey = config('services.midtrans.serverKey');
            Config::$isProduction = config('services.midtrans.isProduction');
            Config::$isSanitized = config('services.midtrans.isSanitized');
            Config::$is3ds = config('services.midtrans.is3ds');

            $total = $request->input('amount');  // Use 'totalPembayaran' to match the key from the request
            $id = 'TP-' . rand();

            $payload = [
                'transaction_details' => [
                    'order_id' => $id,
                    'gross_amount' => $total,
                ],
                'customer_details' => [
                    'first_name' => Auth::guard('member')->user()->nama,
                    'email' => Auth::guard('member')->user()->email,
                ],
            ];

            $snapToken = Snap::getSnapToken($payload);
            return response()->json(['snapToken' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateSaldo(Request $request)
    {
        try {
            $member = Saldo::where('member_id', $request->memberId)->firstOrFail();
            $member->saldo += $request->amount;
            $member->save();

            return response()->json(['message' => 'Saldo updated successfully', 'memberId' => $member->memberId]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating saldo', 'error' => $e->getMessage()], 500);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
