<?php

return [


    /*
    |--------------------------------------------------------------------------
    | Look & feel customizations
    |--------------------------------------------------------------------------
    |
    | Make it yours.
    |
    */

    // Project name. Shown in the breadcrumbs and a few other places.
    'project_name' => 'GSK',


    'project_description' => '“Milion Game” is a fun and engaging game that challenges players to answer a series of questions correctly to win. The game is designed to test your knowledge in various categories.',

  
    /*
    |--------------------------------------------------------------------------
    | Registration Open
    |--------------------------------------------------------------------------
    |
    | Choose whether new users/admins are allowed to register.
    | This will show up the Register button in the menu and allow access to the
    | Register functions in AuthController.
    |
    | By default the registration is open only on localhost.
    */

 

    /*
    |--------------------------------------------------------------------------
    | Routing
    |--------------------------------------------------------------------------
    */

    // The prefix used in all base routes (the 'admin' in admin/dashboard)
    // You can make sure all your URLs use this prefix by using the backpack_url() helper instead of url()
    'route_prefix' => 'surveygame2024',

 
 

    // The guard that protects the Application admin panel.
    // If null, the config.auth.defaults.guard value will be used.
    'guard' => 'admin',

 
 
];
