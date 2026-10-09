<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VendorRequest;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index() {
        return view('admin.vendor.index');
    }

    public function add() {
        return view('admin.vendor.form');
    }
}
