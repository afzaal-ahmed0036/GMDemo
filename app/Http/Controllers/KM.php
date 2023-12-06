<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class KM extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    public function welcome2()
    {

        return view('welcome');
    }

    public function Login()
    {

        return view('login');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Prayer()
    {
        //

        $date = '2022-06-06';
        $data = Http::get('http://api.aladhan.com/v1/hijriCalendarByCity?city=Jhelum&country=Pakistan&method=2&month=11&year=2022')->json();


        echo $date;



        $content_array =  $data;



        for ($i = 0; $i <= 29; $i++) {


            $selectedTime = $data['data'][$i]['timings']['Sunrise'];
            $ishraq = date('h:i', strtotime($selectedTime . ' +15 minutes'));


            echo "<pre>";
            print_r('Fajr: ' . $data['data'][$i]['timings']['Fajr']); // an associative array.
            print_r('<br>Sunrise: ' .  $data['data'][$i]['timings']['Sunrise']); // an associative array.
            print_r('<br>Ishraq: ' .  $ishraq); // an associative array.
            print_r('<br>Dhuhr: ' .  $data['data'][$i]['timings']['Dhuhr']); // an associative array.
            print_r('<br>Asr: ' .  $data['data'][$i]['timings']['Asr']); // an associative array.
            print_r('<br>Maghrib: ' .  $data['data'][$i]['timings']['Maghrib']); // an associative array.
            print_r('<br>Isha: ' .  $data['data'][$i]['timings']['Isha']); // an associative array.

            echo "<br>";
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function base1()
    {
        //
        return view('base64.base1');
    }

    public function base2(Request $request)
    {



        $url = $request->signed;

        $urlParts = pathinfo($url);
        $extension = $urlParts['extension'];

        $base64 = 'data:image/' . $extension . ';base64,' . base64_encode(\Illuminate\Support\Facades\Http::get($url)->body());



        $folderPath = public_path('base64/');

        $image_parts = explode(";base64,", $base64);

        $image_type_aux = explode("image/", $image_parts[0]);

        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);

        $signature = uniqid() . '.' . $image_type;

        $file = $folderPath . $signature;

        file_put_contents($file, $image_base64);




        return back()->with('success', 'Form successfully submitted with signature');
    }
}
