<br />
	<div class="row">
		<div class="col-lg-12" style="border: 1px solid #F7F7F5; padding: 0; background:#f9f9f7;">
			<div class="col-lg-3"
				style="border-right: 0px solid #ddd; padding: 10px; margin-top: 55px;">
				<center>
					<div class="btn btn-warning">Summary in each locations</div>
				</center>
			</div>
			<div class="col-lg-9"
				style="padding: 10px; border-left: 1px solid #F7F7F5;">

				@foreach($Provinces as $province)
				<div class="btn btn-default"
					style="border-radius: 0; min-width: 160px; font-size: 12px; border: none; text-align: left;">
					<a href="{{Config::get('app.url')}}search?q=&location=<?php echo $province->province_id?>&type=1">
					<?php echo $province->{'province_name_'.Session::get('lang')}; ?> &nbsp;&nbsp;<span
						class="number-display">200</span>
					</a>
				</div>
				@endforeach
			</div>
		</div>
	</div>
	<br />
	<div class="row">
		<div class="col-lg-12" style="border: 1px solid #F7F7F5; padding: 0; background:#f9f9f7;">
			<div class="col-lg-3"
				style="border-right: 0px solid #ddd; padding: 10px;">
				<center>
					<div class="btn btn-warning">Summary in Seller Type</div>
				</center>
			</div>
			<div class="col-lg-9"
				style="padding: 10px; border-left: 1px solid #F7F7F5;">
				@foreach($seller_type as $sellertype)
				<div class="btn btn-default"
					style="border-radius: 0; min-width: 160px; font-size: 12px; border: none; text-align: left;">
					<a href="{{Config::get('app.url')}}product/list/<?php echo $sellertype->rol_id ?>/0" >
					  <?php 
					  	echo $sellertype->{'rol_name_'.Session::get('lang')}; ?>
					  	&nbsp;&nbsp;
					  	<span class="number-display">200</span>
					</a>
				</div>
				@endforeach
			</div>
		</div>
	</div>
	<br />
	<div class="row">
		<div class="col-lg-12" style="border: 1px solid #F7F7F5; padding: 0; background:#f9f9f7;">
			<div class="col-lg-3"
				style="border-right: 0px solid #ddd; padding: 10px;">
				<center>
					<div class="btn btn-warning">Summary in business site</div>
				</center>
			</div>
			<div class="col-lg-9"
				style="padding: 10px; border-left: 1px solid #F7F7F5;">
				@foreach($client_type as $clienttype)
				<div class="btn btn-default"
					style="border-radius: 0; min-width: 160px; font-size: 12px; border: none; text-align: left;">
					<a href="{{Config::get('app.url')}}product/list/<?php echo $clienttype->id ?>/0" >
					  <?php 
					  	echo $clienttype->{'name_'.Session::get('lang')}; ?>
					  	&nbsp;&nbsp;
					  	<span class="number-display">200</span>
					</a>
				</div>
				@endforeach
			</div>
		</div>
	</div>
