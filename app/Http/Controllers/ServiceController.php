<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected function execute(){

        if(view()->exists('admin.services')){

            $services = Service::all();

            $data = [
                'title' => 'Portfolios',
                'services' => $services
            ];

            return view('admin.services', $data);

        }

        abort(404);

    }
}
