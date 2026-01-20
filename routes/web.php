<?php

use Illuminate\Support\Facades\Route;


Route::get('/', \App\Livewire\FamilyTree::class)->name('home');
