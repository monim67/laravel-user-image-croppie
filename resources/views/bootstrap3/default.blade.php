<form role="form" method="post" action="{{route('user.avatar.update')}}" data-lui-croppie-form>
  @csrf
  @method('PUT')

  <div class="form-group text-center lui-croppie-initial-visible lui-croppie-uploading-visible lui-croppie-success-visible">
    <img data-lui-croppie-image src="{{ asset('storage/' . auth()->user()->{config('lui-croppie.form_input_name')}) }}">
  </div>

  <div class="form-group">
    <label class="control-label">{{ __('lui-croppie::form.file_input_label') }}</label>
    <input type="file" name="{{ config('lui-croppie.form_input_name') }}" value="Choose an image" accept="image/*" />
    <div class="help-block"></div>
  </div>

  <div class="upload-demo-wrap lui-croppie-cropping-visible">
    <div data-lui-croppie-viewport></div>
    <div class="help-block text-center">{{ __('lui-croppie::form.croppie_help_text') }}</div>
    <button type="submit" class="btn btn-primary pull-right">
      <i class="fa fa-upload margin-r-5"></i>
      {{ __('lui-croppie::form.upload_button_text') }}
    </button>
    <button type="button" class="btn btn-primary margin-r-5" data-lui-croppie-rotate-right>
      <i class="fa fa-rotate-left margin-r-5"></i>
      {{ __('lui-croppie::form.rotate_left_button_text') }}
    </button>
    <button type="button" class="btn btn-primary margin-r-5" data-lui-croppie-rotate-left>
      <i class="fa fa-rotate-right margin-r-5"></i>
      {{ __('lui-croppie::form.rotate_right_button_text') }}
    </button>
  </div>

  <div class="form-group lui-croppie-uploading-visible">
    <div class="progress">
      <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:0%" data-lui-croppie-progress-bar>
        <span data-lui-croppie-progress-text>0%</span>
      </div>
    </div>
  </div>

  <div class="alert alert-danger lui-croppie-error-visible">
    <ul data-lui-croppie-errors></ul>
  </div>

  <div class="alert alert-success lui-croppie-success-visible">
    <i class="fa fa-check margin-r-5"></i>
    <span data-lui-croppie-success></span>
  </div>

</form>
