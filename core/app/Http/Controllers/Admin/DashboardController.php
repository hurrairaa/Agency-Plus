<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Quote;
use App\Portfolio;

class DashboardController extends Controller
{
    public function dashboard() {
      $data['quotes'] = Quote::orderBy('id', 'DESC')->limit(10)->get();
      $data['portfolios'] = Portfolio::orderBy('id', 'DESC')->limit(10)->get();
      return view('admin.dashboard', $data);
    }
}
