<?php
/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/




//Route::get('lead/{id}',
//    [
//        'middleware' => 'auth',
//        'uses' => 'LeadController@show'
//    ]
//);

//Route::get('create',
//    [
//
//        'uses' => 'LeadController@create'
//    ]
//
//);



// Helper for viewing mysql queries
/*Event::listen('illuminate.query', function($query)
{
    var_dump($query);
}
);*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/


Route::group(['middleware' => 'web'], function () {

    Route::auth();

    //--------------------------------------------
    // leads
    //--------------------------------------------
    Route::get('/', 'LeadController@index');

    Route::any('leads', 'LeadController@index');

    Route::any('lead/{id}', 'LeadController@show');

    Route::any('create', 'LeadController@create');

    Route::any('store', 'LeadController@store');

    Route::any('update', 'LeadController@update');

    Route::post('getpagi', 'LeadController@get_pagination');

    Route::any('pdf', function(){
        return view('pdf');
    });


//--------------------------------------------------
// independent
//---------------------------------------------------
    Route::get('services', 'LeadController@services');

    Route::any('getdata', 'LeadController@getdata');

    Route::post('getcities', 'LeadController@getcities');

    Route::get('reps', 'HomeController@reps');

    Route::post('rep/update/{id}', 'HomeController@update_rep');

    Route::get('lists', 'HomeController@lists');

    Route::post('list/update/{id}', 'HomeController@update_list');

    Route::get('sqlt', 'HomeController@sqltest');

    
//----------------------------------------------------
// note
//----------------------------------------------------
    Route::post('note/add', 'NoteController@add');

    Route::post('note/delete/{noteid}', 'NoteController@delete');


//----------------------------------------------------
// drawings
//----------------------------------------------------
    Route::post('drawing/delete/{id}', 'DrawingController@delete');

    Route::post('drawing/select/{id}', 'DrawingController@select');

    Route::post('drawing/edit/{id}', 'DrawingController@edit');

    Route::post('drawing/add/{leadid}', 'DrawingController@create');


//----------------------------------------------------
// jobs
//----------------------------------------------------
    Route::any('job/create/{leadid}', 'JobController@create');

    Route::any('job/store', 'JobController@store');

    Route::post('job/update', 'JobController@update');

    Route::get('job/note', 'JobController@show_note');

    Route::get('job/{id}/style', 'StyleController@show');

    Route::any('jobs', 'JobController@index');

    Route::any('style/pdf/{id}', 'JobController@style_pdf');

    Route::any('style/html/{id}', 'JobController@style_html');

    Route::any('print/job/{id}', 'JobController@print_preview');

    Route::any('print/installer/{id}', 'JobController@print_installer');

    Route::any('email/job/{id}', 'JobController@email_pdf');

    Route::post('style/update', 'StyleController@update');

    Route::post('style/{id}/delete', 'StyleController@delete');

    Route::post('proposal/edit/{jobid}', 'JobController@edit_proposal');


//----------------------------------------------------
// Report
//----------------------------------------------------
    Route::post('report/upload', 'ReportController@upload');

    Route::get('report/upload', 'ReportController@upload_show');

    Route::get('report/leads', 'ReportController@leads');

    Route::get('report/lead/{id}', 'ReportController@lead');

    Route::get('report/jobs', 'ReportController@jobs');

    Route::get('report/job/{id}', 'ReportController@job');

    Route::get('download/{id}', 'HomeController@get_xls');//todo remove it

//   -------------------------------------------------------
//Google Calendar
//----------------------------------------------------------
    Route::get('gapi', 'HomeController@gapi');

    Route::get('gapi/logout', 'HomeController@logout_gapi');

    Route::any('calendar/add/{id}', 'HomeController@add_calendar_event');

});
