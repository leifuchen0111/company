<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->

<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->

<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->

<!-- BEGIN HEAD -->

<head>

	<meta charset="utf-8" />

	<title>路由器管理后台</title>

	<meta content="width=device-width, initial-scale=1.0" name="viewport" />

	<meta content="" name="description" />

	<meta content="" name="author" />

	<!-- BEGIN GLOBAL MANDATORY STYLES -->

	<link href="/Public/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

	<link href="/Public/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>

	<link href="/Public/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>

	<link href="/Public/css/style-metro.css" rel="stylesheet" type="text/css"/>

	<link href="/Public/css/style.css" rel="stylesheet" type="text/css"/>

	<link href="/Public/css/style-responsive.css" rel="stylesheet" type="text/css"/>

	<link href="/Public/css/default.css" rel="stylesheet" type="text/css" id="style_color"/>

	<link href="/Public/css/uniform.default.css" rel="stylesheet" type="text/css"/>

	<!-- END GLOBAL MANDATORY STYLES -->

	<!-- BEGIN PAGE LEVEL STYLES -->

	<link rel="stylesheet" type="text/css" href="/Public/css/select2_metro.css" />

	<link rel="stylesheet" href="/Public/css/DT_bootstrap.css" />
	
	<link rel="stylesheet" type="text/css" href="/Public/css/bootstrap-fileupload.css" />

	<link rel="stylesheet" type="text/css" href="/Public/css/jquery.gritter.css" />

	<link rel="stylesheet" type="text/css" href="/Public/css/chosen.css" />

	<link rel="stylesheet" type="text/css" href="/Public/css/select2_metro.css" />

	<link rel="stylesheet" type="text/css" href="/Public/css/jquery.tagsinput.css" />

	<link rel="stylesheet" type="text/css" href="/Public/css/clockface.css" />

	<link rel="stylesheet" type="text/css" href="/Public/css/bootstrap-wysihtml5.css" />

	<link rel="stylesheet" type="text/css" href="/Public/css/datepicker.css" />

	<link rel="stylesheet" type="text/css" href="/Public/css/timepicker.css" />

	<link rel="stylesheet" type="text/css" href="/Public/css/colorpicker.css" />

	<link rel="stylesheet" type="text/css" href="/Public/css/bootstrap-toggle-buttons.css" />

	<link rel="stylesheet" type="text/css" href="/Public/css/daterangepicker.css" />

	<link rel="stylesheet" type="text/css" href="/Public/css/datetimepicker.css" />

	<link rel="stylesheet" type="text/css" href="/Public/css/multi-select-metro.css" />

	<link href="/Public/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
	<!-- 404 -->
	<link href="/Public/css/error.css" rel="stylesheet" type="text/css"/>
	

	<!-- END PAGE LEVEL STYLES -->

	<link rel="shortcut icon" href="/Public/image/favicon.ico" />
	
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

				

		

			</ul>

			<!-- END SIDEBAR MENU -->

		</div>

		<!-- END SIDEBAR -->

		<!-- BEGIN PAGE -->

		<div class="page-content" >

			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->

			<div id="portlet-config" class="modal hide" style="display:none;margin:-170px -200px;box-shadow:0 0 0 2000px rgba(0,0,0,0.5);">

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

							<small></small>

							
						
						</h3>

						<ul class="breadcrumb">


						</ul>

						<!-- END PAGE TITLE & BREADCRUMB-->

					</div>

				</div>
				

				<!-- END PAGE HEADER-->
<div class="row-fluid">

	<div class="span12 page-404">

		<div class="number">

			404

		</div>

		<div class="details">

			<h3>页面不存在</h3>

			<p>

				找不您所请求的页面，我们表示深深的歉意.<br>

				您可以    <a href="javascript:window.history.go(-1);">返回</a> 或者<br/>
				<a href="/">转到首页</a>

			</p>

		</div>

	</div>

</div>
<include file="./Application/Tool/View/footer.html" />