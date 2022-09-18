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

<div class="container pipa-bx surv-box">


<?php

	if(!empty($questions))
	{
		
		$sizeofAllQuestions			=	sizeof($questions);
	
	}else{
		
		$sizeofAllQuestions			=	0;
		
	}
	
	if ($this->session->flashdata('message')):

	?>
		
        <div class="col-md-12">
        
			<div class="alert alert-error">
			
				<a class="close" data-dismiss="alert">×</a>
				
				<?php 
				
					echo $this->session->flashdata('message');
				
				?>
			</div>
		
        </div>
        
	<?php 
		 endif;
		
		if($this->session->flashdata('success-message')):
	?>
      
      <div class="alert alert-info">
       
        <a class="close" data-dismiss="alert">×</a>
       
        <?php echo $this->session->flashdata('success-message');?>
    
    </div>
                    
    <?php 
    
    endif;
    
    ?>
                              			
    <div class="col-md-12">
        
        <div class="col-xs-12 col-md-9">
            
            <div class="surv-page-hdr-txt">
                
                360 assessment for <strong><?php if(!empty($participantDetails)){ echo ucfirst($participantDetails['first_name']).' '.ucfirst($participantDetails['last_name']); }?></strong>
                
            </div>
            
            <div class="surv-page-hdr-txt-section">
                
                Section <?php echo $currentSection; ?> of <?php echo $totalSections; ?>
            
            </div>
            
        </div>
        
        <div class="col-xs-12 col-md-3">
            
            <div class="">
                
                <div class="footer-question-number-wrapper text-center">
                
                    <div class="mt-4">
                        
                        Question
                         
                        <span id="current-question-number-label">1</span>
                
                        <span>of <b><?php echo $sizeofAllQuestions; ?></b></span>
                
                    </div>
                
                </div>
        
            </div>
            
        </div>
        
    </div>

    <div class="col-md-12">
    
        <div class="col-xs-12 col-md-12 exams-body">
        
            <form method="post" action="<?php echo base_url(); ?>survey/submit-survey/<?php echo $surveyor['survey_id'].'/'.$surveyor['survey_surveyor_id'].'/'.$surveyor['survey_participant_id']; ?>/" id="examwizard-question">
                
                <?php
                
                if(!empty($questions))
                {
                    
                    $countQuestions				=	1;
                    
                    $count						=	0;
                    
                    $styl						=	'';
					
					$userFilledCounter			=	0;
					
					$userFilledCounterQuest		=	1;
        
                    foreach($questions as $question)
                    {

						if(!empty($question['survey_competency_id']))
						{
							
							//check if this user has selected some answers previously
							
							$saveduserOpt		=	'';
							
							if(!empty($question['response_whole_number']))
							{
								
								$saveduserOpt	=	$question['response_whole_number'];
								
								$userFilledCounter++;
								
								$styl				=	'hidden';
								
							}else{
								
								if($countQuestions == 1)
								{
																		
									$styl				=	'';
									
								}else{
									
									if(!empty($userFilledCounter))
									{
										
										if($userFilledCounterQuest == '1')
										{
											
											$styl				=	'';
											//echo 'Count Questions = '.$countQuestions.'<br /><br />';
										
										}else{
											
											$styl				=	'hidden';
											//echo 'Got here 2 ('.$userFilledCounter.')<br /><br />';
											
										}
										
										$userFilledCounterQuest++;
										
									}else{
										
										$styl				=	'hidden';
									}
									
								}
						
							}
							
							echo '<div class="question '.$styl.'" data-question="'.$countQuestions.'">
							
								<div class="row quest-container">
									
									<div class="col-xs-12">
									
										<h2 class="question-title color-green"> '.$question['question'].'</h2>
									
									</div>
									
								</div>
							
								<div class="row mt-50 quest-options-container">
							
									<div class="col-xs-12">
							
										<div class="alert alert-danger hidden"></div>
							
										<div class="green-radio color-green">
							
											<ol type="1">
							
												<li class="font-size-30 answer-number">
													
													<label>
													  
													  <input class="selected-surv-option" lang="'.$question['survey_question_id'].'" type="radio" data-alternatetype="radio" name="fieldName['.$question['survey_question_id'].']" data-alternateName="answer['.$question['survey_question_id'].']" data-alternateValue="1.0"'; if(!empty($saveduserOpt)){ if($saveduserOpt == "1"){ echo 'checked="checked"'; } } echo 'value="1" id="answer-0-1"/>
													  
													  <span>1.0</span>
													  
													  <div class="div-option-text">Never</div>
													  
													</label>
												
												</li>
							
												<li class="font-size-30 answer-number">
													
													<label>
													   
													   <input class="selected-surv-option" lang="'.$question['survey_question_id'].'" type="radio" data-alternatetype="radio" name="fieldName['.$question['survey_question_id'].']" data-alternateName="answer['.$question['survey_question_id'].']" data-alternateValue="2.0"'; if(!empty($saveduserOpt)){ if($saveduserOpt == "2"){ echo 'checked="checked"'; } } echo ' value="2" id="answer-0-2"/>
		 
														<span>2.0</span>
													   
														<div class="div-option-text">Rarely</div>
														
													</label>
												
												</li>
							
												<li class="font-size-30 answer-number" >
												
													
													<label >
														
														<input class="selected-surv-option" lang="'.$question['survey_question_id'].'" type="radio" data-alternatetype="radio" name="fieldName['.$question['survey_question_id'].']" data-alternateName="answer['.$question['survey_question_id'].']" data-alternateValue="3.0"'; if(!empty($saveduserOpt)){ if($saveduserOpt == "3"){ echo 'checked="checked"'; } } echo ' value="3" id="answer-0-3"/>
		
														<span>3.0</span>
													
														<div class="div-option-text">Sometimes</div>
														
													</label>
												
												</li>
							
												<li class="font-size-30 answer-number">
																								
													<label >
														
														<input class="selected-surv-option" lang="'.$question['survey_question_id'].'" type="radio" data-alternatetype="radio" name="fieldName['.$question['survey_question_id'].']" data-alternateName="answer['.$question['survey_question_id'].']" data-alternateValue="4.0"'; if(!empty($saveduserOpt)){ if($saveduserOpt == "4"){ echo 'checked="checked"'; } } echo ' value="4" id="answer-0-4"/>
														
														<span>4.0</span>
		
														<div class="div-option-text"> Often</div>
														
													</label>
												
												</li>
												
												<li class="font-size-30 answer-number" >
													
													
													<label >
													
														<input class="selected-surv-option" lang="'.$question['survey_question_id'].'" type="radio" data-alternatetype="radio" name="fieldName['.$question['survey_question_id'].']" data-alternateName="answer['.$question['survey_question_id'].']" data-alternateValue="5.0"'; if(!empty($saveduserOpt)){ if($saveduserOpt == "5"){ echo 'checked="checked"'; } } echo ' value="5" id="answer-0-5"/>
		
														<span>5.0</span>
														
														<div class="div-option-text"> Always</div>
														
													</label>
													
												</li>
							
											</ol>
							
										</div>
							
									</div>
							
								</div>
							
							</div>';
							
						}else{
							
							$saveduserOpt		=	'';
							
							if(!empty($question['response_text']))
							{
								
								$saveduserOpt	=	$question['response_text'];
								
								$userFilledCounter++;
								
								$styl				=	'hidden';
								
							}else{
								
								if($countQuestions == 1)
								{
																		
									$styl				=	'';
									
								}else{
									
									if(!empty($userFilledCounter))
									{
										
										if($userFilledCounterQuest == '1')
										{
											
											$styl				=	'';
											//echo 'Count Questions = '.$countQuestions.'<br /><br />';
										
										}else{
											
											$styl				=	'hidden';
											//echo 'Got here 2 ('.$userFilledCounter.')<br /><br />';
											
										}
										
										$userFilledCounterQuest++;
										
									}else{
										
										$styl				=	'hidden';
									}
									
								}
						
							}
							
							echo '<div class="question '.$styl.'" data-question="'.$countQuestions.'">
        
								<div class="row">
									
									<div class="col-xs-12">
									
										<h2 class="question-title color-green">'.$question['question'].'</h2>
									
									</div>
									
								</div>
					
								<div class="row mt-50">
								   
									<div class="col-xs-12">
									   
										<div class="alert alert-danger hidden"></div>
									   
										<div class="form-group admin-form-setup">
										 
											<input type="text" name="fieldName['.$question['survey_question_id'].']" data-alternateName="answer['.$question['survey_question_id'].']" data-alternateValue="'; if(!empty($question['response_text'])){ echo $question['response_text'];  }else{ echo 'Text'; } echo '" value="'; if(!empty($question['response_text'])){ echo $question['response_text']; } echo '" id="answer-3-4" class="form-control surv-openended-val" placeholder="Fill Text..." autocomplete="off"/>
									   
										</div>
								   
									</div>
							   
								</div>
								
							</div>';
						}
                        
                        $countQuestions++;
                        
                        $count++;
                        
                
                    }
                    
                }
                
                ?>
        
                <input type="hidden" value="<?php if(!empty($userFilledCounter)){ echo $userFilledCounter + 1; }else{ echo '1'; } ?>" id="currentQuestionNumber" name="currentQuestionNumber" />
                
                <input type="hidden" value="<?php echo $sizeofAllQuestions; ?>" id="totalOfQuestion" name="totalOfQuestion" />
                
                <input type="hidden" value="[]" id="markedQuestion" name="markedQuestions" />
                
                <input type="hidden" value="<?php echo $currentSection; ?>" name="currentSection" />
                
                <button type="submit" class="btn btn-primary submt-surv" style="display:none;">Submit</button>
                
            </form>
            
        </div>
    
        <div class="col-xs-12 col-md-12 section-summary" style="display:none;" id="quick-access-section">
            
            <div class="surveyWelcomeHdr">
                        
               Great Job, Here's a summary of your survey
                
            </div>
                    
            <table class="table table-responsive table-hover text-center">
            
                
                <tbody>
                
                    <?php
                    
                    if(!empty($questions))
                    {
                    
                        $summaryCount		=	1;
                            
                        foreach($questions as $summary)
                        {
                            
							if(!empty($summary['survey_competency_id']))
							{
								
								$compStyle		= '';
								
							}else{
								
								$compStyle		= 'surv-open-tbl-td';
							}
							
                            echo '<tr class="question-response-rows" data-question="'.$summaryCount.'">
                                
                                <td>
                                    
                                    '.$summaryCount.'.
                                    
                                </td>
                                
                                <td>
                                    
                                    <div class="">
                                        
                                        <div class="" style="text-align:left;">
                                        
                                            '.$summary['question'].'
                                            
                                        </div>
                                        
                                    </div>
                                
                                </td>
                            
                                <td class="'.$compStyle.'">
								
								<div class="question-response-rows-value question-response-rows-value-dv">';
									
									if(!empty($summary['survey_competency_id']))
									{
										
										if(!empty($summary['response_whole_number']))
										{
											
											echo $summary['response_whole_number'].'.0';
											
										}else{
											
											echo '-';
										}
										
									}else{
										
										if(!empty($summary['response_text']))
										{
											
											echo $summary['response_text'];
											
										}else{
											
											echo '-';
										}
										
									}
									
									echo '</div>
								
								</td>
								
								<td class="'.$compStyle.'">
								
									<div class="surv-summary-edit">
										
										
										<a href="javascript:void(0);" class="marked-link show-mrked-lnk" data-question="'.$summaryCount.'">Edit</a>
																			
									</div>
								
								</td>
                            
                            </tr>';
                            
                            $summaryCount++;
                            
                        }
                    
                    }
                    
                    ?>
                    
                </tbody>
                
            </table>
           
            <div class="col-xs-12 col-md-12">
                
                <div class="col-xs-1 col-md-4">
                
                </div>
                
                <div class="col-xs-12 col-md-4 text-center">
                	
                    <div class="quick-access-cont" style="padding-top:10px;">
                    
                        <a href="javascript:void(0)" class="quick-access-cont-left" id="quick-access-prev">
                        
                            <i class="fa fa-angle-left"></i> &nbsp; Back
                        
                        </a>
                     
                        <span class="alert alert-info" id="quick-access-info"></span>
                    
                        <a href="javascript:void(0)" class="quick-access-cont-right" id="quick-access-next">
                        
                            Next &nbsp; <i class="fa fa-angle-right"></i>
                        
                        </a>
                    
                    </div>
                    
                    <?php
					
					if($totalSections > 1)
					{
						
						if($currentSection == $totalSections)
						{
							
                            
							echo '<div class="btn btn-primary survey-continue-sect-2">
								
								Submit  &nbsp; <i class="fa fa-angle-right"></i>
							
							</div>';
					
						}else{
							
							echo '<div class="btn btn-primary survey-continue-sect-2">
								
								Continue to section 2  &nbsp; <i class="fa fa-angle-right"></i>
							
							</div>';
							
						}
						
					}else{
						
						echo '<div class="btn btn-primary survey-continue-sect-2">
								
								Submit  &nbsp; <i class="fa fa-angle-right"></i>
							
							</div>';
							
					}
					
					?>
           
                </div>
                
                <div class="col-xs-1 col-md-4">
                
                </div>
                
            </div>
            
        </div>
    
    </div>

	<!-- Exmas Footer - Multi Step Pages Footer -->
    
    <div class="col-md-12 exams-footer">
        
        <div class="col-md-12" style="padding-bottom:10px; padding-top:10px;">
        
            <div class="col-xs-6 back-to-prev-question-wrapper text-right survey-quest-direction survey-quest-direction-left" style="">
            
                <a href="javascript:void(0);" id="back-to-prev-question" class=" disabled">
            
                    <i class="fa fa-angle-left"></i> &nbsp; Previous
            
                </a>
            
            </div>
            
            
            
            <div class="col-xs-6 go-to-next-question-wrapper text-left survey-quest-direction survey-quest-direction-right">
               
                <a href="javascript:void(0);" id="go-to-next-question" class="">
                   
                    Next &nbsp; <i class="fa fa-angle-right"></i>
                     
                </a>
            
            </div>
        
        </div>
        
