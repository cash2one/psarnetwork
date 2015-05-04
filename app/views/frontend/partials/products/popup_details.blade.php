<!-- Modal -->
<div class="container modal fade" id="myModal" tabindex="-1"
	role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Product details title</h4>
			</div>
			<div class="modal-body modal_container">
				<div class="col-lg-8" id="details_view"></div>
				<div class="col-lg-4">
					{{App::make('FeDetailController')->getVerticalRightAds()}}
				</div>
			</div>
		</div>
	</div>
</div>