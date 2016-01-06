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

						<button class="btn blue" onclick="location='<?php echo U('Dashboard/postSysnews');?>'"><i class="icon-comment-alt"></i>&nbsp;&nbsp;发布系统消息</button>

					</li><?php endif; ?>
					 <li class="dropdown user">

						<button onclick="location='<?php echo U('Public/delCache');?>'" class="btn blue"><i class="icon-trash"></i>&nbsp;&nbsp;清除缓存</button>

					</li>
					<li class="dropdown user">

						<button onclick="location='<?php echo U('User/profile');?>'" class="btn blue"><i class="icon-user"></i>&nbsp;&nbsp;个人中心</button>

					</li>
					<li class="dropdown user">

						<button class="btn blue" onclick="window.history.go(-1)"><i class="icon-step-backward"></i>&nbsp;&nbsp;返回</button>

					</li>
					<li class="dropdown user">

						<button onclick="location='<?php echo U('Public/logOut');?>'" class="btn blue"><i class="icon-ban-circle"></i>&nbsp;&nbsp;退出</button>

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
					<i class="icon-cogs"></i> 
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
					<i class="icon-cogs"></i> 
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
					<i class="icon-cogs"></i> 
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
					<i class="icon-cogs"></i> 
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
					<i class="icon-cogs"></i> 
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
<div class="row-fluid">

	<div class="span12">

		<div class="portlet box blue" id="form_wizard_1">

			<div class="portlet-title">

				<div class="caption">

					<i class="icon-reorder"></i> 自助建站<span class="step-title"> 3-1</span>

				</div>

				<div class="tools hidden-phone">

					<a href="javascript:;" class="collapse"></a>

					<a href="#portlet-config" data-toggle="modal" class="config"></a>

					<a href="javascript:;" class="reload"></a>

					<a href="javascript:;" class="remove"></a>

				</div>

			</div>

			<div class="portlet-body form">

				<form action="<?php echo U('Webbuild/webAdd');?>" method="post" enctype="multipart/form-data" class="form-horizontal" id="submit_form" novalidate="novalidate">

					<input type="hidden" name="gw_id" value="<?php echo ($apInfo["gw_id"]); ?>">

					<input type="hidden" name="rid" value="<?php echo ($route["id"]); ?>">

					<div class="form-wizard">

						<div class="navbar steps">

							<div class="navbar-inner">

								<ul class="row-fluid nav nav-pills">

									<li class="span6 active">

										<a href="#tab3" data-toggle="tab" class="step active">

										<span class="number">1</span>

										<span class="desc"><i class="icon-ok"></i> 选择模板</span>

										</a>

									</li>

									<li class="span6">

										<a href="#tab4" data-toggle="tab" class="step">

										<span class="number">2</span>

										<span class="desc"><i class="icon-ok"></i>选择热点</span>

										</a>

									</li>

								</ul>

							</div>

						</div>

						<div id="bar" class="progress progress-success progress-striped">

							<div class="bar" style="width: 25%;"></div>

						</div>

						<div class="tab-content">

							<div class="alert alert-error hide">

								<button class="close" data-dismiss="alert"></button>

								信息填写错误，请检查

							</div>

							<div class="alert alert-success hide">

								<button class="close" data-dismiss="alert"></button>

								恭喜您，信息填写正切

							</div>

							<div class="" id="tab3">

								<h3 class="block">请选择具体模板</h3>

							 	<?php if(is_array($tpl)): $i = 0; $__LIST__ = $tpl;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$value): $mod = ($i % 2 );++$i;?><div class="row-fluid">

								<?php if(is_array($value)): $k = 0; $__LIST__ = $value;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($k % 2 );++$k;?><div class="span3 button-next" onclick="choiceTpl($(this))">

										<div class="item">

											<a class="fancybox-button"  data-rel="fancybox-button"  title="<?php echo ($item["tpl_name"]); ?>" href="javascript:;">

												<div class="zoom">

													<img src="<?php echo ($item["screenshot"]); ?>" class="selecttpl" alt="<?php echo ($item["tpl_name"]); ?>" title="<?php echo ($item["tpl_name"]); ?>">

													<div class="zoom-icon"></div>

												</div>

											</a>

											<div class="details">
												<label class="radio">
												 <input type="radio" name="tpl_name" value="<?php echo ($item["tpl_name"]); ?>" /><?php echo ($item["tpl_name"]); ?>
												</label>
												<label>
													<span class="help-block"><?php echo ($item["intro"]); ?></span>
												</label>
											</div>


										</div>

									</div><?php endforeach; endif; else: echo "" ;endif; ?>

								</div>

								<div class="space10"></div><?php endforeach; endif; else: echo "" ;endif; ?>



							</div>

							<script>
								var choiceTpl = function(e){
									e.children().find("input").attr('checked',true);
									e.children().find("span").addClass('checked');
								}
							</script>

							<div class="tab-pane" id="tab4">

								<div class="control-group">

									<label class="control-label">对应热点</label>

									<div class="controls">

											<input type="checkbox"  name="selectAll"  data-set="#sample_1 .checkboxes" >全选<br/>

											<?php if(is_array($ssid)): $i = 0; $__LIST__ = $ssid;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><span class="span6"><input  type="checkbox" class="myChecked" name="ssid[]" value="<?php echo ($item["ssid"]); ?>_<?php echo ($item["gw_id"]); ?>"><?php echo ($item["gw_id"]); ?>-<?php echo ($item["ssid"]); ?> (<?php echo ($item["channel"]); ?>)</span>
											<!-- 	<option value="<?php echo ($item["ssid"]); ?>"><?php echo ($item["ssid"]); ?> (<?php echo ($item["channel"]); ?>)</option>
											 --><?php endforeach; endif; else: echo "" ;endif; ?>

										<span class="help-inline">选择应用SSID(多选)</span>

									</div>

								</div>

							</div>
							<script>
								$(document).ready(function(){

									$("input[name='selectAll']").click(function(){

										if($(this).prop('checked')){

											$("div.checker span").addClass('checked')
											$("div.checker span input").prop('checked',true)
										}

									})

								})
							</script>

						</div>

						<div class="form-actions clearfix">

							<a href="javascript:;" class="btn button-previous" style="display: none;">

							<i class="m-icon-swapleft"></i> 上一步

							</a>

							<a href="javascript:;" class="btn blue button-next">

							下一步 <i class="m-icon-swapright m-icon-white"></i>

							</a>

							<a href="javascript:;" class="btn green button-submit" style="display: none;">

							提交 <i class="m-icon-swapright m-icon-white"></i>

							</a>

						</div>

					</div>

				</form>

			</div>

		</div>

	</div>

</div>

				<!-- END PAGE CONTENT-->         

</div>
<script src="/min/?f=
	/Public/js/jquery-1.10.1.min.js,
	/Public/js/jquery-ui-1.10.1.custom.min.js,
	/Public/js/bootstrap.min.js,
	/Public/js/jquery.slimscroll.min.js,
	/Public/js/jquery.blockui.min.js,
	/Public/js/jquery.cookie.min.js,
	/Public/js/jquery.uniform.min.js,
	/Public/js/jquery.validate.min.js,
	/Public/js/additional-methods.min.js
"></script>
<script src="/min/?f=
	/Public/js/jquery.bootstrap.wizard.min.js,
	/Public/js/chosen.jquery.min.js,
	/Public/js/select2.min.js,
	/Public/js/app.min.js,
	/Public/js/form-wizard.min.js,
	/Public/js/route.min.js
"></script>

<!--[if lt IE 9]>
<script src="/Public/js/excanvas.min.js"></script>
<script src="/Public/js/respond.min.js"></script>
<![endif]-->
<script>
	jQuery(document).ready(function() {
		// initiate layout and plugins
		App.init();
		FormWizard.init();
	});
</script>

	<!-- END JAVASCRIPTS -->   


<!-- END BODY -->

</html>