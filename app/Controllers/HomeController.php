<?php 

namespace App\Controllers;

class HomeController
{
    public function index()
    {
        return view('test', ['name' => 'John', 'age' => 35]);
    }
}