<?php

namespace App\Http\Controllers;

use App\Portfolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    //
    protected function execute(){

        if(view()->exists('admin.portfolios')){

            $portfolios = Portfolio::all();

            $data = [
                'title' => 'Portfolios',
                'portfolios' => $portfolios
            ];

            return view('admin.portfolios', $data);

        }

        abort(404);

    }
}
