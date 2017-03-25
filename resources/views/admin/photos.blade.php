@extends('admin.menu')

@section('contentPane')
    <div class="row">
        <div class="col-md-12">
            <div class="btn btn-info" onclick='history.back();'>Retour</div>
            <div class="panel panel-kerden-home">
                <div class="panel-heading">{{$garden->title}} -> Photos</div>
                <div class="panel-body">
                    @if($errors->has('upload'))
                        <div class="alert alert-danger">{{$errors->first('upload')}}</div>
                    @endif

                	@if(empty($photos))
                		Pas de photos...
                	@else
                	<div class="row">
                		@foreach($photos as $key=>$ph)
                		<div class='col-md-4'>
                			<div class="thumbnail">
                				<img src="{{ $photosURL[$key] }}">
                				<div class="caption">
                					<a href="{{ url('/admin/delphotos?path='.urlencode($ph)) }}" class="btn btn-danger">Supprimer</a>
                                    @if( $garden->defautImg && ($garden->id.'/'.$garden->defautImg->file_name  == $ph))
                                    <div class="btn btn-primary"><i class="fa fa-check"></i>Photo par défaut</div>
                                    @else
                                    <a href="{{url('/admin/defautImg/'.$ph)}}"><div class="btn btn-primary">Choisir par défaut</div>  </a>
                                    @endif
                				</div>
                			</div>
                		</div>
                		@endforeach
                	</div>
                	@endif
                	<a href="#" data-toggle="modal" data-target="#addModal" class="btn btn-primary">Ajouter une photo</a>
                </div>
            </div>
        </div>
    </div>

<div class="modal fade" tabindex="-1" role="dialog" id="addModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Ajouter une photo</h4>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div id="compression" style="padding-top:30px; display:none">Image trop grande<br>Compression...</div>
                    <div class="col-xs-3">
                	{!! Form::open(['files'=>true,'id'=>'newPhotoForm','method'=>'POST','onsubmit'=>'removeInputBeforeSubmit()']) !!}

                    <input name="image" type="file" accept='image/*' onchange='loadFile(event);' />

                	{!! Form::submit('Envoyer',['class'=>'btn btn-primary']) !!}

                	{!! Form::close() !!}
                    </div>
                    <div class="col-xs-7">
                        <div class="thumbnail">
                            <canvas id="canvas"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
var removeInputBeforeSubmit = function(){
    if( $('#newPhotoForm input[name="b64Image"]').length ){
        $('#newPhotoForm input[name="image"]').remove();
    }
}

var makeNewFileInput = function(image){
    $('#newPhotoForm input[name="b64Image"]').remove();
    $('#newPhotoForm').append( '<input type="hidden" name="b64Image" value="'+image.src+'"/>' );
}

var setCanvasZoom = function(){
    var W = $('.modal .thumbnail').first().width();
    var ratio = W/$('canvas').width();
    console.log('ratio zoom : '+ratio);
    $('canvas').css('zoom',ratio);
    $('#compression').fadeOut();
}

var loadFile = function(event) {
    var size = event.target.files[0].size;
    if(size > 2097152){
        $('#compression').show();
    }
    var myJQCanvas = $('#canvas');
    var myCanvas = myJQCanvas[0];
    var myCtxt = myCanvas.getContext('2d');
    var image = new Image();
    image.addEventListener('load',function(){
        myJQCanvas.attr('width',image.width);
        myJQCanvas.attr('height',image.height);
        myCtxt.drawImage( image,0,0 );
        if(size > 2097152){
            //var ratio = 2097152/size;
            var ratio = 0.95;
            var dataUrl = myCanvas.toDataURL('image/jpeg',ratio);
            var tmpSize = Math.round(dataUrl.length * 3 / 4);
            console.log('ratio : '+ratio);
            console.log('>size : '+Math.round(dataUrl.length * 3 / 4));
            while( tmpSize > 2097152){
                ratio -= 0.050;
                dataUrl = myCanvas.toDataURL('image/jpeg',ratio);
                tmpSize = Math.round(dataUrl.length * 3 / 4);
                console.log('ratio : '+ratio);
                console.log('>size : '+Math.round(dataUrl.length * 3 / 4));
            }

            var img2 = new Image();
            img2.addEventListener('load',function(){
                myCtxt.clearRect(0,0,myCanvas.width,myCanvas.height);
                myCtxt.drawImage(img2,0,0);
                setCanvasZoom();
                makeNewFileInput(this);
                
            });
            img2.src = dataUrl;
        }
        else{
            setCanvasZoom();
        }
    });
    image.src =window.URL.createObjectURL( event.target.files[0]);
};
</script>
@endsection