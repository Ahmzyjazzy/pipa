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
  
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/userlte/dist/css/style.css">
 
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

<div class="container" style="margin:50px auto">
<h1>Cookie-enabled Exam Wizard Plugin Example</h1>
<div class="col-xs-9">

    <form id="examwizard-question">
        
        <div class="question" data-question="1">
        
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="question-title color-green">Q. Set Your Question Here?</h2>
                </div>
            </div>
        
            <div class="row mt-50">
        
                <div class="col-xs-12">
        
                    <div class="alert alert-danger hidden"></div>
        
                    <div class="green-radio color-green">
        
                        <ol type="A">
        
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[0]" data-alternateName="answer[0]" data-alternateValue="A" value="1" id="answer-0-1"/><label for="answer-0-1" class="answer-text"><span></span>BE 1 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
        
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[0]" data-alternateName="answer[0]" data-alternateValue="B" value="2" id="answer-0-2"/><label for="answer-0-2" class="answer-text"><span></span>BE 1 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
        
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[0]" data-alternateName="answer[0]" data-alternateValue="C" value="3" id="answer-0-3"/><label for="answer-0-3" class="answer-text"><span></span>BE 1 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
        
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[0]" data-alternateName="answer[0]" data-alternateValue="D" value="4" id="answer-0-4"/><label for="answer-0-4" class="answer-text"><span></span>BE 1 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
        
                        </ol>
        
                    </div>
        
                </div>
        
            </div>
        
        </div>
        
        <div class="question hidden" data-question="2">
            
            <div class="row">
            
                <div class="col-xs-12">
            
                    <h2 class="question-title color-green">Q. Set Your Question Here?</h2>
            
                </div>
            
            </div>
            
            <div class="row mt-50">
        
                <div class="col-xs-12">
        
                    <div class="alert alert-danger hidden"></div>
        
                    <div class="green-radio color-green">
        
                        <ol type="A">
        
                            <li class="font-size-30 answer-number">
                                <input type="checkbox" name="fieldName[1]" data-alternateName="answer[1]" data-alternateValue="A" data-alternatetype="checkbox" value="1" id="answer-1-1"/><label for="answer-1-1" class="answer-text"><span></span>BE 2 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
        
                            <li class="font-size-30 answer-number">
                                <input type="checkbox" name="fieldName[1]" data-alternateName="answer[1]" data-alternateValue="B" data-alternatetype="checkbox" value="2" id="answer-1-2"/><label for="answer-1-2" class="answer-text"><span></span>BE 2 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
        
                            <li class="font-size-30 answer-number">
                                <input type="checkbox" name="fieldName[1]" data-alternateName="answer[1]" data-alternateValue="C" data-alternatetype="checkbox" value="3" id="answer-1-3"/><label for="answer-1-3" class="answer-text"><span></span>BE 2 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
        
                            <li class="font-size-30 answer-number">
                                <input type="checkbox" name="fieldName[1]" data-alternateName="answer[1]" data-alternateValue="D" data-alternatetype="checkbox" value="4" id="answer-1-4"/><label for="answer-1-4" class="answer-text"><span></span>BE 2 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
        
                        </ol>
        
                    </div>
        
                </div>
        
            </div>
        
        </div>
        
        <div class="question hidden" data-question="3">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="question-title color-green">Q. Set Your Question Here?</h2>
                </div>
            </div>
            <div class="row mt-50">
                <div class="col-xs-12">
                    <div class="alert alert-danger hidden"></div>
                    <div class="green-radio color-green">
                        <ol type="A">
                            <li class="font-size-30 answer-number">
                                <input type="checkbox" name="fieldName[2]" data-alternateName="answer[2]" data-alternateValue="A" data-alternatetype="checkbox" value="1" id="answer-2-1"/><label for="answer-2-1" class="answer-text"><span></span>BE 3 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                            <li class="font-size-30 answer-number">
                                <input type="checkbox" name="fieldName[2]" data-alternateName="answer[2]" data-alternateValue="B" data-alternatetype="checkbox" value="2" id="answer-2-2"/><label for="answer-2-2" class="answer-text"><span></span>BE 3 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                            <li class="font-size-30 answer-number">
                                <input type="checkbox" name="fieldName[2]" data-alternateName="answer[2]" data-alternateValue="C" data-alternatetype="checkbox" value="3" id="answer-2-3"/><label for="answer-2-3" class="answer-text"><span></span>BE 3 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                            <li class="font-size-30 answer-number">
                                <input type="checkbox" name="fieldName[2]" data-alternateName="answer[2]" data-alternateValue="D" data-alternatetype="checkbox" value="4" id="answer-2-4"/><label for="answer-2-4" class="answer-text"><span></span>BE 3 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="question hidden" data-question="4">
        
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="question-title color-green">Q. Set Your Question Here?</h2>
                </div>
            </div>

            <div class="row mt-50">
               
                <div class="col-xs-12">
                   
                    <div class="alert alert-danger hidden"></div>
                   
                    <div class="green-radio color-green">
                     
                        <input type="text" name="fieldName[3]" data-alternateName="answer[3]" data-alternateValue="Text" id="answer-3-4" class="form-control" placeholder="Fill Text..."/>
                   
                    </div>
               
                </div>
           
            </div>
            
        </div>
        
        <div class="question hidden" data-question="5">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="question-title color-green">Q. Set Your Question Here?</h2>
                </div>
            </div>

            <div class="row mt-50">
                <div class="col-xs-12">
                    <div class="alert alert-danger hidden"></div>
                    <div class="green-radio color-green">
                        <textarea name="fieldName[4]" data-alternateName="answer[4]" data-alternateValue="Text" id="answer-4-1" class="form-control" placeholder="Fill Textarea..."></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="question hidden" data-question="6">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="question-title color-green">Q. Set Your Question Here?</h2>
                </div>
            </div>

            <div class="row mt-50">
                <div class="col-xs-12">
                    <div class="alert alert-danger hidden"></div>
                    <div class="green-radio color-green">
                        <select name="fieldName[5]" data-alternateName="answer[5]" data-alternateType="select" class="form-control">
                            <option value="">None</option>
                            <option value="1" data-alternateValue="A">A</option>
                            <option value="2" data-alternateValue="B">B</option>
                            <option value="3" data-alternateValue="C">C</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="question hidden" data-question="7">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="question-title color-green">Q. Set Your Question Here? (Multiple Select)</h2>
                </div>
            </div>

            <div class="row mt-50">
                <div class="col-xs-12">
                    <div class="alert alert-danger hidden"></div>
                    <div class="green-radio color-green">
                        <select name="fieldName[6]" data-alternateName="answer[6]" data-alternateType="select" class="form-control" multiple>
                            <option value="">None</option>
                            <option value="1" data-alternateValue="A">A</option>
                            <option value="2" data-alternateValue="B">B</option>
                            <option value="3" data-alternateValue="C">C</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="question hidden" data-question="8">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="question-title color-green">Q. Set Your Question Here?</h2>
                </div>
            </div>

            <div class="row mt-50">
                <div class="col-xs-12">
                    <div class="alert alert-danger hidden"></div>
                    <div class="green-radio color-green">
                        <ol type="A">
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[7]" data-alternateName="answer[7]" data-alternateValue="A" value="1" id="answer-7-1"/><label for="answer-7-1" class="answer-text"><span></span>BE 8 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[7]" data-alternateName="answer[7]" data-alternateValue="B" value="2" id="answer-7-2"/><label for="answer-7-2" class="answer-text"><span></span>BE 8 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[7]" data-alternateName="answer[7]" data-alternateValue="C" value="3" id="answer-7-3"/><label for="answer-7-3" class="answer-text"><span></span>BE 8 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[7]" data-alternateName="answer[7]" data-alternateValue="D" value="4" id="answer-7-4"/><label for="answer-7-4" class="answer-text"><span></span>BE 8 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="question hidden" data-question="9">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="question-title color-green">Q. Set Your Question Here?</h2>
                </div>
            </div>

            <div class="row mt-50">
                <div class="col-xs-12">
                    <div class="alert alert-danger hidden"></div>
                    <div class="green-radio color-green">
                        <ol type="A">
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[8]" data-alternateName="answer[8]" data-alternateValue="A" value="1" id="answer-8-1"/><label for="answer-8-1" class="answer-text"><span></span>BE 9 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[8]" data-alternateName="answer[8]" data-alternateValue="B" value="2" id="answer-8-2"/><label for="answer-8-2" class="answer-text"><span></span>BE 9 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[8]" data-alternateName="answer[8]" data-alternateValue="C" value="3" id="answer-8-3"/><label for="answer-8-3" class="answer-text"><span></span>BE 9 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[8]" data-alternateName="answer[8]" data-alternateValue="D" value="4" id="answer-8-4"/><label for="answer-8-4" class="answer-text"><span></span>BE 9 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="question hidden" data-question="10">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="question-title color-green">Q. Set Your Question Here?</h2>
                </div>
            </div>

            <div class="row mt-50">
                <div class="col-xs-12">
                    <div class="alert alert-danger hidden"></div>
                    <div class="green-radio color-green">
                        <ol type="A">
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[9]" data-alternateName="answer[9]" data-alternateValue="A" value="1" id="answer-9-1"/><label for="answer-9-1" class="answer-text"><span></span>BE 10 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[9]" data-alternateName="answer[9]" data-alternateValue="B" value="2" id="answer-9-2"/><label for="answer-9-2" class="answer-text"><span></span>BE 10 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[9]" data-alternateName="answer[9]" data-alternateValue="C" value="3" id="answer-9-3"/><label for="answer-9-3" class="answer-text"><span></span>BE 10 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[9]" data-alternateName="answer[9]" data-alternateValue="D" value="4" id="answer-9-4"/><label for="answer-9-4" class="answer-text"><span></span>BE 10 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="question hidden" data-question="11">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="question-title color-green">Q. Set Your Question Here?</h2>
                </div>
            </div>

            <div class="row mt-50">
                <div class="col-xs-12">
                    <div class="alert alert-danger hidden"></div>
                    <div class="green-radio color-green">
                        <ol type="A">
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[10]" data-alternateName="answer[10]" data-alternateValue="A" value="1" id="answer-10-1"/><label for="answer-10-1" class="answer-text"><span></span>BE 11 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[10]" data-alternateName="answer[10]" data-alternateValue="B" value="2" id="answer-10-2"/><label for="answer-10-2" class="answer-text"><span></span>BE 11 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[10]" data-alternateName="answer[10]" data-alternateValue="C" value="3" id="answer-10-3"/><label for="answer-10-3" class="answer-text"><span></span>BE 11 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[10]" data-alternateName="answer[10]" data-alternateValue="D" value="4" id="answer-10-4"/><label for="answer-10-4" class="answer-text"><span></span>BE 11 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="question hidden" data-question="12">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="question-title color-green">Q. Set Your Question Here?</h2>
                </div>
            </div>

            <div class="row mt-50">
                <div class="col-xs-12">
                    <div class="alert alert-danger hidden"></div>
                    <div class="green-radio color-green">
                        <ol type="A">
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[11]" data-alternateName="answer[11]" data-alternateValue="A" value="1" id="answer-11-1"/><label for="answer-11-1" class="answer-text"><span></span>BE 12 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[11]" data-alternateName="answer[11]" data-alternateValue="B" value="2" id="answer-11-2"/><label for="answer-11-2" class="answer-text"><span></span>BE 12 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[11]" data-alternateName="answer[11]" data-alternateValue="C" value="3" id="answer-11-3"/><label for="answer-11-3" class="answer-text"><span></span>BE 12 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[11]" data-alternateName="answer[11]" data-alternateValue="D" value="4" id="answer-11-4"/><label for="answer-11-4" class="answer-text"><span></span>BE 12 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="question hidden" data-question="13">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="question-title color-green">Q. Set Your Question Here?</h2>
                </div>
            </div>

            <div class="row mt-50">
                <div class="col-xs-12">
                    <div class="alert alert-danger hidden"></div>
                    <div class="green-radio color-green">
                        <ol type="A">
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[12]" data-alternateName="answer[12]" data-alternateValue="A" value="1" id="answer-12-1"/><label for="answer-12-1" class="answer-text"><span></span>BE 13 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[12]" data-alternateName="answer[12]" data-alternateValue="B" value="2" id="answer-12-2"/><label for="answer-12-2" class="answer-text"><span></span>BE 13 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[12]" data-alternateName="answer[12]" data-alternateValue="C" value="3" id="answer-12-3"/><label for="answer-12-3" class="answer-text"><span></span>BE 13 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[12]" data-alternateName="answer[12]" data-alternateValue="D" value="4" id="answer-12-4"/><label for="answer-12-4" class="answer-text"><span></span>BE 13 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="question hidden" data-question="14">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="question-title color-green">Q. Set Your Question Here?</h2>
                </div>
            </div>

            <div class="row mt-50">
                <div class="col-xs-12">
                    <div class="alert alert-danger hidden"></div>
                    <div class="green-radio color-green">
                        <ol type="A">
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[13]" data-alternateName="answer[13]" data-alternateValue="A" value="1" id="answer-13-1"/><label for="answer-13-1" class="answer-text"><span></span>BE 14 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[13]" data-alternateName="answer[13]" data-alternateValue="B" value="2" id="answer-13-2"/><label for="answer-13-2" class="answer-text"><span></span>BE 14 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[13]" data-alternateName="answer[13]" data-alternateValue="C" value="3" id="answer-13-3"/><label for="answer-13-3" class="answer-text"><span></span>BE 14 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[13]" data-alternateName="answer[13]" data-alternateValue="D" value="4" id="answer-13-4"/><label for="answer-13-4" class="answer-text"><span></span>BE 14 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="question hidden" data-question="15">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="question-title color-green">Q. Set Your Question Here?</h2>
                </div>
            </div>

            <div class="row mt-50">
                <div class="col-xs-12">
                    <div class="alert alert-danger hidden"></div>
                    <div class="green-radio color-green">
                        <ol type="A">
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[14]" data-alternateName="answer[14]" data-alternateValue="A" value="1" id="answer-14-1"/><label for="answer-14-1" class="answer-text"><span></span>BE 15 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[14]" data-alternateName="answer[14]" data-alternateValue="B" value="2" id="answer-14-2"/><label for="answer-14-2" class="answer-text"><span></span>BE 15 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[14]" data-alternateName="answer[14]" data-alternateValue="C" value="3" id="answer-14-3"/><label for="answer-14-3" class="answer-text"><span></span>BE 15 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[14]" data-alternateName="answer[14]" data-alternateValue="D" value="4" id="answer-14-4"/><label for="answer-14-4" class="answer-text"><span></span>BE 15 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="question hidden" data-question="16">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="question-title color-green">Q. Set Your Question Here?</h2>
                </div>
            </div>

            <div class="row mt-50">
                <div class="col-xs-12">
                    <div class="alert alert-danger hidden"></div>
                    <div class="green-radio color-green">
                        <ol type="A">
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[15]" data-alternateName="answer[15]" data-alternateValue="A" value="1" id="answer-15-1"/><label for="answer-15-1" class="answer-text"><span></span>BE 16 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[15]" data-alternateName="answer[15]" data-alternateValue="B" value="2" id="answer-15-2"/><label for="answer-15-2" class="answer-text"><span></span>BE 16 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[15]" data-alternateName="answer[15]" data-alternateValue="C" value="3" id="answer-15-3"/><label for="answer-15-3" class="answer-text"><span></span>BE 16 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[15]" data-alternateName="answer[15]" data-alternateValue="D" value="4" id="answer-15-4"/><label for="answer-15-4" class="answer-text"><span></span>BE 16 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="question hidden" data-question="17">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="question-title color-green">Q. Set Your Question Here?</h2>
                </div>
            </div>

            <div class="row mt-50">
                <div class="col-xs-12">
                    <div class="alert alert-danger hidden"></div>
                    <div class="green-radio color-green">
                        <ol type="A">
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[16]" data-alternateName="answer[16]" data-alternateValue="A" value="1" id="answer-16-1"/><label for="answer-16-1" class="answer-text"><span></span>BE 17 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[16]" data-alternateName="answer[16]" data-alternateValue="B" value="2" id="answer-16-2"/><label for="answer-16-2" class="answer-text"><span></span>BE 17 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[16]" data-alternateName="answer[16]" data-alternateValue="C" value="3" id="answer-16-3"/><label for="answer-16-3" class="answer-text"><span></span>BE 17 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[16]" data-alternateName="answer[16]" data-alternateValue="D" value="4" id="answer-16-4"/><label for="answer-16-4" class="answer-text"><span></span>BE 17 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="question hidden" data-question="18">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="question-title color-green">Q. Set Your Question Here?</h2>
                </div>
            </div>

            <div class="row mt-50">
                <div class="col-xs-12">
                    <div class="alert alert-danger hidden"></div>
                    <div class="green-radio color-green">
                        <ol type="A">
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[17]" data-alternateName="answer[17]" data-alternateValue="A" value="1" id="answer-17-1"/><label for="answer-17-1" class="answer-text"><span></span>BE 18 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[17]" data-alternateName="answer[17]" data-alternateValue="B" value="2" id="answer-17-2"/><label for="answer-17-2" class="answer-text"><span></span>BE 18 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[17]" data-alternateName="answer[17]" data-alternateValue="C" value="3" id="answer-17-3"/><label for="answer-17-3" class="answer-text"><span></span>BE 18 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                            <li class="font-size-30 answer-number">
                                <input type="radio" data-alternatetype="radio" name="fieldName[17]" data-alternateName="answer[17]" data-alternateValue="D" value="4" id="answer-17-4"/><label for="answer-17-4" class="answer-text"><span></span>BE 18 PREPARED YOUR EXAM WILL START SOON</label>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" value="1" id="currentQuestionNumber" name="currentQuestionNumber" />
        <input type="hidden" value="18" id="totalOfQuestion" name="totalOfQuestion" />
        <input type="hidden" value="[]" id="markedQuestion" name="markedQuestions" />

    </form>
