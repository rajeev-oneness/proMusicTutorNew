<?php
  Route::get('dashboard',function(){
    return view('user.dashboard');
  })->name('home');
?>