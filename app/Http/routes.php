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

get('test', function () {
    return 'test';
});

get('info', function () {
    $API_KEY = 'rnZKLkpBb3396YspUH9PReFRy4lh4bFw';           // from https://telerivet.com/api/keys
    $PROJECT_ID = 'PJf3e398e4fb9f4a07';

    $telerivet = new Telerivet_API($API_KEY);

    $project = $telerivet->initProjectById($PROJECT_ID);

// Send a SMS message
    $project->sendMessage(array(
        'to_number' => '+639189362340',
        'content' => 'Hello world - testing 1,2,3,4!'
    ));

    // Query contacts
    $name_prefix = 'Lester';
    $cursor = $project->queryContacts(array(
        'name[prefix]' => $name_prefix,
        'sort' => 'name',
    ))->limit(20);

    echo "{$cursor->count()} contacts matching $name_prefix:\n";

    while ($cursor->hasNext())
    {
        $contact = $cursor->next();
        echo "{$contact->name} {$contact->phone_number} {$contact->vars->birthdate}\n";
    }

    // Import a contact
    $contact = $project->getOrCreateContact(array(
        'name' => 'John Smith',
        'phone_number' => '555-0001',
        'vars' => array(
            'birthdate' => '1981-03-04',
            'network' => 'Vodacom'
        )
    ));

    // Add a contact to a group
    $group = $project->getOrCreateGroup('Subscribers');
    $contact->addToGroup($group);

    $table = $project->getOrCreateDataTable("pop");

    $row = $table->createRow(array(
        'from_number' => "+639189362340",
        'vars' => array(
            'barangay' => "Philam",
            'cluster_id' => 5,
            'polling_place' => 'St. Vincent',
            'precinct_id' => '0014A'
        )
    ));

    phpinfo();
});