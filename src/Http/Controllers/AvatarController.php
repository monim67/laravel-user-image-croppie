<?php

namespace Monim67\LaravelUserImageCroppie\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Monim67\LaravelUserImageCroppie\Http\Handlers\Image as ImageHandler;
use Monim67\LaravelUserImageCroppie\Events\AvatarUpdate;


class AvatarController extends Controller
{
    public function edit()
    {
        return view(config('lui-croppie.edit_view'));
    }

    public function update(Request $request)
    {
        $form_field = config('lui-croppie.form_input_name');
        $model_field = config('lui-croppie.db_column_name');
        $default_avatar = config('lui-croppie.default_avatar');

        $this->validate($request, [
            $form_field => config('lui-croppie.validator'),
        ]);

        if(!$request->hasFile($form_field)){
            return response()->json([
                "message" => __('lui-croppie::form.invalid_file_error_message'),
                "errors" => [
                    $form_field => [__('lui-croppie::form.invalid_file_error_message')],
                ]
            ], 422);
        }
    
        $file_path =  str_replace('\\', '/', (new ImageHandler())->handle($request->file($form_field))); 

        if($file_path){

            $user = \Auth::user();
            if($user->$model_field != $default_avatar) {
                ImageHandler::deleteFileIfExists($user->$model_field);
            }
            $user->$model_field = $file_path;
            $user->save();

            event(new AvatarUpdate($user));

            return response()->json([
                'success' => True,
                'uploaded_image_url' => asset('storage/' . $file_path),
                'redirect_url' => config('lui-croppie.redirect_on_success'),
                'message' => __('lui-croppie::form.success_message_text', [
                    'attribute' => $form_field,
                    'ATTRIBUTE' => Str::upper($form_field),
                    'Attribute' => Str::title($form_field),
                ]),
            ]);
        }
    }
}
