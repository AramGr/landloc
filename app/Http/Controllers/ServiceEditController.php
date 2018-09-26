<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceEditController extends Controller
{
    public function execute(Service $service, Request $request)
    {
        if($request->isMethod('delete')){

            $service->delete();
            return redirect('admin')->with('status', 'The service is deleted');

        }

        if($request->isMethod('post')){

            $input = $request->except('_token');

            $messages = [
                'required' => ':attribute դաշտը պարտադիր է'
            ];

            $validator = Validator::make($input, [
                'name' => 'required|max:255',
                'text' => 'required',
                'icon' => 'required'
            ], $messages);

            if($validator->fails()){
                return redirect()->route('serviceEdit', ['service' => $input['id']])->withErrors($validator);
            }

            $service->fill($input);

            if($service->update()){
                return redirect('admin')->with('status', 'The service is updated');
            }

        }

        if(view()->exists('admin.service_edit')){

            $old = $service->toArray();

            $data = [
                'title' => 'Editing the Service '.$old['name'],
                'data' => $old
            ];

            return view('admin.service_edit', $data);
        }
    }
}
