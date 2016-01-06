<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

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
	/Public/css/page.css
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

                <!-- BEGIN NOTIFICATION DROPDOWN -->
                <ul class="nav pull-right">

                    <?php if(($_SESSION['userId']) != "1"): ?><li class="dropdown user">

                            <button onclick="location='<?php echo U('Tool/Api/download');?>?name=readme.doc'" class="btn blue"><i class="icon-file"></i>&nbsp;&nbsp;下载使用文档</button>

                        </li>
                        <?php else: ?>
                        <li class="dropdown user">

                            <button class="btn blue" onclick="location='<?php echo U('Home/Dashboard/postSysnews');?>'"><i class="icon-comment-alt"></i>&nbsp;&nbsp;发布系统消息</button>

                        </li>
                        <li class="dropdown user">

                            <button class="btn blue" onclick="location='<?php echo U('Mmclick/Index/add');?>'"><i
                                    class=""></i>&nbsp;&nbsp;MMclick图片</button>

                        </li><?php endif; ?>

                    <li class="dropdown user">

                        <button onclick="location='<?php echo U('Analysis/Index/index');?>'" class="btn blue"><i class="icon-trash"></i>&nbsp;&nbsp;数据分析</button>

                    </li>

                    <li class="dropdown user">

                        <button onclick="location='<?php echo U('Home/Public/delCache');?>'" class="btn blue"><i class="icon-trash"></i>&nbsp;&nbsp;清除缓存</button>

                    </li>
                    <li class="dropdown user">

                        <button onclick="location='<?php echo U('Home/User/profile');?>'" class="btn blue"><i class="icon-user"></i>&nbsp;&nbsp;个人中心</button>

                    </li>
                    <li class="dropdown user">

                        <button class="btn blue" onclick="Home/window.history.go(-1)"><i class="icon-step-backward"></i>&nbsp;&nbsp;返回</button>

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

                <div class="sidebar-toggler hidden-phone"></div>

            </li>

            <li class="start ">

                <a href="/">

                    <i class="icon-home"></i>

                    <span class="title">首页</span>

                </a>

            </li>

            <?php if(is_array($main_nav)): foreach($main_nav as $key=>$item): ?><li class="<?php if((MODULE_NAME) == $item['node']): ?>open<?php endif; ?>">

                <a href="javascript:;">

                    <i class="<?php echo ($item["style"]); ?>"></i>

                    <span class="title"><?php echo ($item["action"]); ?></span>

                    <span class="arrow "></span>

                </a>

                <ul class="sub-menu" <?php if((MODULE_NAME) == $item['node']): ?>style="display:block;"<?php endif; ?>>

                <?php if(is_array($item["cnav"])): foreach($item["cnav"] as $key=>$i): if($i['p_id'] == $item['id']): ?><li >

                            <a href="<?php echo U('Home'.'/'.$item['node'].'/'.$i['node']);?>">

                                <?php echo ($i["action"]); ?></a>

                        </li><?php endif; endforeach; endif; ?>

        </ul>

        </li><?php endforeach; endif; ?>

        <?php if(($_SESSION['userId']) == "1"): ?><li>

                <a href="javascript:;">

                    <i class="icon-android"></i>

                    <span class="title">APK管理</span>

                    <span class="arrow "></span>

                </a>

                <ul class="sub-menu" <?php if((MODULE_NAME) == $item['node']): ?>style="display:block;"<?php endif; ?>>


            <li >

                <a href="<?php echo U('Android/Apk/ApkHistory');?>">

                    历史版本
                </a>

            </li>

            <li >

                <a href="<?php echo U('Android/Apk/ApkUpload');?>">

                    升级APK</a>

            </li>


            </ul>

            </li><?php endif; ?>



        </ul>

        <!-- END SIDEBAR MENU -->

    </div>

    <!-- END SIDEBAR -->

    <!-- BEGIN PAGE -->

    <div class="page-content" >

        <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->

        <div id="portlet-config" class="modal hide" style="margin:0 -200px;box-shadow:0 0 0 2000px rgba(0,0,0,0.5);">

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
            <div class="row-fluid">

                <div class="span12">

                   <!-- <ul class="breadcrumb">

                        <li>

                            <i class="icon-home"></i>

                            <a href="/Route">首页</a>

                            <i class="icon-angle-right"></i>

                        </li>
                        <li>

                            <a href="<?php echo U('ApMain/aplist');?>">AP列表</a>

                            <i class="icon-angle-right"></i>

                        </li>

                        <li><a href="javascript:;"><?php echo ($apInfo["hwserial"]); ?></a></li>

                    </ul>-->

                </div>

            </div>

