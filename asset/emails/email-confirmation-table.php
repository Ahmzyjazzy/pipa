AS
BEGIN
	
	SET @FULLNAME = ISNULL(@FULLNAME,'')
	SET @CLUBNAME = ISNULL(@CLUBNAME,'')
	SET @DUE_TYPE = ISNULL(@DUE_TYPE,'')
	SET @DUE_PERIOD = ISNULL(@DUE_PERIOD,'')
	SET @DUE_FREQUENCY = ISNULL(@DUE_FREQUENCY,'')
	SET @DUE_AMOUNT = ISNULL(@DUE_AMOUNT,0)
	SET @OUTSTANDING_BALANCE = ISNULL(@OUTSTANDING_BALANCE,0)
	SET @CLUB_LOGO = ISNULL(@CLUB_LOGO,'')

	-- Declare the return variable here
	DECLARE @HTML AS VARCHAR(MAX),@APP_WEBSITE AS VARCHAR(MAX), @EMAIL_TITLE AS VARCHAR(50),@EMAIL_ADDRESS VARCHAR(50),
	@TABLE_2_HTML AS VARCHAR(50),@TABLE_3_HTML AS VARCHAR(50),@MAIL_BODY VARCHAR(MAX),@NOTIFICATIN VARCHAR(50),@BACKGROUND VARCHAR(50)

	DECLARE @TRIMMED_NAME VARCHAR(200), @YEAR VARCHAR(5), @FORMAT_AMOUNT  VARCHAR(50), @FORMAT_BALANCE VARCHAR(50), @BALANCE_TEXT VARCHAR(500)
	SET @TRIMMED_NAME = RTRIM(LTRIM(@FULLNAME))
	SET @YEAR = YEAR(GETDATE())
	SET @FORMAT_AMOUNT = DBO.UDF_FORMAT_NUMBER(@DUE_AMOUNT)
	IF @OUTSTANDING_BALANCE >= 0
	BEGIN
		SET @BALANCE_TEXT = ''
	END
	ELSE
	BEGIN
		SET @BALANCE_TEXT = '* <br><br><span style="color:red;font-size:11px;"><strong>Please Note:</strong>Your Total Due is negative because you have overpaid on your account or paid in advance. The excess would be used in settling your next due</span>'
	END
	SET @FORMAT_BALANCE = DBO.UDF_FORMAT_NUMBER(@OUTSTANDING_BALANCE)
	---=============================================================

	---=============================================================
	---GENERAL DECLARATION
	   DECLARE @LOGO VARCHAR(50),@FB_IMAGE VARCHAR(50),@TWITTER VARCHAR(50),@backgroundImage VARCHAR(50)

	---=============================================================

	SET @APP_WEBSITE = DBO.UDF_SETTING_VALUE('APP_WEBSITE') + '/HTS/login'
	SET @EMAIL_ADDRESS = DBO.UDF_SETTING_VALUE('APP_EMAIL')
	SET @LOGO =  'swiftledger.com\HTS\IMAGES\EMAIL\email\fortuneheight.png'
	SET @BACKGROUND = 'swiftledger.com/HTS/IMAGES/email/swiftledger.png'
	SET @fb_Image = 'swiftledger.com\HTS\IMAGES\email\_fb.png'
	SET @twitter = 'swiftledger.com\HTS\IMAGES\email\black.png'
	SET @backgroundImage = 'swiftledger.com\HTS\EMAIL\email\back.png'

	IF @CLUB_LOGO != ''
	BEGIN
		SET @CLUB_LOGO = 'https://swiftledger.com/eDues/uploads/club/' + @CLUB_LOGO
	END
	ELSE
	BEGIN
		SET @CLUB_LOGO = 'https://swiftledger.com/eDues/assets/images/no-image.png'
	END

	SET @HTML = ''
	
	SET @HTML = @HTML + '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://opengraph.org/schema/"> <head>
        
<meta property="og:title" content="">

<!--<meta property="fb:page_id" content="43929265776">
-->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="referrer" content="origin">        
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
	
