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
<div class="row-fluid">

	<div class="span12">

		<div class="tabbable tabbable-custom boxless">

			<div class="tab-content">

				<div class="tab-pane active" id="tab_4">

					<div class="portlet box blue">

						<div class="portlet-title">

							<div class="caption"><i class="icon-reorder"></i>配置项</div>
							<div class="tools">
							</div>

						</div>

						<div class="portlet-body form">

							<!-- BEGIN FORM-->

							<form action="<?php echo U('Apconf/baseConfEdit');?>" method="post" class="form-horizontal">

								<input type="hidden" name="id" value="<?php echo ($data['id']); ?>" />
								<div class="control-group">

									<label class="control-label">在线用户强制下线时间</label>

									<div class="controls">

										<input type="text" pattern="[0-9]{1,11}" placeholder="twifiuser" name="twifiuser" value="<?php echo ($data['twifiuser']); ?>" class="m-wrap span2">

										<span class="help-inline">秒</span>

									</div>

								</div>

								<div class="control-group">

									<label class="control-label">远程重启更新时间</label>

									<div class="controls">

										<input type="text" pattern="[0-9]{1,11}" placeholder="trestart" name="trestart" value="<?php echo ($data['trestart']); ?>" class="m-wrap span2">

										<span class="help-inline">秒(0表示不自动重启)</span>

									</div>

								</div>
								<div class="control-group">

									<label class="control-label">开启/关闭认证</label>

									<div class="controls">

										<div class="basic-toggle-button" id="isrecord">

											<input type="checkbox" name="isrecord" class="toggle" value="1" <?php if(($data["isrecord"]) != ""): ?>checked="checked"<?php endif; ?> />

										</div>

									</div>

								</div>
								
								<div class="control-group" id="type">

									<label class="control-label">认证方式</label>

									<div class="controls">
											<input type="checkbox" name="recordType[]" <?php if(in_array('ph',json_decode($data['isrecord']))){echo 'checked=checked'; } ?>  value="ph" />短信认证
										
											<input type="checkbox" id="wx"  name="recordType[]" <?php if(in_array('wx',json_decode($data['isrecord']))){echo 'checked=checked'; } ?>  value="wx" />微信认证

									</div>
								
								</div>
								<div class="control-group wx_id" >

									<label class="control-label">公众号名称</label>

									<div class="controls">

										<input type="text" name="wx_name"  value="<?php echo ($data["wx_name"]); ?>" />
										<span class="help-inline">输入公众号名称，有利于引导用户关注</span>
									</div>

								</div>
								
								<div class="control-group wx_id" >

									<label class="control-label">微信原始ID</label>

									<div class="controls">

											<input type="text" name="wx_id"  value="<?php echo ($data["wx_id"]); ?>" />
											<span class="help-inline">请输入需要关注的微信公众号的原始ID</span>
									</div>
								
								</div>
								<div class="control-group wx_id">
									<label class="control-label">appid</label>

									<div class="controls">

											<input type="text" name="appid"  value="<?php echo ($data["appid"]); ?>" />
											<span class="help-inline">请输入需要关注的微信公众号的appid</span>
									</div>
								</div>
								<div class="control-group wx_id">
									<label class="control-label">appsecret</label>

									<div class="controls">

											<input type="text" name="appsecret"  value="<?php echo ($data["appsecret"]); ?>" />
											<span class="help-inline">请输入需要关注的微信公众号的appsecret</span>
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
										<?php if($data['qrcode'] != ''){ echo '<img width="100" src="'.$data['qrcode'].'">'; } ?>
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

									<label class="control-label">上行流量限制</label>

									<div class="controls">

										<input type="text" pattern="[0-9]{1,11}" placeholder="bw_up" name="bw_up" value="<?php echo ($data['bw_up']); ?>" class="m-wrap span2">

										<span class="help-inline">kb</span>

									</div>

								</div>

								<div class="control-group">

									<label class="control-label">下行流量限制</label>

									<div class="controls">

										<input type="text" pattern="[0-9]{1,11}" placeholder="bw_down" name="bw_down" value="<?php echo ($data['bw_down']); ?>" class="m-wrap span2">

										<span class="help-inline">kb</span>

									</div>

								</div>
								<div class="control-group">

									<label class="control-label">备注</label>

									<div class="controls">

										<input type="text"  placeholder="备注" name="mark"
											   value="<?php echo ($data['mark']); ?>" class="m-wrap span6">

										<span class="help-inline">如位置信息，以便您更好的管理您的设备</span>

									</div>

								</div>
								<div class="form-actions">
									
									<input type="hidden" name="gw_id" value="<?php echo ($gw_id); ?>" />

									<button type="submit" class="btn blue"><i class="icon-ok"></i> 保存</button>

								</div>

							</form>

							<!-- END FORM-->  

						</div>

					</div>

				</div>

			</div>

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