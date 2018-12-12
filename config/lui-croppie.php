<?php

return [
    /*
    |--------------------------------------------------------------------------
    | General config
    |--------------------------------------------------------------------------
    |
    */

    'db_column_name' => "avatar",
    'form_input_name' => "avatar",
    'default_avatar' => "users/default.png",

    'edit_view' => 'avatar.edit',
    'validator' => 'mimes:jpeg,jpg,png,gif|required|max:100000',

    /*
    |--------------------------------------------------------------------------
    | Image Config
    |--------------------------------------------------------------------------
    |
    | Here you can specify image crop parameters
    | image.size => Size of image to crop and store 
    | image.boundary => Size of croppie HTML canvas
    |
    */

    'image' => [
        'type' => 'square', /* square/circle */
        'quality' => 75,
        'size' => [
            'width' => 160,
            'height' => 160,
        ],
        'boundary' => [
            'width' => 300,
            'height' => 300,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Storage Config
    |--------------------------------------------------------------------------
    |
    | Here you can specify storage and directory to store images 
    |
    */

    'storage' => 'public',
    'directory' => 'users',


    /*
    |--------------------------------------------------------------------------
    | Action after a successful upload
    |--------------------------------------------------------------------------
    |
    | Accepts full URL eg http://...
    | You can specify it with a route eg route('route-name')
    | Set it to null for no redirection
    |
    */

    'redirect_on_success' => null,

];
