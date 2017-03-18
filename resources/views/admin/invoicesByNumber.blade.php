@extends('admin.menu')

@section('contentPane')
	<div class="panel panel-kerden-home">
		<div class="panel-heading">Admin -> factures et reçus</div>
		<div class="panel-body">
			<div class="row">
				Factures :<br>
				@foreach($factures as $fac)
					<a href="{{ url('/invoice/user/'.$fac->reservation->id) }}">{{ $fac->reference }} </a>
					<br/>
				@endforeach
			</div>
			<hr>
			<div class="row">
				Reçus :<br>
				@foreach($receipts as $rec)
					@if($rec->reservation->status == "refund_by_owner")
						<a href="{{ url('/invoice/userReceipt/'.$rec->reservation->id) }}">{{ $rec->reference }}</a>
					@else
						<a href="{{ url('/invoice/owner/'.$rec->reservation->id) }}">{{$rec->reference}}</a>
					@endif
					<br/>
				@endforeach
			</div>
		</div>
	</div>
@endsection


@section('scripts')
<script>
(function($){
	$('.HPMenuLink').removeClass('active');
    $('.adminMenu').addClass('active');

    $('.left-menu-link').removeClass('active');
    $('.left-menu-link:nth-child(8)').addClass('active');
}) (jQuery);
</script>
@endsection