</div>
<div class="col-xs-3" id="quick-access-section">
    <table class="table table-responsive table-borderd table-hover table-striped text-center">
        <thead class="question-response-header">
            <tr><th class="text-center">Question</th>
                <th class="text-center">Response</th></tr>
        </thead>
        <tbody>
            <tr class="question-response-rows" data-question="1">
                <td>1</td>
                <td class="question-response-rows-value">-</td>
            </tr>
            <tr class="question-response-rows" data-question="2">
                <td>2</td>
                <td class="question-response-rows-value">-</td>
            </tr>
            <tr class="question-response-rows" data-question="3">
                <td>3</td>
                <td class="question-response-rows-value">-</td>
            </tr>
            <tr class="question-response-rows" data-question="4">
                <td>4</td>
                <td class="question-response-rows-value">-</td>
            </tr>
            <tr class="question-response-rows" data-question="5">
                <td>5</td>
                <td class="question-response-rows-value">-</td>
            </tr>
            <tr class="question-response-rows" data-question="6">
                <td>6</td>
                <td class="question-response-rows-value">-</td>
            </tr>
            <tr class="question-response-rows" data-question="7">
                <td>7</td>
                <td class="question-response-rows-value">-</td>
            </tr>
            <tr class="question-response-rows" data-question="8">
                <td>8</td>
                <td class="question-response-rows-value">-</td>
            </tr>
            <tr class="question-response-rows" data-question="9">
                <td>9</td>
                <td class="question-response-rows-value">-</td>
            </tr>
            <tr class="question-response-rows" data-question="10">
                <td>10</td>
                <td class="question-response-rows-value">-</td>
            </tr>
            <tr class="question-response-rows" data-question="11">
                <td>11</td>
                <td class="question-response-rows-value">-</td>
            </tr>
            <tr class="question-response-rows" data-question="12">
                <td>12</td>
                <td class="question-response-rows-value">-</td>
            </tr>
            <tr class="question-response-rows" data-question="13">
                <td>13</td>
                <td class="question-response-rows-value">-</td>
            </tr>
            <tr class="question-response-rows" data-question="14">
                <td>14</td>
                <td class="question-response-rows-value">-</td>
            </tr>
            <tr class="question-response-rows" data-question="15">
                <td>15</td>
                <td class="question-response-rows-value">-</td>
            </tr>
            <tr class="question-response-rows" data-question="16">
                <td>16</td>
                <td class="question-response-rows-value">-</td>
            </tr>
            <tr class="question-response-rows" data-question="17">
                <td>17</td>
                <td class="question-response-rows-value">-</td>
            </tr>
            <tr class="question-response-rows" data-question="18">
                <td>18</td>
                <td class="question-response-rows-value">-</td>
            </tr>
        </tbody>
    </table>
    <div class="col-xs-12">
        <a href="javascript:void(0)" class="btn btn-success" id="quick-access-prev">< Back</a>
        <span class="alert alert-info" id="quick-access-info"></span>
        <a href="javascript:void(0)" class="btn btn-success" id="quick-access-next">Next ></a>
    </div>
