<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PagesEditController extends Controller
{
    protected function execute(Page $page, Request $request)
    {
        //if the request comes with parameter in url, dependency injection of Laravel (Page) selects the requested data from database
//        $page = Page::find($id);

        if($request->isMethod('delete')){
            $page->delete();
            return redirect('admin')->with('status', 'The page is deleted');
        }

        if($request->isMethod('post')){

            $input = $request->except('_token');

            $validator = Validator::make($input, [
                'name' => 'required|max:255',
                'alias' => 'required|max:255|unique:pages,alias,'.$input['id'],
                'text' => 'required'
            ]);

            if($validator->fails()){
                return redirect()->route('pagesEdit', ['page' => $input['id']])->withErrors($validator);
            }

            if($request->hasFile('images')){
                $file = $request->file('images');
                $file->move(public_path().'/assets/img', $file->getClientOriginalName());
                $input['images'] = $file->getClientOriginalName();
            } else {
                $input['images'] = $input['old_images'];
            }
//hanum enq old_images-@ vor fill()-ov modelin asenq qci database, vor error chta havai avel datai hamar
            unset($input['old_images']);

            $page->fill($input);

            if($page->update()){
                return redirect('admin')->with('status', 'The page is updated');
            }

        }

        $old = $page->toArray();

        if(view()->exists('admin.pages_edit')){

            $data = [
                'title' => 'Editing the page '.$old['name'],
                'data' => $old
            ];

            return view('admin.pages_edit', $data);
        }

    }
}
