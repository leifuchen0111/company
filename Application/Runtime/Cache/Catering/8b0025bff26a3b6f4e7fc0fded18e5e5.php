<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->

<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->

<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->

<!-- BEGIN HEAD -->

<head>

	<meta charset="utf-8" />

	<title>路由管理后台</title>

	<meta content="width=device-width, initial-scale=1.0" name="viewport" />

	<meta content="" name="description" />

	<meta content="" name="author" />

	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link href="
	/min/?f=/Public/css/bootstrap.min.css,
	/Public/css/bootstrap-responsive.min.css,
	/Public/css/bootstrap-wysihtml5.min.css,
	/Public/css/font-awesome.min.css,
	/Public/css/style-metro.min.css,
	/Public/css/style.min.css,
	/Public/css/style-responsive.min.css,
	/Public/css/default.min.css,
	/Public/css/uniform.default.min.css,
	/Public/css/select2_metro.min.css,
	/Public/css/DT_bootstrap.min.css
	" rel="stylesheet" type="text/css"/>

	<script src="/Public/js/jquery-1.10.1.min.js" type="text/javascript"></script>

	
</head>

<!-- END HEAD -->

<!-- BEGIN BODY -->

<body class="page-header-fixed">

	<!-- BEGIN HEADER -->

	<div class="header navbar navbar-inverse navbar-fixed-top">

		<!-- BEGIN TOP NAVIGATION BAR -->

		<div class="navbar-inner">

			<div class="container-fluid">

				<!-- BEGIN LOGO -->

				<a class="brand" href="/">

				</a>

				<!-- END LOGO -->

				<!-- BEGIN RESPONSIVE MENU TOGGLER -->

				<a href="javascript:;" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">

				<img src="/Public/image/menu-toggler.png" alt="" />

				</a>          

				<!-- END RESPONSIVE MENU TOGGLER -->            

				<!-- BEGIN TOP NAVIGATION MENU -->              

				<ul class="nav pull-right">

					<li class="dropdown user">

						<button onclick="location='/Home/WebMag/weblist.html?gw_id=<?php echo ($gw_id); ?>'" class="btn blue"><i class="icon-share-alt"></i>&nbsp;&nbsp;返回站点列表</button>

					</li>
					
					<?php if(($_SESSION['userId']) == "1"): ?><li class="dropdown user">

						<button class="btn blue" onclick="location='<?php echo U('Home/Dashboard/postSysnews');?>'"><i class="icon-comment-alt"></i>&nbsp;&nbsp;发布系统消息</button>

					</li><?php endif; ?>
					
					<li class="dropdown user">

						<button onclick="location='/Home/Public/delCache'" class="btn blue"><i class="icon-trash"></i>&nbsp;&nbsp;清除缓存</button>

					</li>
					<li class="dropdown user">

						<button onclick="location='/Home/User/profile'" class="btn blue"><i class="icon-user"></i>&nbsp;&nbsp;个人中心</button>

					</li>
					<li class="dropdown user">

						<button onclick="window.history.go(-1)" class="btn blue"><i class="icon-step-backward"></i>&nbsp;&nbsp;返回</button>

					</li>
					<li class="dropdown user">

						<button onclick="location='<?php echo U('Home/Public/logOut');?>'" class="btn blue"><i class="icon-ban-circle"></i>&nbsp;&nbsp;退出</button>

					</li>

					<!-- END USER LOGIN DROPDOWN -->

				</ul>

				<!-- END TOP NAVIGATION MENU --> 

			</div>

		</div>

		<!-- END TOP NAVIGATION BAR -->

	</div>

	<!-- END HEADER -->

	<!-- BEGIN CONTAINER -->

	<div class="page-container row-fluid">

		<!-- BEGIN SIDEBAR -->

		<div class="page-sidebar nav-collapse collapse">

			<!-- BEGIN SIDEBAR MENU -->        

			<ul class="page-sidebar-menu">

				<li>

					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->

					<div class="sidebar-toggler hidden-phone"></div>

					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->

				</li>

				<li>

				</li>

				<li class="start ">

					<a href="/">

					<i class="icon-home"></i> 

					<span class="title">首页</span>

					</a>

				</li>

				<?php foreach($nav as $k=>$v){ ?>
				<li class="">
					<a href="javascript:;">
					<i class="icon-list"></i>
					<span class="title"><?php echo ($k); ?></span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<?php if(is_array($v)): $i = 0; $__LIST__ = $v;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li >
							<a href="<?php echo U($vo[1],array('gw_id'=>$gw_id,'webid'=>$webid));?>">
								<?php echo ($vo[0]); ?>
							</a>

						</li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</li>
				<?php } ?>
				
			</ul>

			<!-- END SIDEBAR MENU -->

		</div>

		<!-- END SIDEBAR -->

		<!-- BEGIN PAGE -->

		<div class="page-content" >

			<div class="container-fluid">

				<!-- BEGIN PAGE HEADER-->

				<div class="row-fluid">

					<div class="span12">

						<h3 class="page-title">



						</h3>

					</div>

				</div>

				<!-- END PAGE HEADER-->
				

