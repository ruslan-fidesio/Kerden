<div class='panel panel-kerden-home'>
    <div class='panel-heading'>{{trans('garden.musicware')}}</div>
    <div class='panel-body'>
        @if ($errors->has('music'))
            <div class="alert alert-danger fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{ trans('garden.illogicMusic') }}
            </div>
        @endif
        <div class='col-xs-12'>{{ trans('garden.musicchoosing') }}</div>
        <div class="text-center">
        	<div class='col-xs-3'>
                <label>
                    {!! Form::radio('music','none', ($music_level->level == 'none') ) !!}<br/>
                    {{ trans('garden.none') }}
                </label>
        	</div>
        	<div class='col-xs-3'>
                <label>
                    {!! Form::radio('music','low', ($music_level->level == 'low')) !!}<br/>
                    {{ trans('garden.low') }}
                </label>
        	</div>
        	<div class='col-xs-3'>
                <label>
                    {!! Form::radio('music','high', ($music_level->level == 'high')) !!}<br/>
                    {{ trans('garden.high') }}
                </label>
        	</div>
            <div class='col-xs-3'>
                <label>
                    {!! Form::radio('music','powerfull', ($music_level->level == 'powerfull')) !!}<br/>
                    {{ trans('garden.powerfull') }}
                </label>
            </div>
        </div>
        <div class="col-xs-12">
            <div class='checkbox'>
                <label>
                    {!! Form::checkbox('orchestar','1', $music_level->orchestar  ) !!}
                    {{ trans('garden.orchestar') }}
                </label>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="checkbox">
                <label>
                    {!! Form::checkbox('music_lowerlevel_asked','1',$music_level->lower_level_asked) !!}
                    Je souhaite que le volume sonore baisse après une certaine heure
                </label>
            </div>
        </div>
        <div class="col-xs-12" id="music_lower_level_div"
        @if(!$music_level->lower_level_asked)
            style='display:none'
        @endif
        >
            <div class="col-xs-6">
                <label for="music_lowerlevel">Heure limite:</label>
            </div>
            <div class="col-xs-6">
                {!! Form::number('music_lowerlevel_hour',$music_level->lower_level_hour,['min'=>'0','step'=>'1','class'=>'form-control'])  !!}
            </div>
            <div class="text-center">
                <div class='col-xs-3'>
                    <label>
                        {!! Form::radio('music_lower_level','none', ($music_level->lower_level=='none')) !!}<br/>
                        {{ trans('garden.none') }}
                    </label>
                </div>
                <div class='col-xs-3'>
                    <label>
                        {!! Form::radio('music_lower_level','low',($music_level->lower_level=='low') )  !!}<br/>
                        {{ trans('garden.low') }}
                    </label>
                </div>
                <div class='col-xs-3'>
                    <label>
                        {!! Form::radio('music_lower_level','high', ($music_level->lower_level=='high')) !!}<br/>
                        {{ trans('garden.high') }}
                    </label>
                </div>
                <div class='col-xs-3'>
                    <label>
                        {!! Form::radio('music_lower_level','powerfull',($music_level->lower_level=='powerfull'))  !!}<br/>
                        {{ trans('garden.powerfull') }}
                    </label>
                </div>
            </div>
        </div>

    </div>
</div>	