<!--        <div class="visible-xs">
        
            <div class="clearfix"></div>
        
            <div class="mt-50"></div>
        
        </div>-->
        
        <div class="col-sm-2">
           
           <!--<div class="mark-unmark-wrapper" data-question="1000" style="display:none;">
                
                <a href="javascript:void(0);" class="mark-question btn btn-success" data-question="1000">
                    
                    <b>MARK</b>
                    
                </a>
                
                <a href="javascript:void(0);" class="hidden unmark-question btn btn-success" data-question="1000">
                    
                    <b>UNMARK</b>
                    
                </a>
                
            </div>-->
                    
            <?php
                    
            if(!empty($questions))
            {				
                $markCount			=	1;
                
                $markstyl			=	'';
                
               /* foreach($questions as $mark)
                {
                    
                    if($markCount == 1)
                    {
                        
                        $markstyl				=	'';
                        
                    }else{
                        
                        $markstyl				=	'hidden';
                        
                    }
                        
                    echo '<div class="mark-unmark-wrapper '.$markstyl.'" data-question="'.$markCount.'">
                        
                        <a href="javascript:void(0);" class="mark-question btn btn-success" data-question="'.$markCount.'">
                            
                            <b>MARK</b>
                            
                        </a>
                        
                        <a href="javascript:void(0);" class="hidden unmark-question btn btn-success" data-question="'.$markCount.'">
                            
                            <b>UNMARK</b>
                            
                        </a>
                        
                    </div>';
                    
                    $markCount++;
                    
                }*/
            
            }
            
            ?>       
            
        </div>
        
        <div class="col-xs-12 col-md-12 footer-finish-question-wrapper text-center" style="margin-top:10px;">
           
        	<div class="col-xs-1 col-md-4">
                    
            </div>
            
            <div class="col-xs-10 col-md-4 text-center">
    
                <!--<div class="btn btn-primary survey-continue-sect-2">
                    
                    Continue to section 2  &nbsp; <i class="fa fa-angle-right"></i>
                
                </div>-->
       
                <a href="javascript:void(0);" id="finishExams" class="btn btn-primary disabled" style="display:none;">
                
                    <b>Finish</b>
                
                </a>
                
                <a href="javascript:void(0);" id="backToSummary" class="btn btn-primary" style="display:none;">
                
                    <b>Back to Summary</b>
                
                </a>
                
                <a id="saveAndContinue" class="btn btn-primary">
                
                    <b>Save and Continue Later</b>
                
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

