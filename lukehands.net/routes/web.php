<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use \App\Reading;
use \App\Turbidity;
use \App\Temperature;
use \App\Humidity;
use \App\Sound;
use \App\Light;
use \App\Location;
use \App\Node;


Route::get('/', function () {

    return view('welcome');
});

Route::get('/rcv', function () {
    $input_string = $_GET['str'];
    $readings = explode('~', $input_string);
    Reading::create([
        'node_id' => $readings[0],
        'time' => \Carbon\Carbon::now(),
        'temperature' => $readings[2],
        'humidity' => $readings[3],
        'sound' => $readings[4],
        'light' => floatval($readings[5]),
    ]);
});


Route::get('/rcv_csv', function () {

    echo "/rcv_csv</br>";
    chdir("import_csv");
    $current_dir = getcwd();
    $dir = scandir($current_dir);
    $files = array_diff($dir, array('.', '..'));
    print_r($files);
    echo "</br>";
    $myfile = fopen("3_201118.CSV", "r") or die("Unable to open file!");
    while (!feof($myfile)) {
        $line = fgets($myfile);
        $readings = explode(',', $line);
        if(count($readings)>1) {
            if ($readings[1] != "2165-165-165 165:11:30") {
                Reading::create([
                    'node_id' => $readings[0],
                    'time' => $readings[1],
                    'temperature' => $readings[2],
                    'humidity' => $readings[3],
                    'sound' => $readings[4],
                    'light' => floatval($readings[5]),
                ]);
            }
        }

        echo fgets($myfile) . "<br>";
    }
    fclose($myfile);
    dd();
});


Route::get('/rcv_humidity', function () {

    //dd($_GET['input_string']);
    $input_string = $_GET['input_string'];
    $readings = explode('~', $input_string);

    Humidity::create([
        'node_id' => $readings[0],
        'humidity' => $readings[1],
    ]);
});

Route::get('/rcv_temperature', function () {

    //dd($_GET['input_string']);
    $input_string = $_GET['input_string'];
    $readings = explode('~', $input_string);

    Temperature::create([
        'node_id' => $readings[0],
        'temperature' => $readings[1],
    ]);
});

Route::get('/rcv_sound', function () {

    //dd($_GET['input_string']);
    $input_string = $_GET['input_string'];
    $readings = explode('~', $input_string);

    Sound::create([
        'node_id' => $readings[0],
        'sound_value' => $readings[1],
    ]);
});

Route::get('/rcv_lux', function () {

    //dd($_GET['input_string']);
    $input_string = $_GET['input_string'];
    $readings = explode('~', $input_string);

    if ($readings[1] != '262143.00') {
        Light::create([
            'node_id' => $readings[0],
            'lux_value' => $readings[1],
        ]);
    }


});

Route::get('/rcv_location', function () {

    //dd($_GET['input_string']);
    $input_string = $_GET['input_string'];
    $readings = explode(',', $input_string);

    Location::create([
        'node_id' => $readings[0],
        'latitude' => $readings[1],
        'northsouth' => $readings[2],
        'longitude' => $readings[3],
        'eastwest' => $readings[4],
        'date' => $readings[5],
        'gps_utc_time' => $readings[6],
        'altitude' => $readings[7],
        'speed' => $readings[8],
        'course' => $readings[9],
    ]);
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/sound/{node_id}/{hours?}', function ($node_id = 0, $hours = 36) {

    $range = $hours;
    $date = \Carbon\Carbon::now()->subHours($range);
    $sound_labels2 = Reading::where([['node_id', $node_id], ['time', '>=', $date]])->pluck('time')->toArray();
    $sound_labels = [sizeof($sound_labels2)];
    for ($i = 0; $i < sizeof($sound_labels2); $i++) {
        $created_time = $sound_labels2[$i];
        $newtime = \Carbon\Carbon::parse($created_time)->toDateTimeString();
        $sound_labels[$i] = $newtime;
    }
    $datapoints = Reading::where([['node_id', $node_id], ['time', '>=', $date]])->pluck('sound')->toArray();


    $chartjs = app()->chartjs
        ->name('lineChartTest')
        ->type('line')
        ->size(['width' => 400, 'height' => 200])
        ->labels($sound_labels)
        ->datasets([
            [
                "label" => "Sound",
                'backgroundColor' => "rgba(193, 66, 66, 0)",
                'borderColor' => "blue",
                "pointBorderColor" => "blue",
                "pointBackgroundColor" => "blue",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => $datapoints,
            ]
        ])
        ->options([]);

    return view('example')->with(compact('chartjs'));
});