<link href="https://fonts.googleapis.com/css?family=Arvo:400,400i,700,700i|Lato:400,400i,700,700i|Merriweather:400,400i,700,700i|Merriweather+Sans:400,400i,700,700i|Open+Sans:400,400i,700,700i|Roboto:400,400i,700,700i" rel="stylesheet"><!--<![endif]-->

</head>

<body style="height: 100%;margin: 0;padding: 0;width: 100%;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #348018;">
	<!---->
	<center>
    
		<table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;height: 100%;margin: 0;padding: 0;width: 100%;background-color: #348018;">
			
            <tr>
			
            	<td align="center" valign="top" id="bodyCell" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;height: 100%;margin: 0;padding: 0;width: 100%;border-top: 0;">
			
            		<!-- BEGIN TEMPLATE // -->
					<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
			
            			<tr>
			
            				<td align="center" valign="top" id="templatePreheader" style="background:#348018 none no-repeat center/cover;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #348018;background-image: none;background-repeat: no-repeat;background-position: center;background-size: cover;border-top: 0;border-bottom: 0;padding-top: 15px;padding-bottom: 15px;">
								<!--[if (gte mso 9)|(IE)]>
								<table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
								<tr>
								<td align="center" valign="top" width="600" style="width:600px;">
								<![endif]-->
						
                        		<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;max-width: 600px !important;">
						
                        			<tr>
						
                        				<td valign="top" class="preheaderContainer" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"></td>
						
                        			</tr>
						
                        		</table>
						
                        		<!--[if (gte mso 9)|(IE)]>
								</td>
								</tr>
								</table>
								<![endif]-->
							</td>
						
                        </tr>
                        
						<tr>
							
                            <td align="center" valign="top" id="templateHeader" style="background:#eeeeee none no-repeat center/cover;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #eeeeee;background-image: none;background-repeat: no-repeat;background-position: center;background-size: cover;border-top: 0;border-bottom: 0;padding-top: 9px;padding-bottom: 3px;">
								<!--[if (gte mso 9)|(IE)]>
								<table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
								<tr>
								<td align="center" valign="top" width="600" style="width:600px;">
								<![endif]-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;max-width: 600px !important;">
									<tr>
										<td valign="top" class="headerContainer" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
<tbody class="mcnTextBlockOuter">

	<tr>
		<td valign="top" class="mcnTextBlockInner" style="padding-top: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
			<!--[if mso]>
			<table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
			<tr>
			<![endif]-->
			
			<!--[if mso]>
			<td valign="top" width="600" style="width:600px;">
			<![endif]-->
			<table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width: 100%;min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" width="100%" class="mcnTextContentContainer">
				<tbody><tr>
					
					<td valign="top" class="mcnTextContent" style="padding: 0px 18px 9px;font-family: Arvo, Courier, Georgia, serif;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;color: #202020;font-size: 16px;line-height: 150%;text-align: left;">
					
						<h1 style="text-align: center;display: block;margin: 0;padding: 0;color: #202020;font-family: Helvetica;font-size: 26px;font-style: normal;font-weight: bold;line-height: 125%;letter-spacing: normal;"><span style="font-family:merriweather sans,helvetica neue,helvetica,arial,sans-serif">E-DUES</span></h1>

<p style="text-align: center;font-family: Arvo, Courier, Georgia, serif;margin: 10px 0;padding: 0;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #202020;font-size: 16px;line-height: 150%;"><span style="font-family:merriweather sans,helvetica neue,helvetica,arial,sans-serif">Club Management App</span></p>

					</td>
				</tr>
			</tbody></table>
			<!--[if mso]>
			</td>
			<![endif]-->
			
			<!--[if mso]>
			</tr>
			</table>
			<![endif]-->
		</td>
	</tr>
</tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
<tbody class="mcnImageBlockOuter">
		<tr>
			<td valign="top" style="padding: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnImageBlockInner">
				<table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
					<tbody><tr>
						<td class="mcnImageContent" valign="top" style="padding-right: 9px;padding-left: 9px;padding-top: 0;padding-bottom: 0;text-align: center;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
							
								
									<img align="center" alt="" src="https://gallery.mailchimp.com/74fb4bfa822615daba98a27d7/images/8fe8bfac-7a3b-4690-8996-6f077b009594.png" width="250" style="max-width: 500px;padding-bottom: 0;display: inline !important;vertical-align: bottom;border: 0;height: auto;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;" class="mcnRetinaImage">
								
							
						</td>
					</tr>
				</tbody></table>
			</td>
		</tr>
