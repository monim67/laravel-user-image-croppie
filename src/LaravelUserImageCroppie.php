<?php

namespace Monim67\LaravelUserImageCroppie;


class LaravelUserImageCroppie
{
    public static function routes()
    {
        require __DIR__.'/../routes/routes-all.php';
    }
    public static function update_routes_only()
    {
        require __DIR__.'/../routes/update-routes.php';
    }
}

