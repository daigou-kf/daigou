<?php

namespace App\Http\Controllers;

use App\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Order;
use App\Service;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('users.index',compact('users'));
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
        $user = User::find($id);
        $cart_products = $user->cart_products;
        $orders = $user->orders;
        $addresses = $user->addresses;
        $fav_products = $user->fav_products;
        return view('users.show',compact('user','cart_products','orders','addresses','fav_products','id'));
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
    public function update(Request $request, $id)
    {
        //
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

    public function staff_index(){
        $admins = User::all()->where('admin','1');
        $staffs = User::all()->where('staff','>','0');
        return view('staffs.index',compact('staffs','admins'));
    }

    public function staff_create(){
        return view('staffs.create');
    }

    public function staff_store(Request $request){
        if($request->staff == 0){
            return redirect(route('staff_index'))->with('fail','没有选择职务');
        } else {
            $user = User::create([
                'email' => $request['phone'],
                'password' => Hash::make($request['password']),
                'phone'=>$request['phone'],
            ]);
            $user->staff = $request['staff'];
            $user->save();
            return redirect(route('staff_index'))->with('success','创建新员工账户成功');
        }
    }


    public static function add_points($user_id, $order_id){
        $order = Order::find($order_id);
        $user = User::find($user_id);
        $points = $order->total;
        $points = $points/10;
        if($user->cuid == null){
            $user->points += $points;
            $user->save();
        } else {
            PospalController::change_user_points('phone',$user->phone,null,$points);
        }

    }

}
