<?php

Route::group(['as'=>'employee.','prefix' =>'employee', 'middleware' => ['auth', 'employee']], function(){

    Route::get('dashboard','Employee\DashboardController@index')->name('dashboard');

    //Employee Profile management....
    Route::get('/view-profile', 'Employee\ProfileController@viewProfile')->name('view-profile');
    Route::get('/edit-profile', 'Employee\ProfileController@editProfile')->name('edit-profile');
    Route::post('/profile/update', 'Employee\ProfileController@updateProfile')->name('profile-update');
    Route::get('/edit-password', 'Employee\ProfileController@editPassword')->name('edit-password');
    Route::post('/password/update', 'Employee\ProfileController@updatePassword')->name('password-update');
    Route::post('/education/store', 'Employee\ProfileController@educationStore')->name('education-store');
    Route::post('/education/edit', 'Employee\ProfileController@educationEdit')->name('education.edit');
    Route::post('/education/update', 'Employee\ProfileController@educationUpdate')->name('education-update');
    Route::delete('/education/destroy/{id}', 'Employee\ProfileController@educationDelete')->name('education.destroy');

    Route::post('/job-experience/store', 'Employee\ProfileController@jobExperienceStore')->name('job-experience-store');
    Route::post('/job-experience/edit', 'Employee\ProfileController@jobExperienceEdit')->name('job-experience.edit');
    Route::post('/job-experience/update', 'Employee\ProfileController@jobExperienceUpdate')->name('job-experience-update');
    Route::delete('/job-experience/destroy/{id}', 'Employee\ProfileController@jobExperienceDelete')->name('job-experience.destroy');

    Route::post('/job-status/change', 'Employee\DashboardController@changeJobStatus')->name('change-job-status');

    Route::get('/notification', 'Employee\DashboardController@notification')->name('notification');
    Route::get('/notification/{id}', 'Employee\DashboardController@notificationDetails')->name('notification.detail');
    Route::get('/offer/list', 'Employee\OfferController@offerList')->name('offer-list');
    Route::get('/offer/details/{id}', 'Employee\OfferController@offerDetails')->name('offer-details');
    Route::post('/offer/replay-message', 'Employee\OfferController@offerReplayMessage')->name('offer-replay-message');
    Route::get('/offer/company-info/details/{id}', 'Employee\OfferController@companyDetails')->name('company-info-details');

});
