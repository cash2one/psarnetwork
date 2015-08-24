<?php
$newProducts = Product::findNewProducts ();
if(count($newProducts) > 0){
?>
<div class="category-tab feature-ad lastest-post" style="padding: 0;">
	<!--recommended_items-->
	<ul class="nav nav-tabs new_product">
		<li><strong>New Products</strong> &nbsp;&nbsp;&nbsp; &frasl;</li>
		<li>Products : <span class="number-display">25</span></li>
		<li>Stores :<span class="number-display">25</span></li>
		<li>Market :<span class="number-display">25</span></li>
		<li>Companies :<span class="number-display">25</span></li>
		<li>Home Shop :<span class="number-display">25</span></li>
		<li>Individual : <span class="number-display">25</span></li>
		<li>View :<span class="number-display">25</span></li>
	</ul>
	<div id="hotpromotion-item-carousel" class="carousel slide"
		data-ride="carousel">
		<div class="carousel-inner">
			<?php
			$newPro = 1;
			?>
			<div class="item active">
			<div id="detail_product" data-get-detail-product-url="{{Config::get('app.url')}}"></div>
				@foreach($newProducts as $newProduct)
				<?php 
				if(strtotime($newProduct->publish_date) >= strtotime("d/m/Y")){
				?>
					<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
						<div class="product-image-wrapper">
							<div class="single-products">
								<div class="productinfo text-center">
									<a href="#" data-toggle="modal" data-target="#myModal"
										onclick="popupDetails.add_popup_detail(<?php echo $newProduct->id; ?>)">
										<img
										src="{{Config::get('app.url')}}upload/product/thumb/{{$newProduct->thumbnail}}"
										alt="" />
									</a>
									<h2 class="price">$ {{$newProduct->price}}</h2>
									<center>
										<a href="{{Config::get('app.url')}}product/details/{{$newProduct->id}}">
											<?php echo substr($newProduct->title,0,20)?>
										</a>
									</center>
								</div>
								<img
									src="{{Config::get('app.url')}}/frontend/images/home/sale.png"
									class="new" alt="" />
							</div>
						</div>
					</div>
				<?php
				}
				
				if ($newPro >= 6 && $newPro % 6 == 0) {
					echo '</div><div class="item"> ';
				}
				$newPro ++;
				?>
				@endforeach
			</div>
		</div>
		<a class="left recommended-item-control"
			href="#hotpromotion-item-carousel" data-slide="prev"> <i
			class="fa fa-angle-left"></i>
		</a> <a class="right recommended-item-control"
			href="#hotpromotion-item-carousel" data-slide="next"> <i
			class="fa fa-angle-right"></i>
		</a>
	</div>
</div>
<?php 
}
?>