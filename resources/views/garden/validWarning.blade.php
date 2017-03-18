@extends('layouts.backend')


@section('content')

<div class="container">
	<h1 class="jumbotron-heading text-center">{{ trans('base.warning') }}</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('base.warning') }}</div>
                <div class="panel-body">
                    <div class='alert-danger'> 
                        @if($isAdmin)
                            En tant qu'administrateur, vos modifications sont enregistrés instantanément, et ne nécessitent pas de revalidation. Attention, tout ce que vous effacez est perdu!
                        @else
                            {{ trans('garden.validWarning') }}
                        @endif
                    </div>

                    {!! Form::open(['url'=>$url]) !!}

                    {!! Form::hidden('validWarning',true) !!}

                    @foreach($input as $k=>$v)
                   		@if(is_array($v))
                   			@foreach($v as $kk=>$vv)
                   				{!! Form::hidden( $k.'['.$kk.']' ,$vv) !!}
                   			@endforeach
                   		@else
                    		{!! Form::hidden($k,$v) !!}
                    	@endif
                    @endforeach

                    <div class="form-group">
                        <a href="/home"><div class='col-xs-4 col-xs-offset-3'>{!! Form::button(trans('auth.cancel'),['class'=>'btn btn-danger']) !!}</div></a>
                        <div class='col-xs-4'>{!! Form::submit(trans('base.save'),['class'=>'btn btn-primary']) !!}</div>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection