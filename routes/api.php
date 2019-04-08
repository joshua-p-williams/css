<?php

Route::group(['prefix' => '/v1', 'middleware' => ['auth:api'], 'namespace' => 'Api\V1', 'as' => 'api.'], function () {
    Route::post('change-password', 'ChangePasswordController@changePassword')->name('auth.change_password');
    Route::apiResource('rules', 'RulesController', ['only' => ['index']]);
    Route::apiResource('permissions', 'PermissionsController');
    Route::apiResource('roles', 'RolesController');
    Route::apiResource('users', 'UsersController');
    Route::apiResource('faq-categories', 'FaqCategoriesController');
    Route::apiResource('faq-questions', 'FaqQuestionsController');
    Route::apiResource('categories', 'CategoriesController');
    Route::apiResource('events', 'EventsController');
    Route::apiResource('contact-companies', 'ContactCompaniesController');
    Route::apiResource('contacts', 'ContactsController');
    Route::apiResource('scores', 'ScoresController');
    Route::get('categoryCompletions', 'CategoryCompletionsController@index');
    Route::get('teamCompletions', 'TeamCompletionsController@index');
    Route::get('individualCompletions', 'IndividualCompletionsController@index');
    Route::get('individualResults', 'IndividualResultsController@index');
    Route::get('teamResults', 'TeamResultsController@index');
});
