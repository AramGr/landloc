<?php

namespace App\Http\Controllers;

use App\Page;
use App\Service;
use App\Portfolio;
use App\People;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class IndexController extends Controller
{
    public function execute (Request $request) {

        if($request->ismethod('post')){

            $messages = [
                'required' => 'The field :attribute must be filled in',
                'email' => 'The field :attribute must be a valid email',
            ];

            $this->validate($request, [
                'name' => 'required|max:255',
                'email' => 'required|email',
                'text' => 'required',
            ], $messages);

            $data = $request->all();

            //mail
            $result = Mail::send('site.email', ['data' => $data], function($message) use ($data) {

                $mail_admin = env('MAIL_ADMIN');
                $message->from($data['email'], $data['name']);
                $message->to($mail_admin, 'Mr. Admin')->subject('Question');

            });

                return redirect()->route('home')->with('status', 'Email is sent');

        }

        $pages = Page::all();
        $portfolios = Portfolio::get(['name', 'filter', 'images']);
        $services = Service::where('id', '<', 20)->get();
        $peoples = People::take(3)->get();

        $tags = DB::table('portfolios')->distinct()->pluck('filter');

        $menu = [];
        foreach ($pages as $page){
            $item = ['title' => $page->name, 'alias' => $page->alias];
            $menu[] = $item;
        }

        $item = ['title' => 'Services', 'alias' => 'service'];
        $menu[] = $item;

        $item = ['title' => 'Portfolio', 'alias' => 'Portfolio'];
        $menu[] = $item;

        $item = ['title' => 'Team', 'alias' => 'team'];
        $menu[] = $item;

        $item = ['title' => 'Contact', 'alias' => 'contact'];
        $menu[] = $item;


        return view('site.index', [
                                            'menu' => $menu,
                                            'pages' => $pages,
                                            'services' => $services,
                                            'portfolios' => $portfolios,
                                            'peoples' => $peoples,
                                            'tags' =>$tags
                                        ]);

    }
}
