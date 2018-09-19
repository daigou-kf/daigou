<?php

namespace App\Http\Controllers;

use App\Address;
use App\Collection;
use App\Notifications\OrderPaid;
use App\Order;
use App\OrderProduct;
use App\SenderAddress;
use App\ShoppingCart;
use App\User;
use Doctrine\Common\Util\Debug;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use http\Exception;
use Illuminate\Http\Request;
use App\Favourite;
use App\Product;
use App\Category;
use App\Brand;
use App\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     * Main 5 tabs
     */
    public function index()
    {
        return redirect(route('home_home'));
    }

}
