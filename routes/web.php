<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LinkController;


Route::get('/dashboard', function () {
    return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
    
Route::middleware('auth')->group(function () {
    Route::get('/',[LinkController::class,'index'])->name('links.index');
    Route::post('/shorten',[LinkController::class,'store'])->name('links.store');
    
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';
Route::get('/{link}',[LinkController::class,'redirect'])->name('links.redirect');
Route::delete('/links/{link}',[LinkController::class,'destroy'])->name('links.destroy');
