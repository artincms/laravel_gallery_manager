<?php

return [

    /* Important Settings */
    'backend_lgs_middlewares' => ['web'],
    'frontend_lgs_middlewares' => ['web'],
    // you can change default route from sms-admin to anything you want
    'backend_lgs_route_prefix' => 'LGS',
    'frontend_lgs_route_prefix' => 'LGS',
    // SMS.ir Api Key
    'api-key' => env('SMSIR-API-KEY','Your api key'),
    // ======================================================================
    //allow user to upload private file in filemanager
    'userModel'=>'App\User',
    'guestCanVote'=>true
];