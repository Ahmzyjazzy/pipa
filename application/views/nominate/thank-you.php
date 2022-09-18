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
  
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/userlte/dist/css/style.css?v=1.2">
 
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

<div class="container pipa-bx" style="margin-top:60px; margin-bottom:50px; margin-left:auto; margin-right:auto; padding-bottom:40px; padding-top:0px; padding-left:0px; padding-right:0px;">
	
    <div class="survey-thanks-layer-top">
    
    </div>
    
    <div class="col-md-12">
    
        <div class="col-xs-12 col-md-12">
        
            <div class="survey-thanks-cont">
            
            	
                <div class="survey-thanks-cont-layer1">
                	<p>
                        Awesome, <strong><?php if(!empty($participantDetail)){ echo ucfirst($participantDetail['first_name']).' '.ucfirst($participantDetail['last_name']); }?></strong>
                    </p>

                    <p>
                    	Your nominees for the 360 assessment  have been Submitted
                    </p>

                    <p><?php if(!empty($error_msg)){ echo $error_msg; } ?></p>
                    
                </div>
                
                <div class="survey-thanks-cont-layer2">
                	
                    Thank You!
                    
                </div>
                
                <div class="survey-thanks-cont-layer3">
                	
                    <img src="<?php echo base_url(); ?>asset/images/checkmark.png" />
                    
                </div>
                
            </div>
            
        </div>
        
        <div class="col-xs-12 col-md-12 text-center" style="margin-bottom:20px;">
           
        	<div class="col-xs-1 col-md-4">
                    
            </div>
            
            <div class="col-xs-10 col-md-4 text-center" id="close-window" style="display:none;">
       
                <a href="javascript:void(0);" class="btn btn-primary">
                
                    <b>Close</b>
                
                </a>
                
            </div>
            
            <div class="col-xs-1 col-md-4">
            
            </div>  
        
        </div>
        
    </div>


</div>


<!-- jQuery 3 -->
<script src="<?php echo base_url() ?>asset/userlte/bower_components/jquery/dist/jquery.min.js"></script>

<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url() ?>asset/userlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- iCheck -->
<script src="<?php echo base_url() ?>asset/userlte/plugins/iCheck/icheck.min.js"></script>

<script>

$(document).ready(function(e) {
    
	$('#close-window').click(function(){
		
		window.close();	
		
	});
	
});
</script>

</body>

</html>
