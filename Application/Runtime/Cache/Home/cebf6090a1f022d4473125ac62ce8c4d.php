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

	<link href="
	/min/?f=/Public/css/bootstrap.min.css,
	/Public/css/bootstrap-responsive.min.css,
	/Public/css/font-awesome.min.css,
	/Public/css/style-metro.min.css,
	/Public/css/style.min.css,
	/Public/css/style-responsive.min.css,
	/Public/css/default.min.css,
	/Public/css/uniform.default.min.css,
	/Public/css/select2_metro.min.css,
	/Public/css/DT_bootstrap.min.css,
	/Public/css/bootstrap-toggle-buttons.min.css
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

				<!--<img src="/Public/image/logo.png" alt="logo" />-->
				&nbsp;路由器管理后台

				</a>

				<!-- END LOGO -->

				<!-- BEGIN RESPONSIVE MENU TOGGLER -->

				<a href="javascript:;" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">

				<img src="/Public/image/menu-toggler.png" alt="" />

				</a>          

				<!-- END RESPONSIVE MENU TOGGLER -->            

				<!-- BEGIN TOP NAVIGATION MENU -->              

				<ul class="nav pull-right">

					<?php if(($_SESSION['userId']) != "1"): ?><li class="dropdown user">

						<button onclick="location='<?php echo U('Tool/Api/download');?>?name=readme.doc'" class="btn blue"><i class="icon-file"></i>&nbsp;&nbsp;下载使用文档</button>

					</li>
					<?php else: ?>
					<li class="dropdown user">

						<button class="btn blue" onclick="location='<?php echo U('Home/Dashboard/postSysnews');?>'"><i
								class="icon-comment-alt"></i>&nbsp;&nbsp;发布系统消息</button>

					</li>
					<li class="dropdown user">

						<button class="btn blue" onclick="location='<?php echo U('Mmclick/Index/add');?>'"><i
								class=""></i>&nbsp;&nbsp;MMclick图片</button>

					</li><?php endif; ?>
					 <li class="dropdown user">

						<button onclick="location='<?php echo U('Home/Public/delCache');?>'" class="btn blue"><i
								class="icon-trash"></i>&nbsp;&nbsp;清除缓存</button>

					</li>
					<li class="dropdown user">

						<button onclick="location='<?php echo U('Home/User/profile');?>'" class="btn blue"><i
								class="icon-user"></i>&nbsp;&nbsp;个人中心</button>

					</li>
					<li class="dropdown user">

						<button class="btn blue" onclick="window.history.go(-1)"><i class="icon-step-backward"></i>&nbsp;&nbsp;返回</button>

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

				<li class="start ">

					<a href="/">

					<i class="icon-home"></i> 

					<span class="title">首页</span>

					</a>

				</li>

				
				<li class="<?php if((MODULE_NAME) == "ApMain"): ?>open<?php endif; ?>">
					<a href="javascript:;">
					<i class="icon-list"></i>
					<span class="title">路由信息</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu"<?php if((MODULE_NAME) == "ApMain"): ?>style="display:block;"<?php endif; ?>>
						<li >
							<a href="<?php echo U('ApMain/detail');?>?gw_id=<?php echo ($apInfo["gw_id"]); ?>&id=<?php echo ($apInfo["id"]); ?>">
								基本/实时信息
							</a>

						</li>
					</ul>
				</li>
				
				<li class="<?php if((MODULE_NAME) == "Apconf"): ?>open<?php endif; ?>">
					<a href="javascript:;">
					<i class="icon-list"></i>
					<span class="title">配置项</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu" <?php if((MODULE_NAME) == "Apconf"): ?>style="display:block;"<?php endif; ?>>
						<li >
							<a href="<?php echo U('Apconf/baseConf');?>?gw_id=<?php echo ($apInfo["gw_id"]); ?>&id=<?php echo ($apInfo["id"]); ?>">
								基本配置
							</a>

						</li>
						<li >
							<a href="<?php echo U('Ssid/ssidList');?>?gw_id=<?php echo ($apInfo["gw_id"]); ?>&id=<?php echo ($apInfo["id"]); ?>">
								SSID 列表
							</a>

						</li>
						<li >
							<a href="<?php echo U('Ssid/ssidAdd');?>?gw_id=<?php echo ($apInfo["gw_id"]); ?>&id=<?php echo ($apInfo["id"]); ?>">
								添加SSID
							</a>

						</li>
					</ul>
				</li>
				
				<li class="<?php if((MODULE_NAME) == "Mac"): ?>open<?php endif; ?>">
					<a href="javascript:;">
					<i class="icon-list"></i>
					<span class="title">上网用户管理</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu" <?php if((MODULE_NAME) == "Mac"): ?>style="display:block;"<?php endif; ?>>
						<!--<li >
							<a href="<?php echo U('Mac/macWhite');?>?gw_id=<?php echo ($apInfo["gw_id"]); ?>&id=<?php echo ($apInfo["id"]); ?>">
								用户白名单
							</a>

						</li>-->
						<!--<li >
							<a href="<?php echo U('Mac/macScan');?>?gw_id=<?php echo ($apInfo["gw_id"]); ?>&id=<?php echo ($apInfo["id"]); ?>">
								人流统计
							</a>

						</li>-->
						<li >
							<a href="<?php echo U('Mac/macOnline');?>?gw_id=<?php echo ($apInfo["gw_id"]); ?>&id=<?php echo ($apInfo["id"]); ?>">
								在线用户
							</a>

						</li>
						<!--<li >
							<a href="<?php echo U('Mac/macHistory');?>?gw_id=<?php echo ($apInfo["gw_id"]); ?>&id=<?php echo ($apInfo["id"]); ?>">
								历史用户
							</a>

						</li>-->
					</ul>
				</li>
				
				<li class=" <?php if((MODULE_NAME) == "Url"): ?>open<?php endif; ?>">
					<a href="javascript:;">
					<i class="icon-list"></i>
					<span class="title">URL管理</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu" <?php if((MODULE_NAME) == "Url"): ?>style="display:block;"<?php endif; ?>>
						<li >
							<a href="<?php echo U('Url/urlWhite');?>?gw_id=<?php echo ($apInfo["gw_id"]); ?>&id=<?php echo ($apInfo["id"]); ?>">
								URL白名单
							</a>

						</li>
						<!--<li >
							<a href="<?php echo U('Url/urlHistory');?>?gw_id=<?php echo ($apInfo["gw_id"]); ?>&id=<?php echo ($apInfo["id"]); ?>">
								访问记录
							</a>

						</li>-->
					</ul>
				</li>
				<li class="<?php if((MODULE_NAME) == "WebMag"): ?>open<?php endif; ?>">
					<a href="javascript:;">
					<i class="icon-list"></i>
					<span class="title">自媒体</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu" <?php if((MODULE_NAME) == "WebMag"): ?>style="display:block;"<?php endif; ?>>
						<li >
							<a href="<?php echo U('WebMag/weblist');?>?gw_id=<?php echo ($apInfo["gw_id"]); ?>&id=<?php echo ($apInfo["id"]); ?>">
								站点列表
							</a>

						</li>
						<li >
							<a href="<?php echo U('WebMag/webAdd');?>?gw_id=<?php echo ($apInfo["gw_id"]); ?>&id=<?php echo ($apInfo["id"]); ?>">
								新建站点
							</a>

						</li>
						<li >
							<a href="<?php echo U('WebMag/webUpload');?>?gw_id=<?php echo ($apInfo["gw_id"]); ?>&id=<?php echo ($apInfo["id"]); ?>">
								上传自定义模板
							</a>
						</li>
					</ul>
				</li>
			</ul>

			<!-- END SIDEBAR MENU -->

		</div>

		<!-- END SIDEBAR -->

		<!-- BEGIN PAGE -->

		<div class="page-content" >

			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->

			<div id="portlet-config" class="modal hide" style="display:none;box-shadow:0 0 0 2000px rgba(0,0,0,0.5);">

				<div class="modal-header">

					<button data-dismiss="modal" class="close" type="button"></button>

					<h3></h3>

				</div>

				<div class="modal-body">

					<p></p>

				</div>

			</div>

			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->

			<!-- BEGIN PAGE CONTAINER-->        

			<div class="container-fluid">

				<!-- BEGIN PAGE HEADER-->

				<div class="row-fluid">

					<div class="span12">

						<!-- BEGIN STYLE CUSTOMIZER -->

						<div class="color-panel hidden-phone">

							<div class="color-mode-icons icon-color"></div>

							<div class="color-mode-icons icon-color-close"></div>

							<div class="color-mode">

								<p>主题颜色</p>

								<ul class="inline">

									<li class="color-black current color-default" data-style="default"></li>

									<li class="color-blue" data-style="blue"></li>

									<li class="color-brown" data-style="brown"></li>

									<li class="color-purple" data-style="purple"></li>

									<li class="color-grey" data-style="grey"></li>

									<li class="color-white color-light" data-style="light"></li>

								</ul>

								<label>

									<span>布局</span>

									<select class="layout-option m-wrap small">

										<option value="fluid" selected>流体布局</option>

										<option value="boxed">盒子布局</option>

									</select>

								</label>

								<label>

									<span>头部</span>

									<select class="header-option m-wrap small">

										<option value="fixed" selected>流体布局</option>

										<option value="default">默认</option>

									</select>

								</label>

								<label>

									<span>侧栏</span>

									<select class="sidebar-option m-wrap small">

										<option value="fixed">流体布局</option>

										<option value="default" selected>默认</option>

									</select>

								</label>

								<label>

									<span>底部</span>

									<select class="footer-option m-wrap small">

										<option value="fixed">流体布局</option>

										<option value="default" selected>默认</option>

									</select>

								</label>

							</div>

						</div>

						<!-- END BEGIN STYLE CUSTOMIZER -->  

						<!-- BEGIN PAGE TITLE & BREADCRUMB-->

						<h3 class="page-title">

							

						</h3>

						<ul class="breadcrumb">

 							 <li>

								<i class="icon-home"></i>

								<a href="/">首页</a>

								<i class="icon-angle-right"></i>

							</li>
							<li>

								<a href="<?php echo U('ApMain/aplist');?>">AP列表</a>

								<i class="icon-angle-right"></i>

							</li>

							<li><a href="javascript:;"><?php echo ($apInfo["hwserial"]); ?></a></li>

						</ul>

					</div>

				</div>