<script src="<?php echo base_url() ?>asset/js/bootbox.min.js"></script>

<!-- Scripts -->

<script src="<?php echo base_url(); ?>asset/js/examwizard.min.js"></script><!-- Required -->

<script>
 var examWizard = $.fn.examWizard({
    currentQuestionSelector:'#currentQuestionNumber',
    totalOfQuestionSelector:'#totalOfQuestion',
    formSelector:           '#examwizard-question',
    currentQuestionLabel:   '#current-question-number-label',
    alternateNameAttr:      'data-alternateName',
    alternateValueAttr:     'data-alternateValue',
    alternateTypeAttr:      'data-alternateType',
    quickAccessOption: {
        quickAccessSection:     '#quick-access-section',
        enableAccessSection:    true,
        quickAccessPagerItem:   '10',
        quickAccessInfoSelector:'#quick-access-info',
        quickAccessPrevSelector:'#quick-access-prev',
        quickAccessNextSelector:'#quick-access-next',
        quickAccessInfoSeperator:'/',
        quickAccessRow:         '.question-response-rows',
        quickAccessRowValue:    '.question-response-rows-value',
        quickAccessDefaultRowVal:'-',
        quickAccessRowValSeparator: ', ',
        nextCallBack            :function(){},
        prevCallBack            :function(){},
    },
    nextOption: {
        nextSelector:           '#go-to-next-question',
        allowadNext:            true,
        callBack:               function(){ var currentQuestion = $('#currentQuestionNumber').val(); var totalQuestion = $('#totalOfQuestion').val(); if(currentQuestion == totalQuestion){ $('#finishExams').show(); $('#backToSummary').hide(); $('#saveAndContinue').hide(); }else{ $('#finishExams').hide(); $('#saveAndContinue').show(); }},
        breakNext:             function(){return false;},
    },
    prevOption: {
        prevSelector:           '#back-to-prev-question', 
        allowadPrev:            true,
        allowadPrevOnQNum:      2,
        callBack:               function(){ var currentQuestion = $('#currentQuestionNumber').val(); var totalQuestion = $('#totalOfQuestion').val(); if(currentQuestion == totalQuestion){ $('#finishExams').show(); $('#backToSummary').hide(); $('#saveAndContinue').hide(); }else{ $('#finishExams').hide(); $('#saveAndContinue').show(); }},
        breakPrev:              function(){return false;},
    },
    finishOption: {
        enableAndDisableFinshBtn:true,
        enableFinishButtonAtQNum:'onLastQuestion',
        finishBtnSelector:      '#finishExams',
        enableModal:            true,
        finishModalTarget:      '#finishExamsModal',
        finishModalAnswerd:     '.finishExams-total-answerd',
        finishModalMarked:      '.finishExams-total-marked',
        finishModalRemaining:   '.finishExams-total-remaining',
        callBack:               function(){ $('.exams-body').hide(); $('.exams-footer').hide(); $('.footer-question-number-wrapper').hide(); $('.section-summary').show(); }
    },
    markOption: {
        markSelector:           '.mark-question',
        unmarkSelector:         '.unmark-question',
        markedLinkSelector:     '.marked-link',
        markedQuestionsSelector:'#markedQuestion',
        markedLabel:            'Marked',
        markUnmarkWrapper:      '.mark-unmark-wrapper',
        enableMarked:           true,
        markCallBack:           function(){ },
        unMarkCallBack:         function(){ },
    },
    cookiesOption: {
        enableCookie:           false,
        cookieKey:              '',
        expires:                1*24*60*60*1000 // 1 day
    }
});
</script>