Route::get('/light/{node_id}/{hours?}', function ($node_id = 1, $hours = 36) {

    $range = $hours;
    $date = \Carbon\Carbon::now()->subHours($range);
    $light_labels2 = Reading::where([['node_id', $node_id], ['time', '>=', $date]])->pluck('time')->toArray();
    $light_labels = [sizeof($light_labels2)];
    for ($i = 0; $i < sizeof($light_labels2); $i++) {
        $created_time = $light_labels2[$i];
        $newtime = \Carbon\Carbon::parse($created_time)->toDateTimeString();
        $light_labels[$i] = $newtime;
    }
    $datapoints = Reading::where([['node_id', $node_id], ['created_at', '>=', $date]])->pluck('light')->toArray();

    $chartjs = app()->chartjs
        ->name('lineChartTest')
        ->type('line')
        ->size(['width' => 400, 'height' => 200])
        ->labels($light_labels)
        ->datasets([
            [
                "label" => "Light",
                'backgroundColor' => "rgba(193, 66, 66, 0)",
                'borderColor' => "blue",
                "pointBorderColor" => "blue",
                "pointBackgroundColor" => "blue",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => $datapoints,
            ]
        ])
        ->options([]);

    return view('example')->with(compact('chartjs'));
});

Route::get('/temperature/{node_id}/{hours?}', function ($node_id = 1, $hours = 36) {

    $range = $hours;
    $date = \Carbon\Carbon::now()->subHours($range);
    $temperature_labels2 = Reading::where([['node_id', $node_id], ['time', '>=', $date]])->pluck('time')->toArray();
    $temperature_labels = [sizeof($temperature_labels2)];
    for ($i = 0; $i < sizeof($temperature_labels2); $i++) {
        $created_time = $temperature_labels2[$i];
        $newtime = \Carbon\Carbon::parse($created_time)->toDateTimeString();
        $temperature_labels[$i] = $newtime;
    }
    $datapoints = Reading::where([['node_id', $node_id], ['created_at', '>=', $date]])->pluck('temperature')->toArray();


    $chartjs = app()->chartjs
        ->name('lineChartTest')
        ->type('line')
        ->size(['width' => 400, 'height' => 200])
        ->labels($temperature_labels)
        ->datasets([
            [
                "label" => "Temperature",
                'backgroundColor' => "rgba(193, 66, 66, 0)",
                'borderColor' => "blue",
                "pointBorderColor" => "rgba(193, 66, 66, 0)",
                "pointBackgroundColor" => "rgba(193, 66, 66, 0)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => $datapoints,
            ]
        ])
        ->options([]);

    return view('example')->with(compact('chartjs'));
});

Route::get('/humidity/{node_id}/{hours?}', function ($node_id = 1, $hours = 36) {

    $range = $hours;
    $date = \Carbon\Carbon::now()->subHours($range);
    $humidity_labels2 = Reading::where([['node_id', $node_id], ['time', '>=', $date]])->pluck('time')->toArray();
    $humidity_labels = [sizeof($humidity_labels2)];
    for ($i = 0; $i < sizeof($humidity_labels2); $i++) {
        $created_time = $humidity_labels2[$i];
        $newtime = \Carbon\Carbon::parse($created_time)->toDateTimeString();
        $humidity_labels[$i] = $newtime;
    }
    $datapoints = Reading::where([['node_id', $node_id], ['time', '>=', $date]])->pluck('humidity')->toArray();


    $chartjs = app()->chartjs
        ->name('lineChartTest')
        ->type('line')
        ->size(['width' => 400, 'height' => 200])
        ->labels($humidity_labels)
        ->datasets([
            [
                "label" => "Humidity",
                'backgroundColor' => "rgba(193, 66, 66, 0)",
                'borderColor' => "blue",
                "pointBorderColor" => "blue",
                "pointBackgroundColor" => "blue",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => $datapoints,
            ]
        ])
        ->options([]);

    return view('example')->with(compact('chartjs'));
});


