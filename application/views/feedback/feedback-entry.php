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

  <link rel="stylesheet" href="<?php echo base_url() ?>asset/admin_asset/css/analyze/analyze.css">

  <style>
	/* width */
	.evaluators_tmp {
		margin: 30px 0;
	}

	.surv-box {
		margin-top: 25px;
		margin-bottom: 50px;
		margin-left: auto;
		margin-right: auto;
		padding-top: 40px;
		padding-bottom: 40px;
	} 

	.evaluator-list {
		box-shadow: -1px -1px 5px 6px rgba(242,242,242,1);
		padding: 10px;
		margin-top: 10px;
	}

	.evaluator-name {
		font-size: 18px;
		width: 60%;
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
	}

	.evaluator-con{
		display: flex;
		align-items: center;
		justify-content: space-between;
	}
	  
	@media screen and (max-width: 640px) {
		.setup-form-header {
			font-size: 18px;
			font-weight: 800;
		}
		.surv-box {
			margin-top: 0;
			margin-bottom: 0;
			margin-left: auto;
			margin-right: auto; 
		}
		.pipa-bx {
			padding: 20px 0;
		}
		.padding-sm-0 {
			padding: 0;
		}
	}

	.sb-body-overlay {
		z-index: 10000023;
		display: block;
		position: absolute;
		width: 100%;
		height: 100%;
		background-color: #ffffffba;
		overflow: hidden;
		pointer-events: none;
	}
	.e-view {
		bottom: 0;
		left: 0;
		overflow: hidden;
		position: fixed;
		right: 0;
		top: 0;
	}
	.sb-loading {
		width: 56px;
		height: 56px;
		position: absolute;
		top: calc(50% - 28px);
		left: calc(50% - 28px);
		z-index: 10000;
		border-radius: 50%;
		padding: 3px;
		box-shadow: 0px 3px 1px -2px rgba(0, 0, 0, 0.2), 0px 2px 2px 0px rgba(0, 0, 0, 0.14), 0px 1px 5px 0px rgba(0, 0, 0, 0.12);
		overflow: hidden;
		display: inline-block;
		background: #ffffff;
	}
	.circular {
		animation: rotate 2s linear infinite;
		height: 50px;
		width: 50px;
		border-radius: 50%;
	}
	.path {
		stroke-dasharray: 1, 200;
		stroke-dashoffset: 0;
		animation: dash 1s ease-in-out infinite, color 1s ease-in-out infinite;
		stroke-linecap: round;
		stroke: #007AFF;
	}
	@keyframes rotate {
		100% {
			transform: rotate(360deg);
		}
	}
	@keyframes dash {
		0% {
			stroke-dasharray: 1, 200;
			stroke-dashoffset: 0;
		}
		50% {
			stroke-dasharray: 89, 200;
			stroke-dashoffset: -35;
		}
		100% {
			stroke-dasharray: 89, 200;
			stroke-dashoffset: -124;
		}
	}
	.sb-hide {
		display: none;
	}

  </style>

</head>

<body class="">

<div class="container pipa-bx surv-box">

	<div class="sb-body-overlay e-view sb-hide">
        <div class="sb-loading">
            <svg class="circular" height="40" width="40">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="6" stroke-miterlimit="10"></circle>
            </svg>
			<p>Please wait...</p>
        </div>
    </div> 

	<div class="alert alert-error hide">
		
		<a class="close" data-dismiss="alert">×</a>
		
		<p>An error occured</p>
		
	</div> 
                       	 

    <div class="col-xs-12 col-md-12 direct-report padding-sm-0"> 

		<div class="col-xs-12 col-md-12"> 

			<form action="" onsubmit="event.preventDefault();">
			
				

				<div class="col-xs-12 col-md-12">
					
					<div class="">
						
						<div class="surv-page-hdr-txt">							
							<strong><?php if(!empty($participantDetail)){ echo ucfirst($participantDetail['first_name']).' '.ucfirst($participantDetail['last_name']); }?></strong>
							requested a recommendation feedback for your response submitted for his evaluation question below                
						</div>

						<hr>

					</div>
				
				</div>
				
				<div class="col-xs-12 col-md-12 admin-form-row"> 

					<p><b>Question</b><br> <?php echo $surveyorDetail['question'] ?></p>
					
					<p><b>Your Response</b><br> <?php echo $surveyorDetail['response_text'] ?></p>


					<div class="">
						
						<div class="form-group admin-form-setup"> 

							<?php 
																		
								$data 				= 	array(
									'name'        	=> 'feedback',
									'id'          	=> 'feedback',
									'value'       	=> set_value('feedback', $feedback),
									'rows'        	=> '5',
									'cols'        	=> '10',
									'style'       	=> 'width:100%',
									'placeholder'	=>	'Please specify your feedback',
									'class'       	=> 'form-control'
								);

								echo form_textarea($data); 
							?> 
											
						</div>
						
					</div>
					
				</div> 				

				<div class="col-xs-12 col-md-4 text-center"> 
					
					<button href="javascript:void(0);" class="btn btn-primary add-to-list" id="post-feedback">
						
						<b>Submit Feedback</b>
					
					</button> 
						
				</div> 
				
			</form> 
		</div>

		<div class="col-xs-12 col-md-12 evaluators_tmp"></div>
		
	</div>  

</div>



<!-- jQuery 3 -->
<script src="<?php echo base_url() ?>asset/userlte/bower_components/jquery/dist/jquery.min.js"></script>

<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url() ?>asset/userlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- iCheck -->
<script src="<?php echo base_url() ?>asset/userlte/plugins/iCheck/icheck.min.js"></script>

<script src="<?php echo base_url() ?>asset/js/bootbox.min.js"></script>

<script src="<?php echo base_url() ?>asset/admin_asset/js/handlebars.min.js"></script>

<!-- Scripts -->

<script src="<?php echo base_url(); ?>asset/js/examwizard.min.js"></script><!-- Required -->

<script>
//  nomination js here
(function(){

	$('#post-feedback').on('click', function(){
		
		const url = window.location.href;    
		const baseUrl = url.substring(0, url.indexOf('feedback'));
		const feedback = $('textarea#feedback').val(); 
		
		// post nominees
		$.ajax({
			url: window.location.href.replace('feedback-entry','post_feedback'),
			type: 'POST',
			data: { base_url: baseUrl, feedback: feedback },
			beforeSend: function(){
				// show loader
				 $('.sb-body-overlay').removeClass('sb-hide');
            },
			error: function(err) {
				 $('.sb-body-overlay').addClass('sb-hide');
				console.log(err, ' something went wrong'); 
				$('.alert-error').removeClass('hide');
			},
			success: function(response){ 
				 $('.sb-body-overlay').addClass('sb-hide');
				 const result = JSON.parse(response);
				 if(result.success){
					bootbox.alert({ 
						message: result.message,
						closeButton: false, 
						onHide: function(e) {
						console.log('hide')
						} 
					});
					// navigate to thank you page
					$('.bootbox-alert button', $('body')).on('click', function(){
						window.location.href = window.location.href.replace('feedback-entry','thank-you');
					});
				 }else{
					$('.alert-error').removeClass('hide').find('p').html(result.message); 
				 }
				// success here
				console.log(result);
			}
		}); 

	});	
 
}());
</script>

</body>

</html>
