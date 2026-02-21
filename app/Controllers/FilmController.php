<?php 

namespace App\Controllers;

class FilmController extends Controller {
    public function index()
    {
        echo 'FilmController index';
    }

    /**
     * @param mixed $film (id|slug)
     */
    public function show($film)
    {
        echo 'FilmController show: '.$film;
    }

    public function test($user, $action) {
        echo "{$action} user: {$user}";
    }
}