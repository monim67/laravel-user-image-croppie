<?php

namespace Monim67\LaravelUserImageCroppie\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use TestHook\Http\Handlers\Image as ImageHandler;
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
                "message" => "The given data was invalid.",
                "errors" => [
                    $form_field => ["The file format is not acceptable"],
                ]
            ], 422);
        }

        $file_path = (new ImageHandler())->handle($request->file($form_field));

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
                'message' => config('lui-croppie.success_message_text'),
                'uploaded_image_url' => asset('storage/' . $file_path),
                'redirect_url' => config('lui-croppie.redirect_on_success'),
            ]);
        }
    }
}
