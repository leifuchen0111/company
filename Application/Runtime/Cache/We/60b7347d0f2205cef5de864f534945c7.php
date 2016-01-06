<?php if (!defined('THINK_PATH')) exit();?><div class="row-fluid">

	<div class="span12 responsive" data-tablet="span12 fix-offset" data-desktop="span12">

		<!-- BEGIN EXAMPLE TABLE PORTLET-->

		<div class="portlet box grey">

			<div class="portlet-title">

				<div class="caption"><i class="icon-user"></i>视频列表</div>

				<div class="actions">
					<a href="<?php echo U('Category/catList');?>?webid=<?php echo ($webHeader["id"]); ?>&type=video" class="btn blue"><i
							class="icon-pencil"></i> 分类列表</a>

					<a href="<?php echo U('Vadio/vadioAdd');?>?webid=<?php echo ($webHeader["id"]); ?>" class="btn blue"><i class="icon-plus"></i> 添加</a>

					<div class="btn-group">

						<a class="btn green" href="#" data-toggle="dropdown">

						<i class="icon-cogs"></i> 工具

						<i class="icon-angle-down"></i>

						</a>

						<ul class="dropdown-menu pull-right">

						<!-- 	<li id="edit" action="<?php echo U('Nac/navEdit');?>"><a href="<?php echo U('Nac/navEdit');?>"><i class="icon-pencil"></i> 编辑</a></li> -->

							<li id="del" action="<?php echo U('Vadio/vadioDel');?>"><a href="javascript:;"><i class="icon-trash"></i> 删除</a></li>
							
							<li class="divider"></li>

						</ul>

					</div>

				</div>

			</div>

			<div class="portlet-body">

				<table class="table table-striped table-bordered table-hover" id="sample_2">

					<thead>

						<tr>

							<th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes" /></th>

							<th>ID</th>

							<th>视频名称</th>
							
							<th>类型</th>

							<th  class="hidden-480">简介</th>
							
							<th>播放次数</th>

						</tr>

					</thead>

					<tbody>
						
						<?php if(is_array($vadio)): $i = 0; $__LIST__ = $vadio;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr class="odd gradeX">

							<td><input type="checkbox" class="checkboxes" value="<?php echo ($v["id"]); ?>" /></td>
							<td><?php echo ($v["id"]); ?></td>

							<td><?php echo ($v["name"]); ?></td>
							
							<td><?php echo ($v["cat_name"]); ?></td>

							<td class="hidden-480"><?php echo ($v["desc"]); ?></td>

							<td><?php echo ($v["playcount"]); ?></td>

						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</tbody>

				</table>

			</div>

		</div>

		<!-- END EXAMPLE TABLE PORTLET-->

	</div>
</div>