</tbody>
</table></td>
									</tr>
								</table>
								<!--[if (gte mso 9)|(IE)]>
								</td>
								</tr>
								</table>
								<![endif]-->
							</td>
						</tr>
						<tr>
							<td align="center" valign="top" id="templateBody" style="background:#ffffff none no-repeat center/cover;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #ffffff;background-image: none;background-repeat: no-repeat;background-position: center;background-size: cover;border-top: 0;border-bottom: 0;padding-top: 9px;padding-bottom: 9px;">
								<!--[if (gte mso 9)|(IE)]>
								<table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
								<tr>
								<td align="center" valign="top" width="600" style="width:600px;">
								<![endif]-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;max-width: 600px !important;">
									<tr>
										<td valign="top" class="bodyContainer" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
<tbody class="mcnTextBlockOuter">
	<tr>
		<td valign="top" class="mcnTextBlockInner" style="padding-top: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
			<!--[if mso]>
			<table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
			<tr>
			<![endif]-->
			
			<!--[if mso]>
			<td valign="top" width="600" style="width:600px;">
			<![endif]-->
			<table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width: 100%;min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" width="100%" class="mcnTextContentContainer">
				<tbody><tr>
					
					<td valign="top" class="mcnTextContent" style="padding: 0px 18px 9px;color: #555555;font-family: Lato, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;font-size: 16px;line-height: 150%;text-align: left;">
					
						<h1 style="display: block;margin: 0;padding: 0;color: #202020;font-family: Helvetica;font-size: 26px;font-style: normal;font-weight: bold;line-height: 125%;letter-spacing: normal;text-align: left;"><span style="font-family:open sans,helvetica neue,helvetica,arial,sans-serif">Hello ' + @TRIMMED_NAME + ',</span></h1>

					</td>
				</tr>
			</tbody></table>
			<!--[if mso]>
			</td>
			<![endif]-->
			
			<!--[if mso]>
			</tr>
			</table>
			<![endif]-->
		</td>

	</tr>

</tbody>

</table>

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;table-layout: fixed !important;">

<tbody class="mcnDividerBlockOuter">

	<tr>

		<td class="mcnDividerBlockInner" style="min-width: 100%;padding: 5px 18px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
			
            <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-top: 2px solid #EEEEEE;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
			
            	<tbody>
                
                <tr>
			
            		<td style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
			
            			<span></span>
			
            		</td>
			
            	</tr>
			
            </tbody>
            
            </table>
<!--            
			<td class="mcnDividerBlockInner" style="padding: 18px;">
			<hr class="mcnDividerContent" style="border-bottom-color:none; border-left-color:none; border-right-color:none; border-bottom-width:0; border-left-width:0; border-right-width:0; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0;" />
-->
		</td>

	</tr>

</tbody>

</table>

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
              	<!--[if mso]>
				<table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
				<tr>
				<![endif]-->
			    
				<!--[if mso]>
				<td valign="top" width="600" style="width:600px;">
				<![endif]-->
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width: 100%;min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding: 0px 18px 9px;color: #555555;font-family: Lato, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;font-size: 16px;line-height: 150%;text-align: left;">
                        
                            <p style="color: #555555;font-family: Lato, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;margin: 10px 0;padding: 0;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;font-size: 16px;line-height: 150%;text-align: left;">A new invoice&nbsp;has just been generated for you.<br>
