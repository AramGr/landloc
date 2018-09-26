<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceAddController extends Controller
{
    public function execute(Request $request)
    {

        if($request->isMethod('post')){

            $input = $request->except('_token');

            $messages = [
                'required' => ':attribute դաշտը պարտադիր է'
            ];

            $validator = Validator::make($input, [
                'name' => 'required|max:255',
                'icon' => 'required',
                'text' => 'required'
            ], $messages);

            if($validator->fails()){
                return redirect()->route('serviceAdd')->withErrors($validator)->withInput();
            }

            $service = new Service();

            $service->fill($input);

            if($service->save()){
                return redirect('admin')->with('status', 'The service is added');
            }

        }




        if(view()->exists('admin.service_add')){

            $data = [
                'title' => 'New Service'
            ];

            return view('admin.service_add', $data);

        }
    }
}
