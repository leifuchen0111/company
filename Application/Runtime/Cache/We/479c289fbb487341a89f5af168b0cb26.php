<?php if (!defined('THINK_PATH')) exit();?><div class="row-fluid">

	<div class="span12">

		<!-- BEGIN PORTLET-->   

		<div class="portlet box blue">

			<div class="portlet-title">

				<div class="caption"><i class="icon-reorder"></i>APK添加</div>

				<div class="tools">

					<a href="javascript:;" class="collapse"></a>

					<a href="#portlet-config" data-toggle="modal" class="config"></a>

					<a href="javascript:;" class="reload"></a>

					<a href="javascript:;" class="remove"></a>

				</div>

			</div>

			<div class="portlet-body form">

				<!-- BEGIN FORM-->

				<form action="/we/apk/apkadd"  class="form-horizontal" method="post" enctype="multipart/form-data">

					<div class="control-group">

						<label class="control-label">APk名称</label>

						<div class="controls">

							<input type="text" placeholder="APk名称 " autofocus class="m-wrap span6"  name="name" value="<?php echo ($apk["name"]); ?>"  />

						</div>

					</div>
					
					<?php if(($html["mode"]) == "detail"): ?><div class="line_grid">
							
							<div class="g_3"><span class="label">大小(MB)<span class="must">*</span></span></div>
							
							<div class="g_9">
								
								<input type="text" placeholder="链接地址" class="m-wrap span6" readonly name="title" value="<?php echo ($apk["size"]); ?>" required />
							
							</div>
						</div>
						
						<div class="line_grid">
							
							<div class="g_3"><span class="label">上传时间<span class="must">*</span></span></div>
							
							<div class="g_9">
								
								<input type="text" placeholder="类型" class="m-wrap span6" readonly name="title" value="<?php echo (date('Y-m-d',$apk["posttime"])); ?>" required />
							
							</div>
						
						</div>
						
						<div class="line_grid">
							
							<div class="g_3"><span class="label">存贮地址<span class="must">*</span></span></div>
							
							<div class="g_9">
								
								<input type="text" placeholder="存储地址" class="m-wrap span6" readonly name="title" value="<?php echo ($apk["url"]); ?>" required />
							
							</div>
						
						</div><?php endif; ?>
					
					<div class="control-group">

						<label class="control-label">分类<span class="required">*</span></label>

						<div class="controls">

							<select name="cat_id" class="m-wrap span6">
								
								<?php if(is_array($cate)): $i = 0; $__LIST__ = $cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["cat_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
															
							</select>
						</div>

					</div>
					
					<div class="control-group">

						<label class="control-label">是否推荐<span class="required">*</span></label>

						<div class="controls">

							<label><input type="radio" value="1" name="isrecom">是</label>
							<label><input type="radio" value="0" name="isrecom">否</label>
						</div>

					</div>
					
					<div class="control-group">

						<label class="control-label">版本号</label>

						<div class="controls">

							<input type="text" placeholder="版本号" class="m-wrap span6"  name="version" value=""  />
						
						</div>

					</div>	
					
					<div class="control-group">

						<label class="control-label">上传文件<span class="required">*</span></label>

						<div class="controls">

							<input type="file" class="m-wrap span6" name="apk" required />
						
						</div>

					</div>

					<script type="text/javascript"  src="/Public/diyUpload/jquery.js"></script>
					<link rel="stylesheet" type="text/css" href="/Public/diyUpload/css/webuploader.css">
					<link rel="stylesheet" type="text/css" href="/Public/diyUpload/css/diyUpload.css">
					<script type="text/javascript" src="/Public/diyUpload/js/webuploader.html5only.min.js"></script>
					<script type="text/javascript" src="/Public/diyUpload/js/diyUpload.js"></script>
					<div class="control-group">
						<label class="control-label">缩略图</label>
						<input type="hidden" name="path" value="">
						<input type="hidden" name="filename" value="">
						<div class="controls">

							<div id="demo">
								<div id="as" > </div>
							</div>
							<?php if($data['qrcode'] != ''){ echo '<img width="100" src="'.$data['img'].'">'; } ?>
							<span class="label label-important">注意:</span>

										<span>

										  建议尺寸：300*200,单位像素(px)，如果看不到图片，可能是您的浏览器版本过低，或者换个浏览器试试:)

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
						<label class="control-label">内容图片</label>
						<input type="hidden" name="cpath" value="">
						<input type="hidden" name="cfilename" value="">
						<div class="controls">

							<div>
								<div id="images" > </div>
							</div>
							<?php if($data['qrcode'] != ''){ echo '<img width="100" src="'.$data['img'].'">'; } ?>
							<span class="label label-important">注意:</span>

										<span>

										  建议尺寸：288*480,单位像素(px)，如果看不到图片，可能是您的浏览器版本过低，或者换个浏览器试试:)

										</span>

						</div>

					</div>
					<script type="text/javascript">

						/*
						 * 服务器地址,成功返回,失败返回参数格式依照jquery.ajax习惯;
						 * 其他参数同WebUploader
						 */
						$('#images').diyUpload({
							url:'/Tool/Tool/fileupload/path/<?php echo ($filepath); ?>',
							success:function( data ) {
								console.log(data)
								var path = $('input[name=cpath]').val() == ''?'':$('input[name=cpath]').val()+','
								var fielname = $('input[name=cfilename]').val() == ''?'':$('input[name=cfilename]').val()+','
								$('input[name=cpath]').val(path+data.path);
								$('input[name=cfilename]').val(fielname+data.filename);
							},
							error:function( err ) {
								console.info( err );
							},
							buttonText : '点击选择文件',
							chunked:true,
							// 分片大小
							chunkSize:512 * 1024,
							//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
							fileNumLimit:5,
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