<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Service;

class ServiceController extends Controller
{
    public function service_index()
    {
        $page = 'dashboard';
        $user = Auth::user();
        $orders = $user->orders->where('status', 3);
        return view('home.services.index', compact('page', 'orders'));
    }

    public function service_create($order_id)
    {
        $page = 'dashboard';
        $user = Auth::user();
        $order = $user->orders->where('status', '3')->find($order_id);
        if ($order->service) {
            Auth::logout();
            return redirect(route('index'));
        }
        return view('home.services.create', compact('page', 'order'));
    }

    public function service_store(Request $request)
    {
        $user = Auth::user();
        $order = $user->orders->find($request->order_id);
        if (!$order->service) {
            $service = new Service();
            $service->order_id = $request->order_id;
            $service->cause = $request->cause;
            $service->note = $request->note;
            $service->refund = $request->refund;
            if ($files = $request->file('images')) {
                $images = array();
                foreach ($files as $file) {
                    if ($file->isValid()) {
                        $img_path = $file->store('services');
                        $images[] = $img_path;
                    } else {
                        return redirect(route('index'))->with('fail', '图片上传失败');
                    }
                }
                $service->images = implode("|", $images);
                $service->save();
                return redirect(route('home_service_index'));
            } else {
                return redirect(route('index'))->with('fail', '图片上传失败');
            }
        } else {
            Auth::logout();
            return redirect(route('index'));
        }
    }

    public function service_show(Request $request)
    {
        $page = 'dashboard';
        $user = Auth::user();
        $service = $user->services->find($request->service_id);
        return view('home.services.show', compact('service', 'page'));
    }
}
