<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Http\Requests\Backoffice\Customer\StoreCustomerRequest;
use App\Models\RFID;
use App\Models\Saldo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = Member::orderBy('id', 'DESC')->get();
        return view('pages._Main.Cashier.card', compact('members'));
    }

    public function getRfidData(Request $request)
    {
        // Fetch the most recently added RFID data
        $latestRfidData = RFID::orderBy('created_at', 'desc')->first();
        return response()->json($latestRfidData);
    }

    public function getAllCardIds()
    {
        $cardIds = RFID::pluck('card_id');
        return response()->json($cardIds);
    }

    public function deleteRfidData(Request $request)
    {
        RFID::where('id', $request->id)->delete();
        return response()->json(['success' => true]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request)
    {
        $user = Member::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('password'),
        ]);

        $user = Saldo::create([
            'member_id' => $request->id,
            'email' => $request->email,
            'password' => bcrypt('password'),
        ]);

        if (!$user) {
            return responseToast('error', 'Something went wrong', null, 500);
        }

        return responseToast('success', 'Berhasil menambahkan pelanggan baru');
    }

    public function edit(Member $member)
    {
        return response()->json([
            'status' => true,
            'data' => $member,
        ]);
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers,email,' . $member->id,
        ]);

        $member->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if (!$member) {
            return responseToast('error', 'Something went wrong', null, 500);
        }
        return responseToast('success', 'Berhasil mengubah data pelanggan');
    }

    public function destroy(Member $member)
    {
        $member->delete();

        if (!$member) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong',
                'title' => 'Error!'
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menghapus data pelanggan',
            'title' => 'Success.',
        ]);
    }
}
