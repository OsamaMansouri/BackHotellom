<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'storage',
            'visibility' => 'public',
            /* 'root' => storage_path('app'),
            'url' => env('APP_URL').'/img', */
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'storage',
            'visibility' => 'public',
        ],

        'categories' => [
            'driver' => 'local',
            'root' => storage_path('app/public/categories'),
            'url' => env('APP_URL').'storage',
            'visibility' => 'public',
        ],

        'articles' => [
            'driver' => 'local',
            'root' => storage_path('app/public/articles'),
            'url' => env('APP_URL').'storage',
            'visibility' => 'public',
        ],

        'types' => [
            'driver' => 'local',
            'root' => storage_path('app/public/types'),
            'url' => env('APP_URL').'storage',
            'visibility' => 'public',
        ],

        'offers' => [
            'driver' => 'local',
            'root' => storage_path('app/public/offers'),
            'url' => env('APP_URL').'storage',
            'visibility' => 'public',
        ],

        'hotels' => [
            'driver' => 'local',
            'root' => storage_path('app/public/hotels'),
            'url' => env('APP_URL').'storage',
            'visibility' => 'public',
        ],

        'users' => [
            'driver' => 'local',
            'root' => storage_path('app/public/users'),
            'url' => env('APP_URL').'storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
        ],

        'ftp' => [
            'driver' => 'ftp',
            'host' => env('FTP_HOST'),
            'username' => env('FTP_USERNAME'),
            'password' => env('FTP_PASSWORD'),
            //'root' => '/home/u646687646/domains/hotellom.com/public_html/api/img',

            // Optional FTP Settings...
            // 'port' => 21,
            // 'root' => '',
            // 'passive' => true,
            // 'ssl' => true,
            // 'timeout' => 30,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
        public_path('public/storage') => storage_path('storage/app/public'),
        /* public_path('img/categories') => storage_path('storage/app/public/categories'),
        public_path('img/articles') => storage_path('storage/app/public/articles'),
        public_path('img/offers') => storage_path('storage/app/public/offers'),
        public_path('img/settings') => storage_path('storage/app/public/settings'),
        public_path('img/shops') => storage_path('storage/app/public/shops'),
        public_path('img/types') => storage_path('storage/app/public/types'), */
    ],

];
