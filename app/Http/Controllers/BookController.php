<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\book;
use App\Models\Order;

class BookController extends Controller
{
    public function index()
    {
        $data['records'] = book::get();
        return view('book.index', $data);
    }
}
