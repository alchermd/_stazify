<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Auth scaffold routes
Auth::routes(['verify' => true]);

Route::middleware('guest')->group(function () {
    // Static routes
    Route::get('/', function () {
        return view('welcome');
    });
    Route::view('/companies', 'companies');
    Route::view('/faq', 'faq');
    Route::view('/terms-of-use', 'tos')->name('pages.tos');

    // Feedback routes
    Route::get('/feedback', 'SiteFeedbackController@create');
    Route::post('/feedback', 'SiteFeedbackController@store');

    // Registration routes
    Route::prefix('/register')->group(function () {
        Route::namespace('Company')->group(function () {
            Route::get('/company', 'CompanyController@create');
            Route::post('/company', 'CompanyController@store');
        });

        Route::namespace('Student')->group(function () {
            Route::get('/student', 'StudentController@create');
            Route::post('/student', 'StudentController@store');
        });
    });
});

// Verified routes.
Route::middleware('verified')->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');

    // Jobpost routes
    Route::prefix('/home/jobs')->group(function () {
        Route::get('/', 'JobpostController@index')->name('jobposts.index');
        Route::get('/new', 'JobpostController@create');
        Route::post('/', 'JobpostController@store')->name('jobposts.store');
        Route::get('/{jobpost}', 'JobpostController@show')->name('jobposts.show');
        Route::get('/{jobpost}/edit', 'JobpostController@edit');
        Route::put('/{jobpost}', 'JobpostController@update');

        Route::patch('/{jobpost}/close', 'SAC\CloseJobPost')->name('jobpost.close');
    });

    // Application routes
    Route::prefix('/home/applications')->group(function () {
        Route::namespace('Application')->group(function () {
            Route::get('/', 'ApplicationController@index');
            Route::post('/', 'ApplicationController@store')->name('applications.store');
            Route::get('/{application}', 'ApplicationController@show')->name('applications.show');
            Route::delete('/{application}', 'ApplicationController@destroy')->name('applications.delete');

            Route::post('/{application}/accept', 'ApplicationAcceptanceController@store');
            Route::post('/{application}/reject', 'ApplicationRejectionController@store');
        });

        Route::post('/{application}/change-status', 'SAC\ChangeApplicationStatus')->name('applications.change-status');
    });

    // Student Profile routes
    Route::prefix('/home/students')->namespace('Student')->group(function () {
        Route::get('/{user}', 'StudentProfileController@show')->name('students.show');
        Route::put('/{user}', 'StudentProfileController@update');
    });

    // Company Profile routes
    Route::prefix('/home/companies')->namespace('Company')->group(function () {
        Route::get('/{user}', 'CompanyProfileController@show')->name('companies.show');
        Route::put('/{user}', 'CompanyProfileController@update');
    });

    // Notification routes
    Route::prefix('/home/notifications')->group(function () {
        Route::delete('/', 'NotificationController@destroy');
    });

    // Messages routes
    Route::prefix('/home/messages')->namespace('Messages')->group(function () {
        Route::prefix('/sent')->group(function () {
            Route::get('/', 'SentMessagesController@index')->name('sent-messages.index');
            Route::get('/{message}', 'SentMessagesController@show')->name('sent-messages.show');
        });

        Route::prefix('/trashed')->group(function () {
            Route::get('/', 'TrashedMessagesController@index')->name('trashed-messages.index');
            Route::get('/{message}', 'TrashedMessagesController@show')->name('trashed-messages.show');
            Route::delete('/{message}', 'TrashedMessagesController@destroy')->name('trashed-messages.delete');
            Route::patch('/{message}', 'TrashedMessagesController@update')->name('trashed-messages.update');
        });

        Route::get('/', 'MessagesController@index')->name('messages.index');
        Route::get('/new', 'MessagesController@create')->name('messages.create');
        Route::post('/', 'MessagesController@store')->name('messages.store');
        Route::get('/{message}', 'MessagesController@show')->name('messages.show');
        Route::delete('/{message}', 'MessagesController@destroy')->name('messages.delete');
    });

    // Settings routes
    Route::prefix('/home/settings')->group(function () {
        Route::get('/summary', 'SAC\ShowSettingsSummaryPage')->name('settings.summary');
        Route::get('/password', 'SAC\ShowPasswordSettingsPage')->name('settings.password');
        Route::post('/password', 'SAC\ChangePassword')->name('settings.password.change');
        Route::get('/notifications', 'SAC\ShowNotificationsSettingsPage')->name('settings.notification');
        Route::patch('/notifications', 'SAC\UpdateEmailNotifications')->name('settings.notification.update');

        Route::redirect('/', '/home/settings/summary');
    });

    // Search routes
    Route::prefix('/home/search')->group(function () {
        Route::get('/companies', 'SAC\SearchForCompanyAccounts')->name('search.companies');
        Route::get('/students', 'SAC\SearchForStudentAccounts')->name('search.students');
        Route::get('/jobs', 'SAC\SearchForJobposts')->name('search.jobposts');
    });

    // Verification routes
    Route::prefix('/home/verify')->group(function () {
        Route::get('/', 'SAC\ShowCompanyValidationForm')->name('company.verify.request.create');
        Route::post('/{user}', 'SAC\RequestForCompanyValidation')->name('company.verify.request');
    });

    Route::post('/home/companies/{company}/like', 'SAC\LikeCompany')->name('company.like');
    Route::post('/home/companies/{company}/unlike', 'SAC\UnlikeCompany')->name('company.unlike');
});
