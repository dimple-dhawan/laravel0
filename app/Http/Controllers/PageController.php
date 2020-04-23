<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactForm;




class PageController extends Controller {

    public function about() {
        return "About Us Page";
    }

    public function contactUs() {
        return "Contact Page";
    }

    public function submitContact() {
        return "Submitted Contact Page";
    }

    public function profile($id) {
        $user = User::with('questions', 'answers', 'answers.question')->find($id);
        return view('profile')->with('user', $user);
    }

    public function contact() {
        return view('contact');
    }

    public function sendContact(Request $request) {
        // Send and process the email

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required|min:2',
            'message' => 'required|min:2'
        ]);

        Mail::to('admin@example.com')->send( new ContactForm($request) );

        return redirect(('/'));

    }

}
