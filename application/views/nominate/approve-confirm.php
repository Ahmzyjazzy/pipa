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

    <style>
      body {
        overflow: hidden;
      }
      .survey-login-bx {
        overflow-y: scroll; 
        padding-bottom: 20px;
      }

      .survey-login-bx::-webkit-scrollbar {
        width: 5px;
      }

      /* Track */
      .survey-login-bx::-webkit-scrollbar-track {
      background: #f1f1f1; 
      }
      
      /* Handle */
      .survey-login-bx::-webkit-scrollbar-thumb {
        background: #888; 
      }

      /* Handle on hover */
      .survey-login-bx::-webkit-scrollbar-thumb:hover {
        background: #555; 
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
        .surveyWelcomeBodyText p {
            font-size: 16px;
            line-height: 14px;
            padding-bottom: 0;
            padding-top: 0;
          }

        .surveyWelcomeBodyText p {
            font-size: 16px;
            line-height: 14px;
            padding-bottom: 0;
            padding-top: 0;
            word-break: break-word;
        }

        .toggle-switch {
          --width: 38px;
          --height: 20px;
          --padding: 0px;
          --handle-size: calc(var(--height) - var(--padding) * 2);
          display: inline-block;
          outline-width: 0;
        }

        .toggle-switch > input {
          position: absolute;
          clip: rect(1px, 1px, 1px, 1px);
          clip-path: inset(50%);
          height: 1px;
          width: 1px;
          margin: -1px;
          overflow: hidden;
          cursor: pointer !important;
        }

        label {
          display: inline-grid;
          grid-template-columns: auto auto;
          column-gap: 10px;
          cursor: pointer !important;
        }

        .area {
          padding: 4px;
          margin: -4px;
        }

        .toggle-switch :active {
          outline-width: 0;
        }

        .background,
        .handle {
          transition: all 0.1s ease;
        }

        .background {
          display: inline-flex;
          flex-direction: row;
          align-items: center;
          width: var(--width);
          height: var(--height);
          border-radius: var(--height);
          padding: 0 var(--padding);
          vertical-align: text-bottom;
          user-select: none;
          background-color: darkgray;
          box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.25);
          overflow: hidden;
          transition: background-color .15s ease;
        }

        .toggle-switch:focus .area {
          outline: 1px dotted gray;  
        }

        .toggle-switch:active .area {
          outline-width: 0;
        }

        .toggle-switch:focus .background,
        .area:hover .background {
          background-color: gray;
        }

        .handle {
          width: var(--handle-size);
          height: var(--handle-size);
          background-color: white;
          border-radius: 50%;
          box-shadow:
            0 2px 4px rgba(0, 0, 0, 0.5),
            inset 0 2px 4px rgba(0, 0, 0, 0.15);
        }

        .handle:hover {
          background-color: white;
        }

        input:checked + label .area .background {
          background-color: lightgreen;
        }

        input:checked + label .area .handle {
          background-color: white;
          transform: translateX(calc(var(--width) - var(--handle-size)));
        }

    </style>
</head>

<body class="">

  <div class="sb-body-overlay e-view sb-hide">
        <div class="sb-loading">
            <svg class="circular" height="40" width="40">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="6" stroke-miterlimit="10"></circle>
            </svg>
			<p>Please wait...</p>
        </div>
    </div> 

    <div class="login-outer">
    
        
        <div class="login-bx survey-login-bx">
        	
            <div class="login-bx-bdy surveyWelcomeBody">
            	
                <div class="surveyWelcomeHdr">
                  
                  <a href="<?php echo base_url(); ?>nominate/approve/<?php echo $surveyor['survey_id'].'/'.$surveyor['survey_participant_id'].'/'; ?>">
                  <i class="fa fa-angle-left"></i></a> Approve or Reject Nominees
                    
                </div>
                
				        <div class="surveyWelcomeBodyText">
                    <?php 
                          foreach ($nominees as $nominee) {
                      ?>
                          <div class="evaluator-list" data-id="<?php echo $nominee['nominee_id']; ?>">
                            <p class="evaluator-con"><b class="evaluator-name"><?php echo $nominee['name']; ?></b><?php echo $nominee['evaluator_type']; ?></p>
                            <p class="evaluator-email"><?php echo $nominee['email']; ?></p>
                            <p class="evaluator-con"><?php echo $nominee['phone_number']; ?>
                            <div class="toggle-switch" tabindex="0">
                              <input type="checkbox" name="my_checkbox" id="checkbox-<?php echo $nominee['nominee_id']; ?>" 
                              <?php echo $nominee['approved'] == 1 ? 'checked' : ''; ?>/>
                              <label for="checkbox-<?php echo $nominee['nominee_id']; ?>">
                                <div class="area" aria-hidden="true">
                                  <div class="background">
                                    <div class="handle"></div>
                                  </div>
                                </div>
                                <span class="toggle-text"><?php echo $nominee['approved'] == 1 ? 'Approved' : 'Not Approved'; ?></span>
                              </label>
                            </div> 
                          </div>    
                      <?php
                          } //end foreach 
                      ?> 
                   
                </div>
                
                <div class="surveyWelcomeBodyBTN">
                
                	<button class="btn btn-primary" id="post-nominees-approval">
                        
                       Submit
                        
                    </button>
                                        
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

<script src="<?php echo base_url() ?>asset/js/bootbox.min.js"></script>

<script>
  $(function () { 

    $(".toggle-switch input").on('change', function(){
      const ischecked = $(this).is(':checked');
      const toggleText = $(this).siblings('label').find('.toggle-text');
      toggleText.html(ischecked ? 'Approved' : 'Not Approved');
    });

    $('#post-nominees-approval').on('click', function(){
		
      const url = window.location.href;    
      const baseUrl = url.substring(0, url.indexOf('nominate'));

      let nominees = [];
      $('.evaluator-list').each(function(i,elem){
        const $elem = $(elem);
        const obj = {
          nominee_id: $elem.data('id'),
          approved: $elem.find('input[type="checkbox"]').is(':checked') ? 1 : 0
        }
        nominees.push(obj)   
      });
    
      // post nominees
      $.ajax({
        url: window.location.href.replace('approve-confirm','approve_nominee'),
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
              window.location.href = window.location.href.replace('approve-confirm','approved-success');
            });
          }else{
            $('.alert-error').removeClass('hide').find('p').html(result.message); 
          }
          // success here
          console.log(result);
        }
      }); 

    });	


  });
</script>

</body>

</html>
