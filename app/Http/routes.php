<?php
//dd(php_ini_loaded_file());
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
Route::post('oath/token', 'UserController@get_token');

Route::group(['prefix' => 'api', 'middleware' => 'auth:api'], function()
{
    Auth::onceUsingId(Auth::guard('api')->id());

    Route::any('lead/create', 'LeadController@api_create');

    Route::get('lead/update', 'LeadController@update');

    Route::get('lead/{id}', 'LeadController@show');

    Route::any('job/update', 'JobController@update');

    Route::any('job/create/{leadid}', 'JobController@create');

    Route::get('job/{id}/style', 'StyleController@show');

    Route::get('job/{id}', 'JobController@show');

    Route::get('leads', 'LeadController@index');

    Route::get('cities', 'LeadController@getcities');

    Route::any('note/add', 'NoteController@add');

    Route::post('drawing/add/{leadid}', 'DrawingController@create');

    Route::get('style/update', 'StyleController@update');

    Route::post('proposal/edit/{id}', 'JobController@edit_proposal');

    Route::get('proposal/{id}', 'JobController@show_proposal');

    Route::get( 'print/job/{id}', 'JobController@print_preview');

});



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

    Route::post( 'label/delete', 'LeadController@delete_label');

    Route::post( 'label/update', 'LeadController@update_label');

    
//----------------------------------------------------
// note
//----------------------------------------------------
    Route::post('note/add', 'NoteController@add');

    Route::post('note/delete/{noteid}', 'NoteController@delete');

//-----------------------------------------------------
// phone
//-----------------------------------------------------
    Route::any('phone/add', 'PhoneController@add');
    Route::post('phone/delete/{noteid}', 'PhoneController@delete');



//----------------------------------------------------
// drawings
//----------------------------------------------------
    Route::post('drawing/delete/{id}', 'DrawingController@delete');

    Route::post('drawing/protection/{id}', 'DrawingController@change_protection');

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

    Route::any('email/customer/{id}', 'JobController@email_pdf_customer');

    Route::post('style/update', 'StyleController@update');

    Route::post('style/{id}/delete', 'StyleController@delete');

    Route::post('proposal/edit/{id}', 'JobController@edit_proposal');

    Route::post('proposal/new/{id}', 'JobController@new_proposal');

    Route::get('/proposal/index/{jobid}', 'JobController@index_proposal');



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

//   -------------------------------------------------------
// User
//----------------------------------------------------------
    Route::get('/user/create', 'UserController@create');

    Route::post('/user/store', 'UserController@store');

    Route::post('/user/update/{id}', 'UserController@update');

    Route::get('/user/{id}', 'UserController@show');

    Route::get('/users', 'UserController@index');
});
