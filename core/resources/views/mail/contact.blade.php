@if ($subsc)
<h4>Hello Subscriber, </h4>
@endif


<p>{!! replaceBaseUrl($text) !!}</p>

@if ($subsc)
<p style="margin-botton: 0px;">Best Regards,</p>
<p>{{$bs->website_title}}</p>
@endif

