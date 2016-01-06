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

    <link href="/min?f=/Public/css/bootstrap.min.css,
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

	<div  class="span6 responsive" data-tablet="span6"
		 data-desktop="span6">
			
			<div   class="dashboard-stat blue">

				<div class="visual">

					<i class="icon-eye-open"></i>

				</div>

				<div class="details">

					<div class="number">

						页面总浏览量

					</div>

					<div class="desc">                           
						<?php echo ($data["pv"]); ?>

					</div>

				</div>

				
				<a class="more" href="javascript:;">
				详情 <i class="m-icon-swapright m-icon-white"></i>
				</a>
				                

			</div>

		</div>

		<div  class="span6 responsive" data-tablet="span6"
			 data-desktop="span6">

			<div class="dashboard-stat green">

				<div class="visual">

					<i class="icon-download"></i>

				</div>

				<div class="details">

					<div class="number">总下载数</div>

					<div class="desc"><?php echo ($data['down']); ?></div>

				</div>

				<a class="more" href="javascript:;">

				详情 <i class="m-icon-swapright m-icon-white"></i>

				</a>                 

			</div>

		</div>

	</div>

</div>
<div class="row-fluid">

    <div class="span6">

        <!-- BEGIN VALIDATION STATES-->

        <div class="portlet box purple">

            <div class="portlet-title">

                <div class="caption"><i class="icon-data"></i>访问量(PV)走势图</div>
                <div class="tools">

                    <a href="javascript:;" class="expand"></a>

                </div>
            </div>

            <div class="portlet-body">

                <div id="container" class="col-md-12"></div>

            </div>

        </div>

    </div>
    <div class="span6">

        <!-- BEGIN VALIDATION STATES-->

        <div class="portlet box purple">

            <div class="portlet-title">

                <div class="caption"><i class="icon-data"></i>下载量走势图</div>
                <div class="tools">

                    <a href="javascript:;" class="expand"></a>

                </div>
            </div>

            <div class="portlet-body">

                <div id="container1" class="col-md-12"></div>

            </div>

        </div>

    </div>
</div>
<div class="row-fluid">
    <div class="span6">

        <!-- BEGIN VALIDATION STATES-->

        <div class="portlet box purple">

            <div class="portlet-title">

                <div class="caption"><i class="icon-data"></i>近7日统计</div>
                <div class="tools">

                    <a href="javascript:;" class="expand"></a>

                </div>
            </div>

            <div class="portlet-body">

                <div id="container2" class="col-md-12"></div>

            </div>

        </div>

    </div>

</div>
<script src="http://cdn.hcharts.cn/highstock/highstock.js"></script>
<script src="http://cdn.hcharts.cn/highstock/modules/exporting.js"></script>
<script type="text/javascript">
    $(function () {
        $('#container').highcharts({
            chart: {
                type: 'line'
            },
            title: {
                text: '今(昨)日对比'
            },
            subtitle: {
                text: '来源：平台数据'
            },
            xAxis: {
                categories: [<?php echo (implode(',',$todayPv["time"])); ?>]
            },
            yAxis: {
                title: {
                    text: '(人/次)'
                }
            },
            tooltip: {
                enabled: true,
                formatter: function() {
                    return '<b>'+ this.series.name +'</b><br/>'+this.x +': '+ this.y +'人/次';
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: true
                }
            },
            series: [{
                        name: '今天',
                        data: [<?php echo (implode(',',$todayPv["data"])); ?>]
                    },
                    {
                        name: '昨天',
                        data: [<?php echo (implode(',',$todayPv["data1"])); ?>]
                    }
            ]
        });

        $('#container1').highcharts({
            chart: {
                type: 'line'
            },
            title: {
                text: '今(昨)日对比'
            },
            subtitle: {
                text: '来源：平台数据'
            },
            xAxis: {
                categories: [<?php echo (implode(',',$todayDown["time"])); ?>]
            },
            yAxis: {
                title: {
                    text: '(人/次)'
                }
            },
            tooltip: {
                enabled: true,
                formatter: function() {
                    return '<b>'+ this.series.name +'</b><br/>'+this.x +': '+ this.y +'人/次';
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: true
                }
            },
            series: [{
                        name: '今天',
                        data: [<?php echo (implode(',',$todayDown["data"])); ?>]
                    },
                    {
                        name: '昨天',
                        data: [<?php echo (implode(',',$todayDown["data1"])); ?>]
                    }
            ]
        });
        $('#container2').highcharts({
            chart: {
                type: 'line'
            },
            title: {
                text: '近7日统计'
            },
            subtitle: {
                text: '来源：平台数据'
            },
            xAxis: {
                categories: [<?php echo (implode(',',$sevenPv["time"])); ?>]
            },
            yAxis: {
                title: {
                    text: '(人/次)'
                }
            },
            tooltip: {
                enabled: true,
                formatter: function() {
                    return '<b>'+ this.series.name +'</b><br/>'+this.x +': '+ this.y +'人/次';
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: true
                }
            },
            series: [{
                        name: '浏览量',
                        data: [<?php echo (implode(',',$sevenPv["data"])); ?>]
                    },
                    {
                        name: '下载量',
                                data: [<?php echo (implode(',',$sevenDown["data"])); ?>]
                    }
            ]
        });

    });

</script>


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



<script src="/min?f=
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
<script src="/min?f=
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
<script src="/min?f=
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