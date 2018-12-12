# laravel-user-image-croppie

This package adds square/circular user profile image with an update event to laravel application.
Users can rotate, resize and crop profile picture before upload with pure JavaScript, no jQuery needed.
An avatar controller is included to handle image upload which emits an event after a successful avatar upload.

![Steps of image upload - laravel-user-image-croppie][cover-image]

![version of laravel-user-image-croppie][packagist-version-badge]

## Features

- Resize/Rotate/Crop image before upload.
- Upload image with a progress bar.
- Built with Vanilla JavaScript, no jQuery needed.
- Emits AvatarUpdate Event on successful image upload.
- Includes Routes and Controllers within the package.
- Includes optional migration that adds avatar column to user table.
- Integration to laravel with just few simple steps.
- Fully customizable through editing the config file.
- Includes localization support.
- Can be used along with laravel voyager admin panel.

## Getting Started

Install the package via composer and publish the config file.

    composer require monim67/laravel-user-image-croppie
    php artisan vendor:publish --provider="Monim67\LaravelUserImageCroppie\ServiceProvider" --tag=config

If you already have a database column for user's image, you need to specify it in the config file, otherwise
you can publish the migration from this package that adds a column named `avatar` to users table.

    php artisan vendor:publish --provider="Monim67\LaravelUserImageCroppie\ServiceProvider" --tag=migrations
    php artisan migrate

Add the following to your routes in `web.php` file.

```php
Route::prefix('avatar')->middleware('auth:web')->group(function(){LUICroppie::routes();});
```

This will include edit and update routes for user image. You can use any prefix of your choice.

If you only want the update route, use the following instead.

```php
Route::prefix('avatar')->middleware('auth:web')->group(function(){LUICroppie::update_routes_only();});
```

The edit route will look for `resources\views\avatar\edit.blade.php`.
So create a file extending your base layout template and include the image upload form in it.

```html
@extends('layouts.main')

@section('content')
@include('lui-croppie::partials.css')
@include('lui-croppie::partials.js')
<div class="row">
    <div class="col-md-8">
        <div class="box box-primary" >
            <div class="box-header with-border">
                <h3 class="box-title">Change Profile Picture</h3>
                <div class="box-tools pull-right">
            </div>
        </div>
            <div class="box-body">
                @include('lui-croppie::bootstrap3.default')
            </div>
        </div>
    </div>
</div>
@stop
```

That is all you need, the controller is shipped with the package, you don't need to
write controller actions. Run the development server and visit
`http://localhost:8000/avatar/edit` to see it in action.


## Customizing the options

You can edit the config file `lui-croppie.php` in your config directory to customize the options
to your needs.

__NOTE:__ For circular profile picture set image type to `circle`.


## Other Form Layouts 

At present only Bootstrap 3 layout is included, few more will be added later. You can also draw
your own layout, or even create PR with your own layout.

If you don't want a separate page to upload image, you can add this form to one of
your existing pages ie the profile page or account settings page. Then include only update
route to your `web.php` and include the password-update form in the page of your choice.


## Localization

If you want to customize package language files publish them to modify. Files will be published to
`resources\lang\vendor\lui-croppie` directory. You can create lang files for other languages there.

    php artisan vendor:publish --provider="Monim67\LaravelUserImageCroppie\ServiceProvider" --tag=lang


## User Image Update Event

When user uploads an image `Monim67\LaravelUserImageCroppie\Events\AvatarUpdate` event
is emitted, you can subscribe to the event or add listeners to it.


## Acknowledgments

This package uses [Croppie](https://foliotek.github.io/Croppie/) Javascript Image Cropper to crop
images to upload.


[cover-image]: https://raw.githubusercontent.com/monim67/laravel-user-image-croppie/39c06c651176b9cddf93fdb4ff650e528bb83520/.github/images/lui-croppie-cover.png

[packagist-version-badge]: https://img.shields.io/packagist/v/monim67/laravel-user-image-croppie.svg?style=flat-square