<div class="row-fluid">

	<div class="span12">

		<!-- BEGIN PORTLET-->   

		<div class="portlet box blue">

			<div class="portlet-title">

				<div class="caption"><i class="icon-reorder"></i>新闻添加</div>
				<div class="actions">
					<a href="<?php echo U('News/news',array('gw_id'=>$gw_id,'webid'=>$webid));?>" class="btn red"><i class="icon-long-arrow-left"></i>新闻列表</a>
				</div>
			</div>

			<div class="portlet-body form">

				<!-- BEGIN FORM-->

				<form action="<?php echo U('save');?>" class="form-horizontal" method="post" enctype="multipart/form-data">

					<input type="hidden" name="webid" value="<?php echo ($webid); ?>">
					<input type="hidden" name="id" value="<?php echo ($news["id"]); ?>">

					<div class="control-group">

						<label class="control-label">分类<span class="required">*</span></label>

						<div class="controls">

							<select name="category" required>
								<?php if(is_array($cates)): $i = 0; $__LIST__ = $cates;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" <?php if(($news['category']) == $vo['id']): ?>selected<?php endif; ?> ><?php echo ($vo["category"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select>

						</div>

					</div>

					<div class="control-group">

						<label class="control-label">标题<span class="required">*</span></label>

						<div class="controls">

							<input type="text"  required class="span6 m-wrap" value="<?php echo ($news["title"]); ?>" name="title">

						</div>

					</div>

					<div class="control-group">

						<label class="control-label">作者<span class="required">*</span></label>

						<div class="controls">

							<input type="text"  required class="span6 m-wrap" value="<?php echo ($news["author"]); ?>" name="author">

						</div>

					</div>

					<div class="control-group">

						<label class="control-label">排序</label>

						<div class="controls">

							<input type="text" class="span6 m-wrap" value="<?php echo ($news["displayorder"]); ?>" name="displayorder">

							<span class="help-inline">指定显示的先后顺便，1-999之间的整数</span>

						</div>

					</div>

					<div class="control-group">

						<label class="control-label">描述</label>

						<div class="controls">

							<textarea class="large m-wrap" rows="3" name="desc"><?php echo ($news["desc"]); ?></textarea>

							<span class="help-block">请输入100字以内的描述</span>

						</div>

					</div>

					<div class="control-group">

						<label class="control-label">内容</label>

						<div class="controls">

							<textarea id="editor_id" name="content" style="width:700px;height:300px;">
								<?php echo ($news["content"]); ?>
							</textarea>
							<span class="help-block">如果需要插入外部资源，请将相应的域名设置为白名单</span>
							<script charset="utf-8" src="/Public/kindeditor/kindeditor.js"></script>
							<script charset="utf-8" src="/Public/kindeditor/lang/zh_CN.js"></script>
							<script>
								var options = {
									items:[
											'source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
											'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
											'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
											'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
											'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
											'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 'multiimage',
											 'table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
											'anchor', 'link', 'unlink'
											]

								};

								KindEditor.ready(function(K) {
									window.editor = K.create('#editor_id',options);
								});
							</script>

						</div>

					</div>


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
</div>

<!-- END PAGE CONTAINER-->

</div>

<!-- END PAGE -->

</div>

<!-- END CONTAINER -->

<!-- BEGIN FOOTER -->

<div class="footer">

	<div class="footer-inner">

		<!--2015 &copy; <a href="http://www.sun-net.cn">���ƿƼ�</a> ��������Ȩ.-->

	</div>

	<div class="footer-tools">

			<span class="go-top">

			<i class="icon-angle-up"></i>

			</span>

	</div>

</div>

<!-- END FOOTER -->

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<!-- BEGIN CORE PLUGINS -->



<script src="/min/?f=
/Public/js/jquery-migrate-1.2.1.min.js,
/Public/js/jquery-ui-1.10.1.custom.min.js,
/Public/js/bootstrap.min.js,
/Public/js/jquery.slimscroll.min.js,
/Public/js/jquery.blockui.min.js,
/Public/js/jquery.cookie.min.js,
/Public/js/jquery.uniform.min.js,
/Public/js/route.min.js,
/Public/js/select2.min.js
" type="text/javascript"></script>
<script src="/min/?f=
/Public/js/jquery.dataTables.min.js,
/Public/js/DT_bootstrap.min.js,
/Public/js/ckeditor.min.js
/Public/js/bootstrap-fileupload.min.js,
/Public/js/chosen.jquery.min.js,
/Public/js/wysihtml5-0.3.0.min.js,
/Public/js/bootstrap-wysihtml5.min.js,
/Public/js/jquery.tagsinput.min.js,
/Public/js/jquery.toggle.buttons.min.js,
/Public/js/bootstrap-datepicker.min.js,
/Public/js/bootstrap-datetimepicker.min.js,
/Public/js/clockface.min.js,
/Public/js/date.min.js
" type="text/javascript"></script>
<script src="/min/?f=
/Public/js/daterangepicker.min.js,
/Public/js/bootstrap-colorpicker.min.js,
/Public/js/bootstrap-timepicker.min.js,
/Public/js/jquery.inputmask.bundle.min.js,
/Public/js/jquery.input-ip-address-control-1.0.min.js,
/Public/js/jquery.multi-select.min.js,
/Public/js/bootstrap-modal.min.js,
/Public/js/bootstrap-modalmanager.min.js,
/Public/js/app.min.js,
/Public/js/table-managed.js,
/Public/js/form-components.min.js
" type="text/javascript"></script>
<!--[if lt IE 9]>

<script src="/Public/js/excanvas.min.js"></script>

<script src="/Public/js/respond.min.js"></script>

<![endif]-->
<script>

	jQuery(document).ready(function() {

		App.init();
		FormComponents.init();

	});

</script>
</html>