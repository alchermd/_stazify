<?php

Route::prefix('/industries')->group(function () {
    Route::get('/', function () {
        return \App\Models\Industry::all();
    })->name('api.industries.index');
});

Route::prefix('/courses')->group(function () {
    Route::get('/', function () {
        return \App\Models\Course::all();
    })->name('api.courses.index');
});
