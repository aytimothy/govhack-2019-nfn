<?php

namespace App\Http\Controllers;

use App\Reading;
use Illuminate\Http\Request;
use \App\Temperature;
use \App\Humidity;
use \App\Sound;
use \App\Light;
use \App\Turbidity;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $node_id = 1;
        $range = 24;
        $date = \Carbon\Carbon::now()->subHours($range);
        $light_labels2 = Reading::where([['node_id', '=', $node_id], ['time', '>=', $date]])->pluck('time')->toArray();
        $light_labels = [sizeof($light_labels2)];
        for ($i = 0; $i < sizeof($light_labels2); $i++) {
            $created_time = $light_labels2[$i];
            $newtime = \Carbon\Carbon::parse($created_time)->toDateTimeString();
            $light_labels[$i] = $newtime;
            //dd($newtime);
        }

        $light_datapoints = Reading::where([['node_id', '=', $node_id], ['time', '>=', $date]])->pluck('light')->toArray();
        $temperature_datapoints = Reading::where([['node_id', '=', $node_id], ['time', '>=', $date]])->pluck('temperature')->toArray();
        $humidity_datapoints = Reading::where([['node_id', '=', $node_id], ['time', '>=', $date]])->pluck('humidity')->toArray();
        $sound_datapoints = Reading::where([['node_id', '=', $node_id], ['time', '>=', $date]])->pluck('sound')->toArray();

        $all_chart = app()->chartjs
            ->name('all_chart')
            ->type('line')
            ->size(['width' => 400, 'height' => 200])
            ->labels($light_labels)
            ->datasets([
                [
                    "label" => "Sound",
                    'backgroundColor' => "rgba(193, 66, 66, 0)",
                    'borderColor' => "rgba(0,0,255,0.50",
                    "pointBorderColor" => "rgba(193, 66, 66, 0)",
                    "pointBackgroundColor" => "rgba(193, 66, 66, 0)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => $sound_datapoints,
                ],
                [
                    "label" => "Light",
                    'backgroundColor' => "rgba(193, 66, 66, 0)",
                    'borderColor' => "red",
                    "pointBorderColor" => "rgba(193, 66, 66, 0)",
                    "pointBackgroundColor" => "rgba(193, 66, 66, 0)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => $light_datapoints,
                ],
                [
                    "label" => "Temperature",
                    'backgroundColor' => "rgba(193, 66, 66, 0)",
                    'borderColor' => "green",
                    "pointBorderColor" => "rgba(193, 66, 66, 0)",
                    "pointBackgroundColor" => "rgba(193, 66, 66, 0)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => $temperature_datapoints,
                ],
                [
                    "label" => "Humidity",
                    'backgroundColor' => "rgba(193, 66, 66, 0)",
                    'borderColor' => "yellow",
                    "pointBorderColor" => "rgba(193, 66, 66, 0)",
                    "pointBackgroundColor" => "rgba(193, 66, 66, 0)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => $humidity_datapoints,
                ],


            ])
            ->options([]);


        $node_id = 2;
        $range = 24;
        $date = \Carbon\Carbon::now()->subHours($range);
        $light_labels2 = Reading::where([['node_id', '=', $node_id], ['time', '>=', $date]])->pluck('time')->toArray();
        $light_labels = [sizeof($light_labels2)];
        for ($i = 0; $i < sizeof($light_labels2); $i++) {
            $created_time = $light_labels2[$i];
            $newtime = \Carbon\Carbon::parse($created_time)->toDateTimeString();
            $light_labels[$i] = $newtime;
            //dd($newtime);
        }

        $light_datapoints = Reading::where([['node_id', '=', $node_id], ['time', '>=', $date]])->pluck('light')->toArray();
        $temperature_datapoints = Reading::where([['node_id', '=', $node_id], ['created_at', '>=', $date]])->pluck('temperature')->toArray();
        $humidity_datapoints = Reading::where([['node_id', '=', $node_id], ['time', '>=', $date]])->pluck('humidity')->toArray();
        $sound_datapoints = Reading::where([['node_id', '=', $node_id], ['time', '>=', $date]])->pluck('sound')->toArray();

        $all_chart2 = app()->chartjs
            ->name('all_chart2')
            ->type('line')
            ->size(['width' => 400, 'height' => 200])
            ->labels($light_labels)
            ->datasets([
                [
                    "label" => "Sound",
                    'backgroundColor' => "rgba(193, 66, 66, 0)",
                    'borderColor' => "rgba(0,0,255,0.50",
                    "pointBorderColor" => "rgba(193, 66, 66, 0)",
                    "pointBackgroundColor" => "rgba(193, 66, 66, 0)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => $sound_datapoints,
                ],
                [
                    "label" => "Light",
                    'backgroundColor' => "rgba(193, 66, 66, 0)",
                    'borderColor' => "red",
                    "pointBorderColor" => "rgba(193, 66, 66, 0)",
                    "pointBackgroundColor" => "rgba(193, 66, 66, 0)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => $light_datapoints,
                ],
                [
                    "label" => "Temperature",
                    'backgroundColor' => "rgba(193, 66, 66, 0)",
                    'borderColor' => "green",
                    "pointBorderColor" => "rgba(193, 66, 66, 0)",
                    "pointBackgroundColor" => "rgba(193, 66, 66, 0)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => $temperature_datapoints,
                ],
                [
                    "label" => "Humidity",
                    'backgroundColor' => "rgba(193, 66, 66, 0)",
                    'borderColor' => "yellow",
                    "pointBorderColor" => "rgba(193, 66, 66, 0)",
                    "pointBackgroundColor" => "rgba(193, 66, 66, 0)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => $humidity_datapoints,
                ],


            ])
            ->options([]);

        $node_id = 3;
        $range = 24;
        $date = \Carbon\Carbon::now()->subHours($range);
        $light_labels2 = Reading::where([['node_id', '=', $node_id], ['time', '>=', $date]])->pluck('time')->toArray();
        $light_labels = [sizeof($light_labels2)];
        for ($i = 0; $i < sizeof($light_labels2); $i++) {
            $created_time = $light_labels2[$i];
            $newtime = \Carbon\Carbon::parse($created_time)->toDateTimeString();
            $light_labels[$i] = $newtime;
            //dd($newtime);
        }

        $light_datapoints = Reading::where([['node_id', '=', $node_id], ['time', '>=', $date]])->pluck('light')->toArray();
        $temperature_datapoints = Reading::where([['node_id', '=', $node_id], ['created_at', '>=', $date]])->pluck('temperature')->toArray();
        $humidity_datapoints = Reading::where([['node_id', '=', $node_id], ['time', '>=', $date]])->pluck('humidity')->toArray();
        $sound_datapoints = Reading::where([['node_id', '=', $node_id], ['time', '>=', $date]])->pluck('sound')->toArray();

        $all_chart3 = app()->chartjs
            ->name('all_chart3')
            ->type('line')
            ->size(['width' => 400, 'height' => 200])
            ->labels($light_labels)
            ->datasets([
                [
                    "label" => "Sound",
                    'backgroundColor' => "rgba(193, 66, 66, 0)",
                    'borderColor' => "rgba(0,0,255,0.50",
                    "pointBorderColor" => "rgba(193, 66, 66, 0)",
                    "pointBackgroundColor" => "rgba(193, 66, 66, 0)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => $sound_datapoints,
                ],
                [
                    "label" => "Light",
                    'backgroundColor' => "rgba(193, 66, 66, 0)",
                    'borderColor' => "red",
                    "pointBorderColor" => "rgba(193, 66, 66, 0)",
                    "pointBackgroundColor" => "rgba(193, 66, 66, 0)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => $light_datapoints,
                ],
                [
                    "label" => "Temperature",
                    'backgroundColor' => "rgba(193, 66, 66, 0)",
                    'borderColor' => "green",
                    "pointBorderColor" => "rgba(193, 66, 66, 0)",
                    "pointBackgroundColor" => "rgba(193, 66, 66, 0)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => $temperature_datapoints,
                ],
                [
                    "label" => "Humidity",
                    'backgroundColor' => "rgba(193, 66, 66, 0)",
                    'borderColor' => "yellow",
                    "pointBorderColor" => "rgba(193, 66, 66, 0)",
                    "pointBackgroundColor" => "rgba(193, 66, 66, 0)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => $humidity_datapoints,
                ],


            ])
            ->options([]);

        return view('home')->with(compact('all_chart', 'all_chart2', 'all_chart3'));

    }



}
