<?php

namespace App\Http\Controllers;

class IndexController extends Controller
{

    public function index()
    {
        throw new \Exception("Error Processing Request", 1);

        return redirect()->action('EventController@index');
    }
}