<script>

	var wasSubmitted 	= 	false;
	
	$(document).ready(function(e) {
		
		$('#current-question-number-label').html($('#currentQuestionNumber').val());
		
		$('.selected-surv-option').click(function(){
			
			var question_id		=	$(this).attr('lang');
			
			var question_val	=	$(this).val();
			
			//alert('Question ID = '+question_id+' Selected Value = '+question_val);
				
		});
		
		checkUserFilledFinishPage();
		
		$('.survey-continue-sect-2').click(function(){
						
			bootbox.confirm({
				message: "Are you sure you want to Submit this Survey?",
				buttons: {
					confirm: {
						label: 'Yes',
						className: 'btn-success'
					},
					cancel: {
						label: 'No',
						className: 'btn-danger'
					}
				},
				centerVertical: true,
				callback: function (result) {
					
					//console.log('This was logged in the callback: ' + result);
					if(result){
						
						if(!wasSubmitted)  //this here is for checking if this approval button has been clicked previously
						{
							wasSubmitted = true;
							
							$('.submt-surv').click();
						
						}else{
							
							return false;
							
						}
						
					}else{
						
						
					}
			
				}
			});
			
		});
		
		$('.surv-openended-val').keyup(function(){
			
			var	userresponse			=	$(this).val();
						
			$(this).attr('data-alternateValue', userresponse);
			
		});
		
		$('.mark-question').click();
		
		$('.surv-summary-edit').click(function(){
			
			$('.section-summary').hide();
			
			$('#finishExams').hide();
			
			$('.footer-question-number-wrapper').show();
			
			$('#backToSummary').show();
			
			$('.exams-body').show();
			
			$('.exams-footer').show(); 	
			
		});
		
		$('#backToSummary').click(function(){
			
			$('#backToSummary').hide();
			
			$('.footer-question-number-wrapper').hide();
			
			$('.exams-body').hide();
			
			$('.exams-footer').hide(); 	
			
			$('.section-summary').show();
			
		});
		
		$('#saveAndContinue').click(function(){
			
			bootbox.confirm({
				message: "Are you sure you want to Save and Continue Later?",
				buttons: {
					confirm: {
						label: 'Yes',
						className: 'btn-success'
					},
					cancel: {
						label: 'No',
						className: 'btn-danger'
					}
				},
				centerVertical: true,
				callback: function (result) {
					
					//console.log('This was logged in the callback: ' + result);
					if(result){
						
						if(!wasSubmitted)  //this here is for checking if this approval button has been clicked previously
						{
							wasSubmitted = true;
							
							$('.submt-surv').click();
						
						}else{
							
							return false;
							
						}
						
					}else{
						
						
					}
			
				}
			});
	
		});
		
	});
	
	
	function checkUserFilledFinishPage()
	{
		
		var totalQuestionCheck 			=	$('#totalOfQuestion').val();
		
		var currentPageCheck			=	$('#currentQuestionNumber').val();	
		
		if(currentPageCheck == totalQuestionCheck)
		{
			
			$('#finishExams').removeClass('disabled'); 
			
			$('#finishExams').show(); 
			
			$('#backToSummary').hide(); 
			
			$('#saveAndContinue').hide();
			
		}
		
	}

</script>

</body>

</html>
