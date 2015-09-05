@extends('frontend.layout') 
@section('title') 
Categories 
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="#">Home</a></li>
    <li><a href="#">Library</a></li>
    <li class="active">Data</li>
</ol>
@endsection
@section('content')
@include('frontend.partials.left-supermarket')
	<div class="col-lg-10" style="">
		<div class="col-lg-2 pull-right" style="padding:0;">
			@include('frontend.partials.categories.right')
		</div>
		<div class="col-lg-10"  style="padding-left:0;">
			<div>
				<!-- ============Slider end here========= -->
				@include('frontend.partials.products.search')
				<div class="row">
					<div id="detail_product" data-get-detail-product-url="{{Config::get('app.url')}}"></div>
					<?php 
					if(count($listProductSupermarket) > 0){
					?>
						@foreach($listProductSupermarket as $product)
							<div class="product_list_container">
								<div class="media commnets product-list-item">
									<a href="#" data-toggle="modal" data-target="#myModal"
									onclick="popupDetails.add_popup_detail(<?php echo $product->id; ?>)" class="pull-left product_image">
										<img alt="" src="{{Config::get('app.url')}}upload/product/thumb/{{$product->thumbnail}}" class="media-object small">
										<img alt="" src="{{Config::get('app.url')}}upload/product/{{$product->thumbnail}}" class="media-object big">
									</a>
									
									<div class="media-body">
										<strong class="media-heading">
											<a href="{{Config::get('app.url')}}product/details/{{$product->id}}">
											{{ str_limit($product->title, $limit = 10, $end = '...') }}
											</a>
										</strong><br />
										<small><i>{{$product->publish_date}}</i></small><br />
										<p>
											{{ str_limit($product->description, $limit = 90, $end = '...') }}<br />
										</p>
										<div class="blog-socials">
											<a href="{{Config::get('app.url')}}product/details/{{$product->id}}" class="btn btn-primary">$ {{$product->price}}</a>
										</div>
									</div>
								</div>
							</div>
						@endforeach
					<?php 
						}else{
							echo '<h4><center style="color:red;">Product not found!</center></h4>';
						}
					?>
					</div>
				</div>
			</div>
		</div>
	</div>
@include('frontend.partials.products.popup_details')
@endsection
<script src="{{Config::get('app.url')}}/frontend/js/jquery.js"></script>
<script src="{{Config::get('app.url')}}/frontend/js/carouselengine/amazingcarousel.js"></script>
<link rel="stylesheet" type="text/css" href="{{Config::get('app.url')}}/frontend/js/carouselengine/initcarousel-1.css">
<script src="{{Config::get('app.url')}}/frontend/js/carouselengine/initcarousel-1.js"></script>


