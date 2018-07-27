@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div >

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card">

                <div class="card-header">
                    <label>Boletin Agrometeorlógico -  Región: 
                    {{ $detalleMacrozona->subsecciones[0]->boletin->region->name }} - 
                    {{ $detalleMacrozona->subsecciones[0]->boletin->publicacion->mes->nombre }} 
                    {{ $detalleMacrozona->subsecciones[0]->boletin->publicacion->año }} 
                    </label>  
                    <a href="{{ route('boletines.show', $boletin->id)}}"
                    class="btn btn-sm btn-primary pull-right">Volver Atrás</a>
                </div>

                <div class="card-body">
                    <strong>
                    Macrozona : {{ $detalleMacrozona->name}} 
                    @if($detalleMacrozona->rubro != null)
                     > {{ $detalleMacrozona->rubro->name}} > 
                     @if($detalleMacrozona->rubro->subrubro != null)
                     {{ $detalleMacrozona->rubro->subrubro}}
                     @else
                     @endif
                    @else
                    @endif
                    </strong>
                    <hr>
                    <div>
                    <form id="get-data-form" method="post">

                       <textarea name="content" id="tinymce" class="form-control my-editor" >
                       <?= htmlspecialchars($detalleMacrozona->pivot->contenido); ?>
                        </textarea>

                    </form>
                    <div style="display:none;">
                        <input id="obj" value="{{ $detalleMacrozona }}"></input>
                        <input id="boletin" value="{{ $boletin }}"></input>
                        
                    </div>
                    <div>
                    </div>
                    <br>
                    <center>
                        <button  class="btn btn-sm btn-primary"  onclick="guardarDatos()">Guardar Datos</button>
                    </center>
                    <hr>
                    <div class="form-group">
                      <label for="resumen"><strong>Resumen</strong> (Máximo 900 caracteres)</label>
                      <textarea maxlength="900" class="form-control" rows="7" id="resumen">{{ $detalleMacrozona->pivot->resumen }}</textarea>
                    </div>
                    <center>
                        <button  class="btn btn-sm btn-primary"  onclick="guardarResumen()">Guardar Resumen</button>
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
    var boletinObj = JSON.parse(document.getElementById('boletin').value);

    var subseccion_id = objSeccion.pivot.subseccion_id;
    var macrozona_id = objSeccion.pivot.macrozona_id;
    var boletin_id = boletinObj.id;
    
    var contentTinymce = tinymce.get('tinymce').getContent();
    $.ajax({
    method: 'POST', // Type of response and matches what we said in the route
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: '/editorMacrozona/update', // This is the url we gave in the route
    data: {subseccion_id: subseccion_id, macrozona_id: macrozona_id, contenido: contentTinymce, boletin_id: boletin_id}, // a JSON object to send back
    success: function(response){ // What to do if we succeed
        alert('Se ha editado correctamente');
        //window.location.href = response;
    },
    error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
        //console.log(JSON.stringify(jqXHR));
        //console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
    }
});

}


 function guardarResumen()
 {
    var objSeccion = JSON.parse(document.getElementById('obj').value);
    var boletinObj = JSON.parse(document.getElementById('boletin').value);

    var subseccion_id = objSeccion.pivot.subseccion_id;
    var macrozona_id = objSeccion.pivot.macrozona_id;
    var boletin_id = boletinObj.id;
    
    var contentResumen = document.getElementById('resumen').value;
    console.log(contentResumen);
    
    $.ajax({
    method: 'POST', // Type of response and matches what we said in the route
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: '/editorMacrozonaResumen/update', // This is the url we gave in the route
    data: {subseccion_id: subseccion_id, macrozona_id: macrozona_id, resumen: contentResumen, boletin_id: boletin_id}, // a JSON object to send back
    success: function(response){ // What to do if we succeed
        alert('Se ha editado correctamente');
        console.log(response);
        //window.location.href = response;
    },
    error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
        //console.log(JSON.stringify(jqXHR));
        //console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
    }
    });
    
 }
</script>
@endsection