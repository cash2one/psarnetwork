@extends('frontend.nosidebar') @section('title') Register for Enterprise
Seller Page @endsection @section('breadcrumb')
<ol class="breadcrumb">
	<li><a href="#">Home</a></li>
	<li><a href="#">Library</a></li>
	<li class="active">Data</li>
</ol>
@endsection @section('frontend.partials.left') @endsection @section('content')
<?php
function rm($article, $char) {
	$article = preg_replace ( "/<img[^>]+\>/i", "(image) ", $article );
	if (strlen ( $article ) > $char) {
		return substr ( $article, 0, $char ) . '...';
	} else
		return $article;
}
?>
{{HTML::style('frontend/plugin/trumbowyg/dist/ui/trumbowyg.css')}}
{{HTML::style('frontend/plugin/trumbowyg/dist/plugins/colors/ui/trumbowyg.colors.css')}}
<div class="memberlogin">
	<div class="col-sm-3">
		@include('frontend.modules.member.layout.sidebar')
		<div class="clear"></div>
	</div>
	<div class="col-sm-9">
		<!--login form-->
		<div class="conent">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="panel-control">
						@if($addActions) <a class="btn btn-default btn-sm"
							href="{{Config::get('app.url')}}member/userinfo/addpage"
							role="button">{{trans('register.BTN_BACK')}}</a> @else <a
							class="btn btn-default btn-sm"
							href="{{Config::get('app.url')}}member/userinfo/addpage?add=1"
							role="button">{{trans('register.banner_add_add')}}</a>
						@endif
					</div>
					<h3 class="panel-title">
					@if(!empty($dataEdit))
						{{trans('register.acc_eidt_page_title')}}
					@else
						{{trans('register.acc_page_title')}}
					@endif</h3>
				</div>

				<div class="panel-body">
					@if($addActions)
					<div class="col-sm-12">
						<form action="" id="vaildateForm" class="form-horizontal"
							method="post">
							<div class="pro-detail">
								<div class="form-group">
									<label for="TitleTxt" class="col-sm-3 control-label">
										{{trans('register.acc_page_name')}} </label>
									<div class="col-sm-9">
										<input type="text"
											value="@if(!empty($dataEdit)) {{$dataEdit[0]->title}} @endif"
											name="name" class="form-control" id="TitleTxt"
											placeholder="{{trans('register.acc_page_name')}}"
											aria-describedby="TitleTxtStatus" required /> <span
											data="TitleTxt"
											class="glyphicon glyphicon-remove form-control-feedback"
											aria-hidden="true"> </span> <span id="TitleTxtStatus"
											class="sr-only"> (error) </span>
									</div>
								</div>
								<div class="form-group">
									<label for="bodyTxt" class="col-sm-3 control-label">
										{{trans('register.acc_page_body')}} </label>
									<div class="col-sm-9">
										<textarea name="body" class="form-control" id="bodyTxt"
											placeholder="{{trans('register.acc_page_body')}}"
											aria-describedby="bodyTxtStatus">@if(!empty($dataEdit)){{$dataEdit[0]->description}}@endif</textarea>
									</div>
								</div>

								<div class="form-group">
									<label for="bodyTxt" class="col-sm-3 control-label">
										{{trans('register.acc_page_body')}} </label>
									<div class="col-sm-9">
										<select class="form-control" name="menuPosition">
											<option value="1"@if(!empty($dataEdit)) @if($dataEdit[0]->position
												==1) selected @endif @endif >Menu 1</option>
											<option value="2"@if(!empty($dataEdit)) @if($dataEdit[0]->position
												==2) selected @endif @endif>Menu 2</option>
										</select>
									</div>
								</div>
								
								<div class="form-group">
									<label for="status" class="col-sm-3 control-label">
										{{trans('register.acc_page_status')}} </label>
									<div class="col-sm-9">
										<select class="form-control" name="status" id="status">
											<option value="1"@if(!empty($dataEdit)) @if($dataEdit[0]->status
												==1) selected @endif @endif >{{trans('register.enable')}}</option>
											<option value="0"@if(!empty($dataEdit)) @if($dataEdit[0]->status
												==0) selected @endif @endif>{{trans('register.disable')}}</option>
										</select>
									</div>
								</div>
							</div>
							@if(!empty($dataEdit)) <input type="hidden" name="editPage"
								value="{{$dataEdit[0]->id}}" /> @endif <input id="summit"
								type="submit" class="btn btn-default pull-right choosenuser"
								name="btnInfo" value="{{trans('register.BTN_SUBMIT')}}" />
						</form>
					</div>
					@else

					<div class="col-sm-12">
						<table class="table table-striped">
							<tr>
								<th style="width: 40px">ID</th>
								<th style="width: 30%">Title</th>
								<th>content</th>
								<th style="width: 80px">{{trans('register.status')}}</th>
								<th style="width: 80px">Action</th>
							</tr>
							@if($datapage) @foreach($datapage as $page)
							<tr>
								<td>{{$page->id}}</td>
								<td>{{$page->title}}</td>
                                            <?php
																																												$readmore = @rm ( $page->description, 100 );
																																												?>
                                            <td class="content-page">{{$readmore}}</td>
                                <td>
                                	@if($page->status==1)
                                		<span class="label label-success">{{trans('register.enable')}}</span>
                                	@else
                                		<span class="label label-danger">{{trans('register.disable')}}</span>
                                	@endif
								</td>           
								<td>
									<div class="dropdown">
										<button id="dLabel" type="button" data-toggle="dropdown"
											aria-haspopup="true" aria-expanded="false">
											Action <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
											<li><a
												href="{{URL::to('member/userinfo/addpage')}}?id={{$page->id}}">Edit</a>
											</li>
											<li><a
												href="{{URL::to('member/userinfo/addpage')}}?del={{$page->id}}">Delete</a>
											</li>
										</ul>
									</div>
								</td>
							</tr>
							@endforeach @endif
						</table>
					</div>
					@endif
				</div>
			</div>
			<!--end product detail-->
			<div class="clear"></div>
		</div>
		<!--/login form-->
	</div>
