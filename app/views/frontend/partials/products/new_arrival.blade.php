<div class="col-lg-12 center-advertise hidden-xs">
	<!-- type:homepage, position: up on new product, limit -->
	{{ App::make('FePageController')->getHorizontalAds(1, 11, 3) }}
</div>
<?php
$newProducts = Product::findNewProducts ();
if(count($newProducts) > 0){
?>
<div class="category-tab feature-ad lastest-post" style="padding: 0;">
	<!--recommended_items-->
	<ul class="nav nav-tabs new_product">
		<li>{{trans('product.new_product')}}(<strong class="price" style="font-size:12px;"><?php echo count($newProducts)?></strong>)</li>
	</ul>
	<div id="new-item-carousel" class="carousel slide"
		data-ride="carousel">
		<div class="carousel-inner">
			<?php
			$newPro = 1;
			?>
			<div class="item active">
			<div id="detail_product" data-get-detail-product-url="{{Config::get('app.url')}}"></div>
				@foreach($newProducts as $newProduct)
					<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
						<div class="product-image-wrapper">
							<div class="single-products">
								<div class="productinfo text-center">
									<a href="{{Config::get('app.url')}}product/details/{{$newProduct->id}}">
										<?php
										if($newProduct->thumbnail){
											echo '<img src="/image/phpthumb/'.$newProduct->thumbnail.'?p=product&amp;h=90&amp;w=120" />';
										}else{
											echo '<img src="/image/phpthumb/No_image_available.jpg?p=product&amp;h=90&amp;w=120" />';
										}
										?>
									</a>
									<center>
										<h5>
											<a href="{{Config::get('app.url')}}product/details/{{$newProduct->id}}">
												<?php echo str_limit($newProduct->title,$limit = 15, $end = '...');?>
											</a>
										</h5>
										<strong class="price">$ {{$newProduct->price}}</strong>
									</center>
								</div>
							</div>
						</div>
					</div>
				<?php
				if($newPro == 6 || $newPro==12 || $newPro == 18 || $newPro == 24 || $newPro == 30 || $newPro == 36 || $newPro == 42 || $newPro == 48 || $newPro == 54){
					echo '</div><div class="item"> ';
				}
				$newPro++;
				?>
				@endforeach
			</div>
		</div>
		<a class="left recommended-item-control"
			href="#new-item-carousel" data-slide="prev"> <i
			class="fa fa-angle-left"></i>
		</a> <a class="right recommended-item-control"
			href="#new-item-carousel" data-slide="next"> <i
			class="fa fa-angle-right"></i>
		</a>
	</div>
</div>
<?php
}
?>