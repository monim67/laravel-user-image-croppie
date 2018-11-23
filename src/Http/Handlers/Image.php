<?php

namespace Monim67\LaravelUserImageCroppie\Http\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as InterventionImage;

class Image
{
    public function handle($file)
    {
        $image_size = config('lui-croppie.image.size');
        $image_quality = config('lui-croppie.image.quality');
        $directory = config('lui-croppie.directory');

        $path = $directory.DIRECTORY_SEPARATOR.date('FY').DIRECTORY_SEPARATOR;

        $filename = $this->generateFileName($file, $path);

        $image = InterventionImage::make($file);

        if($image_size['width'] != $image->width() || $image_size['width'] != $image->width()){
            return null;
        }

        $image = $image->encode($file->getClientOriginalExtension(), $image_quality);

        $fullPath = $path.$filename.'.'.$file->getClientOriginalExtension();

        Storage::disk(config('lui-croppie.storage'))->put($fullPath, (string) $image);

        return $fullPath;
    }

    protected function generateFileName($file, $path)
    {
        $filename = Str::random(20);

        while (Storage::disk(config('lui-croppie.storage'))->exists($path.$filename.'.'.$file->getClientOriginalExtension())) {
            $filename = Str::random(20);
        }
        return $filename;
    }

    public static function deleteFileIfExists($path)
    {
        if (Storage::disk(config('lui-croppie.storage'))->exists($path)) {
            Storage::disk(config('lui-croppie.storage'))->delete($path);
        }
    }
}
