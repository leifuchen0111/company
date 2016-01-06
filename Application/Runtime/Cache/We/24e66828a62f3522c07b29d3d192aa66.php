<?php if (!defined('THINK_PATH')) exit();?><div class="row-fluid">

	<div class="span12 responsive" data-tablet="span12 fix-offset" data-desktop="span12">

		<!-- BEGIN EXAMPLE TABLE PORTLET-->

		<div class="portlet box grey">

			<div class="portlet-title">

				<div class="caption"><i class="icon-user"></i>商品列表</div>

				<div class="actions">

					<a href="<?php echo U('Product/proAdd');?>?webid=<?php echo ($webHeader["id"]); ?>" class="btn blue"><i class="icon-pencil"></i> 添加商品</a>
					<a href="<?php echo U('Category/catList');?>?webid=<?php echo ($webHeader["id"]); ?>&type=product" class="btn blue"><i class="icon-pencil"></i> 分类列表</a>

					<div class="btn-group">

						<a class="btn green" href="#" data-toggle="dropdown">

						<i class="icon-cogs"></i> 工具

						<i class="icon-angle-down"></i>

						</a>

						<ul class="dropdown-menu pull-right">


							<li id="del" action="<?php echo U('Product/delPro');?>"><a href="javascript:;"><i class="icon-trash"></i> 删除</a></li>
							
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

							<th>商品编号</th>

							<th  class="hidden-480">商品价格</th>

							<th>商品名称</th>
							
							<th>详情</th>

						</tr>

					</thead>

					<tbody>
						<?php if(is_array($product)): $i = 0; $__LIST__ = $product;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ap): $mod = ($i % 2 );++$i;?><tr class="odd gradeX">

							<td><input type="checkbox" class="checkboxes" value="<?php echo ($ap["id"]); ?>" /></td>
							<td><?php echo ($ap["id"]); ?></td>

							<td  class="hidden-480"><?php echo ($ap["price"]); ?></td>

							<td style="max-width:200px;"><?php echo ($ap["title"]); ?></td>

							<td><a href="<?php echo U('Product/editPro',array('id'=>$ap['id'],'webid'=>$webHeader['id']));?>"><i class="icon-pencil"></i> 编辑</a></td>

						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</tbody>

				</table>

			</div>

		</div>

		<!-- END EXAMPLE TABLE PORTLET-->

	</div>
</div>