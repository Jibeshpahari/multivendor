<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $title = "Customer Listing";
        return view('admin.customer.index', compact('title'));
    }

    public function add()
    {
        return view('admin.vendor.form');
    }

    public function edit()
    {
        return view('admin.vendor.form');
    }
}
