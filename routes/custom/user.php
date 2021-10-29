<?php

  namespace App\Http\Controllers;
  use Illuminate\Support\Facades\Route;

  Route::get('dashboard',[UserController::class,'dashboard'])->name('home');

?>