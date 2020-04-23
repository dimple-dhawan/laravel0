<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rules\Unique;
use App\User;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class UploadController extends Controller
{
    public function getUpload()
    {
        return view('upload');
    }

    public function postUpload(Request $request)
    {
        $user = Auth::user();
        $file = $request->file('picture');
        $filename = uniqid( $user->id . "_" ).".". $file->getClientOriginalExtension();
        Storage::disk('s3')->put($filename, File::get($file), 'public');

        // update the user record with the new proile pic filename
        $url = Storage::disk('s3')->url($filename);
        $user->profile_pic = $url;
        $user->save();

        $thumb = Image::make($file);
        $thumb->fit(150);
        $jpg = (string) $thumb->encode('jpg');

        $thumbName = pathinfo($filename, PATHINFO_FILENAME).'-thumb.jpg';
        Storage::disk('s3')->put($thumbName, $jpg, 'public');


        return view('upload-complete')->with('filename', $filename)->with('url', $url);
    }

}
