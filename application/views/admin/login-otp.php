<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title; ?></title>
   
   <!-- Favicon -->
   <link href="<?php echo base_url(); ?>asset/images/favicon.jpg" rel="icon" type="image/x-icon" />
  
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
 
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/adminlte/bower_components/font-awesome/css/font-awesome.min.css">
  
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/adminlte/bower_components/Ionicons/css/ionicons.min.css">
 
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/adminlte/dist/css/AdminLTE.min.css">
 
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/adminlte/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  
	<?php
    
    if(base_url() == 'http://localhost/zickie/')
    {
        
    }else{
        
    ?>
    
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    
    <?php
    
    }
    
    ?>

</head>

<body class="hold-transition login-page">

<div class="login-box">
  
  <div class="login-logo">
   
    <a href="<?php echo base_url(); ?>"><b>Admin Login</b></a>
 
  </div>
  
  <!-- /.login-logo -->
  <div class="login-box-body">
   
    <p class="login-box-msg">Input OTP to start your session</p>

		<?php 
                         
            echo validation_errors(); 
    
            $attr 			= 	array('class'=> '');
			
            echo form_open('admin/validate-otp/',$attr);
            
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
        
		if(!empty($message))
		{
			
			echo '<div class="alert alert-info">
			
				<a class="close" data-dismiss="alert">×
				</a>
			
				'.$message.'
				
			</div>';
				
		}
        ?>

      
      <div class="form-group has-feedback">
      
        <input type="text" name="otp" value="" placeholder="OTP" autocomplete="off" class="form-control" >
              
      </div>
      
      <div class="form-group has-feedback" style="display:none;">
       
        <input type="text" name="email" value="<?php if(!empty($email)){ echo set_value('email', $email); } ?>" class="form-control" readonly >
              
      </div>

      
      <div class="row">
        
        <!-- /.col -->
        <div class="col-xs-4">
        
          <button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
        
        </div>
        <!-- /.col -->
        
      </div>
      
    </form>

    <!--<a href="#">Resend OTP</a><br>-->
    
  </div>
  <!-- /.login-box-body -->
  
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?php echo base_url() ?>asset/adminlte/bower_components/jquery/dist/jquery.min.js"></script>

<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url() ?>asset/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- iCheck -->
<script src="<?php echo base_url() ?>asset/adminlte/plugins/iCheck/icheck.min.js"></script>

<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<!--<script async src="https://www.googletagmanager.com/gtag/js?id=UA-154001443-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-154001443-1');
</script>-->

</body>

</html>
