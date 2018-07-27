@extends('layouts.app')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<div >
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <strong>
                    Boletín Agrometeorológico - Resumen ejecutivo Nacional - 
                    {{ $resumen->publicacion->mes->nombre }} - 
                    {{ $resumen->publicacion->año }}
                    </strong>
                    <a href="{{ route('resumenes.show', $resumen->id)}}"
                    class="btn btn-sm btn-primary pull-right">Volver Atrás</a>
                </div>

                <div class="card-body">
                    @if($seccionDetail->id == 1)
                      Sección: Resumen ejecutivo Nacional
                    @else
                      Sección: Región {{ $seccionDetail->name }}
                    @endif
                    <hr>
                    <div>
                    <form id="get-data-form" method="post">

                       <textarea name="content" id="tinymce" class="form-control my-editor" >
                        <?= htmlspecialchars($seccionDetail->pivot->contenido); ?>
                        </textarea>

                    </form>
                    <div style="display:none;">
                        <input id="obj" value="{{ $seccionDetail }}"></input>
                        
                    </div>
                    <div>
                    </div>
                    <br>
                    <center>
                         <button  class="btn btn-sm btn-primary"  onclick="guardarDatos()">Guardar Datos</button>
                    </center>
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
image_description: false,
toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | mybutton",
relative_urls: false,
remove_script_host: false,
height: 200,
setup: function(editor){
    editor.on('keydown', function(event) {
        if (event.keyCode == 9) { // tab pressed
          if (event.shiftKey) {
            editor.execCommand('Outdent');
          }
          else {
            editor.execCommand('Indent');
          }
          event.preventDefault();
          return false;
        }
    });
editor.addButton('mybutton', {
image: '/public/icons/grafico.png',
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

function guardarDatos()
{   
    var objSeccion = JSON.parse(document.getElementById('obj').value);
    console.log(objSeccion)
    var region_id = objSeccion.pivot.region_id;
    var resumen_id = objSeccion.pivot.resumen_id;
    
    var contentTinymce = tinymce.get('tinymce').getContent();
    $.ajax({
    method: 'POST', // Type of response and matches what we said in the route
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: '/editorResumen/update', // This is the url we gave in the route
    data: {region_id: region_id, resumen_id: resumen_id, contenido: contentTinymce}, // a JSON object to send back
    success: function(response){ // What to do if we succeed
        //console.log(response); 
        window.location.href = response;
    },
    error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
        //console.log(JSON.stringify(jqXHR));
        //console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
    }
});

}
</script>
@endsection