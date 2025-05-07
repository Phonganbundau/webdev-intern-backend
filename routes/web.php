<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/user', function () {
    return ("
        <h1>Hello, User!</h1>
        <p>Welcome to the user page.</p>
        <p>Here you can find user-related information.</p>
        <p>Feel free to explore!</p>
        <p>Have a great day!</p>
        <p>Best regards,</p>
        <p>Your Friendly Web App</p>");
});
