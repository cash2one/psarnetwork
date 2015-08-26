@extends('frontend.nosidebar') @section('title') Register for Enterprise Seller Page @endsection @section('breadcrumb')
<ol class="breadcrumb">
	<li>
		<a href="#">Home</a>
	</li>
	<li>
		<a href="#">Library</a>
	</li>
	<li class="active">
		Data
	</li>
</ol>
@endsection @section('frontend.partials.left') @endsection @section('content')
<div class="memberlogin">
	<div class="col-sm-3">
		@include('frontend.modules.member.layout.sidebar')
		<div class="clear">
		</div>
	</div>
	<div class="col-sm-9">
		<!-- content -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-control">
                    @if(Input::has('action'))
                    <a class="btn btn-default btn-sm" href="{{Config::get('app.url')}}member/userinfo/banner" role="button">{{trans('register.BTN_BACK')}}</a>
                    @else
					<a class="btn btn-default btn-sm" href="{{Config::get('app.url')}}member/userinfo/banner?action=add" role="button">{{trans('register.banner_add_add')}}</a>
                    @endif
				</div>
				<h3 class="panel-title">
                    @if(Input::get('action'))
    					@if(Input::get('action')=='add')
                            Add a banner
                        @else
                            Edit banner
                        @endif
                    @else
                        Banner
                    @endif
				</h3>
			</div>
			<div class="panel-body">
				@if(Input::has('action'))
                @if(Input::get('action')=='add')
                    
                @else
                @endif
				<!-- add -->
                {{Form::open(array('url'=>'member/userinfo/banner','enctype'=>'multipart/form-data','file' => true, 'id'=>'PersonalBanner','class'=>'form-horizontal'))}}
					<div class="form-group">
						<label class="col-sm-3 control-label" for="demo-hor-title">
							{{trans('register.banner_add_title')}}
						</label>
						<div class="col-sm-9">
                            @if(Input::get('action')=='add')
                                
                            @else
                                <input type="hidden" value="{{@$dataBanner->ban_id}}" name="edit"/>
                                <input type="hidden" value="{{@$dataBanner->ban_image}}" name="oldimage"/>
                            @endif
							<input type="text" value="{{@$dataBanner->ban_title}}" name="title" placeholder="Title" id="demo-hor-title" class="form-control" required/>
						</div>
					</div>
                    
                    <div class="form-group">
						<label class="col-sm-3 control-label" for="demo-hor-image">
							{{trans('register.banner_add_image')}}
						</label>
						<div class="col-sm-9">
							<input type="file" name="file" id="demo-hor-image" class="form-control" accept="image/*" @if(Input::get('action')=='add') required @endif />
						</div>
					</div>
                    
                    <div class="form-group">
						<label class="col-sm-3 control-label" for="demo-hor-title">
							{{trans('register.banner_link')}}
						</label>
						<div class="col-sm-9">
							<input value="{{@$dataBanner->ban_link}}" name="link" placeholder="link to url" id="demo-hor-title" class="form-control" type="url" pattern="https?://.+" required/>
						</div>
					</div>
                    
                    <div class="form-group">
						<label class="col-sm-3 control-label" for="demo-hor-position">
							{{trans('register.banner_add_position')}}
						</label>
						<div class="col-sm-9">
							<select class="form-control" name="positions" id="demo-hor-position" required>
                                <option value="">Select a position</option>
                                <option value="top-c" {{@$dataBanner->ban_position == 'top-c' ? 'selected="selected"' : ''}}>{{trans('register.banner_position_top_content')}}</option>
                                <option value="ls" {{@$dataBanner->ban_position == 'ls' ? 'selected="selected"' : ''}}>{{trans('register.banner_position_left_side')}}</option>
                                <option value="rs" {{@$dataBanner->ban_position == 'rs' ? 'selected="selected"' : ''}}>{{trans('register.banner_position_right_side')}}</option>
                                <option value="footer" {{@$dataBanner->ban_position == 'footer' ? 'selected="selected"' : ''}}>{{trans('register.banner_position_footer')}}</option>
                            </select>
						</div>
					</div>
                    
                    <div class="form-group">
						<label class="col-sm-3 control-label" for="datepicker">
							{{trans('register.banner_add_enddate')}}
						</label>
						<div class="col-sm-9">
							<input type="text" value="{{@$dataBanner->ban_enddate}}" name="enddate" placeholder="End date" id="datepicker" class="form-control"/>
						</div>
					</div>
                    
                    <div class="form-group">
						<label class="col-sm-3 control-label" for="demo-hor-status">
							{{trans('register.banner_status')}}
						</label>
						<div class="col-sm-9">
							<select class="form-control" name="status" id="demo-hor-status">
                                <option value="1">Select one</option>
                              <option value="1" {{@$dataBanner->ban_status == '1' ? 'selected="selected"' : ''}}>{{trans('register.banner_status_1')}}</option>
                              <option value="0" {{@$dataBanner->ban_status == '0' ? 'selected="selected"' : ''}}>{{trans('register.banner_status_0')}}</option>
                            </select>
						</div>
					</div>
                    @if(Input::get('action')=='add')
                        <input id="summit" type="submit" class="btn btn-default pull-right choosenuser" name="btnInfo" value="{{trans('register.BTN_SAVE')}}"/>
                    @else
                        <input id="summit" type="submit" class="btn btn-warning pull-right" name="btnInfo" value="{{trans('register.BTN_UPDATE')}}"/>
                    @endif
				{{Form::close()}}
				<!-- end add -->
				@else
				<!-- banner list -->
                @if(Session::get('messsage'))
                <div class="alert alert-success fade in" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <strong>Well done!</strong>  deleted successfully
                </div>
                @endif
				<table class="table">
					<thead>
						<tr>
							<th>
								ID
							</th>
							<th>
								Title
							</th>
							<th>
								Create date
							</th>
							<th>
								End date
							</th>
                            <th>
								Status
							</th>
                            <th>
								Action
							</th>
						</tr>
					</thead>
					<tbody>
                        @if(!empty($dataBanner))
                        @foreach($dataBanner as $banner)
						<tr>
							<th scope="row" style="width: 60px;">
								{{$banner->ban_id}}
							</th>
							<td>
                                <div class="media">
                                      <div class="media-left">
                                        <a href="#">
                                          @if($banner->ban_image)
                                          <img class="media-object" data-src="holder.js/64x64" alt="64x64" src="{{Config::get('app.url')}}upload/user-banner/thumb/{{$banner->ban_image}}" data-holder-rendered="true" style="width: 64px; height: 64px;"/>
                                          @else
                                          <img class="media-object" data-src="holder.js/64x64" alt="64x64" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PCEtLQpTb3VyY2UgVVJMOiBob2xkZXIuanMvNjR4NjQKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNGU5Y2I4ZDg1ZCB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE0ZTljYjhkODVkIj48cmVjdCB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSIxNC41IiB5PSIzNi41Ij42NHg2NDwvdGV4dD48L2c+PC9nPjwvc3ZnPg==" data-holder-rendered="true" style="width: 64px; height: 64px;"/>
                                          @endif
                                        </a>
                                      </div>
                                      <div class="media-body">
                                        <h4 class="media-heading" style="text-align: left;">{{$banner->ban_title}}</h4>
                                      </div>
                                </div>
							</td>
							<td style="width: 110px;">
								{{$banner->ban_cdate}}
							</td>
							<td style="width: 110px;">
								{{$banner->ban_enddate}}
							</td>
                            <td style="width: 110px;">
								{{$banner->ban_status == 1? '<span class="label label-success">Enabled</span>' : '<span class="label label-danger">Disabled</span>'}}
							</td>
                            <td style="width: 70px;">
								<div class="dropdown">
                                  <button class="btn btn-default dropdown-toggle btn-xs" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    Action
                                    <span class="caret"></span>
                                  </button>
                                  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1" style="padding-left: 0;">
                                    <li><a href="{{Config::get('app.url')}}member/userinfo/banner?action={{$banner->ban_id}}">Edit</a></li>
                                    <li><a href="{{Config::get('app.url')}}member/userinfo/banner?action=del&id={{$banner->ban_id}}" class="btn btn-danger">Delete</a></li>
                                  </ul>
                                </div>
							</td>
						</tr>
                        @endforeach
                        @else
                        <tr>
							<td colspan="5">
								no record
							</td>
						</tr>
                        @endif
					</tbody>
				</table>
				<!-- End banner list -->
				@endif
			</div>
		</div>
		<!-- end content -->
	</div>
</div>
<div class="clear">
</div>
<style>
	
	



</style>
@if(Input::get('action'))
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/smoothness/jquery-ui.css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
  <script>
  $(function() {
    $( "#datepicker" ).datepicker({ changeMonth: true,changeYear: true,dateFormat:'yy-mm-dd'});
  });
</script>
@endif
@endsection