<?php if (!defined('THINK_PATH')) exit();?><div class="row-fluid">

	<div class="span12">

		<!-- BEGIN PORTLET-->   

		<div class="portlet box blue">

			<div class="portlet-title">

				<div class="caption"><i class="icon-reorder"></i>广告添加</div>

				<div class="tools">

					<a href="javascript:;" class="collapse"></a>

					<a href="#portlet-config" data-toggle="modal" class="config"></a>

					<a href="javascript:;" class="reload"></a>

					<a href="javascript:;" class="remove"></a>

				</div>

			</div>

			<div class="portlet-body form">

				<!-- BEGIN FORM-->

				<form action="/we/ads/adsadd" class="form-horizontal" method="post" enctype="multipart/form-data">

					<input type="hidden" name="webid" value="<?php echo ($webHeader["id"]); ?>">
					<div class="control-group">

						<label class="control-label">链接地址</label>

						<div class="controls">

							<input type="text"  class="span6 m-wrap" name="url">

							<span class="help-inline">用于点击跳转的地址</span>

						</div>

					</div>
					
					<div class="control-group">

						<label class="control-label">排序<span class="required">*</span></label>

						<div class="controls">

							<input type="text"  required class="span6 m-wrap" name="displayorder">

							<span class="help-inline">指定显示的先后顺便，1-999之间的整数</span>

						</div>

					</div>
					<div class="control-group">

						<label class="control-label">标题</label>

						<div class="controls">

							<input type="text"  required class="span6 m-wrap" name="title">

							<span class="help-inline">用于识别不同的广告</span>

						</div>

					</div>
					<div class="control-group">

						<label class="control-label">广告位</label>

						<div class="controls">

							<select name="position">
								<option value="0">广告位1</option>
								<option value="1">广告位2</option>
								<option value="2">广告位3</option>
								<option value="3">广告位4</option>
								<option value="4">广告位5</option>
								<option value="5">广告位6</option>
								</select>

							<span class="help-inline">广告展示位置</span>

						</div>

					</div>

					<script type="text/javascript"  src="/Public/diyUpload/jquery.js"></script>
					<link rel="stylesheet" type="text/css" href="/Public/diyUpload/css/webuploader.css">
					<link rel="stylesheet" type="text/css" href="/Public/diyUpload/css/diyUpload.css">
					<script type="text/javascript" src="/Public/diyUpload/js/webuploader.html5only.min.js"></script>
					<script type="text/javascript" src="/Public/diyUpload/js/diyUpload.js"></script>
					<div class="control-group">
						<label class="control-label">广告图片</label>
						<input type="hidden" name="path" value="">
						<input type="hidden" name="filename" value="">
						<div class="controls">

							<div id="demo">
								<div id="as" > </div>
							</div>
							<?php if($data['qrcode'] != ''){ echo '<img width="100" src="'.$data['img'].'">'; } ?>
							<span class="label label-important">注意:</span>

										<span>

										  建议尺寸：300*300,单位像素(px)，如果看不到图片，可能是您的浏览器版本过低，或者换个浏览器试试:)

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