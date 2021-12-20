<?php

use App\Models\User;
use App\Models\category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


function admins(){

	$admins = User::where('is_admin',1)->get();
	return $admins;
}