<div id="dashboard">
<div class="row-fluid">
		
		<div onclick="location='<?php echo U('ApMain/apList');?>'" class="span2 responsive" data-tablet="span2" data-desktop="span2">
			
			<div   class="dashboard-stat yellow">

				<div class="visual">

					<i class="icon-reorder"></i>

				</div>

				<div class="details">

					<div class="number">

						路由列表

					</div>

				</div>

			</div>

		</div>
		
		<div
				onclick="location='<?php echo U('ApMain/detail',array('gw_id'=>$apInfo['gw_id'],'id'=>$apInfo['id']));?>'"
			 class="span2 responsive" data-tablet="span2" data-desktop="span2">
			
			<div   class="dashboard-stat blue">

				<div class="visual">

					<i class="icon-hdd"></i>

				</div>

				<div class="details">

					<div class="number">

						运行状态

					</div>

					

				</div>

			</div>

		</div>
		
				<div
						onclick="location='<?php echo U('Apconf/baseConf',array('gw_id'=>$apInfo['gw_id'],'id'=>$apInfo['id']));?>'" class="span2 responsive" data-tablet="span2" data-desktop="span2">
			
			<div   class="dashboard-stat green">

				<div class="visual">

					<i class="icon-wrench"></i>

				</div>

				<div class="details">

					<div class="number">

						参数设置

					</div>

					

				</div>

			</div>

		</div>

		<div onclick="location='<?php echo U('Mac/macOnline',array('gw_id'=>$apInfo['gw_id'],'id'=>$apInfo['id']));?>'"
			 class="span2 responsive" data-tablet="span2" data-desktop="span2">

			<div class="dashboard-stat green">

				<div class="visual">

					<i class="icon-user"></i>

				</div>

				<div class="details">

					<div class="number">在线用户</div>

				</div>

			</div>

		</div>

		<div onclick="location='<?php echo U('Ssid/ssidList',array('gw_id'=>$apInfo['gw_id'],'id'=>$apInfo['id']));?>'"
			 class="span2 responsive" data-tablet="span2  fix-offset" data-desktop="span2">

			<div class="dashboard-stat blue">

				<div class="visual">

					<i class="icon-rss"></i>

				</div>

				<div class="details">

					<div class="number">热点管理</div>

				</div>
				
			</div>

		</div>

		<div onclick="location='<?php echo U('WebMag/weblist',array('gw_id'=>$apInfo['gw_id'],'id'=>$apInfo['id']));?>'"
			 class="span2 responsive" data-tablet="span2" data-desktop="span2">

			<div class="dashboard-stat yellow">

				<div class="visual">

					<i class="icon-th"></i>

				</div>

				<div class="details">

					<div class="number">媒体管理</div>

				</div>

			</div>

		</div>

	</div>

