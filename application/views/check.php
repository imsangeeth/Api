<!DOCTYPE html>
<html lang="en">
<head>
	<title>Admin Login <?php echo $name; ?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="/clicktocall/style/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/clicktocall/style/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/clicktocall/style/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/clicktocall/style/fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/clicktocall/style/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="/clicktocall/style/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/clicktocall/style/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/clicktocall/style/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="/clicktocall/style/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/clicktocall/style/css/util.css">
	<link rel="stylesheet" type="text/css" href="/clicktocall/style/css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" action="http://localhost/clicktocall/index.php/user/ClientLogin" method="post">
					<span class="login100-form-title p-b-26">
						<img src="<?php echo base_url().'style/images/clientlogo/'.$image ?>">
					</span>
					<span class="login100-form-title p-b-48">
						
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Enter Username">
						<input class="input100" type="text" name="UserEmail">
						
						<span class="focus-input100" data-placeholder="Username"></span>
					</div>
					<input type="hidden" name="Key" value="<?php echo $key; ?>">
					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input class="input100" type="password" name="UserPassword">
						<span class="focus-input100" data-placeholder="Password"></span>
					</div>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn">
								Login
							</button>
						</div>
					</div>

					<div class="text-center p-t-115" style="padding-top: 28px;">
						<span style="font-size: 15px;color: #c51a1a;background-color: #eae6e6;" class="txt1">
							<?php echo $this->session->flashdata('error'); ?>
						</span>
					</div>
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="/clicktocall/style/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="/clicktocall/style/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="/clicktocall/style/vendor/bootstrap/js/popper.js"></script>
	<script src="/clicktocall/style/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="/clicktocall/style/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="/clicktocall/style/vendor/daterangepicker/moment.min.js"></script>
	<script src="/clicktocall/style/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="/clicktocall/style/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="/clicktocall/style/js/main.js"></script>

</body>
</html>