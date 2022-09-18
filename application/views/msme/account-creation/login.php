<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title; ?></title>
   
   <!-- Favicon -->
   <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url(); ?>asset/images/favicon/favicon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url(); ?>asset/images/favicon/favicon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url(); ?>asset/images/favicon/favicon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>asset/images/favicon/favicon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url(); ?>asset/images/favicon/favicon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url(); ?>asset/images/favicon/favicon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url(); ?>asset/images/favicon/favicon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url(); ?>asset/images/favicon/favicon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url(); ?>asset/images/favicon/favicon-180x180.png">
    
    <link rel="icon" type="image/png" sizes="192x192" href="<?php echo base_url(); ?>asset/images/favicon/favicon-192x192.png">
    
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>asset/images/favicon/favicon.png">
    
    
    <meta name="msapplication-TileImage" content="<?php echo base_url(); ?>asset/images/favicon/favicon-144x144.png">
  
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
 
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/userlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/userlte/bower_components/font-awesome/css/font-awesome.min.css">
  
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/userlte/bower_components/Ionicons/css/ionicons.min.css">
 
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/userlte/dist/css/AdminLTE.css">
 
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/userlte/plugins/iCheck/square/blue.css">
  
  <!-- user style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/css/userstyle.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  
   <!--<script src="https://www.google.com/recaptcha/api.js?render=6LcID9EUAAAAAPqkwfaZ6H8HpsKgRve55utv6Rpc"></script>
    <script>
        grecaptcha.ready(function () {
            grecaptcha.execute('6LcID9EUAAAAAPqkwfaZ6H8HpsKgRve55utv6Rpc', { action: 'UserLogin' }).then(function (token) {
                var recaptchaResponse = document.getElementById('recaptchaResponse');
                recaptchaResponse.value = token;
            });
        });
    </script>-->
    
   
	<?php
    
    if(base_url() == 'http://localhost/1community/')
    {
        
    }else{
        
    ?>
    
    <!--<script src="https://www.google.com/recaptcha/api.js" async defer></script>-->
    
    <?php
    
    }
    
    ?>

</head>

<body class="hold-transition login-page">

<div class="loginpge-cnt">

    <div class="loginpge-logo">
        
        <a href="<?php echo base_url(); ?>">
        
            <img src="<?php echo base_url(); ?>asset/images/logo.png" />
        
        </a>
     
    </div>

</div>

<div class="login-box">
  
  <!-- /.login-logo -->
  <div class="login-box-body">
   
    <div class="login-logo">
    
        <a href="#">
        
            <b> Login</b>
        
        </a>
    
    </div>
    
    <?php
		
		echo validation_errors();
		
	?>
    
    <?php

		if ($this->session->flashdata('message')):
	
	?>
            <div class="alert alert-error">
                <a class="close" data-dismiss="alert">×
                </a>
                <?php echo $this->session->flashdata('message');?>
            </div>
        
    <?php 
    
    	endif;
	
		if ($this->session->flashdata('success-message')):
    
	?>
    
        	<div class="alert alert-info">
                <a class="close" data-dismiss="alert">×
                </a>
                <?php echo $this->session->flashdata('success-message');?>
            </div>
            
        <?php 
        
        endif;
		
	?>
  
<!--    <p class="login-box-msg">Sign in to start your session</p>
-->
		<?php 
                             
            $attr = array('class'=> '');
           	
			echo form_open('msme/account/validate-user/',$attr);

        ?>

      
      <div class="form-group has-feedback">
      
        <input type="text" name="username" value="<?php echo set_value('username'); ?>" placeholder="Email" class="form-control" >
        
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      
      </div>
      
      <div class="form-group has-feedback">
       
        <input type="password" name="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      
      </div>
      
      <div class="form-group has-feedback">
       
          <!-- <label>Submit the word you see below:</label>
           
           
            <?php
                
                //echo $cap['image'];
    
            ?>
            
            <input type="text" name="captcha" value="" class="form-control" />
            
            <input type="hidden" name="recaptcha_response" id="recaptchaResponse">-->
            
            <!-- <div class="g-recaptcha" data-sitekey="6LfdGdEUAAAAAGQlGEoeIrXoJJWggewnlz6QCKxq"></div>-->
      
      </div>
      
      <div class="row">
      	
        <div class="col-xs-6">
        
        </div>
        
        <div class="col-xs-6">
        	
            <div class="Forgot_Password">
            
            	<a href="<?php echo base_url(); ?>msme/account/forgot-password/">Forgot Password?</a><br>
            
            </div>
            
        </div>
        
      </div>
      
      <div class="row">
      
<!--        <div class="col-xs-8">
        
          <div class="checkbox icheck">
            
            <label>
              <input type="checkbox"> Remember Me
            </label>
            
          </div>
          
        </div>-->
        
        <!-- /.col -->
        <div class="col-xs-12">
        
          <button type="submit" class="btn btn-primary btn-block btn-flat btnLogin">Login</button>
        
        </div>
        <!-- /.col -->
        
      </div>
      
      <div class="row nwact-rw">
      	
        <div class="col-xs-8">
        	
            <div class="Don_t_yet_have_an_account__">
			
            	<span>Don't yet have an account?</span>
                <span style="font-style:normal;font-weight:lighter;"> </span>
			
            </div>
            
        </div>
        
        <div class="col-xs-4">
        	
            <div class="Sign_Up">
            
				<a href="<?php echo base_url(); ?>msme/account/register/">Sign Up</a>
			
            </div>
            
        </div>
        
      </div>
      
    </form>

    
    
  </div>
  <!-- /.login-box-body -->
  
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?php echo base_url() ?>asset/userlte/bower_components/jquery/dist/jquery.min.js"></script>

<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url() ?>asset/userlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- iCheck -->
<script src="<?php echo base_url() ?>asset/userlte/plugins/iCheck/icheck.min.js"></script>

<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>

<?php
if(base_url() == 'http://localhost/1community/')
{
	
}else{
	
?>

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-170462798-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());
	
	  gtag('config', 'UA-170462798-1');
	</script>


<?php

}

?>

</body>

</html>
