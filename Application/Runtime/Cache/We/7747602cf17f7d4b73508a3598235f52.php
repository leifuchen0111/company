<?php if (!defined('THINK_PATH')) exit();?><div class="row-fluid">

	<div class="span12">

		<!-- BEGIN VALIDATION STATES-->

		<div class="portlet box purple">

			<div class="portlet-title">

				<div class="caption"><i class="icon-reorder"></i><?php if(($cate["cid"]) == ""): ?>添加<?php else: ?>修改<?php endif; ?>分类
				</div>

				<div class="tools">

					<a href="javascript:;" class="collapse"></a>

					<a href="#portlet-config" data-toggle="modal" class="config"></a>

					<a href="javascript:;" class="reload"></a>

					<a href="javascript:;" class="remove"></a>

				</div>

			</div>

			<div class="portlet-body form">

				<!-- BEGIN FORM-->

				<form action="<?php echo U('Category/catSave');?>" method="post" enctype="multipart/form-data" id="form_sample_1"
					  class="form-horizontal" novalidate="novalidate">
					
					<input type="hidden" name="webid" value="<?php echo ($webHeader["id"]); ?>">
					<input type="hidden" name="cid" value="<?php echo ($cate["cid"]); ?>">
					<input type="hidden" name="type" value="<?php echo ($type); ?>">
					
					
					<div class="form-wizard">

						<div class="tab-content">

							<div class="alert alert-error hide">

								<button class="close" data-dismiss="alert"></button>

								信息有误，请检查

							</div>

							<div class="alert alert-success hide">

								<button class="close" data-dismiss="alert"></button>

								信息填写成功

							</div>

							<div class="tab-pane active" id="tab1">

								<h3 class="block">填写分类信息</h3>
								<div class="control-group">

									<label class="control-label">父级分类<span class="required">*</span></label>

									<div class="controls">

										<select name="pid">
											<option value="0">作为一级分类</option>
											<?php if(is_array($cats)): $i = 0; $__LIST__ = $cats;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option <?php if(($vo["cid"]) == $cate['pid']): ?>selected<?php endif; ?>
												value="<?php echo ($vo["cid"]); ?>"><?php echo ($vo["cat_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
										</select>

									</div>

								</div>

								<div class="control-group">

									<label class="control-label">分类名称<span class="required">*</span></label>

									<div class="controls">

										<input type="text" class="span6 m-wrap" value="<?php echo ($cate["cat_name"]); ?>" required
											   placeholder="分类名称"
											   name="cat_name">

									</div>

								</div>
								<?php if(($type) == "app"): ?><div class="control-group">
	
										<label class="control-label">所属分类<span class="required">*</span></label>
	
										<div class="controls">
											<label for="">
											<input type="radio" class="span6 m-wrap" value="game" required name="type">游戏
											</label>
											<label>
											<input type="radio" " class="span6 m-wrap" required value="app" name="type">应用
											</label>
										</div>
	
									</div><?php endif; ?>
								<div class="control-group">

									<label class="control-label">上传封面图片<span class="required">*</span></label>

									<div class="controls">

										<input type="file" class="span6 m-wrap" required name="cover_img">
										<span class="help-inline">建议尺寸，180*110，单位像素(px)</span>
									</div>

								</div>
								<?php if(($cate["url"]) != ""): ?><div class="control-group">

										<label class="control-label">封面图片</label>

										<div class="controls">
											<img src="<?php echo ($cate["url"]); ?>" width="100">
										</div>

									</div><?php endif; ?>

							</div>
					
						</div>

						<div class="form-actions clearfix">
							<input type="submit" value="提交" class="btn blue" />

						</div>

					</div>
		


				</form>

				<!-- END FORM-->

			</div>

		</div>

		<!-- END VALIDATION STATES-->

	</div>

</div>