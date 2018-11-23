<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Model config
    |--------------------------------------------------------------------------
    |
    | Here you can specify voyager user configs
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
    | Here you can specify attributes related to your application file system
    |
    */

    'image' => [
        'type' => 'square',
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
    | Here you can specify attributes related to your application file system
    |
    */

    'storage' => 'public',
    'directory' => 'users',


    /*
    |--------------------------------------------------------------------------
    | Action after a successful upload
    |--------------------------------------------------------------------------
    |
    | accepts full URL eg http://...
    | you can specify it with a route eg route('route-name')
    | set it to null for no redirection
    |
    */

    'redirect_on_success' => null,

    /*
    |--------------------------------------------------------------------------
    | Template Config
    |--------------------------------------------------------------------------
    |
    | Here you can specify attributes related to your application file system
    |
    */

    'file_input_label' => 'Select Image to Upload',
    'croppie_help_text' => 'Use the slider to zoom the image, drag/swipe the image to adjust.',
    'rotate_left_button_text' => 'Rotate Left',
    'rotate_right_button_text' => 'Rotate Left',
    'upload_button_text' => 'Crop and Upload',
    'success_message_text' => 'Avatar image uploaded successfully.',
];
