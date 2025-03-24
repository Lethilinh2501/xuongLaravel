<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    $usersXuong1 = DB::connection('mysql')->table('users')->get();

    $usersXuong2 = DB::connection('mysql2_connection')->table('users')->get();
    dd($usersXuong1, $usersXuong2);
});
