@extends('template')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-6 col-md-offset-3">
                <h1>{{ $address->formatted_address }}</h1>
                <hr />

                <p>
                    {{ $weather->weather->description }}
                   </p>

                   <ul>
                    <li>Curent Temp: {{ $weather->temp }}</li>
                    <li>Feels like: {{ $weather->app_temp }}</li>
                    <li>Wind Speed: {{ $weather->wind_spd }} mps</li>

                   </ul>

             </div>
        </div>
    </div>
@endsection
