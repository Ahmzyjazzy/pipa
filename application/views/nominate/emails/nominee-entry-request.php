<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nominee Submission Request</title>

</head>

<body>

<style>

.container {
  padding-right: 15px;
  padding-left: 15px;
   width:90%;
  margin-right: auto;
  margin-left: auto;
}

.col-md-12{
  padding-right: 15px;
  padding-left: 15px;
  
}

.mail-welcome-hdr{
	font-size:18px;
	padding-top:10px;
	padding-bottom:10px;
	margin-bottom:10px;
	margin-top:10px;
	background-color: #0071f6;
	text-transform: uppercase;
	font-family:Verdana, Geneva, sans-serif;
	font-weight: 700;
	color:#fff;
	text-align:center;
}

.mail-msg-usr-hdr{
	font-weight:600;
}

.mail-msg-cnt ul{
	padding-left:15px;
}

.mail-msg-cnt ul li{
	margin-top:10px;
	margin-bottom:10px;	
}

.msg-mail-cnct{
	color: #0071f6;
	font-weight:600;
}

.msg-mail-cnct a{
	text-decoration:none;
	color: #0071f6;
}

.mail-cust-name{
	font-weight:600;
}

.tp-contacts{
	padding-top:3px;
	overflow:auto;
	text-align:center;
}

.tp-contacts ul{
	padding-left:0px;
	display: inline-block;
}

.tp-contacts ul li{
	float:left;
	display:inline-block;
	margin-left:5px;
	margin-right:5px;	
	padding-right:15px;
	padding-left:10px;
	font-family: "AlegreyaSansSC-Thin";
	font-size:14px;
	font-weight:600;
	border-right:1px solid #000;
}

.tp-contacts ul li:last-child{
	border:none;
	padding-right:0px;
	margin-right:0px;
}

.top-logo{
	text-align:center;
}

</style>

<div class="" style="padding-bottom:30px; padding-top:30px; padding-left:0px; padding-right:0px; background-color:#cccccc; ">

	<div class="container" style="background-color:#fff; padding-bottom:20px; padding-top:20px;">
    
    	<div class="col-md-12">
            
            <div class="top-logo">
            	
                <img src="<?php echo base_url().'asset/images/logo.png' ?>" />
                                
            </div>

            
        </div>
        
        <div class="col-md-12">
        	
            <div class="mail-welcome-hdr">
				
			<strong>Evaluator Submission Request</strong>
				
            </div>
            
        </div>
        
        <div class="col-md-12">
        
			<div class="" style="margin-bottom:10px; padding-left:10px; line-height:25px;">

				Dear <strong> <?php if(!empty($participantDetail)){ echo ucfirst($participantDetail['first_name']).' '.ucfirst($participantDetail['last_name']); }?> </strong>,<br>

				You have been selected by  <strong><?php if(!empty($companyDetails)){ echo ucfirst($companyDetails['company_name']); }?></strong> to participate in a 
				180-degree Assessment exercise designed to provide you with feedback - from your Line Manager and Team Members - on your leadership impact. <br><br>

				However, because you do not have up to 5 team members, we require that you nominate some non-team members (at the same or lower grade level) with whom you 
				interact frequently during the course of your work day.<br><br>

				Your nomination will be sent to your manager for approval and if approved, will initiate the deployment of your assessment. <br><br> 
				If however your Line Manager rejects your nomination, you will receive a new nomination request email.<br>
				Thank you and we looking forward to receiving your nominations. 
				<br><br>

				Kindly click or copy the link below to submit your evaluators for the assessment.<br><br>

				<a href="<?php echo base_url() .'nominate/get-started/'. $survey_id .'/'. $participantDetail['survey_participant_id'] . '/'; ?>">
					<?php echo base_url() .'nominate/get-started/'. $survey_id .'/'. $participantDetail['survey_participant_id'] . '/'; ?>
				</a> 

				<br><br>
				
				Thank you.

			</div>
            
        </div>
        
    </div>
    
</div>

</body>
</html>