<div class='panel panel-kerden-home'>
    <div class="panel-heading">{{ trans('garden.kitchen') }}</div>
    <div class='panel-body'>
        <div class="form-group">
            <div class="checkbox">
            	<label>
            		{!! Form::checkbox('kitchen_outdoor','outdoor',($kitchen->outdoor)) !!}
            		{{ trans('garden.kitchen_out') }}
            	</label>
            </div>	
        
            <div class="col-xs-5">{!! Form::label('kitchen_surf', trans('garden.kitchen_surf') ) !!}    </div>

            <div class="col-xs-5">{!! Form::number('kitchen_outdoor_surface',$kitchen->outdoor_surface,['min'=>'0','step'=>'1','class'=>'form-control']) !!}</div>
        </div>


        <div class="form-group" style='padding-top:30px'>
            <div class="checkbox">
            	<label>
            		{!! Form::checkbox('kitchen_indoor','indoor', ($kitchen->indoor)) !!}
            		{{ trans('garden.kitchen_in') }}
            	</label>
            </div>

        
        	<div class="col-xs-5">{!! Form::label('kitchen_surf', trans('garden.kitchen_surf') ) !!}	</div>

        	<div class="col-xs-5">{!! Form::number('kitchen_indoor_surface',$kitchen->indoor_surface,['min'=>'0','step'=>'1','class'=>'form-control']) !!}</div>
        </div>

    </div>
</div>