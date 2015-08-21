@extends('frontend.modules.store.layout.layout')
@section('title')
	@if (!empty($dataProductDetail))
		{{$dataProductDetail->title}}
	@endif
@endsection
@section('description')@if(!empty($dataProductDetail->description)){{$dataProductDetail->description}} @endif @endsection
@section('breadcrumb')
	<ol class="breadcrumb">
		<li><a href="{{Config::get('app.url')}}">Home</a></li>
		<li><a href="#">Library</a></li>
		<li class="active">Data</li>
	</ol>
@endsection
@section('content')
	<div class="col-lg-8" id="slider">
			<div class="col-xs-12" >
		 <!-- Top part of the slider -->
			<div class="row">
				<div class="col-sm-8" id="carousel-bounding-box">
					<div class="carousel slide" id="myCarousel">
						<!-- Carousel items -->
						<div class="carousel-inner">
							@if (!empty($dataProductDetail))
								<?php 
					    			$pictures = json_decode($dataProductDetail->pictures, true);
					    			$i = 0;
					    		?>
					    		@foreach($pictures as $picture)
					    			<?php $active = ($i === 0) ? 'active': ''; ?>
									<div class="{{$active}} item" data-slide-number="0">
										<img 
											alt="{{$dataProductDetail->title}}"
											src="{{Config::get('app.url')}}upload/product/{{$picture['pic']}}"
										>
									</div>
									<?php $i++; ?>
								@endforeach
							@endif
						</div><!-- Carousel nav -->
						<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
							<span class="glyphicon glyphicon-chevron-left"></span>
						</a>
						<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
							<span class="glyphicon glyphicon-chevron-right"></span>
						</a>
						</div>
				</div>
				<div class="col-sm-4" id="carousel-text"></div>
				<div id="slide-content" style="display: none;">
					<div id="slide-content-0">
						<h2>
							@if (!empty($dataProductDetail))
								{{$dataProductDetail->title}}
							@endif
						</h2>
						<h3>
							@if (!empty($dataProductDetail))
								${{$dataProductDetail->price}}
							@endif
						</h3>
						<h4>
							@if (!empty($dataProductDetail))
								{{$dataProductDetail->publish_date}}
							@endif
						</h4>
						<p class="sub-text">
							@if (!empty($dataProductDetail))
								{{$dataProductDetail->description}}
							@endif
						</p>
					</div>
				</div>
			</div>
		</div>

		<div class="row hidden-xs" id="slider-thumbs">
			<div class="col-lg-8">
				<!-- Bottom switcher of slider -->
				@if (!empty($dataProductDetail))
				    <ul class="hide-bullets">
				    	<?php 
				    		$pictures = json_decode($dataProductDetail->pictures, true);
				    	?>
				    	@foreach($pictures as $picture)
					        <li class="col-sm-2">
					            <a class="thumbnail" id="carousel-selector-0">
					            	<img 
					            		alt="{{$dataProductDetail->title}}" 
					            		src="{{Config::get('app.url')}}upload/product/thumb/{{$picture['pic']}}"
					            	>
					            </a>
					        </li>
					    @endforeach
				    </ul>
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