@extends('template')

@section('content')
    <div class="container" id="app">
        <div class="row">

            <div class="col-md-6 col-md-offset-3" v-if="step == 1">
                <h1>Enter an Address to get Weather</h1>
                <hr />
                <form>
                    <input type="text" name="location" style="margin: 20px 0;"
                            class="form-control" placeholder="Enter a Zipcode or Address"
                            v-model="userInput" />
                    <button class="btn btn-primary"style="width: 100%;"
                            v-on:click.prevent="getWeather"
                            v-show="userInput">Get Weather</button>
                </form>
             </div>

             <div class="col-md-6 col-md-offset-3" v-if="step == 2">
                <h1> @{{ googleAddress.formatted }} </h1>
                <hr />

                <ul>
                <li>Lat: @{{ googleAddress.lat }}</li>
                <li>Long: @{{ googleAddress.lng }}</li>
                </ul>
            <p> @{{ weatherBit.summary  }}</p>

                <ul>
                <li>Curent Temp:   @{{ weatherBit.temp }} </li>
                <li>Feels like:   @{{ weatherBit.feelsLikeTemp }}  </li>
                <li>Wind Speed:   @{{ weatherBit.windSpeed }}  </li>
                </ul>

             </div>

        </div>
    </div>
@endsection

@section('scripts')
<script>
var app = new Vue({
    el: '#app',
    data: {
        step: 1,
        userInput: '',
        googleAddress: {
            formatted: '',
            lat: '',
            lng: '',
        },
        weatherBit: {
            summary: '',
            temp: '',
            feelsLikeTemp: '',
            windSpeed: ''
        }
    },
    methods: {
        getWeather: function() {
            this.step = 2
            let vm = this;
            axios.get('https://maps.googleapis.com/maps/api/geocode/json', {
                params: {
                    address: vm.userInput,
                    key:  "{{ env('GOOGLE_API_KEY') }}",
                }
            }).then(function (response) {
                let res = response.data.results[0];
                vm.googleAddress.formatted = res.formatted_address;
                vm.googleAddress.lat = res.geometry.location.lat;
                vm.googleAddress.lng = res.geometry.location.lng;

                let weatherBitAPI = "{{ env('WEATHERBIT_API_KEY') }}"

                let url = `http://api.weatherbit.io/v2.0/forecast/hourly?key=${weatherBitAPI}&lat=${res.geometry.location.lat}&lon=${res.geometry.location.lng}`
                return axios.get(url)
            }).then( function (response) {
                let res2 = response.data.data[0]
                vm.weatherBit.summary = res2.weather.description;
                vm.weatherBit.temp = res2.temp;
                vm.weatherBit.feelsLikeTemp = res2.app_temp;
                vm.weatherBit.windSpeed = res2.wind_spd;
            })

        }
    }
});


</script>
@endsection
