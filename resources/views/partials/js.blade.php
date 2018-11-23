<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.js"></script>
<script>
(function(){
  var Stage = {
    initial: {label:'initial'},
    cropping: {label:'cropping'},
    uploading: {label:'uploading'},
    success: {label:'success'},
    error: {label:'error'},
  }
  function State(form){
    this.form = form;
    this.avatarImage = form.querySelector('[data-lui-croppie-image]');
    this.croppieElement = form.querySelector('[data-lui-croppie-viewport]');
    this.progressTextElement = form.querySelector('[data-lui-croppie-progress-text]');
    this.progressBarElement = form.querySelector('[data-lui-croppie-progress-bar]');
    this.errorElement = form.querySelector('[data-lui-croppie-errors]');
    this.successElement = form.querySelector('[data-lui-croppie-success]');
    this.rotateLeftBtn = form.querySelector('[data-lui-croppie-rotate-left]');
    this.rotateRightBtn = form.querySelector('[data-lui-croppie-rotate-right]');
    this.file_input_name = "{{ config('lui-croppie.form_input_name') }}";
    this.setStage = function(stage) {
      if(this.stage != stage){
        this.stage && this.form.classList.remove('lui-croppie-' + this.stage.label);
        this.stage = stage;
        this.form.classList.add('lui-croppie-' + this.stage.label);
      }
    }
    this.setStage(Stage.initial);
  }
  function readFile(input, callback) {
    var reader = new FileReader();
    reader.onload = callback;
    reader.readAsDataURL(input.files[0]);
  }
  function prepareUploadForm(state){
    let vanilla = new Croppie(state.croppieElement, {
      viewport: {
        width: {{ config('lui-croppie.image.size.width') }},
        height: {{ config('lui-croppie.image.size.height') }},
        type: "{{ config('lui-croppie.image.type') }}"
      },
      boundary: {
        width: {{ config('lui-croppie.image.boundary.width') }},
        height: {{ config('lui-croppie.image.boundary.height') }}
      },
      showZoomer: true,
      enableOrientation: true
    });
    state.rotateLeftBtn&&state.rotateLeftBtn.addEventListener('click', function (event) {
      vanilla.rotate(-90);
    });
    state.rotateRightBtn&&state.rotateRightBtn.addEventListener('click', function (event) {
      vanilla.rotate(90);
    });
    state.croppieElement.addEventListener('update', function (event) {
    });
    state.form[state.file_input_name].addEventListener('change', function(event){
      state.setStage(Stage.initial);
      if (this.files && this.files.length && this.files[0]) {
        readFile(this, function(e){
          state.setStage(Stage.cropping);
          vanilla.bind({
            url: e.target.result,
            zoom: 0,
          });
        });
      }
    });
    state.form.addEventListener('submit', function(event){
      event.preventDefault();
      vanilla.result({
        type: 'blob'
      }).then(function (blob) {
        if(blob) uploadImage(state, blob);
        state.form[state.file_input_name].value = null;
      });
    });
  }
  function uploadImage(state, blob){
    var formData = new FormData(state.form);
    formData.delete(state.file_input_name);
    formData.append(state.file_input_name, blob, 'avatar.png');
    var xhr = new XMLHttpRequest();
    if (xhr.upload) {
      xhr.upload.addEventListener("progress", function(e) {
        if (e.lengthComputable) {
          var pc = parseInt(e.loaded / e.total * 100);
          if(state.progressTextElement) state.progressTextElement.innerText = pc + "%";
          if(state.progressBarElement) state.progressBarElement.style.width = pc + "%";
        }
      }, false);
    };
    xhr.onreadystatechange = function() {
      if (this.readyState == 4) {
        var response = JSON.parse(this.responseText);
        if(this.status == 200) {
          if(response.success){
            state.successElement.innerHTML = response.message;
            state.setStage(Stage.success);
            if(response.uploaded_image_url && state.avatarImage) {
              state.avatarImage.src = response.uploaded_image_url;
            }
            if(response.redirect_url) location.href = response.redirect_url;
          }
        }
        else{
          state.errorElement.innerText = '';
          for(var z in response.errors){
            response.errors[z].forEach(function(errorText){
              let el = document.createElement('li');
              el.innerHTML = errorText;
              state.errorElement.appendChild(el);
            })
          }
          state.setStage(Stage.error);
        }
      }
    };
    xhr.open(state.form.method, state.form.action, true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.send(formData);
    state.setStage(Stage.uploading);
  }
  document.addEventListener("DOMContentLoaded", function(event) {
    let dataTag = 'data-lui-croppie-form';
    document.querySelectorAll('[' + dataTag + ']').forEach(function(form){
      form.removeAttribute(dataTag);
      prepareUploadForm(new State(form));
    });
  });
})();
</script>
