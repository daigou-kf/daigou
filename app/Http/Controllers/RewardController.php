<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RewardController extends Controller
{
    public function __construct()
    {
        $this->middleware('check_reward');
    }
}
