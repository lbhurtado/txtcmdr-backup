<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

require_once "/home/vagrant/Code/txtcmdr/vendor/telerivet/telerivet-php-client/telerivet.php";

Route::get('/', function () {
    return view('welcome');
});

get('info', function () {
    $API_KEY = 'rnZKLkpBb3396YspUH9PReFRy4lh4bFw';           // from https://telerivet.com/api/keys
    $PROJECT_ID = 'PJf3e398e4fb9f4a07';

    $telerivet = new Telerivet_API($API_KEY);

    $project = $telerivet->initProjectById($PROJECT_ID);

// Send a SMS message
    $project->sendMessage(array(
        'to_number' => '+639189362340',
        'content' => 'Hello world!'
    ));
    phpinfo();
});