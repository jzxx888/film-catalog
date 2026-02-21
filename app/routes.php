<?php

$app->router->add(
    "/", 
    function() {
        echo "Hello World";
    },
    ["get", "post"]
);
$app->router->get(
    "films", 
    [App\Controllers\FilmController::class, "index"]
);
$app->router->get(
    "film/{film}", 
    [App\Controllers\FilmController::class, "show"]
);
$app->router->post(
    "/users/", 
    [App\Controllers\FilmController::class, "index"]
);
$app->router->get(
    "/user/{user}/edit/{action}", 
    [App\Controllers\FilmController::class, "test"]
);