<div class='panel panel-default'>
    <div class='panel-heading'>{{trans('garden.requiredstaff')}}</div>
    <div class='panel-body'>
    	<div class="checkbox">
    		<label>
    			{!! Form::checkbox('requiredstaff','ok',$staff->requiredStaff>0) !!}
    			{{ trans('garden.staffrequired') }}
    		</label>
    		<label>
    			{!! Form::checkbox('requiredcook','ok',$staff->restrictedKitchenAccess) !!}
    			{{ trans('garden.cookrequired') }}
    		</label>
    	</div>
    </div>
</div>