<br>
Here are your invoice&nbsp;details:<br><br>
<img src="' + @CLUB_LOGO + '" alt="clublogo" class="mcnFollowBlockIcon" width="36" style="width: 100px";max-width: 100px;display: block;border: 0;height: auto;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;"><br>
Association: <strong> ' + @CLUBNAME + '</strong><br>
Due: <strong>' + @DUE_TYPE + '</strong><br>
Frequency: <strong>' + @DUE_FREQUENCY + '</strong><br>
Period: <strong>' + @DUE_PERIOD + '</strong><br>
Amount: <strong>&#8358;' + CAST(@FORMAT_AMOUNT AS VARCHAR(50)) + '</strong><br>
Total Due: <strong>&#8358;' + CAST(@FORMAT_BALANCE AS VARCHAR(50)) + '</strong>'+ @BALANCE_TEXT +'<br>
<br>
Thank you for using <a href="https://swiftledger.com/eDues/?login" target="_blank">E-Dues.</a> Please remember to pay your due as soon as possible.<br>
<br>
You can reach us via email on <a href="mailto:info@swiftledger.com" target="_blank" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #007C89;font-weight: normal;text-decoration: underline;">info@swiftledger.com</a>.</p>

                        </td>
                    </tr>
                </tbody></table>
				<!--[if mso]>
				</td>
				<![endif]-->
                
				<!--[if mso]>
				</tr>
				</table>
				<![endif]-->
            </td>
        </tr>
    </tbody>
</table></td>
									</tr>
								</table>
								<!--[if (gte mso 9)|(IE)]>
								</td>
								</tr>
								</table>
								<![endif]-->
							</td>
						</tr>
						<tr>
							<td align="center" valign="top" id="templateFooter" style="background:#348018 none no-repeat center/cover;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #348018;background-image: none;background-repeat: no-repeat;background-position: center;background-size: cover;border-top: 0;border-bottom: 0;padding-top: 5px;padding-bottom: 5px;">
								<!--[if (gte mso 9)|(IE)]>
								<table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
								<tr>
								<td align="center" valign="top" width="600" style="width:600px;">
								<![endif]-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;max-width: 600px !important;">
									<tbody><tr>
										<td valign="top" class="footerContainer" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
<tbody class="mcnFollowBlockOuter">
	<tr>
		<td align="center" valign="top" style="padding: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnFollowBlockInner">
			<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentContainer" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
<tbody><tr>
	<td align="center" style="padding-left: 9px;padding-right: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
		<table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnFollowContent">
			<tbody><tr>
				<td align="center" valign="top" style="padding-top: 9px;padding-right: 9px;padding-left: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
					<table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
						<tbody><tr>
							<td align="center" valign="top" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
								<!--[if mso]>
								<table align="center" border="0" cellspacing="0" cellpadding="0">
								<tr>
								<![endif]-->
								
									<!--[if mso]>
									<td align="center" valign="top">
									<![endif]-->
									
										<table align="left" border="0" cellpadding="0" cellspacing="0" class="mcnFollowStacked" style="display: inline;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
												
											<tbody><tr>
												<td align="center" valign="top" class="mcnFollowIconContent" style="padding-right: 10px;padding-bottom: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
													<a href="http://www.facebook.com" target="_blank" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/dark-facebook-96.png" alt="Facebook" class="mcnFollowBlockIcon" width="36" style="width: 36px";max-width: 36px;display: block;border: 0;height: auto;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;"></a>
												</td>
											</tr>
											
											
										</tbody></table>
									
									
									<!--[if mso]>
									</td>
									<![endif]-->
								
									<!--[if mso]>
									<td align="center" valign="top">
									<![endif]-->
									
										<table align="left" border="0" cellpadding="0" cellspacing="0" class="mcnFollowStacked" style="display: inline;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
												
											<tbody><tr>
												<td align="center" valign="top" class="mcnFollowIconContent" style="padding-right: 10px;padding-bottom: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
													<a href="http://www.twitter.com/" target="_blank" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/dark-twitter-96.png" alt="Twitter" class="mcnFollowBlockIcon" width="36" style="width: 36px";max-width: 36px;display: block;border: 0;height: auto;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;"></a>
												</td>
											</tr>
											
											
										</tbody></table>
									
									
									<!--[if mso]>
									</td>
									<![endif]-->
								
									<!--[if mso]>
									<td align="center" valign="top">
									<![endif]-->
									
										<table align="left" border="0" cellpadding="0" cellspacing="0" class="mcnFollowStacked" style="display: inline;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
												
											<tbody><tr>
												<td align="center" valign="top" class="mcnFollowIconContent" style="padding-right: 10px;padding-bottom: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
													<a href="http://www.linkedin.com" target="_blank" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/dark-linkedin-96.png" alt="LinkedIn" class="mcnFollowBlockIcon" width="36" style="width: 36px";max-width: 36px;display: block;border: 0;height: auto;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;"></a>
												</td>
											</tr>
											
											
										</tbody></table>
									
									
									<!--[if mso]>
									</td>
									<![endif]-->

									<!--[if mso]>
									<td align="center" valign="top">
									<![endif]-->
									
									<table align="left" border="0" cellpadding="0" cellspacing="0" class="mcnFollowStacked" style="display: inline;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
												
											<tbody><tr>
												<td align="center" valign="top" class="mcnFollowIconContent" style="padding-right: 10px;padding-bottom: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
													<a href="http://www.twitter.com/" target="_blank" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><img src="https://swiftledger.com/eDues/assets/icons/google-play-store.png" alt="Twitter" class="mcnFollowBlockIcon" width="36" style="width: 36px";max-width: 36px;display: block;border: 0;height: auto;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;"></a>
												</td>
											</tr>
											
											
										</tbody></table>
									
									
									<!--[if mso]>
									</td>
									<![endif]-->

									<!--[if mso]>
									<td align="center" valign="top">
									<![endif]-->
									
									<table align="left" border="0" cellpadding="0" cellspacing="0" class="mcnFollowStacked" style="display: inline;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
												
											<tbody><tr>
												<td align="center" valign="top" class="mcnFollowIconContent" style="padding-right: 0;padding-bottom: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
													<a href="http://www.linkedin.com" target="_blank" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><img src="https://swiftledger.com/eDues/assets/icons/apple-app-store.png" alt="LinkedIn" class="mcnFollowBlockIcon" width="36" style="width: 36px";max-width: 36px;display: block;border: 0;height: auto;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;"></a>
												</td>
											</tr>
											
											
										</tbody></table>
									
									
									<!--[if mso]>
									</td>
									<![endif]-->

								
								<!--[if mso]>
								</tr>
								</table>
								<![endif]-->
							</td>
						</tr>
					</tbody></table>
				</td>
			</tr>
		</tbody></table>
	</td>
