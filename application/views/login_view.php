<!DOCTYPE html>
<html lang="en" class="coming-soon">
<head>
    <meta charset="utf-8">
    <title><?php echo $this->config->item('program'); ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="author" content="KaijuThemes">

    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600' rel='stylesheet' type='text/css'>
    <link type="text/css" href="<?php echo base_url('');?>/assets/plugins/iCheck/skins/minimal/blue.css" rel="stylesheet">
    <link type="text/css" href="<?php echo base_url('');?>assets/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link type="text/css" href="<?php echo base_url('');?>assets/fonts/themify-icons/themify-icons.css" rel="stylesheet">               <!-- Themify Icons -->
    <link type="text/css" href="<?php echo base_url('');?>assets/css/styles.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries. Placeholdr.js enables the placeholder attribute -->
    <!--[if lt IE 9]>
        <link type="text/css" href="assets/css/ie8.css" rel="stylesheet">
        <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- The following CSS are included as plugins and can be removed if unused-->
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/favicon.ico">
    </head>

    <body class="focused-form animated-content">
        
        
<div class="container" id="login-form">
	<a href="<?php echo base_url(); ?>" class="login-logo"><img src="<?php echo base_url(); ?>assets/img/logo-infra.png"></a>
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h2>Login Infranet</h2>						
					</div> 
					<div class="panel-body">
					<?php echo $this->session->flashdata('login') ?>
						<form action="<?php echo site_url('login/auth');?>" method="post" class="form-horizontal" id="validate-form" >
							<div class="form-group mb-md">
		                        <div class="col-xs-12">
		                        	<div class="input-group">							
										<span class="input-group-addon">
											<i class="ti ti-user"></i>
										</span>
										<input name="username" type="text" class="form-control" placeholder="Username" data-parsley-minlength="6" placeholder="At least 6 characters" required>
									</div>
		                        </div>
							</div>

							<div class="form-group mb-md">
		                        <div class="col-xs-12">
		                        	<div class="input-group">
										<span class="input-group-addon">
											<i class="ti ti-key"></i>
										</span>
										<input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
									</div>
		                        </div>
							</div>
							<div class="clearfix">
								<input type="submit" class="btn btn-primary pull-right" value="Login">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
</div>

    
    
    <!-- Load site level scripts -->

<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script> -->

<script type="text/javascript" src="<?php echo base_url('');?>assets/js/jquery-1.10.2.min.js"></script> 							<!-- Load jQuery -->
<script type="text/javascript" src="<?php echo base_url('');?>assets/js/jqueryui-1.10.3.min.js"></script> 							<!-- Load jQueryUI -->
<script type="text/javascript" src="<?php echo base_url('');?>assets/js/bootstrap.min.js"></script> 								<!-- Load Bootstrap -->
<script type="text/javascript" src="<?php echo base_url('');?>assets/js/enquire.min.js"></script> 									<!-- Load Enquire -->

<script type="text/javascript" src="<?php echo base_url('');?>assets/plugins/velocityjs/velocity.min.js"></script>					<!-- Load Velocity for Animated Content -->
<script type="text/javascript" src="<?php echo base_url('');?>assets/plugins/velocityjs/velocity.ui.min.js"></script>

<script type="text/javascript" src="<?php echo base_url('');?>assets/plugins/wijets/wijets.js"></script>     						<!-- Wijet -->

<script type="text/javascript" src="<?php echo base_url('');?>assets/plugins/codeprettifier/prettify.js"></script> 				<!-- Code Prettifier  -->
<script type="text/javascript" src="<?php echo base_url('');?>assets/plugins/bootstrap-switch/bootstrap-switch.js"></script> 		<!-- Swith/Toggle Button -->

<script type="text/javascript" src="<?php echo base_url('');?>assets/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js"></script>  <!-- Bootstrap Tabdrop -->

<script type="text/javascript" src="<?php echo base_url('');?>assets/plugins/iCheck/icheck.min.js"></script>     					<!-- iCheck -->

<script type="text/javascript" src="<?php echo base_url('');?>assets/plugins/nanoScroller/js/jquery.nanoscroller.min.js"></script> <!-- nano scroller -->

<script type="text/javascript" src="<?php echo base_url('');?>assets/js/application.js"></script>

<!-- End loading site level scripts -->
    <!-- Load page level scripts-->
    

    <!-- End loading page level scripts-->
    </body>
</html>