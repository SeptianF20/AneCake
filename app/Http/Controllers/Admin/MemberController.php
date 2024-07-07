<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backoffice\Member\StoreMemberRequest;
use App\Models\Member;
use App\Models\RFID;
use App\Models\Saldo;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::orderBy('id', 'DESC')->get();

        return view('pages.UserManagement.Member.index', compact('members'));
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

    public function store(StoreMemberRequest $request)
    {
        $member = Member::create([
            'card_id' => $request->card_id ?? null,
            'name' => $request->name ?? null,
            'email' => $request->email ?? null,
            'phone' => $request->phone ?? null,
            'address' => $request->address ?? null,
            'saldo' => $request->saldo ?? null,

        ]);

        if (!$member) {
            return responseToast('error', 'Something went wrong', null, 500);
        }

        return responseToast('success', 'Member created successfully');
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
            'cards' => 'required',
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'saldo' => 'required',
        ]);

        $member->update([
            'card_id' => $request->card_id ?? null,
            'name' => $request->name ?? null,
            'email' => $request->email ?? null,
            'phone' => $request->phone ?? null,
            'address' => $request->address ?? null,
            'saldo' => $request->saldo ?? null,
        ]);

        if (!$member) {
            return responseToast('error', 'Something went wrong', null, 500);
        }
        return responseToast('success', 'Member updated successfully');
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
            'message' => 'Member deleted successfully',
            'title' => 'Success.',
        ]);
    }
}
