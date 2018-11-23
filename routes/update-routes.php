<?php

$avatarController = '\Monim67\LaravelUserImageCroppie\Http\Controllers\AvatarController';

Route::put('', $avatarController.'@update')->name('user.avatar.update');
