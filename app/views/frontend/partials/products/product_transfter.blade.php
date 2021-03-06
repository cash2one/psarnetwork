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
<div class="clear"></div>
@include('frontend.partials.menu')
@section('content')
{{ App::make('FePageController')->mainCategory() }}
	<div class="col-lg-10" style="padding-right:%;">
		<div class="col-lg-2 pull-right" style="padding:0;">
			@include('frontend.partials.categories.right')
		</div>
		<div class="col-lg-10"  style="padding:0;">
			<div>
				<div class="row">
					<div id="detail_product" data-get-detail-product-url="{{Config::get('app.url')}}"></div>
					<?php
					if(count($productsByTransfterType) > 0){
					?>
						@foreach($productsByTransfterType as $product)
							<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
								<div class="product-image-wrapper">
									<div class="single-products">
										<div class="productinfo text-center">
											<a href="#" data-toggle="modal" data-target="#myModal"
												onclick="popupDetails.add_popup_detail(<?php echo $product->id; ?>)">
												<?php
												if($product->thumbnail){
													echo '<img src="'.Config::get('app.url').'image/phpthumb/'.$product->thumbnail.'?p=product&amp;h=130&amp;w=160" />';
												}else{
													echo '<img src="'.Config::get('app.url').'image/phpthumb/No_image_available.jpg?p=product&amp;h=90&amp;w=120" />';
												}
												?>
											</a>
											<center>
												<h5>
													<a href="{{Config::get('app.url')}}product/details/{{$product->id}}"><?php echo  str_limit($product->title,$limit = 20, $end = '...');?></a>
												</h5>
												<strong class="price">$ {{$product->price}}</strong>
											</center>
										</div>
									</div>
								</div>
							</div>
						@endforeach
						<div style="clear: both;"></div>
						<div class="col-lg-12">
								<div id="pagination" class="col-lg-12 text-center">
									{{ $productsByTransfterType->appends(Input::except('page'))->links(); }}
								</div>
						</div>
					<?php
						}else{
							echo '<h3><center style="color:red;">Product not found!</center></h3>';
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