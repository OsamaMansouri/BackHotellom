<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Mesibo App Token
    |--------------------------------------------------------------------------
    |
    | You can generate an app token for your app from the Mesibo dashboard
    | and enter it here
    |
    */
    'app_token' => env('MESIBO_APP_TOKEN', ''),

    /*
    |--------------------------------------------------------------------------
    | Mesibo API Url
    |--------------------------------------------------------------------------
    |
    | Add the Mesibo API url here
    |
    */
    'api_url'   => env('MESIBO_API_URL', 'https://api.mesibo.com/api.php'),

    /*
    |--------------------------------------------------------------------------
    | App ID
    |--------------------------------------------------------------------------
    |
    | Each of your apps (web/ios/android) will have a unique app id. For
    | this app, you can just use the app name define in your app config or
    | anything that will help you identify where your users are interacting
    | from. (ie, com.yourdomain.yourapp)
    |
    */
    'app_id'    => config('app.name', 'Hottelom'),
];
