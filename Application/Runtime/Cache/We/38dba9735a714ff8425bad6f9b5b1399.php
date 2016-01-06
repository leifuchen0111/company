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

					<li class="dropdown user">

						<button onclick="location='/Home/WebMag/weblist.html?gw_id=<?php echo ($ap["gw_id"]); ?>'" class="btn blue"><i class="icon-share-alt"></i>&nbsp;&nbsp;返回站点列表</button>

					</li>
					
					<?php if(($_SESSION['userId']) == "1"): ?><li class="dropdown user">

						<button class="btn blue" onclick="location='<?php echo U('Dashboard/postSysnews');?>'"><i class="icon-comment-alt"></i>&nbsp;&nbsp;发布系统消息</button>

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

				<li>

					<!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->

					<form class="sidebar-search">

						<div class="input-box">

							<a href="javascript:;" class="remove"></a>

							<input type="text" placeholder="Search..." />

							<input type="button" class="submit" value=" " />

						</div>

					</form>

					<!-- END RESPONSIVE QUICK SEARCH FORM -->

				</li>

				<li class="start ">

					<a href="/">

					<i class="icon-home"></i> 

					<span class="title">首页</span>

					</a>

				</li>

				
				<li class="">
					<a href="javascript:;">
					<i class="icon-cogs"></i> 
					<span class="title">网站操作</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<li >
							<a href="<?php echo U('Index/webconf');?>?webid=<?php echo ($webHeader["id"]); ?>">
								基本信息
							</a>

						</li>
						<!--<li >
							<a href="<?php echo U('Index/download');?>?webid=<?php echo ($webHeader["id"]); ?>">
								下载该站点
							</a>

						</li>-->
						<li >
							<a href="<?php echo U('Preview/showQRcode');?>?webid=<?php echo ($webHeader["id"]); ?>">
								预览站点
							</a>

						</li>
					</ul>
				</li>
				
				<li class="">
					<a href="javascript:;">
					<i class="icon-cogs"></i> 
					<span class="title">网站内容管理</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
					<?php if(in_array(($Nav), is_array($leftNav)?$leftNav:explode(',',$leftNav))): ?><li >
							<a href="<?php echo U('Nav/navList');?>?webid=<?php echo ($webHeader["id"]); ?>">
								导航管理
							</a>

						</li><?php endif; ?>
					<?php if(in_array(($Ads), is_array($leftNav)?$leftNav:explode(',',$leftNav))): ?><li >
							<a href="<?php echo U('Ads/adsList');?>?webid=<?php echo ($webHeader["id"]); ?>">
								广告管理
							</a>

						</li><?php endif; ?>
					<?php if(in_array(($Img), is_array($leftNav)?$leftNav:explode(',',$leftNav))): ?><li >
							<a href="<?php echo U('Img/imgList');?>?webid=<?php echo ($webHeader["id"]); ?>">
								图片管理
							</a>

						</li><?php endif; ?>
					<?php if(in_array(($Apk), is_array($leftNav)?$leftNav:explode(',',$leftNav))): ?><li >
							<a href="<?php echo U('Apk/apkList');?>?webid=<?php echo ($webHeader["id"]); ?>">
								APK管理
							</a>

						</li><?php endif; ?>
					<?php if(in_array(($Product), is_array($leftNav)?$leftNav:explode(',',$leftNav))): ?><li >
							<a href="<?php echo U('Product/proList');?>?webid=<?php echo ($webHeader["id"]); ?>">
								商品管理
							</a>

						</li><?php endif; ?>
					<?php if(in_array(($Music), is_array($leftNav)?$leftNav:explode(',',$leftNav))): ?><li >
							<a href="<?php echo U('Music/musicList');?>?webid=<?php echo ($webHeader["id"]); ?>">
								音乐管理
							</a>

						</li><?php endif; ?>
					<?php if(in_array(($Vadio), is_array($leftNav)?$leftNav:explode(',',$leftNav))): ?><li >
							<a href="<?php echo U('Vadio/vadioList');?>?webid=<?php echo ($webHeader["id"]); ?>">
								视频管理
							</a>

						</li><?php endif; ?>
					<?php if(in_array(($Vadio), is_array($leftNav)?$leftNav:explode(',',$leftNav))): ?><li >
							<a href="<?php echo U('News/newsList');?>?webid=<?php echo ($webHeader["id"]); ?>">
								新闻管理
							</a>

						</li><?php endif; ?>
					<?php if(in_array(($Book), is_array($leftNav)?$leftNav:explode(',',$leftNav))): ?><li >
							<a href="<?php echo U('Book/BookList',array('webid'=>$webHeader['id']));?>">
								小说管理
							</a>

						</li><?php endif; ?>
					<?php if(in_array(($Shop), is_array($leftNav)?$leftNav:explode(',',$leftNav))): ?><li >
							<a href="<?php echo U('Shop/ShopList',array('webid'=>$webHeader['id']));?>">
								店铺管理
							</a>

						</li><?php endif; ?>
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

							管理内容<small></small>

						</h3>

						<ul class="breadcrumb">

							<!-- <li>

								<i class="icon-home"></i>

								<a href="/">首页</a> 

								<i class="icon-angle-right"></i>

							</li>
							<li>

								<a href="javascript:;"><?php echo (MODULE_NAME); ?></a>

								<i class="icon-angle-right"></i>

							</li>

							<li><a href="javascript:;"><?php echo (ACTION_NAME); ?></a></li> -->

						</ul>

						<!-- END PAGE TITLE & BREADCRUMB-->

					</div>

				</div>

				<!-- END PAGE HEADER-->