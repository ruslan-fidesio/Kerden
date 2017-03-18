<div class='panel panel-kerden-home'>
    <div class='panel-heading' >{{trans('garden.activities')}}</div>
    <div class='panel-body'>
          @if ($errors->has('activities'))
            <div class="alert alert-danger fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{ trans('garden.atLeastOneAct') }}
            </div>
        @endif
        {{ trans('garden.activitieschoosing') }}
        <div class='checkbox'>
            <label>
                {!! Form::checkbox('activities[lunch]','1', $activities->lunch  ) !!}
                <span class="glyphicon glyphicon-cutlery"></span>
                <strong>{{ trans('garden.activities_.lunch.title')}}</strong> {{ trans('garden.activities_.lunch.sub')}}
            </label>
        </div>
        <div class='checkbox'>
            <label>
                {!! Form::checkbox('activities[relax]','1', $activities->relax  ) !!}
                <span class="glyphicon glyphicon-sunglasses"></span>
                <strong>{{ trans('garden.activities_.relax.title')}}</strong> {{ trans('garden.activities_.relax.sub')}}
            </label>
        </div>
        <div class='checkbox'>
            <label>
                {!! Form::checkbox('activities[barbecue]','1', $activities->barbecue ) !!}
                <span class="glyphicon glyphicon-fire"></span>
                <strong>{{ trans('garden.activities_.barbecue.title')}}</strong> {{ trans('garden.activities_.barbecue.sub')}}
            </label>
        </div>
        <div class='checkbox'>
            <label>
                {!! Form::checkbox('activities[reception]','1', $activities->reception ) !!}
                <span class='glyphicon glyphicon-glass'></span>
                <strong>{{ trans('garden.activities_.reception.title')}}</strong> {{ trans('garden.activities_.reception.sub')}}
            </label>
        </div>
        <div class='checkbox'>
            <label>
                {!! Form::checkbox('activities[children]','1', $activities->children ) !!}
                <span class='glyphicon glyphicon-ice-lolly-tasted'></span>
                <strong>{{ trans('garden.activities_.children.title')}}</strong> {{ trans('garden.activities_.children.sub')}}
            </label>
        </div>
        <div class='checkbox'>
            <label>
                {!! Form::checkbox('activities[party]','1', $activities->party ) !!}
                <span class='glyphicon glyphicon-gift'></span>
                <strong>{{ trans('garden.activities_.party.title')}}</strong> {{ trans('garden.activities_.party.sub')}}
            </label>
        </div>
        <div class='checkbox'>
            <label>
                {!! Form::checkbox('activities[nightEvent]','1', $activities->nightEvent ) !!}
                <span class='glyphicon glyphicon-star'></span>
                <strong>{{ trans('garden.activities_.nightEvent.title')}}</strong> {{ trans('garden.activities_.nightEvent.sub')}}
            </label>
        </div>
        <div class='checkbox'>
            <label>
                {!! Form::checkbox('activities[pro]','1', $activities->pro ) !!}
                <span class='glyphicon glyphicon-briefcase'></span>
                <strong>{{ trans('garden.activities_.pro.title')}}</strong> {{ trans('garden.activities_.pro.sub')}}
            </label>
        </div>
    </div>
</div>