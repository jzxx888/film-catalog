<?php 

namespace App\Controllers;

class FilmController extends Controller {
    public function index()
    {
        return 'FilmController index';
    }

    /**
     * @param mixed $film (id|slug)
     */
    public function show($film)
    {
        return 'FilmController show: '.$film;
    }

    public function test($user, $action) {
        return "{$action} user: {$user}";
    }
}