</div>

<!-- Exmas Footer - Multi Step Pages Footer -->
<div class="row">
    <div class="col-xs-12 exams-footer">
        <div class="col-xs-4 col-sm-1 back-to-prev-question-wrapper text-center">
            <a href="javascript:void(0);" id="back-to-prev-question" class="btn btn-success disabled">
                Back
            </a>
        </div>
        <div class="col-xs-4 col-sm-2 footer-question-number-wrapper text-center">
            <div class="mt-4">
                <span id="current-question-number-label">1</span>
                <span>Of <b>18</b></span>
            </div>
            <div class="mt-4">
                Question Number
            </div>
        </div>
        <div class="col-xs-4 col-sm-1 go-to-next-question-wrapper text-center">
            <a href="javascript:void(0);" id="go-to-next-question" class="btn btn-success">
                Next
            </a>
        </div>
        <div class="visible-xs">
            <div class="clearfix"></div>
            <div class="mt-50"></div>
        </div>
        <div class="col-sm-2">
            <div class="mark-unmark-wrapper" data-question="1">
                <a href="javascript:void(0);" class="mark-question btn btn-success" data-question="1">
                    <b>MARK</b>
                </a>
                <a href="javascript:void(0);" class="hidden unmark-question btn btn-success" data-question="1">
                    <b>UNMARK</b>
                </a>
            </div>
            <div class="mark-unmark-wrapper hidden" data-question="2">
                <a href="javascript:void(0);" class="mark-question btn btn-success" data-question="2">
                    <b>MARK</b>
                </a>
                <a href="javascript:void(0);" class="hidden unmark-question btn btn-success" data-question="2">
                    <b>UNMARK</b>
                </a>
            </div>
            <div class="mark-unmark-wrapper hidden" data-question="3">
                <a href="javascript:void(0);" class="mark-question btn btn-success" data-question="3">
                    <b>MARK</b>
                </a>
                <a href="javascript:void(0);" class="hidden unmark-question btn btn-success" data-question="3">
                    <b>UNMARK</b>
                </a>
            </div>
            <div class="mark-unmark-wrapper hidden" data-question="4">
                <a href="javascript:void(0);" class="mark-question btn btn-success" data-question="4">
                    <b>MARK</b>
                </a>
                <a href="javascript:void(0);" class="hidden unmark-question btn btn-success" data-question="4">
                    <b>UNMARK</b>
                </a>
            </div>
            <div class="mark-unmark-wrapper hidden" data-question="5">
                <a href="javascript:void(0);" class="mark-question btn btn-success" data-question="5">
                    <b>MARK</b>
                </a>
                <a href="javascript:void(0);" class="hidden unmark-question btn btn-success" data-question="5">
                    <b>UNMARK</b>
                </a>
            </div>
            <div class="mark-unmark-wrapper hidden" data-question="6">
                <a href="javascript:void(0);" class="mark-question btn btn-success" data-question="6">
                    <b>MARK</b>
                </a>
                <a href="javascript:void(0);" class="hidden unmark-question btn btn-success" data-question="6">
                    <b>UNMARK</b>
                </a>
            </div>
            <div class="mark-unmark-wrapper hidden" data-question="7">
                <a href="javascript:void(0);" class="mark-question btn btn-success" data-question="7">
                    <b>MARK</b>
                </a>
                <a href="javascript:void(0);" class="hidden unmark-question btn btn-success" data-question="7">
                    <b>UNMARK</b>
                </a>
            </div>
            <div class="mark-unmark-wrapper hidden" data-question="8">
                <a href="javascript:void(0);" class="mark-question btn btn-success" data-question="8">
                    <b>MARK</b>
                </a>
                <a href="javascript:void(0);" class="hidden unmark-question btn btn-success" data-question="8">
                    <b>UNMARK</b>
                </a>
            </div>
            <div class="mark-unmark-wrapper hidden" data-question="9">
                <a href="javascript:void(0);" class="mark-question btn btn-success" data-question="9">
                    <b>MARK</b>
                </a>
                <a href="javascript:void(0);" class="hidden unmark-question btn btn-success" data-question="9">
                    <b>UNMARK</b>
                </a>
            </div>
            <div class="mark-unmark-wrapper hidden" data-question="10">
                <a href="javascript:void(0);" class="mark-question btn btn-success" data-question="10">
                    <b>MARK</b>
                </a>
                <a href="javascript:void(0);" class="hidden unmark-question btn btn-success" data-question="10">
                    <b>UNMARK</b>
                </a>
            </div>
            <div class="mark-unmark-wrapper hidden" data-question="11">
                <a href="javascript:void(0);" class="mark-question btn btn-success" data-question="11">
                    <b>MARK</b>
                </a>
                <a href="javascript:void(0);" class="hidden unmark-question btn btn-success" data-question="11">
                    <b>UNMARK</b>
                </a>
            </div>
            <div class="mark-unmark-wrapper hidden" data-question="12">
                <a href="javascript:void(0);" class="mark-question btn btn-success" data-question="12">
                    <b>MARK</b>
                </a>
                <a href="javascript:void(0);" class="hidden unmark-question btn btn-success" data-question="12">
                    <b>UNMARK</b>
                </a>
            </div>
            <div class="mark-unmark-wrapper hidden" data-question="13">
                <a href="javascript:void(0);" class="mark-question btn btn-success" data-question="13">
                    <b>MARK</b>
                </a>
                <a href="javascript:void(0);" class="hidden unmark-question btn btn-success" data-question="13">
                    <b>UNMARK</b>
                </a>
            </div>
            <div class="mark-unmark-wrapper hidden" data-question="14">
                <a href="javascript:void(0);" class="mark-question btn btn-success" data-question="14">
                    <b>MARK</b>
                </a>
                <a href="javascript:void(0);" class="hidden unmark-question btn btn-success" data-question="14">
                    <b>UNMARK</b>
                </a>
            </div>
            <div class="mark-unmark-wrapper hidden" data-question="15">
                <a href="javascript:void(0);" class="mark-question btn btn-success" data-question="15">
                    <b>MARK</b>
                </a>
                <a href="javascript:void(0);" class="hidden unmark-question btn btn-success" data-question="15">
                    <b>UNMARK</b>
                </a>
            </div>
            <div class="mark-unmark-wrapper hidden" data-question="16">
                <a href="javascript:void(0);" class="mark-question btn btn-success" data-question="16">
                    <b>MARK</b>
                </a>
                <a href="javascript:void(0);" class="hidden unmark-question btn btn-success" data-question="16">
                    <b>UNMARK</b>
                </a>
            </div>
            <div class="mark-unmark-wrapper hidden" data-question="17">
                <a href="javascript:void(0);" class="mark-question btn btn-success" data-question="17">
                    <b>MARK</b>
                </a>
                <a href="javascript:void(0);" class="hidden unmark-question btn btn-success" data-question="17">
                    <b>UNMARK</b>
                </a>
            </div>
            <div class="mark-unmark-wrapper hidden" data-question="18">
                <a href="javascript:void(0);" class="mark-question btn btn-success" data-question="18">
                    <b>MARK</b>
                </a>
                <a href="javascript:void(0);" class="hidden unmark-question btn btn-success" data-question="18">
                    <b>UNMARK</b>
                </a>
            </div>
        </div>
        <div class="col-xs-6 col-sm-2 footer-finish-question-wrapper text-center">
            <a href="javascript:void(0);" id="finishExams" class="btn btn-success disabled">
                <b>Finish</b>
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
        quickAccessPagerItem:   'Full',
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
        callBack:               function(){},
        breakNext:             function(){return false;},
    },
    prevOption: {
        prevSelector:           '#back-to-prev-question', 
        allowadPrev:            true,
        allowadPrevOnQNum:      2,
        callBack:               function(){},
        breakPrev:              function(){return false;},
    },
    finishOption: {
        enableAndDisableFinshBtn:true,
        enableFinishButtonAtQNum:'onLastQuestion',
        finishBtnSelector:      '#finishExams',
        enableModal:            false,
        finishModalTarget:      '#finishExamsModal',
        finishModalAnswerd:     '.finishExams-total-answerd',
        finishModalMarked:      '.finishExams-total-marked',
        finishModalRemaining:   '.finishExams-total-remaining',
        callBack:               function(){}
    },
    markOption: {
        markSelector:           '.mark-question',
        unmarkSelector:         '.unmark-question',
        markedLinkSelector:     '.marked-link',
        markedQuestionsSelector:'#markedQuestion',
        markedLabel:            'Marked',
        markUnmarkWrapper:      '.mark-unmark-wrapper',
        enableMarked:           true,
        markCallBack:           function(){},
        unMarkCallBack:         function(){},
    },
    cookiesOption: {
        enableCookie:           false,
        cookieKey:              '',
        expires:                1*24*60*60*1000 // 1 day
    }
});
</script>

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