</div>
<div class="tab-pane active">

	<div class="portlet box blue">

		<div class="portlet-title">

			<div class="caption"><i class="icon-reorder"></i>基本信息</div>
		</div>

		<div class="portlet-body form">

			<!-- BEGIN FORM-->

			<div class="form-horizontal form-view">

				<div class="row-fluid">

					<div class="span6 ">

						<div class="control-group">

							<label class="control-label">固件版本:</label>

							<div class="controls">

								<span class="text"><?php echo ($data["apDetail"]["fw"]); ?></span>

							</div>

						</div>

					</div>
					<div class="span6 ">

						<div class="control-group">

							<label class="control-label">Wan链接方式:</label>

							<div class="controls">

								<span class="text"><?php echo ($data["apnow"]["wantype"]); ?></span>

							</div>

						</div>

					</div>

				</div>

				<!--/row-->

				<div class="row-fluid">

					<div class="span6 ">

						<div class="control-group">

							<label class="control-label">MAC地址:</label>

							<div class="controls">

								<span class="text"><?php echo ($data["apDetail"]["gw_id"]); ?></span>

							</div>

						</div>

					</div>

					<!--/span-->

					<div class="span6 ">

						<div class="control-group">

							<label class="control-label">硬件序列:</label>

							<div class="controls">

								<span class="text bold"><?php echo ($data["apDetail"]["hwserial"]); ?></span>

							</div>

						</div>

					</div>

					<!--/span-->

				</div>

				<!--/row-->        

				<div class="row-fluid">

					<div class="span6 ">

						<div class="control-group">

							<label class="control-label">存贮情况:</label>

							<div class="controls">

								<span class="text bold"><?php if(($data["apDetail"]["devsize"]) == ""): ?><label>0/0</label><?php else: echo ($data["apDetail"]["devsize"]); endif; ?></span>

							</div>

						</div>

					</div>

					<!--/span-->

					<div class="span6 ">

						<div class="control-group">

							<label class="control-label">注册时间:</label>

							<div class="controls">                                                

								<span class="text bold"><?php echo (date("Y-m-d",$data["apDetail"]["create_time"])); ?></span>

							</div>

						</div>

					</div>

					<!--/span-->

				</div>
				<div class="row-fluid">

					<div class="span12 ">

						<div class="control-group">

							<label class="control-label">备注</label>

							<div class="controls">

								<span class="help-inline"><?php echo ($data["apConf"]["mark"]); ?></span>

							</div>

						</div>

					</div>

				</div>
			</div>

			<!-- END FORM-->  

		</div>

	</div>

