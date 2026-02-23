<?php 

namespace App\Controllers;

class HomeController
{
    public function index()
    {
        return view(
            'home', 
            [
                'title' => 'Home',
                'css' => [
                    'home'
                ]
            ]
        );
    }

    public function form()
    {
        return view(
            'form', 
            [
                'title' => 'Home – Form',
                'css' => [
                    'home'
                ]
            ]
        );
    }
}