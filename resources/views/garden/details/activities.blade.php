<div class='panel panel-kerden-home'>
    <div class='panel-heading' >{{trans('garden.activities')}}</div>
    <div class='panel-body garden-activities'>
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
                <div class="picto picto-lunch"></div>
                <strong>{{ trans('garden.activities_.lunch.title')}}</strong> {{ trans('garden.activities_.lunch.sub')}}
            </label>
        </div>
        <div class='checkbox'>
            <label>
                {!! Form::checkbox('activities[relax]','1', $activities->relax  ) !!}
                <div class="picto picto-relax"></div>
                <strong>{{ trans('garden.activities_.relax.title')}}</strong> {{ trans('garden.activities_.relax.sub')}}
            </label>
        </div>
        <div class='checkbox'>
            <label>
                {!! Form::checkbox('activities[barbecue]','1', $activities->barbecue ) !!}
                <div class="picto picto-barbecue"></div>
                <strong>{{ trans('garden.activities_.barbecue.title')}}</strong> {{ trans('garden.activities_.barbecue.sub')}}
            </label>
        </div>
        <div class='checkbox'>
            <label>
                {!! Form::checkbox('activities[reception]','1', $activities->reception ) !!}
                <div class="picto picto-reception"></div>
                <strong>{{ trans('garden.activities_.reception.title')}}</strong> {{ trans('garden.activities_.reception.sub')}}
            </label>
        </div>
        <div class='checkbox'>
            <label>
                {!! Form::checkbox('activities[children]','1', $activities->children ) !!}
                <div class="picto picto-children"></div>
                <strong>{{ trans('garden.activities_.children.title')}}</strong> {{ trans('garden.activities_.children.sub')}}
            </label>
        </div>
        <div class='checkbox'>
            <label>
                {!! Form::checkbox('activities[party]','1', $activities->party ) !!}
                <div class="picto picto-party"></div>
                <strong>{{ trans('garden.activities_.party.title')}}</strong> {{ trans('garden.activities_.party.sub')}}
            </label>
        </div>
        <div class='checkbox'>
            <label>
                {!! Form::checkbox('activities[nightEvent]','1', $activities->nightEvent ) !!}
                <div class="picto picto-nightEvent"></div>
                <strong>{{ trans('garden.activities_.nightEvent.title')}}</strong> {{ trans('garden.activities_.nightEvent.sub')}}
            </label>
        </div>
        <div class='checkbox'>
            <label>
                {!! Form::checkbox('activities[pro]','1', $activities->pro ) !!}
                <div class="picto picto-pro"></div>
                <strong>{{ trans('garden.activities_.pro.title')}}</strong> {{ trans('garden.activities_.pro.sub')}}
            </label>
        </div>
    </div>
</div>