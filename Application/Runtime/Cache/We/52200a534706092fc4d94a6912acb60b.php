<?php if (!defined('THINK_PATH')) exit();?><div class="row-fluid">

	<div class="span12 responsive" data-tablet="span12 fix-offset" data-desktop="span12">

		<!-- BEGIN EXAMPLE TABLE PORTLET-->

		<div class="portlet box grey">

			<div class="portlet-title">

				<div class="caption"><i class="icon-user"></i>广告列表</div>

				<div class="actions">

					<a href="<?php echo U('Ads/adsAdd');?>?webid=<?php echo ($webHeader["id"]); ?>" class="btn blue"><i class="icon-pencil"></i> 添加</a>

					<div class="btn-group">

						<a class="btn green" href="#" data-toggle="dropdown">

						<i class="icon-cogs"></i> 工具

						<i class="icon-angle-down"></i>

						</a>

						<ul class="dropdown-menu pull-right">

						<!-- 	<li id="edit" action="<?php echo U('Nac/navEdit');?>"><a href="<?php echo U('Nac/navEdit');?>"><i class="icon-pencil"></i> 编辑</a></li> -->

							<li id="del" action="<?php echo U('Ads/adsDel');?>"><a href="javascript:;"><i class="icon-trash"></i> 删除</a></li>
							
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

							<th  class="hidden-480">图片标题</th>

							<th>链接地址</th>
							
							<th>排序</th>

						</tr>

					</thead>

					<tbody>
						
						<?php if(is_array($img)): $i = 0; $__LIST__ = $img;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ap): $mod = ($i % 2 );++$i;?><tr class="odd gradeX">

							<td><input type="checkbox" class="checkboxes" value="<?php echo ($ap["id"]); ?>" /></td>
							<td><?php echo ($ap["id"]); ?></td>

							<td  class="hidden-480"><?php echo ($ap["title"]); ?></td>

							<td style="max-width:200px;"><?php echo ($ap["url"]); ?></td>

							<td><?php echo ($ap["displayorder"]); ?></td>

						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</tbody>

				</table>

			</div>

		</div>

		<!-- END EXAMPLE TABLE PORTLET-->

	</div>
</div>