</div>
<div class="tab-pane active">

	<div class="portlet box blue">

		<div class="portlet-title">

			<div class="caption"><i class="icon-reorder"></i>实时信息</div>
		</div>

		<div class="portlet-body form">

			<!-- BEGIN FORM-->

			<div class="form-horizontal form-view">

				<div class="row-fluid">

					<div class="span6 ">

						<div class="control-group">

							<label class="control-label">状态:</label>

							<div class="controls">

								<span class="text">
									<?php if(time()-$data['apnow']['lasttime']<200){ ?>
										<label class="label label-success">运行中..</label>
									<?php }else{ ?>
										<label class="label label-important">异常</label>
									<?php } ?>

								</span>

							</div>

						</div>

					</div>

					<!--/span-->

					<div class="span6 ">

						<div class="control-group">

							<label class="control-label">连接用户数:</label>

							<div class="controls">

								<span class="text"><?php echo ($data["apnow"]["onUser"]); ?></span>

							</div>

						</div>

					</div>

					<!--/span-->

				</div>

				<!--/row-->

				<div class="row-fluid">

					<div class="span6 ">
						
						<div class="control-group">

							<label class="control-label">运行时间:</label>

							<div class="controls">

								<span class="text"><?php echo (str_time($data["apnow"]["ltime"])); ?></span>

							</div>

						</div>

					</div>

					<!--/span-->
					<div class="span6 ">

						<div class="control-group">

							<label class="control-label">认证用户数:</label>

							<div class="controls">                                                

								<span class="text bold"><?php echo ($data["current"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo U('Mac/macOnline');?>?gw_id=<?php echo ($apInfo["gw_id"]); ?>&id=<?php echo ($apInfo["id"]); ?>">查看</a></span>

							</div>

						</div>

					</div>
					<!--/span-->

				</div>

				<!--/row-->        

				<div class="row-fluid">

					<div class="span6 ">

						<div class="control-group">

							<label class="control-label">CPU占用:</label>

							<div class="controls">

								<span class="text bold"><?php echo (float_to_percent($data["apnow"]["cpu"])); ?></span>

							</div>

						</div>

					</div>

					<!--/span-->

					<div class="span6 ">

						<div class="control-group">

							<label class="control-label">内存占用:</label>

							<div class="controls">                                                

								<span class="text bold"><?php echo (float_to_percent($data["apnow"]["free"])); ?></span>

							</div>

						</div>

					</div>

					<!--/span-->

				</div>
			</div>

			<!-- END FORM-->  

		</div>

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

		TableManaged.init();

		FormComponents.init();



	});

</script>
</html>