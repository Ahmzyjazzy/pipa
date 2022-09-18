<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title; ?></title>
   
  <!-- Favicon -->

  
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
 
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/userlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/userlte/bower_components/font-awesome/css/font-awesome.min.css">
  
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/userlte/bower_components/Ionicons/css/ionicons.min.css">
 
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/userlte/dist/css/AdminLTE.min.css">
  
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/userlte/dist/css/style.css?v=1.2.6">
 
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/userlte/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  
  <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>


</head>

<body class="">

    <div class="login-outer">
    
        
        <div class="login-bx">
        	
            <div class="login-bx-bdy">
            	
                <div class="n310_50">
                	
                    Reset Password?
                    
                </div>
                
                <div class="n310_50_small">
                	
                    Provide your new password
                    
                </div>
                
				<?php 
                
                echo validation_errors(); 
                    
                $attr 			= 	array('class'=> '');
                    
                echo form_open('participant/reset-password/'.$id.'/'.$token.'/',$attr);
                    
                    if ($this->session->flashdata('message')):
                
                    ?>
                    
                            <div class="alert alert-error">
                            
                                <a class="close" data-dismiss="alert">×</a>
                                
                                <?php 
                                
                                    echo $this->session->flashdata('message');
                                
                                ?>
                            </div>
                    
                    <?php 
                    
                        endif;
                    
                        if ($this->session->flashdata('success-message')):
                    
                    ?>
                    
                            <div class="alert alert-info">
                    
                                <a class="close" data-dismiss="alert">×</a>
                    
                    <?php
                    
                                echo $this->session->flashdata('success-message');
                    
                    ?>
                    
                            </div>
                    
                    <?php 
                    
                        endif;
                    
                    ?>
                
                
                    <div class="form-group has-feedback form-group-grey">
                                                
                        <fieldset>
                        	
                            <legend>New Password</legend>
                        
                        	<input type="password" name="password" autocomplete="off" value="" placeholder="Your new password" class="form-control" >
                            
                        </fieldset>
                        
                    </div>
                    
                    <div class="form-group has-feedback">

                        <fieldset>
                        	
                            <legend style="width:30%;">Confirm Password </legend>
                        
                        	 <input type="password" name="conf_password" class="form-control" placeholder="Password">
                            
                        </fieldset>
                    
                    </div>
                    
                    <div class="form-group has-feedback">

                       <a href="<?php echo base_url(); ?>participant/login/">
                       
                       		Back Login
                            
                       </a>
                    
                    </div>
                    
                    <div class="row">
                    
                    
                        <div class="col-xs-12">
                        
                            <button type="submit" class="btn btn-primary btn-block">RESET PASSWORD</button>
                        
                        </div>
                    
                    </div>
                
                </form>
                
            </div>
            
        
        </div>
        
        <div class="loginbg-bx">
        
        </div>
        
    </div>

<!-- jQuery 3 -->
<script src="<?php echo base_url() ?>asset/userlte/bower_components/jquery/dist/jquery.min.js"></script>

<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url() ?>asset/userlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- iCheck -->
<script src="<?php echo base_url() ?>asset/userlte/plugins/iCheck/icheck.min.js"></script>

<script src="<?php echo base_url() ?>asset/js/bootbox.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>

</body>

</html>
