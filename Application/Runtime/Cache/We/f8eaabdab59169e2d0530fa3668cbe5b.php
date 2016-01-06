<?php if (!defined('THINK_PATH')) exit();?><div class="row-fluid">

	<div class="span12">

		<!-- BEGIN PORTLET-->   

		<div class="portlet box blue">

			<div class="portlet-title">

				<div class="caption"><i class="icon-reorder"></i><?php if(($$pro['id']) == ""): ?>商品添加<?php else: ?> 商品编辑<?php endif; ?></div>

				<div class="tools">

					<a href="javascript:;" class="collapse"></a>

					<a href="#portlet-config" data-toggle="modal" class="config"></a>

					<a href="javascript:;" class="reload"></a>

					<a href="javascript:;" class="remove"></a>

				</div>

			</div>

			<div class="portlet-body form">

				<!-- BEGIN FORM-->

				<form action="/we/product/editpro" class="form-horizontal" method="post" enctype="multipart/form-data">

					<input type="hidden" name="web_id" value="<?php echo ($webHeader["id"]); ?>">
					<input type="hidden" name="id" value="<?php echo ($pro["id"]); ?>">
					<div class="control-group">

						<label class="control-label">所属分类<span class="required">(可选)</span></label>

						<div class="controls">
					
							<select name="cat_id">
								<?php if(is_array($cates)): $i = 0; $__LIST__ = $cates;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><option value="<?php echo ($item["id"]); ?>" <?php if($item['id']==$pro['cat_id']) echo 'selected'; ?>><?php echo ($item["cat_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
							<span class="help-inline">请选择商品所属分类</span>

						</div>

					</div>

					<div class="control-group">

						<label class="control-label">商品名称<span class="required">*</span></label>

						<div class="controls">

							<input type="text" required class="span6 m-wrap" name="title" value="<?php echo ($pro["title"]); ?>">

							<span class="help-inline">30个字以内</span>

						</div>

					</div>

					<div class="control-group">

						<label class="control-label">价格<span class="required">*</span></label>

						<div class="controls">

							<input type="text"  required class="span6 m-wrap" value="<?php echo ($pro["price"]); ?>" name="price">

							<span class="help-inline">商品价格，单位(元)</span>

						</div>

					</div>
					<div class="control-group">

						<label class="control-label">菜品介绍</label>

						<div class="controls">

							<textarea name="desc" id="" cols="30" rows="10"><?php echo ($pro["desc"]); ?></textarea>

							<span class="help-inline">简单的菜品介绍</span>

						</div>

					</div>

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
							<?php if($pro['main_img'] != ''){ echo '<img width="100" src="'.str_replace('//','/',$pro['main_img']).'">'; } ?>
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