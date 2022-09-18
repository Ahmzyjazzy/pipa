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
                       			
    <div class="col-md-12">
        
        <div class="col-xs-12 col-md-9 padding-sm-0">
            
            <div class="surv-page-hdr-txt">
                
                Evaluator nomination for <strong><?php if(!empty($participantDetail)){ echo ucfirst($participantDetail['first_name']).' '.ucfirst($participantDetail['last_name']); }?></strong>
                                
            </div>
            
            <div class="surv-page-hdr-txt-section">
                
                <span class="count"></span> Added 
            
            </div>
            
        </div>
        
        <div class="col-xs-12 col-md-3">
            
            <div class="">
                
                <div class="footer-question-number-wrapper text-center">
                
                    <!-- <div class="mt-4">
                        
                        Step
                         
                        <span id="current-question-number-label">1</span>
                
                        <span>of <b>2</b></span>
                
                    </div> -->
                
                </div>
        
            </div>
            
        </div>
        
    </div>

    <div class="col-xs-12 col-md-12 direct-report padding-sm-0"> 

		<div class="col-xs-12 col-md-12"> 

			<form action="" onsubmit="event.preventDefault();">
			
				<div class="col-xs-12 col-md-12">
					
					<div class="setup-form-header-cont">
						
						<div class="setup-form-header">
							
							Nominate Team Members
							
						</div>   

					</div>
				
				</div>
				
				<div class="col-xs-12 col-md-6 admin-form-row"> 
					
					<div class="col-xs-12 col-md-12">
						
						<div class="form-group admin-form-setup">
							
							<fieldset>
								
								<legend style="width: 30%;">First Name</legend> 

								<?php
									
									$data	= array('placeholder'=>'Enter first name', 'name'=>'first_name', 'value'=>set_value('first_name', $first_name), 'class'=>'form-control form-no-style', 'autocomplete'=>'off');
									
									echo form_input($data);
									
								?>
								
							</fieldset>
											
						</div>
						
					</div>
					
				</div>

				<div class="col-xs-12 col-md-6 admin-form-row"> 
					
					<div class="col-xs-12 col-md-12">
						
						<div class="form-group admin-form-setup">
							
							<fieldset>
								
								<legend style="width: 30%;">Last Name</legend> 

								<?php
									
									$data	= array('placeholder'=>'Enter last name', 'name'=>'last_name', 'value'=>set_value('last_name', $last_name), 'class'=>'form-control form-no-style', 'autocomplete'=>'off');
									
									echo form_input($data);
									
								?>
								
							</fieldset>
											
						</div>
						
					</div>
					
				</div>

				<div class="col-xs-12 col-md-6 admin-form-row"> 
					
					<div class="col-xs-12 col-md-12">
						
						<div class="form-group admin-form-setup">
							
							<fieldset>
								
								<legend style="width: 30%;">Email</legend> 

								<?php
									
									$data	= array('type'=>'email','placeholder'=>'Enter email', 'name'=>'email', 'value'=>set_value('email', $email), 'class'=>'form-control form-no-style', 'autocomplete'=>'off');
									
									echo form_input($data);
									
								?>
								
							</fieldset>
											
						</div>
						
					</div>
					
				</div>

				<div class="col-xs-12 col-md-6 admin-form-row"> 
					
					<div class="col-xs-12 col-md-12">
						
						<div class="form-group admin-form-setup">
							
							<fieldset>
								
								<legend style="width: 30%;">Phone number</legend> 

								<?php
									
									$data	= array('type'=>'number','placeholder'=>'Enter phone number', 'name'=>'phone', 'value'=>set_value('phone', $phone), 'class'=>'form-control form-no-style', 'autocomplete'=>'off');
									
									echo form_input($data);
									
								?>
								
							</fieldset>
											
						</div>
						
					</div>
					
				</div> 

				<div class="col-xs-12 col-md-12 admin-form-row"> 
					
					<div class="col-xs-12 col-md-12">
						
						<div class="form-group admin-form-setup">
							
							<fieldset>
								
								<legend style="width: 30%;">Category</legend> 
								
								<select name="category" id="category" class="form-control" style="background: transparent; border: 0; margin-top: 0; min-height: 48px;">    
									<option value="Direct Report" selected>Direct Report</option>     
									<option value="Peer">Peer</option>     
								</select>
								
							</fieldset>
											
						</div>
						
					</div>
					
				</div>  
						

				<div class="col-xs-12 col-md-4 text-center"> 
					
					<button href="javascript:void(0);" class="btn btn-primary add-to-list" data-action="directreport">
						
						<b>Add</b>
					
					</button> 
						
				</div> 
				
			</form> 
		</div>

		<div class="col-xs-12 col-md-12 evaluators_tmp"></div>
		
	</div> 

	<!-- Exmas Footer - Multi Step Pages Footer -->

    <div class="col-md-12 exams-footer">
        
        <div class="col-md-12" style="padding-bottom:10px; padding-top:10px;">
        
            <div class="col-xs-6 back-to-prev-question-wrapper text-right survey-quest-direction survey-quest-direction-left" style="">
            
                <a href="javascript:void(0);" id="reset">
            
                    <!-- <i class="fa fa-angle-left"></i> &nbsp;  -->
					Reset
            
                </a>
            
            </div>            
            
            
            <div class="col-xs-6 go-to-next-question-wrapper text-left survey-quest-direction survey-quest-direction-right">
               
                <a href="javascript:void(0);" id="post-nominees" class="">
                   
                    Submit &nbsp; 
					<!-- <i class="fa fa-angle-right"></i> -->
                     
                </a>
            
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

