<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nominee Aoproval Notices</title>

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
				
				Nominee approval notice
                
            </div>
            
        </div>
        
        <div class="col-md-12">
        
			<div class="" style="margin-bottom:10px; padding-left:10px; line-height:25px;">
				
				Dear <strong> <?php if(!empty($lineManager)){ echo ucfirst($lineManager['line_manager_name']); }?> </strong>,<br>

				Please be informed that your Direct Report, <?php if(!empty($participantDetail)){ echo ucfirst($participantDetail['first_name']).' '.ucfirst($participantDetail['last_name']); }?>, 
				has been selected for a 180-degree Assessment.<br>
				<?php if(!empty($participantDetail)){ echo ucfirst($participantDetail['first_name']).' '.ucfirst($participantDetail['last_name']); }?> does not have the required number of Team Members 
				but has nominated the following non-team members to provide feedback on his/her leadership impact.<br><br>

				As <?php if(!empty($participantDetail)){ echo ucfirst($participantDetail['first_name']).' '.ucfirst($participantDetail['last_name']); }?> Line Manager, 
				we request that you kindly approve or reject <?php if(!empty($participantDetail)){ echo ucfirst($participantDetail['first_name']).' '.ucfirst($participantDetail['last_name']); }?> nominations. 
				You will find the nominations by clicking here or copying this link into your browser.
				Thank you and we looking forward to your feedback.  <br> <br>
				
				kindly click the link below to help approve his nominees. <br><br>

				<a href="<?php echo base_url() .'nominate/approve/'. $survey['survey_id'] .'/'. $participantDetail['survey_participant_id'] . '/'; ?>">
					<?php echo base_url() .'nominate/approve/'. $survey['survey_id'] .'/'. $participantDetail['survey_participant_id'] . '/'; ?>
				</a> 		
				<br><br>
				
				Thank you.
			</div>
            
        </div>
        
    </div>
    
</div>

</body>
</html>