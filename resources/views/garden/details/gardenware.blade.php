<div class='panel panel-kerden-home'>
    <div class="panel-heading">{{ trans('garden.equipment') }}</div>
    <div class='panel-body'>
    	<table id="tableWare">
    		<tbody>
                @foreach($ware as $w)
                    <tr id="{{$w->type}}"><td class='col-xs-7'>
                        <a style="cursor:pointer" onclick="eraseRow('{{$w->type}}')">x  </a>{{$w->type}}</td>
                        <td>{!! Form::number('gardenware['.$w->type.']',$w->nb,['class'=>'form-control','min'=>'0','placeholder'=>'Nombre']) !!}</td>
                    </tr>
                @endforeach
            </tbody>
    	</table>
        <div class="col-xs-12">
    	<select class="form-control" id="wareselect">

    		<option>Chaise</option>
    		<option>Table</option>
    		<option>Hamac</option>
    		<option>Parasol</option>
    		<option>Parasol Chauffant</option>
    		<option>Transat</option>
    		<option>Eclairage exterieur</option>
    		<option>Barbecue</option>
    		<option>Accès Wifi</option>
    		<option>Sonorisation</option>
    		<option>Table de Ping-Pong</option>
    		<option>Badmington (filet+raquettes)</option>
    		<option>Terrain de tennis</option>
    		<option>Piscine</option>
    		<option>Sauna</option>
    		<option>Hamam</option>
    		<option>Jacuzzi</option>
            <option>Canapé de jardin</option>
            <option>Point d'eau</option>
            <option>Prise de courant</option>
    		<option>Places de parking privatives</option>
    		<option id='otherOPT'>Autre...<option>
    	</select>
        </div>
    </div>
</div>