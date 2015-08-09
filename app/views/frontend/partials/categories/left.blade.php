<div class="col-lg-2 left_bar">
	<div class="left-sidebar">
		<div class="panel-group category-products" id="accordian">
			<div class="all_categories_type" id="menu_toogle">
				<img src="{{Config::get('app.url')}}frontend/images/icons/all_category.png" alt="" title="" height="23"/>
				<strong> &nbsp;&nbsp;&nbsp; 
					@foreach ($MaindetailCategory as $maincate)
					<?php 
						echo $maincate->{'name_'.Session::get('lang')};
					?> 
					@endforeach
					&nbsp;&nbsp;&nbsp;<span class="caret" ></span></strong>
			</div>
			<ul class="categories_menu">
				<?php
				$finalCategory = new MCategory();
				if(count($detailCategory)){
				?>
					@foreach ($detailCategory as $categoriesList)
						<li class="dropdown-mainmenu">
							<a href="<?php echo URL::to('products/productbycategories/'.$categoriesList->parent_id.'/'.$categoriesList->id); ?>">
								<?php echo $categoriesList->{'name_'.Session::get('lang')};?>
				      		</a>
						</li>
					@endforeach
				<?php
				}else{
					echo '<span class="price"><center>No Category</center></span>';
				}
				?>
			</ul>
		</div>
		<!--=========Register seller============ -->
		<div class="panel-group category-products" id="accordian">
			<!-- type:homepage, position: left meduim, limit -->
			{{ App::make('FePageController')->getFeAds(1, 4, 3) }}
		</div>
	</div>
</div>

<script>
	jQuery(document).ready(function(){
		jQuery("#menu_toogle").css('cursor','pointer');
		jQuery("#menu_toogle").click(function(){
			jQuery(".categories_menu").toggle("slow");
		});
	});
</script>