<?php
require_once("include/membersite_config.php");

if(isset($_POST['Submit']))
{
	  if($vrcloudtechmembersite->Login()){
        $vrcloudtechmembersite->RedirectToURL("login-home.php");
   }
}
	
?>
<!doctype html>
<html class="no-js">
	<!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>vrcloudtech</title>
		
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
		<link href='http://fonts.googleapis.com/css?family=Bree+Serif' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Philosopher' rel='stylesheet' type='text/css'>
		
		
		<link rel="stylesheet" href="css/bootstrap.min.css"/>
		<link rel="stylesheet" href="css/font-awesome.min.css"/>
	
		<link rel="stylesheet" href="css/style.css" />
		<script src="js/vendor/modernizr-2.6.2.min.js"></script>
		<script src="js/vendor/jquery-1.10.2.min.js"></script>
		<script src="js/vendor/bootstrap.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
			$('#login-modal').modal('show');
			$('#login-modal').modal({backdrop: 'static', keyboard: false})  
			});
		</script>
	</head>
	<body>
		<!--[if lt IE 7]>
		<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->

		<!-- Add your site or application content here -->
		
		</div>
	</body>
</html>



<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
<form name="login" method="post">
	<div class="modal-dialog">
    	<div class="modal-content">
      		<div class="modal-header login_modal_header">
        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        		<h2 class="modal-title" id="myModalLabel">Login to Your Account</h2>
      		</div>
      		<div class="modal-body login-modal">
      			<p>Stack Overflow is a question and answer site for professional and enthusiast programmers. It's 100% free, no registration required</p>
      			<br/>
      			<div class="clearfix"></div>
      			<div id='social-icons-conatainer'>
	        		<div class='modal-body-left'>
	        			<div class="form-group">
		              		<input type="text" name ="username" id="username" value='<?php echo $vrcloudtechmembersite->SafeDisplay('username') ?>' placeholder="Enter your name" class="form-control login-field">
		              		<i class="fa fa-user login-field-icon"></i>
		            	</div>
		
		            	<div class="form-group">
		            	  	<input type="password" name ="login-pass" id="login-pass" value='<?php echo $vrcloudtechmembersite->SafeDisplay('login-pass') ?>'placeholder="Password" class="form-control login-field">
		              		<i class="fa fa-lock login-field-icon"></i>
		            	</div>
		
		            	<input type= "submit" class="btn btn-success modal-login-btn" name='Submit' id='Submit' value="Login">
		            	<a href="#" class="login-link text-center">Lost your password?</a>
	        		</div>
	        	
	        		<div class='modal-body-right'>
	        			<div class="modal-social-icons">
	        				<a href='fbconfig.php' class="btn btn-default facebook"> <i class="fa fa-facebook modal-icons"></i> Sign In with Facebook </a>
	        				<a href='#' class="btn btn-default twitter"> <i class="fa fa-twitter modal-icons"></i> Sign In with Twitter </a>
	        				<a href='#' class="btn btn-default google"> <i class="fa fa-google-plus modal-icons"></i> Sign In with Google </a>
	        				<a href='#' class="btn btn-default linkedin"> <i class="fa fa-linkedin modal-icons"></i> Sign In with Linkedin </a>
	        			</div> 
	        		</div>	
	        		<div id='center-line'> OR </div>
	        	</div>																												
        		<div class="clearfix"></div>
        		
        		<div  class="form-group modal-register-btn">
        			<a href='register.php' class="btn btn-default"> New User Please Register</a>
					
        		</div>
      		</div>
      		<div class="clearfix"></div>
      		<div class="modal-footer login_modal_footer">
      		</div>
    	</div>
  	</div>
</form>	
</div>



