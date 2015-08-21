@extends('frontend.modules.store.layout.layout')
@section('title')
	Home
@endsection
@section('breadcrumb')
	<ol class="breadcrumb">
		<li><a href="{{Config::get('app.url')}}">Home</a></li>
		<li><a href="#">Library</a></li>
		<li class="active">Data</li>
	</ol>
@endsection
@section('content')
<div class="col-sm-8">
	<div class="features_items">
		<div class="col-lg-12" style="padding:0;">
            @if(count($dataUserPageView)>0)
                <h2 class="page-title">{{$dataUserPageView[0]->title}}</h2>
                <div class="content">
                {{$dataUserPageView[0]->description}}
                </div>
            @else
            <div class="col-sm-12">
                <h2>{{trans('product.user_product_not_found')}}</h2>
            </div>
            @endif
		</div>
	</div>
</div>
@endsection
@section('left')
	@if (! empty ( $toolView ))
		@foreach ( $toolView as $tool )
			@if($tool->type == 'tool_memeber_status' && $tool->status == 1)
				@include('frontend.modules.store.partials.slidebar.memeber_status')
			@endif
		@endforeach
	@endif
@endsection
@section('right')

@if (! empty ( $toolView ))
	@foreach ( $toolView as $tool )
		@if($tool->type == 'tool_visitor_info' && $tool->status == 1)
		@include('frontend.modules.store.partials.slidebar.tool_visitor')
		@endif
	@endforeach
@endif

@if(!empty($banner))
    @foreach($banner as $ban)
        @if($ban->ban_position == 'rs')
            @if($ban->ban_enddate >= $currentDate)
<a class="banner-link" href="{{@$ban->ban_link}}" target="_blank"><img
	src="{{Config::get('app.url')}}upload/user-banner/{{$ban->ban_image}}"
	style="width: 100%;" /></a>
@endif @endif @endforeach @endif @endsection