<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title></title>

	<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">

	<!-- 可选的Bootstrap主题文件（一般不用引入） -->
	<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
	<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
	<script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
	<link href="/Public/css/login.min.css" rel="stylesheet">
	<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
	<script src="http://cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<body><style>
	@media screen and (max-width:767px){.login .panel.panel-default{width:90%; min-width:300px;}}
	@media screen and (min-width:768px){.login .panel.panel-default{width:70%;}}
	@media screen and (min-width:1200px){.login .panel.panel-default{width:50%;}}
</style>
<div class="container">
<div class="row">
	<h1 class="text-center" style="font-size:60px;color:#fff;margin:50px 0;">普云</h1>
</div>
<div class="row">

	<div class="col-md-8 col-md-offset-2" style="margin-bottom:5em;">
		<div class="panel panel-default">
			<div class="panel-body">
				<form action="<?php echo U('Tool/Tool/login');?>" id="login" autocomplete="off" method="post" role="form">
					<input type="hidden" name="is_ok" value="2">
					<div id="msg" class="alert alert-danger hide" role="alert">
						<span class="alert-link"></span>
					</div>
					<div class="form-group input-group">
						<div class="input-group-addon"><i class="glyphicon glyphicon-user"></i></div>
						<input name="name" type="text" value="" class="form-control input-lg" autocomplete="off" placeholder="请输入用户名登录">
					</div>
					<div class="form-group input-group">
						<div class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></div>
						<input name="pwd" type="password" class="form-control input-lg" placeholder="请输入登录密码">
					</div>
					<div class="form-group input-group">
						<div class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></div>
						<input name="verify" type="text" class="form-control input-lg" placeholder="请输下方验证码">
					</div>
					<div class="form-group input-group">
						<img id="verify" src="<?php echo U('Tool/Api/verify');?>" title="点击刷新">
					</div>
					<input type="hidden" name="check" id="check" value=false>
					<input type="hidden" name="callbackurl" value="/"/>
					<div class="form-group">
						<label class="checkbox-inline input-lg">
							<input type="checkbox" value="1" name="remember"> 7天免登录
						</label>
						<div class="pull-right">
							<!--<a href="javascript:alert('接口暂未开放');" class="btn btn-link btn-lg">注册</a>-->
							<button type="submit" id="submit" data-loading-text="Loading..."
									class="btn btn-primary btn-lg" autocomplete="off">
								登录
							</button>
							<input name="token" value="f9296d72" type="hidden">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
	<div class="row text-center" style="color: #fff;">
		&copy;2015 <b>深圳市普云技术有限公司</b> All Rights Reseved.
	</div>
	</div>
<script src="/Public/js/route.min.js"></script>
<script>
	jQuery(document).ready(function() {

		$("#verify").click(function(){
			$(this).attr('src',$(this).attr('src')+'?'+Math.random());
		})
		$("form input").focus(function(){
			$('#msg').addClass('hide')
		})
	})
</script>
</body>
</html>