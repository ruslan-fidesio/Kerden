@foreach($files as $f)
<h3>{{ trans('mails.titles.'.str_replace('.blade.php','', $f)) }}</h3>
<p>{{str_replace('.blade.php','', $f)}}</p>
<iframe src="/seeMail/{{str_replace('.blade.php','', $f)}}" frameborder="0" style='width:100%'></iframe>

@endforeach