<div id="dashboard">
<div class="row-fluid">

	<div onclick="location='<?php echo U('Home/ApMain/aplist');?>'" class="span4 responsive" data-tablet="span4"
		 data-desktop="span4">
			
			<div   class="dashboard-stat blue">

				<div class="visual">

					<i class="icon-hdd"></i>

				</div>

				<div class="details">

					<div class="number">

						Ap 总数

					</div>

					<div class="desc">                           
						<?php echo ($indexTj["ap_count"]); ?>
						

					</div>

				</div>

				
				<a class="more" href="javascript:;">
				详情 <i class="m-icon-swapright m-icon-white"></i>
				</a>
				                

			</div>

		</div>

		<div onclick="location='<?php echo U('Home/Dashboard/user');?>'" class="span4 responsive" data-tablet="span4"
			 data-desktop="span4">

			<div class="dashboard-stat green">

				<div class="visual">

					<i class="icon-user"></i>

				</div>

				<div class="details">

					<div class="number">认证用户</div>

					<div class="desc"><?php echo ($indexTj['macCount']); ?></div>

				</div>

				<a class="more" href="javascript:;">

				详情 <i class="m-icon-swapright m-icon-white"></i>

				</a>                 

			</div>

		</div>

		
		
		<div onclick="location='<?php echo U('Home/Dashboard/member');?>'" class="span4 responsive" data-tablet="span4"
			 data-desktop="span4">

			<div class="dashboard-stat yellow">

				<div class="visual">

					<i class="icon-th"></i>

				</div>

				<div class="details">

					<div class="number">会员管理</div>

					<div class="desc"><?php echo ($indexTj['memCount']); ?></div>

				</div>

				<a class="more" href="javascript:;">

				详情<i class="m-icon-swapright m-icon-white"></i>

				</a>                 

			</div>

		</div>
		
		<!-- onclick="location='<?php echo U('Dashboard/flowTotle');?>'"
		<div onclick="location='<?php echo U('Dashboard/flowTotle');?>'" class="span2 responsive" data-tablet="span2" data-desktop="span2">

			<div class="dashboard-stat purple">

				<div class="visual">

					<i class="icon-th"></i>

				</div>

				<div class="details">

					<div class="number">流量统计</div>

					<div class="desc"><?php echo ($indexTj["bw_up_count"]); ?>/<?php echo ($indexTj["bw_down_count"]); ?></div>

				</div>

				<a class="more" href="javascript:;">

				详情<i class="m-icon-swapright m-icon-white"></i>

				</a>

			</div>

		</div>
		
		
		<div onclick="location='<?php echo U('Dashboard/Msg');?>'" class="span2 responsive" data-tablet="span2" data-desktop="span2">

			<div class="dashboard-stat blue">

				<div class="visual">

					<i class="icon-th"></i>

				</div>

				<div class="details">

					<div class="number">短信剩余</div>

					<div class="desc"><?php echo ($indexTj["short_msg_count"]); ?></div>

				</div>

				<a class="more" href="javascript:;">

				详情<i class="m-icon-swapright m-icon-white"></i>

				</a>

			</div>

		</div>
		
		<div onclick="javascript:alert('功能研发中，敬请期待');"  class="span2 responsive" data-tablet="span2" data-desktop="span2">

			<div class="dashboard-stat green">

				<div class="visual">

					<i class="icon-th"></i>

				</div>

				<div class="details">

					<div class="number">应用服务</div>

					<div class="desc">批量设置</div>

				</div>

				<a class="more" href="javascript:;">

				详情<i class="m-icon-swapright m-icon-white"></i>

				</a>                 

			</div>

		</div>-->

	</div>

</div>
<div class="row-fluid">

	<div class="span12 responsive" data-tablet="span12 fix-offset" data-desktop="span12">

		<!-- BEGIN EXAMPLE TABLE PORTLET-->

		<div class="portlet box yellow">

			<div class="portlet-title">

				<div class="caption"><i class="icon-user"></i>运营商列表</div>

				<div class="actions">
					

					<a href="<?php echo U('Member/addAgent');?>" class="btn green"><i class="icon-plus"></i> 添加</a>


				</div>

			</div>

			<div class="portlet-body">

				<table class="table table-striped table-bordered table-hover" id="sample_3">

					<thead>

						<tr>

							<th style="width:8px;"><input type="checkbox" class="checkboxes group-checkable" data-set="#sample_3 .checkboxes" /></th>

							<th>用户名</th>

							<th>电话</th>

							<th>上次登录时间</th>
							<th class="hidden-480">上次登录IP</th>
							
							<td>操作</td>

						</tr>

					</thead>

					<tbody>
						<?php if(is_array($agentList)): $i = 0; $__LIST__ = $agentList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr class="odd gradeX">

							<td><input type="checkbox" class="checkboxes" value="<?php echo ($v["id"]); ?>" /></td>
							<td><?php echo ($v["name"]); ?></td>

							<td><?php echo ($v["phone"]); ?></td>

							<td><?php echo (date("Y-m-d",$v["lasttime"])); ?></td>

							<td class="hidden-480"><span class="label label-success"><?php echo ($v["lastip"]); ?></span></td>

							<td align="center">

								<a href="<?php echo U('Member/editAgent',array('id'=>$v['id']));?>" class="btn blue icn-only"><i class="icon-pencil icon-white"></i>&nbsp;&nbsp;编辑</a>

								<a href="javascript:deleteOne(<?php echo ($v["id"]); ?>,'/Home/Member/delAgente/id/');" class="btn red icn-only"><i class="icon-remove icon-white"></i>&nbsp;&nbsp;删除</a>

							</td>

						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</tbody>

				</table>

			</div>

		</div>

		<!-- END EXAMPLE TABLE PORTLET-->

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

		<!--2015 &copy; <a href="http://www.sun-net.cn">普云科技</a> 保留所有权.-->

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