Route::get('/node/{node_id}/{hours?}', function ($node_id = 1, $hours = 24) {

    $range = $hours;
    $date = \Carbon\Carbon::now()->subHours($range);

    $humidity2_labels = Reading::where('node_id', $node_id)->where('time', '>=', $date)->pluck('time')->toArray();
    $humidity_labels = [sizeof($humidity2_labels)];
    for ($i = 0; $i < sizeof($humidity2_labels); $i++) {
        $created_time = $humidity2_labels[$i];
        $newtime = \Carbon\Carbon::parse($created_time)->toDateTimeString();
        $humidity_labels[$i] = $newtime;
        //dd($newtime);
    }
    $humidity2_datapoints = Reading::where('node_id', $node_id)->where('time', '>=', $date)->pluck('humidity')->toArray();
    //$datapoints2 = Humidity::where('node_id', $node_id)->where('time', '>=', $date)->pluck('humidity')->toArray();

    $humidity_chart = app()->chartjs
        ->name('humidity')
        ->type('line')
        ->size(['width' => 400, 'height' => 200])
        ->labels($humidity_labels)
        ->datasets([
            /*[
                "label" => "Node ".$node_id." NTU",
                'backgroundColor' => "rgba(193, 66, 66, 0)",
                'borderColor' => "blue",
                "pointBorderColor" => "blue",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => $datapoints2,
            ],*/
            [
                "label" => "Node " . $node_id . " Humidity",
                'backgroundColor' => "rgba(193, 66, 66, 0)",
                'borderColor' => "red",
                "pointBorderColor" => "rgba(193, 66, 66, 0)",
                "pointBackgroundColor" => "rgba(193, 66, 66, 0)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => $humidity2_datapoints,
            ]
        ])
        ->options([]);

    $temperature_labels2 = Reading::where('node_id', $node_id)->where('time', '>=', $date)->pluck('time')->toArray();
    $temperature_labels = [sizeof($temperature_labels2)];
    for ($i = 0; $i < sizeof($temperature_labels2); $i++) {
        $created_time = $temperature_labels2[$i];
        $newtime = \Carbon\Carbon::parse($created_time)->toDateTimeString();
        $temperature_labels[$i] = $newtime;
        //dd($newtime);
    }
    $temperature_datapoints = Reading::where('node_id', $node_id)->where('time', '>=', $date)->pluck('temperature')->toArray();
    //$datapoints2 = Turbidity::where('node_id','2')->orderBy('id','desc')->take(100000)->pluck('analog_read')->toArray();

    $temperature_chart = app()->chartjs
        ->name('temperature')
        ->type('line')
        ->size(['width' => 400, 'height' => 200])
        ->labels($temperature_labels)
        ->datasets([
            /*[
                "label" => "Node 2",
                'backgroundColor' => "white",
                'borderColor' => "blue",
                "pointBorderColor" => "blue",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => $datapoints,
            ],*/
            [
                "label" => "Node " . $node_id . " Temperature",
                'backgroundColor' => "rgba(193, 66, 66, 0)",
                'borderColor' => "blue",
                "pointBorderColor" => "rgba(193, 66, 66, 0)",
                "pointBackgroundColor" => "rgba(193, 66, 66, 0)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => $temperature_datapoints,
            ]
        ])
        ->options([]);

    $light_labels2 = Reading::where('node_id', $node_id)->where('time', '>=', $date)->pluck('time')->toArray();
    $light_labels = [sizeof($light_labels2)];
    for ($i = 0; $i < sizeof($light_labels2); $i++) {
        $created_time = $light_labels2[$i];
        $newtime = \Carbon\Carbon::parse($created_time)->toDateTimeString();
        $light_labels[$i] = $newtime;
        //dd($newtime);
    }
    //$turbidity2_datapoints = Turbidity::where('node_id',$node_id)->where('created_at','>=',$date)->pluck('analog_read')->toArray();
    $datapoints_light = Reading::where('node_id', $node_id)->where('time', '>=', $date)->pluck('light')->toArray();

    $light_chart = app()->chartjs
        ->name('light')
        ->type('line')
        ->size(['width' => 400, 'height' => 200])
        ->labels($light_labels)
        ->datasets([
            [
                "label" => "Node " . $node_id . " Light",
                'backgroundColor' => "rgba(193, 66, 66, 0)",
                'borderColor' => "blue",
                "pointBorderColor" => "blue",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => $datapoints_light,
            ],
            /*[
                "label" => "Node ".$node_id." Analog" ,
                'backgroundColor' => "rgba(193, 66, 66, 0)",
                'borderColor' => "red",
                "pointBorderColor" => "rgba(193, 66, 66, 0)",
                "pointBackgroundColor" => "rgba(193, 66, 66, 0)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => $turbidity2_datapoints,
            ]*/
        ])
        ->options([]);

    return view('node_view')->with(compact('humidity_chart', 'temperature_chart', 'light_chart'));

});
