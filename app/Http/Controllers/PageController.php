<?php

namespace App\Http\Controllers;
use App\User;

class PageController extends Controller {

    public function about() {
        return "About Us Page";
    }

    public function contact() {
        return "Contact Page";
    }

    public function submitContact() {
        return "Submitted Contact Page";
    }

    public function profile($id) {
        $user = User::with('questions', 'answers', 'answers.question')->find($id);
        return view('profile')->with('user', $user);
    }

}
