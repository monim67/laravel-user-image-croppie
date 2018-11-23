<?php

$avatarController = '\Monim67\LaravelUserImageCroppie\Http\Controllers\AvatarController';

Route::get('/edit', $avatarController.'@edit')->name('user.avatar.edit');
Route::put('', $avatarController.'@update')->name('user.avatar.update');
