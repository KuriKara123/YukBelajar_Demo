<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
 
    public function index()
    {
        $fproducts = Product::where('featured',1)->get()->take(8);
        return view('index',compact('fproducts'));
    }

    public function about(){
        return view('about');
    }

    public function contact(){
        return view('contact');
    }

    public function contact_store(Request $request){
        $request->validate([
            'name'=> 'required|max:100',
            'email'=> 'required|email',
            'phone'=> 'required|numeric|digits:10',
            'comment'=> 'required'
        ]);

        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->comment = $request->comment;
        $contact->save();
        return redirect()->back()->with('success','Your comment has been sent to us!');

    }

    public function search(Request $request){
        $query = $request->input('query');
        $results = Product::where('name','LIKE',"%{$query}%")->get()->take(8);
        return response()->json($results);
    }

}
