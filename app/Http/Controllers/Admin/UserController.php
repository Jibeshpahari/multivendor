<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $title = "Customer Listing";
        $search = true;

        return view('admin.customer.index', compact('title', 'search'));
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
