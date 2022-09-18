
(function(){
    
    const url = window.location.href;    
    const baseUrl = url.substring(0, url.indexOf('participant')) || url.substring(0, url.indexOf('evaluation'));
    let company_setting   =   {}; 

    const Analyze = (function(){
        return {     
            reisterHelpers: function(){      
                var helpers = (function () {
                    return {
                        inc: function(value){
                            return value + 1;
                        },
                        toPercentage: function(value){                    
                            return value + '%';
                        },
                        getColor: function(label){
                            const colors = {
                                self: '#0071F7',
                                manager: '#029942',
                                peers: '#F70085', //'#FF2372',
                                direct_report: '#F70085'
                            }
                            return colors[label.toLowerCase()];
                        },                        
                        getColorIndex: function(index){
                            const colors = ['blue','green','pink','black'];
                            return index >= 0 && index <= colors.length ? colors[index] : 0;
                        },
                        notLineManager: function(relationship, options){ 
                            return relationship.toLowerCase() !== 'line manager' ? options.fn(this) : options.inverse(this)
                        },
                        notSelf: function(relationship, options){ 
                            return relationship.toLowerCase() !== 'self' ? options.fn(this) : options.inverse(this)
                        },
                        getSettingName: function(name){
                            if(name == 'Peer' && company_setting.use_peer == 1) return company_setting.peer_name;
                            if(name == 'Direct Report' && company_setting.use_direct_report == 1) return company_setting.direct_report_name;
                            let result = name.charAt(0).toUpperCase() + name.slice(1).toLowerCase();
                            return result.replace(/\_/g,' ');
                        },
                        useSettingName: function(relationship, options){ 
                            let active = true;
                            switch(relationship){
                                case 'Peer':
                                    active = (company_setting.use_peer == 1) ? true : false;
                                break;
                                case 'Direct Report':
                                    active = (company_setting.use_direct_report == 1) ? true : false;
                                break;
                            }
                            return active ? options.fn(this) : options.inverse(this);
                        },
                        to2DP: function(avg){
                            return parseFloat(avg).toFixed(2);
                        },
                        toSum: function(data, key){
                            let total = 0;
                            data.forEach(function(obj){
                                total += parseFloat(obj[key]);
                            })
                            return parseFloat(total / data.length).toFixed(2);
                        },
                        toOverallSum: function(data){
                            let selftotal = 0;
                            data.forEach(function(obj){
                                selftotal += parseFloat(obj['self']);
                            })
                            const selfavg = parseFloat(selftotal / data.length).toFixed(2);

                            let mgrtotal = 0;
                            data.forEach(function(obj){
                                mgrtotal += parseFloat(obj['line_manager']);
                            })
                            const mgravg = parseFloat(mgrtotal / data.length).toFixed(2);

                            let tmtotal = 0;
                            data.forEach(function(obj){
                                tmtotal += parseFloat(obj['team_members']);
                            })
                            const tmavg = parseFloat(tmtotal / data.length).toFixed(2);
                            
                            return parseFloat(((parseFloat(mgravg) + parseFloat(tmavg)) / 2)).toFixed(2);
                        }
                    }
                }())          
                Object.keys(helpers).forEach(function (prop) {
                    JSTemplate.registerHelper(prop,helpers[prop])
                });
                Array.prototype.remove = function() {
                    var what, a = arguments, L = a.length, ax;
                    while (L && this.length) {
                        what = a[--L];
                        while ((ax = this.indexOf(what)) !== -1) {
                            this.splice(ax, 1);
                        }
                    }
                    return this;
                };
            },    
            generatePaging: function(info, selector){ 
                let result = [];
                for(i=0; i < info.pages; i++){ 
                    result.push({
                        label: (i === 0 ? 1 : ((i > 1 ? 1 : i) + (i * info.length))) + '-' + ((i * info.length) + info.length),
                        index: i          
                    })
                }
                //rendr menu
                $(selector).html('')
                result.forEach(function(obj){
                    $(selector).append('<option data-page="'+ obj.index +'">'+ obj.label +'</option>');
                });
            },
            generateDate: function(startDate, endDate) {
                var dates = [],
                    currentDate = startDate,
                    addDays = function(days) {
                        var date = new Date(this.valueOf());
                        date.setDate(date.getDate() + days);
                        return date;
                    };
                while (currentDate <= endDate) {
                    dates.push({
                        formated: moment(currentDate).format('MMM DD, YYYY'),
                        datetime: moment(currentDate).format('YYYY-MM-DD HH:MM:SS')
                    });
                    currentDate = addDays.call(currentDate, 1);
                }
                return dates; 
            },  
            getSettingName: function(name){
                if(name == 'peers' && company_setting.use_peer == 1) return company_setting.peer_name;
                if(name == 'direct_report' && company_setting.use_direct_report == 1) return company_setting.direct_report_name;
                let result = name.charAt(0).toUpperCase() + name.slice(1).toLowerCase();
                return result.replace(/\_/g,' ');
            },
            replaceSettingName: function(name){
                if((name == 'Peer' || name == 'Peers') && company_setting.use_peer == 1) return company_setting.peer_name;
                if((name == 'Direct Report' || name == 'Direct reports') && company_setting.use_direct_report == 1) return company_setting.direct_report_name;
                let result = name.charAt(0).toUpperCase() + name.slice(1).toLowerCase();
                return result.replace(/\_/g,' ');
            },
            getCompanySetting: function(cb){
                // get company level and use across the app
                fetch(baseUrl + 'admin/get_company_setting/')
                .then(response => response.json())
                .then(result => {
                    //set views 
                    localStorage.setItem('company_setting', JSON.stringify(result.data));
                    company_setting = result.data;
                    cb(company_setting);
                })
                .catch(error => {
                    console.error('Error:', error);
                });

            },

            //Page 4.
            initSurveyorsummary: function(data, date_from = '', date_to = ''){
                if(!document.getElementById('no_of_self')) return;   
                const participant = data; 
 
                $('.participant_title').html(participant ? participant.first_name + ' ' + participant.last_name : ''); 

                $('.no_of_surveyors').html(participant ? participant.surveyors.total_surveyors : '0')

                $('#participant_grade').html(participant.grade);
                $('#no_of_self').html(participant.surveyors.leaders);
                $('#no_of_manager').html(participant.surveyors.managers);
                
                if(company_setting.use_peer == 1){
                    $('#use_peer').find('.balls-label').html(company_setting.peer_name + ' (<span id="no_of_dreport">'+ participant.surveyors.peers +'</span>)');                   
                }else{
                    $('#use_peer').remove();
                }

                if(company_setting.use_direct_report == 1){
                    $('#use_direct_report').find('.balls-label').html(company_setting.direct_report_name + ' (<span id="no_of_dreport">'+ participant.surveyors.direct_reports +'</span>)');                   
                }else{
                    $('#use_direct_report').remove();
                }

                const colors = {
                    self: '#0071F7',
                    manager: '#029942',
                    peers: '#F70085', //'#FF2372',
                    direct_report: '#F70085'
                }
                $('.ball-content.self').find('span.balls').css({backgroundColor: colors['self'] });
                $('.ball-content.manager').find('span.balls').css({backgroundColor: colors['manager']});
                $('.ball-content.peers').find('span.balls').css({backgroundColor: colors['peers']});
                $('.ball-content.direct_report').find('span.balls').css({backgroundColor: colors['direct_report']}); 

                const total_response = (participant.surveyors.leaders + participant.surveyors.managers + participant.surveyors.peers + participant.surveyors.direct_reports);
                $('.total_sresponse').html(total_response);
            },
            initMultipleRadar: function(selector, data, date_from = '', date_to = ''){               

                if(!document.getElementById(selector)) return; 

                am4core.ready(function() {

                    // Themes begin
                    am4core.useTheme(am4themes_animated);
                    // Themes end
                    
                    /* Create chart instance */
                    var chart = am4core.create(selector, am4charts.RadarChart);
                    
                    /* Add data */
                    chart.data = data;
                    
                    /* Create axes */
                    var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                    categoryAxis.dataFields.category = "competencies";
                    var label = categoryAxis.renderer.labels.template;
                    label.wrap = true;
                    label.maxWidth = 120;
                                        
                    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                    valueAxis.min = 0;
                    valueAxis.max = 5;
                    
                    /* Create and configure series */
                    
                    if(chart.data.length > 0){                        

                        const keys = Object.keys(chart.data[0]); 

                        // remove key if not active in settings
                        if(company_setting.use_peer == 0){
                            keys.remove('peers'); 
                        }
                        if(company_setting.use_direct_report == 0){
                            keys.remove('direct_report'); 
                        }  

                        const colors = {
                            self: '#0071F7',
                            manager: '#029942',
                            peers: '#F70085', //'#FF2372',
                            direct_report: '#F70085'
                        } 
                        keys.forEach(function(key, i){ 
                            if(key !== 'competencies'){
                                const series = chart.series.push(new am4charts.RadarSeries()); 
                                series.dataFields.valueY = key;                              
                                series.dataFields.categoryX = "competencies";
                                series.name = key;
                                series.strokeWidth = 1; 
                                series.fill = am4core.color(colors[key]);
                                series.tooltipText = "Series: {name}\nCategory: {categoryX}\nScore: {valueY}";     
                                series.stroke =  am4core.color(colors[key]);

                                bullet = series.bullets.push(new am4charts.Bullet());
                                circle = bullet.createChild(am4core.Circle);
                                circle.width = 6;
                                circle.height = 6; 
                            }
                        });
                    }                        
                    
                });

            },
            initCompetencyResponses: function(competency_summary, date_from = '', date_to = ''){
                function compute_percentage_avg($my_surveyors, $total_comp_questions, $max_option_value, $compute_average){ 
                    //expected_average result to value that makes 100%
                    if($my_surveyors == 0) return 0;
                    $expected_average = (($max_option_value * $total_comp_questions * $my_surveyors) / ($my_surveyors * $total_comp_questions)); 
                    return Math.round((100 * $compute_average) / $expected_average);
                }

                const processedData = competency_summary.map(function(obj){ 
                    let newObj = $.extend(true,{},obj); 
                    const keys = Object.keys(obj);
                    // remove key if not active in settings
                    if(company_setting.use_peer == 0){
                        keys.remove('peers'); 
                    }
                    if(company_setting.use_direct_report == 0){
                        keys.remove('direct_report'); 
                    } 
                    newObj['evaluator_categories'] = [];
                    keys.forEach(function(key, i){
                        if(['self','manager','peers','direct_report'].indexOf(key) !== -1){
                            const compute_average = (newObj[key].my_surveyors == 0) ? 0 : (newObj[key].total_score / (newObj[key].my_surveyors * newObj[key].total_comp_questions));
                            newObj[key]['percent'] = compute_percentage_avg(newObj[key].my_surveyors, newObj[key].total_comp_questions, newObj[key].max_option_value, compute_average); 
                            newObj[key]['label'] = Analyze.getSettingName(key);
                            newObj[key]['actual_label'] = key;
                            newObj['evaluator_categories'].push(newObj[key]);
                        }                                      
                    });  
                    return newObj;
                });  

                const source = document.getElementById("competency_responses").innerHTML;
                const htmlstr = JSTemplate.compile(source)({ competency_summary: processedData });  
                $('.competency_responses').html(htmlstr);    
                //view_questions_response
                $('body .view_questions_response').on('click', function(){
                    $question_detail_cont = $(this).closest('.competency-response-header').siblings('.competency-response-detail');
                    if($question_detail_cont.find('.card-skeleton').length){
                        //fetch questions
                        const url = window.location.pathname.split('/');
                        const survey_participant_id = window.location.pathname.endsWith('/') ? url[url.length - 2] : url[url.length - 1];  
                        const competency_id = $(this).data('comid'); 
                        Analyze.fetchAnalyzeComptenciesQuestionScore(survey_participant_id, competency_id,  $question_detail_cont);
                    }
                });     
                //
                $('.section-navigation-btn').on('click', function (e) {
                    e.preventDefault();                
                    var target = $(this).data("href");
                
                    if ($(target).length) {
                        $('html, body').stop().animate({
                          scrollTop: $(target).offset().top
                        }, 1000, function () {
                            
                        });
                    }
                
                    return false;
                  });
            },
            initCompetencyQuestionResponses: function(competencies_question_score, $question_detail_cont){
                function compute_percentage_avg($my_surveyors, $total_comp_questions, $max_option_value, $compute_average){ 
                    //expected_average result to value that makes 100%
                    if($my_surveyors == 0) return 0;
                    $expected_average = (($max_option_value * $total_comp_questions * $my_surveyors) / ($my_surveyors * $total_comp_questions)); 
                    return Math.round((100 * $compute_average) / $expected_average);
                }

                const processedData = competencies_question_score.map(function(obj){
                    let obNew = $.extend(true,{},obj); 
                    const keys = Object.keys(obj);
                    // remove key if not active in settings
                    if(company_setting.use_peer == 0){
                        keys.remove('peers'); 
                    }
                    if(company_setting.use_direct_report == 0){
                        keys.remove('direct_report'); 
                    } 
                    obNew['evaluator_categories'] = [];
                    keys.forEach(function(key, i){
                        if(['self','manager','peers','direct_report'].indexOf(key) !== -1){
                            const avg = (obNew[key].my_surveyors == 0) ? 0 : (obNew[key].total_score / obNew[key].my_surveyors);
                            obNew[key]['percent'] = compute_percentage_avg(obNew[key].my_surveyors, obNew[key].total_comp_questions, obNew[key].max_option_value, avg);
                            obNew[key]['label'] = Analyze.getSettingName(key);                            
                            obNew[key]['actual_label'] = key;
                            obNew['evaluator_categories'].push(obNew[key]);
                        }                                      
                    });
                    return obNew; 
                }); 

                const source = document.getElementById("competency_questions_responses").innerHTML;
                const htmlstr = JSTemplate.compile(source)({ questions: processedData });  
                $question_detail_cont.html(htmlstr);           
            },
            initOpenEndedResponses: function(open_ended, date_from = '', date_to = ''){

                const source = document.getElementById("openended_responses").innerHTML;
                const htmlstr = JSTemplate.compile(source)({ open_ended: open_ended });  
                $('.openended_responses').html(htmlstr);  

                //pmf open responses
                const sourcepmf = document.getElementById("openended_responses_cont").innerHTML;
                const htmlstrpmf = JSTemplate.compile(sourcepmf)({ open_ended: open_ended });  
                $('.openended_responses_cont').html(htmlstrpmf); 

                $('.section-navigation-btn').on('click', function (e) {
                    e.preventDefault();                
                    var target = $(this).data("href"); 
                
                    if ($(target).length) {
                        $('html, body').stop().animate({
                            scrollTop: $(target).offset().top
                        }, 1000, function () { 
                        });
                    }
                
                    return false;
                });                  
                //request feedback event
                $('.request-feedback').on('click', function(){
                    const btndom = $(this);
                    const data = btndom.data();

                    btndom.addClass("loading-start");
                    btndom.attr("disabled",true);

                    $.ajax({
                        url: baseUrl + 'admin/request_feedback/',
                        type: 'POST',
                        data: data,
                        error: function(err) {
                            console.log(err, ' something went wrong'); 
                        },
                        success: function(result){ 
                            const responseData = JSON.parse(result); 
                            btndom.removeClass("loading-start").removeAttr("disabled");
                            alert('Feedback request submitted')
                        }
                    });   
                })      
                     
                $('.view-feedback').on('click', function(){
                    bootbox.alert({ 
                        title: "Feedback",
						message: $(this).data('feedback'),
						closeButton: false, 
						onHide: function(e) {
						console.log('hide')
						} 
					});
                })       
            },     
            fetchOpenEndedResponse: function(survey_participant_id){                
                return new Promise(function(resolve, reject){
                    fetch(baseUrl + 'participant/fetch_open_ended_response/' + survey_participant_id)
                    .then(response => response.json())
                    .then(result => { 
                        Analyze.initOpenEndedResponses(result.data.open_ended_response);  
                    }).catch(function(err){
                        reject(err);
                    })
                }) 
            },    
            fetchAnalyzeComptenciesQuestionScore: function(survey_participant_id, competency_id, $question_detail_cont){
                return new Promise(function(resolve, reject){
                    fetch(baseUrl + 'participant/fetch_competencies_question_score/' + survey_participant_id +'/' + competency_id)
                    .then(response => response.json())
                    .then(result => {                  
                        resolve();   
                        //init question responses summary                     
                        Analyze.initCompetencyQuestionResponses(result.data.competencies_question_score, $question_detail_cont); 
                    }).catch(function(err){
                        reject(err);
                    })
                }) 
            },              
            fetchAnalyzeRadarChart: function(survey_participant_id){
                return new Promise(function(resolve, reject){
                    fetch(baseUrl + 'participant/fetch_competencies_radar_score/' + survey_participant_id)
                    .then(response => response.json())
                    .then(result => { 
                        resolve();                        
                        const data = (function(data){
                            return data.map(function(obj, index){
                                let newObj = $.extend(true,{},obj);
                                const keys = Object.keys(obj);
                                keys.forEach(function(key, i){
                                    if(['self','manager','peers','direct_report'].indexOf(key) !== -1){
                                        newObj[key] = (obj[key].avg); //force average to be 5 max;
                                    }                                      
                                });  
                                return newObj;                              
                            });
                        }(result.data.competencies_radar_score));

                        Analyze.initMultipleRadar('multiple_radar',data);
                        Analyze.initMultipleRadar('multiple_radar_2',data);                       
                        
                        Analyze.initCompetencyResponses(result.data.competencies_radar_score); 
                        Analyze.initPMFCompetencyResponses(result.data.competencies_radar_score);

                    }).catch(function(err){
                        reject(err);
                    })
                })                 
            },
            fetchAnalyzeSurveyor: function(survey_participant_id){
                return new Promise(function(resolve, reject){
                    fetch(baseUrl + 'participant/fetch_analyze_surveyors/' + survey_participant_id)
                    .then(response => response.json())
                    .then(result => { 
                        resolve();
                        Analyze.initSurveyorsummary(result.data.surveyors);  
                    }).catch(function(err){
                        reject(err);
                    })
                }) 
            },            
            initAnalyze: function(){
                if(!document.getElementById('multiple_radar')) return; 
     
                async function loadAnalyzeParticipant(date_from = '', date_to = ''){
                    const url = window.location.pathname.split('/');
                    const survey_participant_id = window.location.pathname.endsWith('/') ? url[url.length - 2] : url[url.length - 1];  

                    Analyze.fetchAnalyzeSurveyor(survey_participant_id);
                    Analyze.fetchAnalyzeRadarChart(survey_participant_id);
                    Analyze.fetchOpenEndedResponse(survey_participant_id);
                    // await Analyze.fetchAnalyzeComptenciesOverallScore(employee_number);
                    $('#fetchpmf').on('click', function(){
                        $('#download-report').html('Loading, Please wait...');
                        Analyze.fetchPMFRadarChart(survey_participant_id);
                        Analyze.fetchPMFStrengthAndOpportunity(survey_participant_id);
                        Analyze.fetchPMFQuestionsCriteriaScore(survey_participant_id);
                        Analyze.fetchPMFDetailAnalysis(survey_participant_id);
                    });
                }

                const $surveydate = $('#surveydate-dropdown');
                fetch(baseUrl + 'participant/fetch_daterange/')
                .then(response => response.json())
                .then(result => { 
                    
                    loadAnalyzeParticipant();

                    const dateRange = result ? result.date_range : {};
                    const dates = Analyze.generateDate(new Date(dateRange.start_date), new Date(dateRange.end_date));
                    $surveydate.daterangepicker({
                        startDate: moment(dateRange.start_date).format('MM/DD/YYYY'),
                        endDate  : moment(dateRange.end_date).format('MM/DD/YYYY'),                        
                        minDate: moment(dateRange.start_date).format('MM/DD/YYYY'),
                        maxDate  : moment(dateRange.end_date).format('MM/DD/YYYY'),
                        // singleDatePicker: true,
                        showCustomRangeLabel: false,
                        autoUpdateInput: true
                    }, function (start, end) { 
                        loadAnalyzeParticipant(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));  
                    });
                })
            },   
            loadAnalyzeMe: function(survey_participant_id, program_id){
                if(!document.getElementById('multiple_radar')) return; 
     
                async function loadAnalyzeParticipant(date_from = '', date_to = ''){
                    await Analyze.fetchAnalyzeSurveyor(survey_participant_id);
                    await Analyze.fetchAnalyzeRadarChart(survey_participant_id);
                    await Analyze.fetchOpenEndedResponse(survey_participant_id);
                    // await Analyze.fetchAnalyzeComptenciesOverallScore(survey_participant_id);
                }

                const $surveydate = $('#surveydate-dropdown');
                loadAnalyzeParticipant();

                // const dateRange = result ? result.date_range : {};
                const start_date = $('#program-select-participant').find('option:selected').data('startdate');
                const end_date = $('#program-select-participant').find('option:selected').data('enddate');

                $surveydate.daterangepicker({
                    startDate: moment(start_date).format('MM/DD/YYYY'),
                    endDate  : moment(end_date).format('MM/DD/YYYY'),                        
                    minDate: moment(start_date).format('MM/DD/YYYY'),
                    maxDate  : moment(end_date).format('MM/DD/YYYY'),
                    // singleDatePicker: true,
                    showCustomRangeLabel: false,
                    autoUpdateInput: true
                }, function (start, end) { 
                    loadAnalyzeParticipant(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));  
                });
            }, 
            initAnalyzeMeSummary: function(){ 

                if(!document.getElementById('program-select-participant')) return;
                
                //.eg http://localhost:90/participant/analyze_me/<survey_participant_id>-<survey_id>            
                //.eg http://localhost:90/participant/analyze_me/5-2
                
                const url = window.location.pathname.split('/');
                const query_slug = url[url.length - 1];  //e.g<survey_participant_id>-<survey_id>
                const survey_participant_id = query_slug.split('-')[0];
                let survey_id = query_slug.split('-')[1];

                $('#program-select-participant').val(survey_id);
                let program_id =  $('#program-select-participant').find('option:selected').data('program')
                if(!program_id){
                    alert('No survey was selected');
                    return;
                }

                localStorage.setItem('pid', program_id);     
                Analyze.loadAnalyzeMe(survey_participant_id, program_id);

                $('#program-select-participant').on('change', function(){
                    survey_id = $(this).val();
                    program_id = $(this).find('option:selected').data('program');
                    alert(program_id);
                    if(!program_id) return;
                    localStorage.setItem('pid', program_id);                    
                    Analyze.loadAnalyzeMe(survey_participant_id, program_id); 
                });

            },

            // PMF            
            fetchPMFRadarChart: function(survey_participant_id){
                return new Promise(function(resolve, reject){
                    fetch(baseUrl + 'admin/fetch_pmf_radar_score/' + survey_participant_id)
                    .then(response => response.json())
                    .then(result => { 
                        resolve();
                        Analyze.initPMFMultipleRadar((function(data){
                            return data.map(function(obj, index){
                                let newObj = $.extend(true,{},obj);
                                const keys = Object.keys(obj);
                                keys.forEach(function(key, i){
                                    if(['self','manager','peers','direct_report'].indexOf(key) !== -1){
                                        newObj[key] = (obj[key].avg); //force average to be 5 max;
                                    }                                      
                                });  
                                return newObj;                              
                            });
                        }(result.data.competencies_radar_score)));
                    }).catch(function(err){
                        reject(err);
                    })
                })                 
            },            
            initPMFMultipleRadar: function(data, date_from = '', date_to = ''){

                if(!document.getElementById('multiple_radar_pmf')) return;
                am4core.ready(function() {

                    // Themes begin
                    am4core.useTheme(am4themes_animated);
                    // Themes end
                    
                    /* Create chart instance */
                    var chart = am4core.create("multiple_radar_pmf", am4charts.RadarChart);
                    
                    /* Add data */
                    chart.data = data.filter(function(obj){
                        return obj.pmf.toLowerCase() !== 'pmf to self';
                    });
                    
                    /* Create axes */
                    var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                    categoryAxis.dataFields.category = "pmf";
                    var label = categoryAxis.renderer.labels.template;
                    label.wrap = true;
                    label.maxWidth = 120;
                                        
                    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                    valueAxis.min = 0;
                    valueAxis.max = 5; //for max to be 5
                    
                    /* Create and configure series */
                    if(chart.data.length > 0){
                        let keys = Object.keys(chart.data[0]);

                        // remove key if not active in settings
                        if(company_setting.use_peer == 0){
                            keys.remove('peers'); 
                        }
                        if(company_setting.use_direct_report == 0){
                            keys.remove('direct_report'); 
                        } 
                        
                        const colors = {
                            self: '#0071F7',
                            manager: '#029942',
                            peers: '#F70085', //'#FF2372',
                            direct_report: '#F70085'
                        }  
                        keys.forEach(function(key, i){ 
                            if(key !== 'pmf' && keys){
                                const series = chart.series.push(new am4charts.RadarSeries());                                
                                series.dataFields.valueY = key;                              
                                series.dataFields.categoryX = "pmf";
                                series.name = key;
                                series.strokeWidth = 1; 
                                series.fill = am4core.color(colors[key]);
                                series.tooltipText = "Series: {name}\nCategory: {categoryX}\nScore: {valueY}";     
                                series.stroke =  am4core.color(colors[key]);

                                bullet = series.bullets.push(new am4charts.Bullet());
                                circle = bullet.createChild(am4core.Circle);
                                circle.width = 6;
                                circle.height = 6; 
                            }
                        });
                    }                        
                    
                });
            },
            initPMFCompetencyResponses: function(competency_summary, date_from = '', date_to = ''){

                function compute_percentage_avg($my_surveyors, $total_comp_questions, $max_option_value, $compute_average){ 
                    //expected_average result to value that makes 100%
                    if($my_surveyors == 0) return 0;
                    $expected_average = (($max_option_value * $total_comp_questions * $my_surveyors) / ($my_surveyors * $total_comp_questions)); 
                    return Math.round((100 * $compute_average) / $expected_average);
                }

                const processedData = competency_summary.map(function(obj){  
                    let newObj = $.extend(true,{},obj); 
                    const keys = Object.keys(obj);
                    // remove key if not active in settings
                    if(company_setting.use_peer == 0){
                        keys.remove('peers'); 
                        delete obj['peers'];
                        delete newObj['peers'];
                    }
                    if(company_setting.use_direct_report == 0){
                        keys.remove('direct_report'); 
                        delete obj['direct_report'];
                        delete newObj['direct_report'];
                    }  

                    //for self
                    newObj['evaluator_categories'] = [];
                    keys.forEach(function(key, i){
                        if(['self'].indexOf(key) !== -1){
                            const compute_average = (newObj[key].my_surveyors == 0) ? 0 : (newObj[key].total_score / (newObj[key].my_surveyors * newObj[key].total_comp_questions));
                            newObj[key]['percent'] = compute_percentage_avg(newObj[key].my_surveyors, newObj[key].total_comp_questions, newObj[key].max_option_value, compute_average); 
                            newObj[key]['label'] = 'Self Evaluation';
                            newObj[key]['actual_label'] = key;
                            newObj['evaluator_categories'].push(newObj[key]);
                        }                                      
                    }); 

                    //for other surveyors 
                    let total_score = 0;
                    let my_other_surveyors = 0;
                    let total_comp_questions = 0;
                    let max_option_value = 0;
                    let avg = 0;
                    const othersKey = 'others';
                    keys.forEach(function(k, i){
                        //other surveyors total
                        if(['manager','peers','direct_report'].indexOf(k) !== -1){
                            total_score += parseInt(obj[k].total_score);
                            my_other_surveyors += obj[k].my_surveyors;
                            total_comp_questions = obj[k].total_comp_questions;
                            max_option_value = obj[k].max_option_value;

                            //remove unwanted keys 
                            delete newObj[k];
                        }                                      
                    }); 
                    avg = (my_other_surveyors == 0) ? 0 : (total_score / (my_other_surveyors * total_comp_questions));
                    
                    newObj[othersKey] = {};
                    newObj[othersKey]['avg'] = avg.toFixed(1);
                    newObj[othersKey]['total_comp_questions'] = total_comp_questions;
                    newObj[othersKey]['my_surveyors'] = my_other_surveyors;
                    newObj[othersKey]['max_option_value'] = max_option_value;
                    newObj[othersKey]['total_score'] = total_score;
                    
                    newObj[othersKey]['percent'] = compute_percentage_avg(my_other_surveyors, total_comp_questions, max_option_value, avg); 
                    newObj[othersKey]['label'] = 'Other Evaluators';
                    newObj[othersKey]['actual_label'] = othersKey;
                    newObj['evaluator_categories'].push(newObj[othersKey]);

                    return newObj;                     
                }); 

                const source = document.getElementById("pmf_competency_responses").innerHTML;
                const htmlstr = JSTemplate.compile(source)({ competency_summary: processedData });  
                $('#pmf_competency_responses_cont').html(htmlstr);    
            },
            fetchPMFQuestionsCriteriaScore: function(survey_participant_id){
                return new Promise(function(resolve, reject){
                    fetch(baseUrl + 'admin/fetch_pmf_question_criteria_scores/' + survey_participant_id)
                    .then(response => response.json())
                    .then(result => { 
                        resolve();            

                        result.data.competencies_radar_score = result.data.competencies_radar_score.map(function(obj){
                            //get divisor for top strength and opportunities
                            if(company_setting.use_peer && company_setting.use_direct_report){
                                obj['others_avg'] =  (obj.manager.avg + obj.peers.avg + obj.direct_report.avg) / 3;
                            }else if(company_setting.use_peer){
                                obj['others_avg'] =  (obj.manager.avg + obj.peers.avg) / 2;
                            }else if(company_setting.use_direct_report){
                                obj['others_avg'] =  (obj.manager.avg + obj.direct_report.avg) / 2;
                            }else{
                                obj['others_avg'] =  obj.manager.avg;
                            }
                            obj['others_avg'] = obj['others_avg'].toFixed(2);
                            return obj;
                        }) 
                        
                        //group by key
                        const group = result.data.competencies_radar_score.reduce((r, a) => { 
                            r[a.competency] = [...r[a.competency] || [], a];
                            return r;
                        }, {});

                        //create UI structure
                        let groupR = [];
                        Object.keys(group).forEach(function(key){
                            let obj = {}; 
                            obj['title'] = key;
                            obj['detail'] = Analyze.computeDetailAnalysisResponses(group[key])
                            obj['recommendation'] = obj['detail'].filter(function(obj){ return obj.is_blind || obj.is_hidden });
                            groupR.push(obj);
                        }); 
                        
                        const sourcetmp = document.getElementById("detail_competency_analysis").innerHTML; 
                        $('.detail_competency_analysis').replaceWith(JSTemplate.compile(sourcetmp)({ competencies: groupR }));  
                        
                        // $('#download-report').html('Download'); 
                        // $('#download-report').attr('disabled',false);
                        // $('#download-report').on('click', function(){
                        //     window.print();
                        // })

                    }).catch(function(err){
                        reject(err);
                    })
                })                 
            },
            computeDetailAnalysisResponses: function(competencies_question_score){

                function compute_percentage_avg($my_surveyors, $total_comp_questions, $max_option_value, $compute_average){ 
                    //expected_average result to value that makes 100%
                    if($my_surveyors == 0) return 0;
                    $expected_average = (($max_option_value * $total_comp_questions * $my_surveyors) / ($my_surveyors * $total_comp_questions)); 
                    return Math.round((100 * $compute_average) / $expected_average);
                }

                const processedData = competencies_question_score.map(function(obj){
                    let obNew = $.extend(true,{},obj); 
                    const keys = Object.keys(obj);
                    // remove key if not active in settings
                    if(company_setting.use_peer == 0){
                        keys.remove('peers'); 
                    }
                    if(company_setting.use_direct_report == 0){
                        keys.remove('direct_report'); 
                    } 
                    
                    obNew['is_blind'] = (obNew.self.avg - ((obNew.manager.avg + obNew.direct_report.avg)/2) ) > 1.0;
                    obNew['is_hidden'] = (((obNew.manager.avg + obNew.direct_report.avg)/2) - obNew.self.avg) > 1.0;

                    obNew['evaluator_categories'] = [];
                    keys.forEach(function(key, i){
                        if(['self','manager','peers','direct_report'].indexOf(key) !== -1){
                            const avg = (obNew[key].my_surveyors == 0) ? 0 : (obNew[key].total_score / obNew[key].my_surveyors);
                            obNew[key]['percent'] = compute_percentage_avg(obNew[key].my_surveyors, obNew[key].total_comp_questions, obNew[key].max_option_value, avg);
                            obNew[key]['label'] = Analyze.getSettingName(key);                            
                            obNew[key]['actual_label'] = key;
                            obNew['evaluator_categories'].push(obNew[key]);
                        }                                      
                    });
                    return obNew; 
                }); 

                
                return processedData;
            },

            //Page 9: 
            initEvaluationReport: function(){
                if(!$('#evaluation_report').length) return;

                const url = window.location.pathname.split('/');
                const survey_id = window.location.pathname.endsWith('/') ? url[url.length - 2] : url[url.length - 1];
                const survey_participant_id = window.location.pathname.endsWith('/') ? url[url.length - 3] : url[url.length - 2];   

                localStorage.setItem('pid', survey_participant_id);   
                localStorage.setItem('sid', survey_id);   

                $('.date-printed').html(moment().format('DD, MMM YYYY'));

                //call to tweak and set program id
                function fetch_analyze_summary(survey_id){
                    fetch(baseUrl + 'evaluation/set_program_id/' + survey_id)
                    .then(response => response.json())
                    .then(result => {
                        //set views 
                         //set views 
                        localStorage.setItem('company_setting', JSON.stringify(result.company_setting));
                        company_setting = result.company_setting;

                        $('#download-report').html('Loading, Please wait...');
                        Analyze.fetchEvaluationSurveyors(survey_participant_id);
                        Analyze.fetchPMFRadarChart(survey_participant_id);
                        Analyze.fetchEvaluationAnalyzeRadarChart(survey_participant_id);
                        Analyze.fetchPMFStrengthAndOpportunity(survey_participant_id);
                        Analyze.fetchPMFQuestionsCriteriaScore(survey_participant_id);
                        Analyze.fetchEvaluationOpenEndedResponse(survey_participant_id);
                        Analyze.fetchPMFDetailAnalysis(survey_participant_id);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    }) 
                }

                fetch_analyze_summary(survey_id);
                
            },
            fetchEvaluationSurveyors: function(survey_participant_id){
                return new Promise(function(resolve, reject){
                    fetch(baseUrl + 'admin/fetch_analyze_surveyors/' + survey_participant_id)
                    .then(response => response.json())
                    .then(result => { 
                        resolve(); 
                        Analyze.initEvaluationSurveyorsSummary(result.data.surveyors);  
                    }).catch(function(err){
                        reject(err);
                    })
                }) 
            },
            initEvaluationSurveyorsSummary(data){

                if(!document.getElementById('pmf_evaluator_rows')) return;   
                const participant = data;                    

                const colors = {
                    self: '#0071F7',
                    manager: '#029942',
                    peers: '#F70085', //'#FF2372',
                    direct_report: '#F70085'
                }
                
                if(company_setting.use_peer == 0){              
                    delete colors['peers']; 
                }

                if(company_setting.use_direct_report == 0){ 
                    delete colors['direct_report']; 
                }
                
                let processedData = [];
                const evaluator_responded = {
                    self: participant.surveyors.leaders,
                    manager: participant.surveyors.managers,
                    peers: participant.surveyors.peers,
                    direct_report: participant.surveyors.direct_reports
                }

                Object.keys(colors).forEach(function(key){
                    processedData.push({
                        label: Analyze.getSettingName(key),
                        total_invited: evaluator_responded[key],
                        total_responded: evaluator_responded[key],
                        color: colors[key]
                    })
                }); 

                const source = document.getElementById("pmf_evaluator_rows").innerHTML;
                const htmlstr = JSTemplate.compile(source)({ evaluators: processedData });  
                $('#pmf_evaluator_body').html(htmlstr);   
            }, 
            fetchEvaluationAnalyzeRadarChart: function(survey_participant_id){
                return new Promise(function(resolve, reject){
                    fetch(baseUrl + 'admin/fetch_competencies_radar_score/' + survey_participant_id)
                    .then(response => response.json())
                    .then(result => { 
                        resolve();
                        const data = (function(data){
                            return data.map(function(obj, index){
                                let newObj = $.extend(true,{},obj);
                                const keys = Object.keys(obj);
                                keys.forEach(function(key, i){
                                    if(['self','manager','peers','direct_report'].indexOf(key) !== -1){
                                        newObj[key] = (obj[key].avg); //force average to be 5 max;
                                    }                                      
                                });  
                                return newObj;                              
                            });
                        }(result.data.competencies_radar_score)); 

                        Analyze.initMultipleRadar('multiple_radar_2',data);                  
                        Analyze.initPMFCompetencyResponses(result.data.competencies_radar_score);

                    }).catch(function(err){
                        reject(err);
                    })
                })                 
            },               
            fetchEvaluationOpenEndedResponse: function(survey_participant_id){                
                return new Promise(function(resolve, reject){
                    fetch(baseUrl + 'admin/fetch_open_ended_response/' + survey_participant_id)
                    .then(response => response.json())
                    .then(result => {  
                        resolve();
                        const sourcepmf = document.getElementById("openended_responses_cont").innerHTML;
                        const htmlstrpmf = JSTemplate.compile(sourcepmf)({ open_ended: result.data.open_ended_response });  
                        $('.openended_responses_cont').html(htmlstrpmf);
                    }).catch(function(err){
                        reject(err);
                    })
                }) 
            },  
            fetchPMFStrengthAndOpportunity: function(survey_participant_id){
                return new Promise(function(resolve, reject){
                    fetch(baseUrl + 'evaluation/fetch_strength_and_opportunity/' + survey_participant_id)
                    .then(response => response.json())
                    .then(result => {  
                        resolve();

                        result.data = result.data.map(function(o){
                            o['others'] = parseFloat(o.others).toFixed(2);
                            return o;
                        })

                        const topstrength = result.data.slice(0,5);   
                        const weakstrength = result.data.slice((result.data.length) - 5);       

                        const source = document.getElementById("strength_tmp").innerHTML;
                        $('.top_strength_body').replaceWith(JSTemplate.compile(source)({ data: topstrength }));   
                        $('.top_opportunity_body').replaceWith(JSTemplate.compile(source)({ data: weakstrength })); 

                    }).catch(function(err){
                        reject(err);
                    })
                }) 
            },
            fetchPMFDetailAnalysis: function(survey_participant_id){
                return new Promise(function(resolve, reject){
                    fetch(baseUrl + 'evaluation/fetch_pmf_detail/' + survey_participant_id)
                    .then(response => response.json())
                    .then(result => {  
                        resolve();
                        
                        const group = result.data.reduce((r, a) => { 
                            r[a.pmf_category] = [...r[a.pmf_category] || [], a];
                            return r;
                        }, {});

                        const arr = ['Focus Me', 'Guide Me', 'Know Me', 'Recognize Me'];
                        arr.forEach(function(item){                                
                            const source = document.getElementById("pmf_detail_analysis").innerHTML;
                            $('.'+ item.replace(/\s/g,'_').toLowerCase()).html(JSTemplate.compile(source)({ data: group[item] }));   
                            
                            $('body').find('.'+ item.replace(/\s/g,'_').toLowerCase()).find('.pmf-type').html(item);
                        });
                        
                        $('#download-report').html('Download'); 
                        $('#download-report').attr('disabled',false);
                        $('#download-report').on('click', function(){
                            window.print();
                        })

                    }).catch(function(err){
                        reject(err);
                    })
                }) 
            }
            
        }
    }());

    Analyze.reisterHelpers();     

    Analyze.getCompanySetting(function(setting){ 
        Analyze.initAnalyzeMeSummary();  
        Analyze.initEvaluationReport();      
    });

}())