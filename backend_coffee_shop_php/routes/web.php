<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => response()->json(['message' => "page not found"],404));
