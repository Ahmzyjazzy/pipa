<div class="content-wrapper">
   
   <!-- Content Header (Page header) -->
    <section class="content-header">     
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="tab-page--container">

            <div class="row">              
                <div class="col-md-12 analyze-header-wrapper">                 
                    <section class="analyze-header-tab">                      
                        <a href="analyze" class="text-blue fixed-backnav">  
                            <svg width="21" height="13" viewBox="0 0 21 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21 6.5H2M2 6.5L7.5 1M2 6.5L7.5 12" stroke="#0071F7" stroke-width="2"/>
                            </svg>
                        </a>                        
                        <ul class="border-bottom nav nav-tabs">
                          
                            <li class="active mr-3 pb-2"> 
                             
                                <a data-toggle="tab" href="#analyze" class="text-md header-title border-0">Engagement Survey</a>
                          
                            </li>
                         
                            <li class="mr-3 pb-2 hidden">
                            
                                <a data-toggle="tab" href="#option" class="text-md header-title border-0">Another option</a>
                         
                            </li>
                        
                        </ul>
                    </section>                 
                </div>                
            </div> 

            <div class="row">                
                <div class="col-md-12" style="padding: 0">
                 
                    <div class="tab-content">

                        <div id="analyze" class="tab-pane fade in active">
                            
                            <div class="analyze-full-card engagement-container col-md-12">
                                <header class="border-bottom">
                                    <p class="text-primary card-title">Analyze engagement surveys</p> 
                                    <div class="date-dropdown">
                                        <p class="card-date" style="margin-right: 1rem;">Survey dates</p>   
                                        <input type="text" id="surveydate-dropdown" class="bg-secondary-color text-md" />
                                    </div>
                                </header>
                                <div>
                                    <div class="col-md-5 engagement-wrapper">
                                        <div id="assessment_pie" class="chart">
                                            <div class="card-skeleton">
                                                <div class="animated-background"> 
                                                    <div class="card-skeleton-img"></div>
                                                    <div class="skel-mask-container">
                                                    <div class="skel-mask skel-mask-1"></div>
                                                    <div class="skel-mask skel-mask-2"></div>
                                                    <div class="skel-mask skel-mask-3"></div>
                                                    <div class="skel-mask skel-mask-4"></div>
                                                    <div class="skel-mask skel-mask-5"></div>
                                                    <div class="skel-mask skel-mask-6"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="program-dropdown">
                                            <div class="engagement-sort">
                                                <p class="card-date" style="margin-right: 1rem;">Sort by</p>  
                                                <select class="bg-secondary-color text-md benchmark-program" id="benchmark-program">
                                                    <?php if (empty($surveys)) { ?>
                                                        <option value="">Participation</option>                                                
                                                    <?php
                                                        } else {?>                                    
                                                        <option value="">Participation</option>   
                                                        <?php
                                                            foreach ($surveys as $survey) {
                                                    ?>
                                                        <option value="<?php echo $survey['program_id'] ?>"><?php echo $survey['survey'] ?></option>    
                                                    <?php
                                                            } //end foreach
                                                        } //end else
                                                    ?>                  
                                                </select>
                                            </div> 
                                            <div class="engagement-bar">
                                                <div>
                                                    <span class="bar dark"></span>
                                                    <p>Participated</p>
                                                </div>
                                                <div>
                                                    <span class="bar green"></span>
                                                    <p>Awaiting response</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div id="engagement-line-chart" style="height:300px;"></div>
                                    </div>
                                </div>
                            </div> 

                            <div class="analyze-gray-card-parent">
                   
                                <div class="analyze-gray-card-child">                                
                                    <div class="analyze-gray-card engagement">  
                                        <div class="engagement-grid top">
                                            <span class="text-primary card-title">Top Strengths</span>
                                            <span class="text-primary card-title">Org</span>
                                            <span class="text-primary card-title">Ind</span>
                                            <span class="text-primary card-title">Nat</span>
                                        </div> 
                                        <div class="engagement-grid line">
                                            <span>Peope here care for each other</span>
                                            <span>56</span>
                                            <span>67</span>
                                            <span>45</span>
                                        </div>  
                                        <div class="engagement-grid line">
                                            <span>My manager cares about me</span>
                                            <span>56</span>
                                            <span>67</span>
                                            <span>45</span>
                                        </div>
                                        <div class="engagement-grid line">
                                            <span>Peope avoid politicing</span>
                                            <span>56</span>
                                            <span>67</span>
                                            <span>45</span>
                                        </div>                                                 
                                    </div>                                    
                                </div>
                                
                                <div class="analyze-gray-card-child">
                                    <div class="analyze-gray-card engagement">                                        
                                        <div class="engagement-grid top">
                                            <span class="text-primary card-title">Top opportunity</span>
                                            <span class="text-primary card-title">Org</span>
                                            <span class="text-primary card-title">Ind</span>
                                            <span class="text-primary card-title">Nat</span>
                                        </div> 
                                        <div class="engagement-grid line">
                                            <span>Peope here care for each other</span>
                                            <span>56</span>
                                            <span>67</span>
                                            <span>45</span>
                                        </div>       
                                        <div class="engagement-grid line">
                                            <span>My manager cares about me</span>
                                            <span>56</span>
                                            <span>67</span>
                                            <span>45</span>
                                        </div>
                                        <div class="engagement-grid line">
                                            <span>Peope avoid politicing</span>
                                            <span>56</span>
                                            <span>67</span>
                                            <span>45</span>
                                        </div>                               
                                    </div>

                                </div>
                                
                            </div>
                            
                            <div class="analyze-gray-card-parent" style="margin-top: 2rem;">
                   
                                <div class="analyze-gray-card-child">                                
                                    <div class="analyze-gray-card word-cloud carousel slide" data-ride="carousel" id="wordCloudCarousel">  
                                        <header class="border-bottom pb-3" style="display: flex;justify-content: space-between;">                         
                                            <p class="text-primary card-title">Word Cloud</p>   
                                            <div class="question-slide-controller">
                                                <span class="question-number">Q1</span>
                                                <div>
                                                    <span class="fa fa-caret-left question-slide-btn" title="prev" data-action="prev"></span>
                                                    <span class="fa fa-caret-right question-slide-btn" title="next" data-action="next"></span>
                                                </div>
                                            </div>                     
                                        </header>
                                        <div class="carousel-inner">
                                            <div class="word-cloud--content item active">
                                                <p class="text-primary word-cloud--content__title">What world would you use to describe the culture in your organization 1</p>
                                                <div class="word-cloud-generator" id="wc-1">
                                                    <div class="card-skeleton">
                                                        <div class="animated-background"> 
                                                            <div class="card-skeleton-img"></div>
                                                            <div class="skel-mask-container">
                                                            <div class="skel-mask skel-mask-1"></div>
                                                            <div class="skel-mask skel-mask-2"></div>
                                                            <div class="skel-mask skel-mask-3"></div>
                                                            <div class="skel-mask skel-mask-4"></div>
                                                            <div class="skel-mask skel-mask-5"></div>
                                                            <div class="skel-mask skel-mask-6"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="word-cloud--content item">
                                                <p class="text-primary word-cloud--content__title">What world would you use to describe the culture in your organization 2</p>
                                                <div class="word-cloud-generator" id="wc-2">
                                                    <div class="card-skeleton">
                                                        <div class="animated-background"> 
                                                            <div class="card-skeleton-img"></div>
                                                            <div class="skel-mask-container">
                                                            <div class="skel-mask skel-mask-1"></div>
                                                            <div class="skel-mask skel-mask-2"></div>
                                                            <div class="skel-mask skel-mask-3"></div>
                                                            <div class="skel-mask skel-mask-4"></div>
                                                            <div class="skel-mask skel-mask-5"></div>
                                                            <div class="skel-mask skel-mask-6"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="word-cloud--content item">
                                                <p class="text-primary word-cloud--content__title">What world would you use to describe the culture in your organization 3</p>
                                                <div class="word-cloud-generator" id="wc-3">
                                                    <div class="card-skeleton">
                                                        <div class="animated-background"> 
                                                            <div class="card-skeleton-img"></div>
                                                            <div class="skel-mask-container">
                                                            <div class="skel-mask skel-mask-1"></div>
                                                            <div class="skel-mask skel-mask-2"></div>
                                                            <div class="skel-mask skel-mask-3"></div>
                                                            <div class="skel-mask skel-mask-4"></div>
                                                            <div class="skel-mask skel-mask-5"></div>
                                                            <div class="skel-mask skel-mask-6"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                                
                                <div class="analyze-gray-card-child">
                                    <div class="analyze-gray-card engagement">                                        
                                        <div class="engagement-grid top">
                                            <span class="text-primary card-title">Strongest engagement correlation</span>
                                            <span class="text-primary card-title">Org</span>
                                            <span class="text-primary card-title">Ind</span>
                                            <span class="text-primary card-title">Nat</span>
                                        </div> 
                                        <div class="engagement-grid line">
                                            <span>Peope here care for each other</span>
                                            <span>56</span>
                                            <span>67</span>
                                            <span>45</span>
                                        </div>       
                                        <div class="engagement-grid line">
                                            <span>My manager cares about me</span>
                                            <span>56</span>
                                            <span>67</span>
                                            <span>45</span>
                                        </div>
                                        <div class="engagement-grid line">
                                            <span>Peope avoid politicing</span>
                                            <span>56</span>
                                            <span>67</span>
                                            <span>45</span>
                                        </div>   
                                        <div class="engagement-grid line">
                                            <span>Peope here care for each other</span>
                                            <span>56</span>
                                            <span>67</span>
                                            <span>45</span>
                                        </div>       
                                        <div class="engagement-grid line">
                                            <span>My manager cares about me</span>
                                            <span>56</span>
                                            <span>67</span>
                                            <span>45</span>
                                        </div>
                                        <div class="engagement-grid line">
                                            <span>Peope avoid politicing</span>
                                            <span>56</span>
                                            <span>67</span>
                                            <span>45</span>
                                        </div>                             
                                    </div>

                                </div>
                                
                            </div>

                            <div class="analyze-full-card competency_responses" id="competency_responses_cont" style="margin-top: 2rem;">
                                <header class="border-bottom">
                                    <p class="text-primary card-title">Engagement Drivers</p>                                                         
                                    <div style="">
                                        <b>Benchmark</b>
                                        <div class="select-group-grid">
                                            <select class="bg-secondary-color text-md program-select" id="program-select">
                                                <option value="">Finance</option>                       
                                            </select>
                                            <select class="bg-secondary-color text-md program-select" id="program-select">
                                                <option value="">Finance</option>                       
                                            </select>
                                            <select class="bg-secondary-color text-md program-select" id="program-select">
                                                <option value="">Finance</option>                       
                                            </select>
                                        </div>
                                    </div>
                                </header> 
                                <section class="row"> 
                                    <header class="competency-response-header" style="display: flex !important; flex-wrap: wrap;">
                                        <div class="title-wrapper">
                                            <h2>Change Management</h2>
                                            <a data-toggle="collapse" href="#competency_25" role="button" aria-expanded="false" aria-controls="communication" class="view_questions_response collapsed" data-comid="25">
                                                View questions
                                                <svg class="arrow-down" width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1 1.5L6 6.5L11 1.5" stroke="#7E9EC2" stroke-width="2"></path>
                                                </svg>
                                                <svg width="12" class="arrow-up" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1 6.5L6 1.5L11 6.5" stroke="#0071F7" stroke-width="2"></path>
                                                </svg>
                                            </a> 
                                        </div>
                                        <div class="progress-wrapper">
                                            <ul class="list-unstyled">
                                                <li class="score-line">
                                                    <p class="score-title text-primary">Organization</p>
                                                    <div class="score-bar-wrapper">
                                                        <div class="score-bar" style="width: 70%; background-color: #0071F7"></div>
                                                    </div>
                                                </li>  
                                                <li class="score-line">
                                                    <p class="score-title text-primary">Benchmark 1</p>
                                                    <div class="score-bar-wrapper">
                                                        <div class="score-bar" style="width: 50%; background-color: #029942"></div>
                                                    </div>
                                                </li>  
                                                <li class="score-line">
                                                    <p class="score-title text-primary">Benchmark 2</p>
                                                    <div class="score-bar-wrapper">
                                                        <div class="score-bar" style="width: 80%; background-color: #F70085"></div>
                                                    </div>
                                                </li>  
                                                <li class="score-line">
                                                    <p class="score-title text-primary">Benchmark 3</p>
                                                    <div class="score-bar-wrapper">
                                                        <div class="score-bar" style="width: 50%; background-color: #0c143e"></div>
                                                    </div>
                                                </li>  
                                                <li class="score-line">
                                                    <p class=""></p>
                                                    <ul class="list-unstyled score-x-value">
                                                        <li class="text-primary">0</li>
                                                        <li class="text-primary">20</li>
                                                        <li class="text-primary">40</li>
                                                        <li class="text-primary">60</li>
                                                        <li class="text-primary">80</li>
                                                        <li class="text-primary">100</li>
                                                    </ul>
                                                </li>
                                            </ul>                                                  
                                        </div>
                                    </header>
                                    <div class="competency-response competency-response-detail collapse" id="competency_25" aria-expanded="false" style="height: 20px;">
                                        <div class="question-response-detail">
                                            <b>Question 1:</b>
                                            <div class="question-desc">
                                                <p> 
                                                    <span>Acts as a champion for change</span>
                                                </p>
                                            </div>   
                                            <div class="progress-wrapper">
                                                <ul class="list-unstyled">
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Organization</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 70%; background-color: #0071F7"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 1</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 50%; background-color: #029942"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 2</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 80%; background-color: #F70085"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 3</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 50%; background-color: #0c143e"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class=""></p>
                                                        <ul class="list-unstyled score-x-value">
                                                            <li class="text-primary">0</li>
                                                            <li class="text-primary">20</li>
                                                            <li class="text-primary">40</li>
                                                            <li class="text-primary">60</li>
                                                            <li class="text-primary">80</li>
                                                            <li class="text-primary">100</li>
                                                        </ul>
                                                    </li>
                                                </ul>                                                  
                                            </div>                                        
                                        </div>
                                        <div class="question-response-detail">
                                            <b>Question 2:</b>
                                            <div class="question-desc">
                                                <p> 
                                                    <span>Helps employees develop a clear understanding of what they will need to do differently as a result of changes in the organization</span>
                                                </p>
                                            </div>   
                                            <div class="progress-wrapper">
                                                <ul class="list-unstyled">
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Organization</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 70%; background-color: #0071F7"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 1</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 50%; background-color: #029942"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 2</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 80%; background-color: #F70085"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 3</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 50%; background-color: #0c143e"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class=""></p>
                                                        <ul class="list-unstyled score-x-value">
                                                            <li class="text-primary">0</li>
                                                            <li class="text-primary">20</li>
                                                            <li class="text-primary">40</li>
                                                            <li class="text-primary">60</li>
                                                            <li class="text-primary">80</li>
                                                            <li class="text-primary">100</li>
                                                        </ul>
                                                    </li>
                                                </ul>                                                  
                                            </div>                                                                                 
                                        </div>
                                        <div class="question-response-detail">
                                            <b>Question 3:</b>
                                            <div class="question-desc">
                                                <p> 
                                                    <span>Establishes the structures and processes to plan and manage the orderly implementation of change</span>
                                                </p>
                                            </div>   
                                            <div class="progress-wrapper">
                                                <ul class="list-unstyled">
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Organization</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 70%; background-color: #0071F7"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 1</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 50%; background-color: #029942"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 2</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 80%; background-color: #F70085"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 3</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 50%; background-color: #0c143e"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class=""></p>
                                                        <ul class="list-unstyled score-x-value">
                                                            <li class="text-primary">0</li>
                                                            <li class="text-primary">20</li>
                                                            <li class="text-primary">40</li>
                                                            <li class="text-primary">60</li>
                                                            <li class="text-primary">80</li>
                                                            <li class="text-primary">100</li>
                                                        </ul>
                                                    </li>
                                                </ul>                                                  
                                            </div>                                                                                  
                                        </div>
                                        <div class="question-response-detail">
                                            <b>Question 4:</b>
                                            <div class="question-desc">
                                                <p> 
                                                    <span>Demonstrates support for innovation and organizational changes needed to improve the organization's effectiveness</span>
                                                </p>
                                            </div>   
                                            <div class="progress-wrapper">
                                                <ul class="list-unstyled">
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Organization</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 70%; background-color: #0071F7"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 1</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 50%; background-color: #029942"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 2</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 80%; background-color: #F70085"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 3</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 50%; background-color: #0c143e"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class=""></p>
                                                        <ul class="list-unstyled score-x-value">
                                                            <li class="text-primary">0</li>
                                                            <li class="text-primary">20</li>
                                                            <li class="text-primary">40</li>
                                                            <li class="text-primary">60</li>
                                                            <li class="text-primary">80</li>
                                                            <li class="text-primary">100</li>
                                                        </ul>
                                                    </li>
                                                </ul>                                                  
                                            </div>                                                                                  
                                        </div>
                                        <div class="question-response-detail">
                                            <b>Question 5:</b>
                                            <div class="question-desc">
                                                <p> 
                                                    <span>Takes a lead in uncertain situations and circumstances</span>
                                                </p>
                                            </div>   
                                            <div class="progress-wrapper">
                                                <ul class="list-unstyled">
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Organization</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 70%; background-color: #0071F7"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 1</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 50%; background-color: #029942"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 2</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 80%; background-color: #F70085"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 3</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 50%; background-color: #0c143e"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class=""></p>
                                                        <ul class="list-unstyled score-x-value">
                                                            <li class="text-primary">0</li>
                                                            <li class="text-primary">20</li>
                                                            <li class="text-primary">40</li>
                                                            <li class="text-primary">60</li>
                                                            <li class="text-primary">80</li>
                                                            <li class="text-primary">100</li>
                                                        </ul>
                                                    </li>
                                                </ul>                                                  
                                            </div>                                                                                 
                                        </div>
                                        <div class="question-response-detail">
                                            <b>Question 6:</b>
                                            <div class="question-desc">
                                                <p> 
                                                    <span>Initiates, sponsors and implements organizational changes</span>
                                                </p>
                                            </div>   
                                            <div class="progress-wrapper">
                                                <ul class="list-unstyled">
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Organization</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 70%; background-color: #0071F7"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 1</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 50%; background-color: #029942"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 2</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 80%; background-color: #F70085"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 3</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 50%; background-color: #0c143e"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class=""></p>
                                                        <ul class="list-unstyled score-x-value">
                                                            <li class="text-primary">0</li>
                                                            <li class="text-primary">20</li>
                                                            <li class="text-primary">40</li>
                                                            <li class="text-primary">60</li>
                                                            <li class="text-primary">80</li>
                                                            <li class="text-primary">100</li>
                                                        </ul>
                                                    </li>
                                                </ul>                                                  
                                            </div>                                                                                 
                                        </div>
                                        <div class="question-response-detail">
                                            <b>Question 7:</b>
                                            <div class="question-desc">
                                                <p> 
                                                    <span>Accepts ambiguity that comes with change activities</span>
                                                </p>
                                            </div>   
                                            <div class="progress-wrapper">
                                                <ul class="list-unstyled">
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Organization</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 70%; background-color: #0071F7"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 1</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 50%; background-color: #029942"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 2</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 80%; background-color: #F70085"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 3</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 50%; background-color: #0c143e"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class=""></p>
                                                        <ul class="list-unstyled score-x-value">
                                                            <li class="text-primary">0</li>
                                                            <li class="text-primary">20</li>
                                                            <li class="text-primary">40</li>
                                                            <li class="text-primary">60</li>
                                                            <li class="text-primary">80</li>
                                                            <li class="text-primary">100</li>
                                                        </ul>
                                                    </li>
                                                </ul>                                                  
                                            </div>                                                                                 
                                        </div>
                                    </div> 
                                </section>
                                <section class="row"> 
                                    <header class="competency-response-header" style="display: flex !important; flex-wrap: wrap;">
                                        <div class="title-wrapper">
                                            <h2>Decision Making</h2>
                                            <a data-toggle="collapse" href="#competency_2" role="button" aria-expanded="false" aria-controls="communication" class="view_questions_response collapsed" data-comid="2">
                                                View questions
                                                <svg class="arrow-down" width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1 1.5L6 6.5L11 1.5" stroke="#7E9EC2" stroke-width="2"></path>
                                                </svg>
                                                <svg width="12" class="arrow-up" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1 6.5L6 1.5L11 6.5" stroke="#0071F7" stroke-width="2"></path>
                                                </svg>
                                            </a> 
                                        </div>
                                        <div class="progress-wrapper">
                                            <ul class="list-unstyled">
                                                <li class="score-line">
                                                    <p class="score-title text-primary">Organization</p>
                                                    <div class="score-bar-wrapper">
                                                        <div class="score-bar" style="width: 70%; background-color: #0071F7"></div>
                                                    </div>
                                                </li>  
                                                <li class="score-line">
                                                    <p class="score-title text-primary">Benchmark 1</p>
                                                    <div class="score-bar-wrapper">
                                                        <div class="score-bar" style="width: 50%; background-color: #029942"></div>
                                                    </div>
                                                </li>  
                                                <li class="score-line">
                                                    <p class="score-title text-primary">Benchmark 2</p>
                                                    <div class="score-bar-wrapper">
                                                        <div class="score-bar" style="width: 80%; background-color: #F70085"></div>
                                                    </div>
                                                </li>  
                                                <li class="score-line">
                                                    <p class="score-title text-primary">Benchmark 3</p>
                                                    <div class="score-bar-wrapper">
                                                        <div class="score-bar" style="width: 50%; background-color: #0c143e"></div>
                                                    </div>
                                                </li>  
                                                <li class="score-line">
                                                    <p class=""></p>
                                                    <ul class="list-unstyled score-x-value">
                                                        <li class="text-primary">0</li>
                                                        <li class="text-primary">20</li>
                                                        <li class="text-primary">40</li>
                                                        <li class="text-primary">60</li>
                                                        <li class="text-primary">80</li>
                                                        <li class="text-primary">100</li>
                                                    </ul>
                                                </li>
                                            </ul>                                                  
                                        </div>
                                    </header>
                                    <div class="competency-response competency-response-detail collapse" id="competency_2" aria-expanded="false" style="height: 20px;">
                                        <div class="question-response-detail">
                                            <b>Question 1:</b>
                                            <div class="question-desc">
                                                <p> 
                                                    <span>Acts as a champion for change</span>
                                                </p>
                                            </div>   
                                            <div class="progress-wrapper">
                                                <ul class="list-unstyled">
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Organization</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 70%; background-color: #0071F7"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 1</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 50%; background-color: #029942"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 2</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 80%; background-color: #F70085"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 3</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 50%; background-color: #0c143e"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class=""></p>
                                                        <ul class="list-unstyled score-x-value">
                                                            <li class="text-primary">0</li>
                                                            <li class="text-primary">20</li>
                                                            <li class="text-primary">40</li>
                                                            <li class="text-primary">60</li>
                                                            <li class="text-primary">80</li>
                                                            <li class="text-primary">100</li>
                                                        </ul>
                                                    </li>
                                                </ul>                                                  
                                            </div>                                        
                                        </div>
                                        <div class="question-response-detail">
                                            <b>Question 2:</b>
                                            <div class="question-desc">
                                                <p> 
                                                    <span>Helps employees develop a clear understanding of what they will need to do differently as a result of changes in the organization</span>
                                                </p>
                                            </div>   
                                            <div class="progress-wrapper">
                                                <ul class="list-unstyled">
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Organization</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 70%; background-color: #0071F7"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 1</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 50%; background-color: #029942"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 2</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 80%; background-color: #F70085"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 3</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 50%; background-color: #0c143e"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class=""></p>
                                                        <ul class="list-unstyled score-x-value">
                                                            <li class="text-primary">0</li>
                                                            <li class="text-primary">20</li>
                                                            <li class="text-primary">40</li>
                                                            <li class="text-primary">60</li>
                                                            <li class="text-primary">80</li>
                                                            <li class="text-primary">100</li>
                                                        </ul>
                                                    </li>
                                                </ul>                                                  
                                            </div>                                                                                 
                                        </div>
                                        <div class="question-response-detail">
                                            <b>Question 3:</b>
                                            <div class="question-desc">
                                                <p> 
                                                    <span>Establishes the structures and processes to plan and manage the orderly implementation of change</span>
                                                </p>
                                            </div>   
                                            <div class="progress-wrapper">
                                                <ul class="list-unstyled">
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Organization</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 70%; background-color: #0071F7"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 1</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 50%; background-color: #029942"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 2</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 80%; background-color: #F70085"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 3</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 50%; background-color: #0c143e"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class=""></p>
                                                        <ul class="list-unstyled score-x-value">
                                                            <li class="text-primary">0</li>
                                                            <li class="text-primary">20</li>
                                                            <li class="text-primary">40</li>
                                                            <li class="text-primary">60</li>
                                                            <li class="text-primary">80</li>
                                                            <li class="text-primary">100</li>
                                                        </ul>
                                                    </li>
                                                </ul>                                                  
                                            </div>                                                                                  
                                        </div>
                                        <div class="question-response-detail">
                                            <b>Question 4:</b>
                                            <div class="question-desc">
                                                <p> 
                                                    <span>Demonstrates support for innovation and organizational changes needed to improve the organization's effectiveness</span>
                                                </p>
                                            </div>   
                                            <div class="progress-wrapper">
                                                <ul class="list-unstyled">
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Organization</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 70%; background-color: #0071F7"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 1</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 50%; background-color: #029942"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 2</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 80%; background-color: #F70085"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 3</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 50%; background-color: #0c143e"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class=""></p>
                                                        <ul class="list-unstyled score-x-value">
                                                            <li class="text-primary">0</li>
                                                            <li class="text-primary">20</li>
                                                            <li class="text-primary">40</li>
                                                            <li class="text-primary">60</li>
                                                            <li class="text-primary">80</li>
                                                            <li class="text-primary">100</li>
                                                        </ul>
                                                    </li>
                                                </ul>                                                  
                                            </div>                                                                                  
                                        </div>
                                        <div class="question-response-detail">
                                            <b>Question 5:</b>
                                            <div class="question-desc">
                                                <p> 
                                                    <span>Takes a lead in uncertain situations and circumstances</span>
                                                </p>
                                            </div>   
                                            <div class="progress-wrapper">
                                                <ul class="list-unstyled">
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Organization</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 70%; background-color: #0071F7"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 1</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 50%; background-color: #029942"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 2</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 80%; background-color: #F70085"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 3</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 50%; background-color: #0c143e"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class=""></p>
                                                        <ul class="list-unstyled score-x-value">
                                                            <li class="text-primary">0</li>
                                                            <li class="text-primary">20</li>
                                                            <li class="text-primary">40</li>
                                                            <li class="text-primary">60</li>
                                                            <li class="text-primary">80</li>
                                                            <li class="text-primary">100</li>
                                                        </ul>
                                                    </li>
                                                </ul>                                                  
                                            </div>                                                                                 
                                        </div>
                                        <div class="question-response-detail">
                                            <b>Question 6:</b>
                                            <div class="question-desc">
                                                <p> 
                                                    <span>Initiates, sponsors and implements organizational changes</span>
                                                </p>
                                            </div>   
                                            <div class="progress-wrapper">
                                                <ul class="list-unstyled">
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Organization</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 70%; background-color: #0071F7"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 1</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 50%; background-color: #029942"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 2</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 80%; background-color: #F70085"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 3</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 50%; background-color: #0c143e"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class=""></p>
                                                        <ul class="list-unstyled score-x-value">
                                                            <li class="text-primary">0</li>
                                                            <li class="text-primary">20</li>
                                                            <li class="text-primary">40</li>
                                                            <li class="text-primary">60</li>
                                                            <li class="text-primary">80</li>
                                                            <li class="text-primary">100</li>
                                                        </ul>
                                                    </li>
                                                </ul>                                                  
                                            </div>                                                                                 
                                        </div>
                                        <div class="question-response-detail">
                                            <b>Question 7:</b>
                                            <div class="question-desc">
                                                <p> 
                                                    <span>Accepts ambiguity that comes with change activities</span>
                                                </p>
                                            </div>   
                                            <div class="progress-wrapper">
                                                <ul class="list-unstyled">
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Organization</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 70%; background-color: #0071F7"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 1</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 50%; background-color: #029942"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 2</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 80%; background-color: #F70085"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class="score-title text-primary">Benchmark 3</p>
                                                        <div class="score-bar-wrapper">
                                                            <div class="score-bar" style="width: 50%; background-color: #0c143e"></div>
                                                        </div>
                                                    </li>  
                                                    <li class="score-line">
                                                        <p class=""></p>
                                                        <ul class="list-unstyled score-x-value">
                                                            <li class="text-primary">0</li>
                                                            <li class="text-primary">20</li>
                                                            <li class="text-primary">40</li>
                                                            <li class="text-primary">60</li>
                                                            <li class="text-primary">80</li>
                                                            <li class="text-primary">100</li>
                                                        </ul>
                                                    </li>
                                                </ul>                                                  
                                            </div>                                                                                 
                                        </div>
                                    </div> 
                                </section>
                            </div>

                        </div>

                        <div id="option" class="tab-pane fade">
                        
                            <h3>Tab 2</h3>
                          
                            <p>Tab 2 content</p>
                        
                        </div> 
                        
                    </div> 
                    
                </div>
                
            </div>

        </div>

    </section>
  </div>

<script src="https://cdn.amcharts.com/lib/4/core.js"></script>

<script src="https://cdn.amcharts.com/lib/4/charts.js"></script> 
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

<!-- for world cloud -->
<script src="https://cdn.amcharts.com/lib/4/plugins/wordCloud.js"></script> 

<script src="<?php echo base_url() ?>asset/admin_asset/js/handlebars.min.js"></script>

<script src="<?php echo base_url() ?>asset/admin_asset/js/analyze.js"></script>