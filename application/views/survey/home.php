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
  
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/userlte/dist/css/style.css?v=1.2.3">
 
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
    
        
        <div class="login-bx survey-login-bx">
        	
            <div class="login-bx-bdy surveyWelcomeBody">
            	
                <div class="surveyWelcomeHdr">
                	
                   Welcome to PIPA Survey Platform
                    
                </div>
                
				<div class="surveyWelcomeBodyText">
                	
                   <p>
                   		
                        Dear <?php if(!empty($surveyor)){ echo ucfirst($surveyor['name']); }?>,
                        
                   </p>
                   
                   <p>
                   
                   		Welcome and thank you for taking the time to complete this 360 Survey for <strong><?php if(!empty($participantDetails)){ echo ucfirst($participantDetails['first_name']).' '.ucfirst($participantDetails['last_name']); }?></strong>. By taking the time to complete it, 
                        
                        your responses will be used to help <strong><?php if(!empty($participantDetails)){ echo ucfirst($participantDetails['first_name']); }?></strong> develop and become a stronger leader along his leadership journey.
                        
                   </p>
                   
                   <p>
                   	
                    	Let me assure you that your responses are completely anonymous and <strong><?php if(!empty($participantDetails)){ echo ucfirst($participantDetails['first_name']); }?></strong> or any other member of <strong><?php if(!empty($companyDetails)){ echo ucfirst($companyDetails['company_name']); }?></strong> will ever be able to trace the responses to you.
                        
                        If you would like to learn more about how we protect your privacy, please click here.
                   
                   </p>
                    
                   <p>
                   		
                        The survey should take you approximately 20 minutes to complete. Should you have any questions or difficulty completing this survey, please do not hesitate
                        
                        to contact us at <strong>0700-CALL-PIPA(2244-7572)</strong> or <strong>support@pipa.com</strong>
                   
                   </p>
                   
                </div>
                
                <div class="surveyWelcomeBodyBTN">
                
                	<a href="<?php echo base_url(); ?>survey/survey-questions/<?php echo $surveyor['survey_id'].'/'.$surveyor['survey_surveyor_id'].'/'.$surveyor['survey_participant_id'].'/'; ?>" class="btn btn-primary">
                        
                       Get Started  &nbsp; <i class="fa fa-angle-right"></i>
                        
                    </a>
                                        
                </div>
                
            </div>
            
        
        </div>
        
        <div class="loginbg-bx surveyWelcomeBody-right-cont">
        
        </div>
        
    </div>

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

</body>

</html>
