<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\SenderAddress;
use App\Address;

class AddressController extends Controller
{
    public function address_index()
    {
        $param = "use_address";
        $page = 'dashboard';
        return view('home.addresses.index', compact('param', 'page'));
    }

    public function get_sending_addresses()
    {
        $user = Auth::user();
        $addresses = $user->addresses;
        return response()->json($addresses, 200);
    }

    public function address_new(Request $request)
    {
        $user = Auth::user();
        if (isset($request->id)) {
            $addresses = $user->addresses;
            $address = $addresses->find($request->id);
            if (!$address) {
                return response()->json('fatal error', 200);
            }
            isset($request->province) ? $address->province = $request->province : '';
            isset($request->city) ? $address->city = $request->city : '';
            isset($request->suburb) ? $address->suburb = $request->suburb : '';
            isset($request->detail) ? $address->detail = $request->detail : '';
        } else {
            $address = new Address();
            $address->province = $request->province;
            $address->city = $request->city;
            $address->suburb = $request->suburb;
            $address->detail = $request->detail;
        }
        $address->name = $request->name;
        $address->phone = $request->phone;
        $address->user_id = $user->id;
        $address->save();
        return response()->json('success', 200);

    }

    public function delete_sending_address(Request $request)
    {
        $user = Auth::user();
        $sending_addresses = $user->addresses;
        $sending_address = $sending_addresses->find($request->address_id);
        if ($sending_address) {
            $sending_address->delete();
            return response()->json('success', 200);
        } else {
            return response()->json('fatal error', 403);
        }
    }

    public function get_sender_addresses()
    {
        $user = Auth::user();
        $addresses = $user->sender_addresses;
        return response()->json($addresses, 200);
    }

    public function sender_address_new(Request $request)
    {
        $user = Auth::user();
        if (isset($request->id)) {
            $addresses = $user->sender_addresses;
            $address = $addresses->find($request->id);
            if (!$address) {
                return response()->json('fatal error', 200);
            }
        } else {
            $address = new SenderAddress();
        }
        $address->name = $request->name;
        $address->detail = $request->detail;
        $address->user_id = $user->id;
        $address->phone = $request->phone;
        $address->save();
        return response()->json('success', 200);
    }

    public function delete_sender_address(Request $request)
    {
        $user = Auth::user();
        $sender_addresses = $user->sender_addresses;
        $sender_address = $sender_addresses->find($request->address_id);
        if ($sender_address) {
            $sender_address->delete();
            return response()->json('success', 200);
        } else {
            return response()->json('fatal error', 403);
        }
    }
}
