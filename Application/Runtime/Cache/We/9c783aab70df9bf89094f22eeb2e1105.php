<?php if (!defined('THINK_PATH')) exit();?><div class="row-fluid">

	<div class="span12">

		<!-- BEGIN PORTLET-->   

		<div class="portlet box blue">

			<div class="portlet-title">

				<div class="caption"><i class="icon-reorder"></i>站点信息修改</div>

				<div class="tools">

					<a href="javascript:;" class="collapse"></a>

					<a href="#portlet-config" data-toggle="modal" class="config"></a>

					<a href="javascript:;" class="reload"></a>

					<a href="javascript:;" class="remove"></a>

				</div>

			</div>

			<div class="portlet-body form">

				<!-- BEGIN FORM-->

				<form action="/We/Index/webconf" class="form-horizontal" method="post" enctype="multipart/form-data">

					<input type="hidden" name="id" value="<?php echo ($data["id"]); ?>">
					<div class="control-group">

						<label class="control-label">站点标题</label>

						<div class="controls">

							<input type="text" value="<?php echo ($data["web_name"]); ?>" class="span6 m-wrap" name="title">

							<span class="help-inline">用于显示网站标题</span>

						</div>

					</div>
					
					<div class="control-group">

						<label class="control-label">模板名称<span class="required">*</span></label>

						<div class="controls">

							<input readonly type="text" value="<?php echo ($data["tpl_style"]); ?>" required class="span6 m-wrap" name="tpl_style">

							<span class="help-inline">该项不可修改</span>

						</div>

					</div>
					
					<div class="control-group">

						<label class="control-label">版权信息</label>

						<div class="controls">

							<input type="text" value="<?php echo ($data["copyright"]); ?>" class="span6 m-wrap" name="copyright">

							<span class="help-inline">在网站中申明版权信息，建议填写</span>

						</div>

					</div>
					
					<div class="control-group">

						<label class="control-label">联系人电话<span class="required">*</span></label>

						<div class="controls">

							<input type="text" required value="<?php echo ($data["phone"]); ?>" class="span6 m-wrap" name="phone">

							<span class="help-inline">网站联系人电话</span>

						</div>

					</div>
					
					<div class="control-group">

						<label class="control-label">网站联系地址</label>

						<div class="controls">

							<input type="text" value="<?php echo ($data["address"]); ?>" class="span6 m-wrap" name="address">

							<span class="help-inline">填写该项，有助于网站内容的推广，建议填写</span>

						</div>

					</div>
					
					
					<div class="control-group">
						<script type="text/javascript"  src="/Public/diyUpload/jquery.js"></script>
						<link rel="stylesheet" type="text/css" href="/Public/diyUpload/css/webuploader.css">
						<link rel="stylesheet" type="text/css" href="/Public/diyUpload/css/diyUpload.css">
						<script type="text/javascript" src="/Public/diyUpload/js/webuploader.html5only.min.js"></script>
						<script type="text/javascript" src="/Public/diyUpload/js/diyUpload.js"></script>
						<div class="control-group">
							<label class="control-label">微信二维码</label>
							<input type="hidden" name="path" value="">
							<input type="hidden" name="filename" value="">
							<div class="controls">

								<div id="demo">
									<div id="as" > </div>
								</div>
								<?php if($data['logo'] != ''){ echo '<img width="100" src="'.$data['logo'].'">'; } ?>
								<span class="label label-important">注意:</span>

										<span>

										  如果看不到图片，可能是您的浏览器版本过低，或者换个浏览器试试:)

										</span>

							</div>

						</div>
						<script type="text/javascript">

							/*
							 * 服务器地址,成功返回,失败返回参数格式依照jquery.ajax习惯;
							 * 其他参数同WebUploader
							 */
							$('#as').diyUpload({
								url:'/Tool/Tool/fileupload/path/<?php echo ($filepath); ?>',
								success:function( data ) {
									$('input[name=path]').val(data.path);
									$('input[name=filename]').val(data.filename);
								},
								error:function( err ) {
									console.info( err );
								},
								buttonText : '点击选择文件',
								chunked:true,
								// 分片大小
								chunkSize:512 * 1024,
								//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
								fileNumLimit:1,
								fileSizeLimit:500000 * 1024,
								fileSingleSizeLimit:50000 * 1024,
								accept: {}
							});
						</script>
					<div class="control-group">
						
						<div class="form-actions">

							<input type="submit" class="btn blue" value="提交">

						</div>

					</div>

				</form>

				<!-- END FORM-->  

			</div>

		</div>

		<!-- END PORTLET-->

	</div>

</div>