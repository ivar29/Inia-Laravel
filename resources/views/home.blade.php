@extends('layouts.app')

@section('content')
<div >
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                    <div>
                    <form id="get-data-form" method="post">

                       <textarea name="content" id="tinymce" class="form-control my-editor" ></textarea>

                    </form>
                    <div>


                    <a href="{{ url('download-pdf') }}">Eportar PDF</a>
                    </div>

                    <input type="button" value="clickme" onclick="pruebaConsole()" />
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
var editor_config = {
path_absolute : "/",
selector: "textarea.my-editor",
language_url : '/languages/es.js',
plugins: [
"advlist autolink lists link image charmap print preview hr",
"searchreplace wordcount visualblocks visualchars code fullscreen",
"insertdatetime nonbreaking save table contextmenu directionality",
"emoticons paste textcolor colorpicker textpattern "
],
paste_enable_default_filters: false,
paste_data_images: false,
branding: false,
toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | mybutton",
relative_urls: false,
height: 200,
setup: function(editor){
editor.addButton('mybutton', {

image: '/icons/grafico.png',
tooltip: "Gráficos de información",
onclick: function () {
alert("Proximamente");
}
});
},
file_browser_callback : function(field_name, url, type, win) {
var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
if (type == 'image') {
cmsURL = cmsURL + "&type=Images";
} else {
cmsURL = cmsURL + "&type=Files";
}
tinyMCE.activeEditor.windowManager.open({
file : cmsURL,
title : 'Filemanager',
width : x * 0.8,
height : y * 0.8,
resizable : "yes",
close_previous : "no"

});
}
};

tinymce.init(editor_config);
</script>

<script>
function pruebaConsole()
{
  var selectContent = tinymce.get('tinymce').getContent();
    console.log(selectContent);
}
</script>
@endsection
