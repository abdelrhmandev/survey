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
    'project_name' => 'Survey Game2024',


    'project_description' => 'Start Survey Game!
    Without much to your name, you go about each lovely day repeating the same boring tasks , enjoy. Every amazing day the same as the one before, like flipping an unbalanced coin. However, this time, your usual pattern will be disrupted, as you will find out that not everything is as it seems enjoy... in the Midnight Zone !',

  
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
