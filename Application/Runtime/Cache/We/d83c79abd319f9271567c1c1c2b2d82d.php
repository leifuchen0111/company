<?php if (!defined('THINK_PATH')) exit();?><div class="row-fluid">

	<div class="span12">

		<!-- BEGIN PORTLET-->   

		<div class="portlet box blue">

			<div class="portlet-title">

				<div class="caption"><i class="icon-reorder"></i>视频添加</div>

				<div class="tools">

					<a href="javascript:;" class="collapse"></a>

					<a href="#portlet-config" data-toggle="modal" class="config"></a>

					<a href="javascript:;" class="reload"></a>

					<a href="javascript:;" class="remove"></a>

				</div>

			</div>

			<div class="portlet-body form">

				<!-- BEGIN FORM-->

				<form action="/we/vadio/vadioadd"  class="form-horizontal" method="post" enctype="multipart/form-data">

					<div class="control-group">

						<label class="control-label">视频名称</label>

						<div class="controls">

							<input type="text" placeholder="视频名称 " autofocus class="m-wrap span6"  name="name" value="<?php echo ($apk["name"]); ?>" required />

						</div>

					</div>
					
					<div class="control-group">

						<label class="control-label">分类<span class="required">*</span></label>

						<div class="controls">

							<select name="cat_id" class="m-wrap span6">
								
								<?php if(is_array($cate)): $i = 0; $__LIST__ = $cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["cat_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
															
							</select>
						</div>

					</div>
					<div class="control-group">

						<label class="control-label">热度</label>

						<div class="controls">

							<input type="text" placeholder="热度 " autofocus class="m-wrap span6"  name="hot"
								   value="<?php echo ($apk["hot"]); ?>"  />
							<span class="help-block"></span>
						</div>

					</div>
					
					<div class="control-group">

						<label class="control-label">上传视频文件<span class="required">*</span></label>

						<div class="controls">

							<input type="file" class="m-wrap span6" name="video" required />
						
						</div>

					</div>


					<script type="text/javascript"  src="/Public/diyUpload/jquery.js"></script>
					<link rel="stylesheet" type="text/css" href="/Public/diyUpload/css/webuploader.css">
					<link rel="stylesheet" type="text/css" href="/Public/diyUpload/css/diyUpload.css">
					<script type="text/javascript" src="/Public/diyUpload/js/webuploader.html5only.min.js"></script>
					<script type="text/javascript" src="/Public/diyUpload/js/diyUpload.js"></script>
					<div class="control-group">
						<label class="control-label">封面图片</label>
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

						<label class="control-label">简介<span class="required">*</span></label>

						<div class="controls">

							<textarea class="m-wrap span6" id="kindedit" name="desc"><?php echo ($apk["desc"]); ?></textarea>

						</div>

					</div>
					
					<input type="hidden" name="webid" value="<?php echo ($webHeader["id"]); ?>">
					
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