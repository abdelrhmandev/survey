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


    'project_description' => 'We have policies in place across GSK to ensure we meet the high standards we set ourselves as a company, and those that are expected of us externally.',

  
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