</div>
<div class="clear"></div>
{{HTML::script('frontend/js/jquery.validate.js')}}
{{HTML::script('frontend/plugin/trumbowyg/dist/trumbowyg.js')}}
{{HTML::script('frontend/plugin/trumbowyg/dist/plugins/colors/trumbowyg.colors.js')}}
<script type='text/javascript'>
$(document).ready(function(){
/*upload*/
    'use strict';

    addXhrProgressEvent();

    $.extend(true, $.trumbowyg, {
        langs: {
            en: {
                upload: "Upload",
                file:   "File",
                uploadError: "Error"
            },
            sk: {
                upload: "Nahrat",
                file:   "S�bor",
                uploadError: "Chyba"
            },
            fr: {
                upload: "Envoi",
                file:   "Fichier",
                uploadError: "Erreur"
            },
            cs: {
                upload: "Nahr�t obr�zek",
                file:   "Soubor",
                uploadError: "Chyba"
            }
        },

        upload: {
            serverPath: '{{Config::get('app.url')}}member/ajaxupload?page=pageupload'
        },

        opts: {
            btnsDef: {
                upload: {
                    func: function(params, tbw){
                        var file,
                            pfx = tbw.o.prefix;

                        var $modal = tbw.openModalInsert(
                            // Title
                            tbw.lang.upload,

                            // Fields
                            {
                                file: {
                                    type: 'file',
                                    required: true
                                },
                                alt: {
                                    label: 'description'
                                }
                            },

                            // Callback
                            function(){
                                var data = new FormData();
                                data.append('fileToUpload', file);

                                if($('.' + pfx +'progress', $modal).length === 0)
                                    $('.' + pfx + 'modal-title', $modal)
                                    .after(
                                        $('<div/>', {
                                            'class': pfx +'progress'
                                        })
                                        .append(
                                            $('<div/>', {
                                                'class': pfx +'progress-bar'
                                            })
                                        )
                                    );

                                $.ajax({
                                    url:            $.trumbowyg.upload.serverPath,
                                    type:           'POST',
                                    data:           data,
                                    cache:          false,
                                    dataType:       'json',
                                    processData:    false,
                                    contentType:    false,

                                    progressUpload: function(e){
                                        $('.' + pfx + 'progress-bar').stop().animate({
                                            width: Math.round(e.loaded * 100 / e.total) + '%'
                                        }, 200);
                                    },

                                    success: function(data){
                                        if(data.message == "uploadSuccess") {
                                            tbw.execCmd('insertImage', data.file);
                                            setTimeout(function(){
                                                tbw.closeModal();
                                            }, 250);
                                        } else {
                                            tbw.addErrorOnModalField(
                                                $('input[type=file]', $modal),
                                                tbw.lang[data.message]
                                            );
                                        }
                                    },
                                    error: function(){
                                        tbw.addErrorOnModalField(
                                            $('input[type=file]', $modal),
                                            tbw.lang.uploadError
                                        );
                                    }
                                });
                            }
                        );

                        $('input[type=file]').on('change', function(e){
                            try {
                                // If multiple files allowed, we just get the first.
                                file = e.target.files[0];
                            } catch (err) {
                                // In IE8, multiple files not allowed
                                file = e.target.value;
                            }
                        });
                    },
                    ico: 'insertImage'
                }
            }
        }
    });


    function addXhrProgressEvent(){
        if (!$.trumbowyg && !$.trumbowyg.addedXhrProgressEvent) {   // Avoid adding progress event multiple times
            var originalXhr = $.ajaxSettings.xhr;
            $.ajaxSetup({
                xhr: function() {
                    var req  = originalXhr(),
                        that = this;
                    if(req && typeof req.upload == "object" && that.progressUpload !== undefined)
                        req.upload.addEventListener("progress", function(e){
                            that.progressUpload(e);
                        }, false);

                    return req;
                }
            });
            $.trumbowyg.addedXhrProgressEvent = true;
        }
    }    
/*end upload*/    
    
    
    
    $("#vaildateForm").validate({
          rules: {
      name: {
         required : true
      }
    },
      messages:{
          name: {
            required : "This Title is required."
          }
      }
    });
    
    /*Editor*/
    var formTbwOptions = {
                closable: false,
                mobile: true,
                fixedBtnPane: true,
                fixedFullWidth: true,
                semantic: true,
                resetCss: true,
                removeformatPasted: true,

                autogrow: true,

                btnsDef: {
                    strong: {
                        func: 'bold',
                        key: 'G'
                    },
					align: {
                        dropdown: ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                        ico: 'justifyLeft'
                    },
                    image: {
                        dropdown: ['insertImage', 'upload', 'base64'],
                        ico: 'insertImage'
                    }
                },
                btns: ['viewHTML',
                    '|', 'formatting',
                    '|', 'btnGrp-lists',
					'|', 'align',
                    '|', 'image',
                    '|', 'foreColor', 'backColor']
            };
            $('#bodyTxt')
            .trumbowyg(formTbwOptions)
            .on('dblclick', function(){
                $(this).trumbowyg(formTbwOptions);
            });
});
</script>
<
<style>
<!--
.content-page img {
	display: none
}
-->
</style>
@endsection