<script src="<?php echo base_url() ?>asset/js/bootbox.min.js"></script>

<script src="<?php echo base_url() ?>asset/admin_asset/js/handlebars.min.js"></script>

<!-- Scripts -->

<script src="<?php echo base_url(); ?>asset/js/examwizard.min.js"></script><!-- Required -->

<script id="evaluators_tmp" type="text/x-handlebars-template">
	{{#if nominees.length }}
		{{#each nominees}}
		<div class="evaluator-list" data-index="{{@index}}">
			<p class="evaluator-con"><b class="evaluator-name">{{firstname}} {{lastname}}</b> {{category}}</p>
			<p class="evaluator-email">{{email}}</p>
			<p class="evaluator-con">{{phone}}<span class="fa fa-times remove-btn" style="cursor:pointer;color:red;font-size:20px;"></span></p>
		</div>
		{{/each}}
	{{else}}
		<div class="empty-content"> 
		</div>
	{{/if}}
</script>

<script>
//  nomination js here
(function(){
	let nominees = [];
	
	let source = document.getElementById("evaluators_tmp").innerHTML;
	let htmlstr = JSTemplate.compile(source)({ nominees: nominees });  
	$('.evaluators_tmp').html(htmlstr);  
	$('.count').html(nominees.length);  
	
	//remove action
	function removeAction(){
		$('body .remove-btn').on('click',function(){
			const index = $(this).closest('div.evaluator-list').data('index');
			nominees.splice(index, 1);
			source = document.getElementById("evaluators_tmp").innerHTML;
			htmlstr = JSTemplate.compile(source)({ nominees: nominees });  
			$('.evaluators_tmp').html(htmlstr); 
			$('.count').html(nominees.length);  
			removeAction();
		});
	}

	// add to list
	$('.add-to-list').on('click', function(){
		const firstname = $('input[name="first_name"]').val().trim();
		const lastname = $('input[name="last_name"]').val().trim();
		const email = $('input[name="email"]').val().trim();
		const phone = $('input[name="phone"]').val().trim();
		const category = $('select[name="category"]').val().trim();

		if(!firstname || !lastname || !email || !phone || !category){
			return alert('Fill in the required fields');
		}

		nominees.push({ firstname, lastname, email, phone, category });
		
		source = document.getElementById("evaluators_tmp").innerHTML;
		htmlstr = JSTemplate.compile(source)({ nominees: nominees });  
		$('.evaluators_tmp').html(htmlstr); 
		$('.count').html(nominees.length); 
		
		$('input').val('');
		
		removeAction();
	});

	$('#reset').on('click', function(){
		nominees = [];
		source = document.getElementById("evaluators_tmp").innerHTML;
		htmlstr = JSTemplate.compile(source)({ nominees: nominees });  
		$('.evaluators_tmp').html(htmlstr); 
		$('.count').html(nominees.length); 
	})

	$('#post-nominees').on('click', function(){
		
		const url = window.location.href;    
		const baseUrl = url.substring(0, url.indexOf('nominate'));
	
		// post nominees
		$.ajax({
			url: window.location.href.replace('evaluator-entry','save_nominees'),
			type: 'POST',
			data: { base_url: baseUrl, nominees: nominees },
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
						window.location.href = window.location.href.replace('evaluator-entry','thank-you');
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
