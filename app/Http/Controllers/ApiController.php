<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client as GuzzleClient;

class ApiController extends Controller
{
    public function github($username)
    {
        $client = new GuzzleClient();
        $response = $client->get("https://api.github.com/users/$username");
        $body = json_decode($response->getBody()->getContents());

        print "Name: $body->name <br>";
        print "Location: $body->location <br>";
        print "Bio: $body->bio <br>";
    }

    public function getWeather()
    {
        return view('weather');
    }

    public function getWeatherJs()
    {
        return view('weather-js');
    }

    public function postWeather(Request $request)
    {
        $this->validate($request, ['location' => 'required|min:5']);

        // google api to get coords
        $googleClient = new GuzzleClient();
        $response = $googleClient->get('https://maps.googleapis.com/maps/api/geocode/json', [
            'query' => [
                'address' => $request->location,
                'key' => env('GOOGLE_API_KEY'),
            ]
        ]);

        $googleBody = json_decode($response->getBody());
        $coords = $googleBody->results[0]->geometry->location;

        //print "Lat: $coords->lat <br> ";
        //print "Lng: $coords->lng <br> ";

        // use the coords to get weather from weather api
        $weatherBitClient = new GuzzleClient();
        $wbUrl = 'http://api.weatherbit.io/v2.0/forecast/hourly?key='.env('WEATHERBIT_API_KEY').
                "&lat=$coords->lat&lon=$coords->lng";

        $wbResponse = $weatherBitClient->get($wbUrl);

        $weatherBody = json_decode($wbResponse->getBody());

        return view('weather-ready')->with('weather', $weatherBody->data[0])->with('address', $googleBody->results[0]);
    }

}