</tr>
</tbody></table>

		</td>
	</tr>
</tbody>

</table>

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">

<tbody class="mcnTextBlockOuter">
	
    <tr>
		
        <td valign="top" class="mcnTextBlockInner" style="padding-top: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
			
            <!--[if mso]>
			<table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
			<tr>
			<![endif]-->
			
			<!--[if mso]>
			<td valign="top" width="600" style="width:600px;">
			<![endif]-->
			<table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width: 100%;min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" width="100%" class="mcnTextContentContainer">
				
                <tbody>
                
                <tr>
					
					<td valign="top" class="mcnTextContent" style="padding: 0px 18px 9px;line-height: 150%;text-align: center;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;color: #ffffff;font-family: ''Roboto'', ''Helvetica Neue'', Helvetica, Arial, sans-serif;font-size: 12px;">
					
						<div><span style="font-size:13px">
<strong>Phone</strong>:&nbsp;01 453 3418 (Mon-Fri from 9am-5pm)<br>
<strong>Email</strong>: <a href="mailto:info@swiftledger.com" target="_blank" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #dadada;font-weight: normal;text-decoration: underline;">info@swiftledger.com</a><br>
<br>
Copyright<strong> © ' + @YEAR + '&nbsp;</strong>HIGH TECH SYNERGY.&nbsp;All rights reserved.</span></div>

					</td>
				
                </tr>
                
			</tbody>
            
            </table>
			<!--[if mso]>
			</td>
			<![endif]-->
			
			<!--[if mso]>
			</tr>
			</table>
			<![endif]-->
		</td>

	</tr>

</tbody>

</table>

</td>
									
                                    </tr>
						
                        		</tbody>
                                
                                </table>
						
                        		<!--[if (gte mso 9)|(IE)]>
								</td>
								</tr>
								</table>
								<![endif]-->
						
                        	</td>
						
                        </tr>
								</table>
	
    						</td>
                            
						</tr>
	
    				</table>
					<!-- // END TEMPLATE -->
	
    			</td>
	
    		</tr>
	
    	</table>
	
    </center>
    
</body>
</html>

