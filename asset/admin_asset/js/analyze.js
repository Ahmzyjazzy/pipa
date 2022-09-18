(function(){
    
    const url = window.location.href;    
    const baseUrl = url.substring(0, url.indexOf('admin')) || url.substring(0, url.indexOf('evaluation'));
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
                                direct_report: '#F70085',                                
                                others: '#FF2372'
                            }
                            return colors[label.toLowerCase()];
                        },                        
                        getColorIndex: function(index){
                            const colors = ['blue','green','pink','black'];
                            return index >= 0 && index <= colors.length ? colors[index] : 0;
                        },
                        formatDate: function(date){
                            return moment(date).format('DD/MM/YYYY')
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
                            return avg ? parseFloat(avg).toFixed(2) : 0.00;
                        },
                        toSum: function(data, key){
                            let total = 0;
                            data.forEach(function(obj){
                                obj[key] = obj[key] ? parseFloat(obj[key]) : 0;
                                total += obj[key];
                            })
                            return total == 0 ? 0.00 : parseFloat(total / data.length).toFixed(2);
                        },
                        toOverallSum: function(data){
                            let selftotal = 0;
                            data.forEach(function(obj){
                                obj['self'] = obj['self'] ? parseFloat(obj['self']) : 0;
                                selftotal += obj['self'];
                            })
                            const selfavg = selftotal == 0 ? 0.00 : parseFloat(selftotal / data.length).toFixed(2);

                            let mgrtotal = 0;
                            data.forEach(function(obj){
                                obj['line_manager'] = obj['line_manager'] ? parseFloat(obj['line_manager']) : 0;
                                mgrtotal += obj['line_manager'];
                            })
                            const mgravg = mgrtotal == 0 ? 0.00 : parseFloat(mgrtotal / data.length).toFixed(2);

                            let tmtotal = 0;
                            data.forEach(function(obj){
                                obj['team_members'] = obj['team_members'] ? parseFloat(obj['team_members']) : 0;
                                tmtotal += obj['team_members'];
                            })
                            const tmavg = tmtotal == 0 ? 0.00 : parseFloat(tmtotal / data.length).toFixed(2);
                            
                            if(tmavg == 0.00 && mgravg == 0.00){
                                return "0.00";
                            }else if(tmavg == 0.00 || mgravg == 0.00){
                                return parseFloat(((parseFloat(mgravg) + parseFloat(tmavg)))).toFixed(2);
                            }else{
                                return parseFloat(((parseFloat(mgravg) + parseFloat(tmavg)) / 2)).toFixed(2);   
                            }
                            
                        }
                    }
                }())          
                Object.keys(helpers).forEach(function (prop) {
                    JSTemplate.registerHelper(prop,helpers[prop])
                })
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
            printDiv: function(){  
                var divContents = document.getElementById("pmf").innerHTML;  
                var printWindow = window.open('', '', 'height=200,width=400');  
                printWindow.document.write('<html><head><title>PMF</title>');  
                printWindow.document.write('</head><body >');  
                printWindow.document.write(divContents);  
                printWindow.document.write('</body></html>');  
                printWindow.document.close();  
                printWindow.print();  
            },   

            //Page 1: Analyze module
            initAnalyzeSummary: function(){
                if(!document.getElementById('program-select')) return;
                let program_id = $('#program-select').val();
                if(!program_id) return;

                localStorage.setItem('pid', program_id);

                function fetch_analyze_summary(program_id){
                    fetch(baseUrl + 'admin/fetch_analyze_summary/'+ program_id)
                    .then(response => response.json())
                    .then(result => {
                        //set views  
                        $('.competency_total').html(result.competency.total_competency)
                        $('.participant_accessed').html(result.competency.total_participant)
                        $('.total_evaluator_invited').html(result.competency.total_evaluator_invited)
                        $('.total_evaluator_responded').html(result.competency.total_evaluator_responded)
                        $('.date_collected').html(result.competency.date_collected ? moment(result.competency.date_collected).format('DD MMM, YYYY HH:MM A') : 'N/A')
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    }) 
                }

                
                fetch_analyze_summary(program_id);

                $('#program-select').on('change', function(){
                    program_id = $(this).val();
                    if(!program_id) return;
                    localStorage.setItem('pid', program_id);
                    fetch_analyze_summary(program_id);
                });

            },

            //Page 2: Assessment 360
            initPiechart: function(selected_date){
                if(!document.getElementById('assessment_pie')) return;
                //get program id selected
                fetch(baseUrl + 'admin/fetch_chart_data/')
                .then(response => response.json())
                .then(result => { 
                    var chart = am4core.create("assessment_pie", am4charts.PieChart);
                    // Add data
                    let data = result.pie_data.map(function(obj){
                        obj['surveyor'] = Analyze.replaceSettingName(obj.surveyor);
                        return obj;
                    }); 

                    chart.data = data.filter(function(obj){
                            return ((obj.surveyor == 'Peers' && company_setting.use_peer == 1) || 
                            (obj.surveyor == 'Direct reports' && company_setting.use_direct_report == 1) ||
                            (obj.surveyor != 'Peers' && obj.surveyor != 'Direct reports'));
                        });
                    
                    result.pie_data; 

                    // Add and configure Series
                    var pieSeries = chart.series.push(new am4charts.PieSeries());
                    pieSeries.dataFields.value = "total";
                    pieSeries.dataFields.category = "surveyor";
                    pieSeries.dataFields['total_surveyors'] = "total_surveyors";

                    chart.innerRadius = am4core.percent(40);

                    // pieSeries.slices.template.stroke = am4core.color("#fff");
                    pieSeries.slices.template.strokeWidth = 1;
                    pieSeries.slices.template.strokeOpacity = 1;

                    pieSeries.colors.list = [
                        am4core.color("#EB5757"),
                        am4core.color("#6FCF97"),
                        am4core.color("#001E42"),
                        am4core.color("#F2C94C"), 
                    ];

                    pieSeries.ticks.template.disabled = true;
                    pieSeries.alignLabels = false;
                    pieSeries.labels.template.text = "{value.percent.formatNumber('#.0')}%";
                    pieSeries.labels.template.radius = am4core.percent(-30);
                    pieSeries.labels.template.fill = am4core.color("white");
                    
                    pieSeries.slices.template.tooltipText = "{category} {value.percent.formatNumber('#.0')}%";

                    chart.legend = new am4charts.Legend(); 
                    chart.legend.position = 'bottom';
                    var marker = chart.legend.markers.template;
                    marker.height = 5; 

                    chart.legend.labels.template.text = "{name}";
                    pieSeries.legendSettings.valueText = "{value.percent.formatNumber('#.0')}% ({value} of {total_surveyors})"; 

                    var label = chart.seriesContainer.createChild(am4core.Label);
                    label.html = '<p style="text-align:center;"><b>' + result.overall_total + " of " + result.total_surveyors + '</b><br><b>Participants<b>';
                    label.horizontalCenter = "middle";
                    label.verticalCenter = "middle";
                    label.fontSize = 14;

                })
                .catch(error => {
                    console.error('Error:', error);
                }) 
            },
            initResponseRateBarLine: function(response_rate){
                if(!document.getElementById('response_rate_barline')) return;

                am4core.useTheme(am4themes_animated);
                var chart = am4core.create("response_rate_barline", am4charts.XYChart); 

                chart.data = (function(data){
                    return data.map(function(obj){
                        obj.total_surveyor_invited = parseInt(obj.total_surveyor_invited);
                        obj.total_surveyor_responded = parseInt(obj.total_surveyor_responded);
                        return obj;
                    })
                }(response_rate));
                            
                //create category axis for years
                var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
                categoryAxis.dataFields.category = "title";
                categoryAxis.renderer.inversed = true;
                categoryAxis.renderer.grid.template.location = 0;
                
                //create value axis for total_surveyors_invited and total_sureyors_responded
                var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
                valueAxis.renderer.opposite = true;                
                
                //create columns
                var chartSeries = chart.series.push(new am4charts.ColumnSeries());
                chartSeries.dataFields.categoryY = "title";
                chartSeries.dataFields.valueX = "total_surveyor_invited";
                chartSeries.name = "Total evaluator invited";
                chartSeries.columns.template.fillOpacity = 0.5;
                chartSeries.columns.template.strokeOpacity = 0;
                chartSeries.tooltipText = "Total evaluator invited in {categoryY}: {valueX.value}";

                chart.colors.list = [
                    am4core.color("#EB5757"),
                    am4core.color("#6FCF97"),
                    am4core.color("#001E42"),
                    am4core.color("#F2C94C"), 
                ]; 

                // as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
                chartSeries.columns.template.adapter.add("fill", function(fill, target) {
                    return chart.colors.getIndex(target.dataItem.index);
                });
                
                //create line
                var lineSeries = chart.series.push(new am4charts.LineSeries());
                lineSeries.dataFields.categoryY = "title";
                lineSeries.dataFields.valueX = "total_surveyor_responded";
                lineSeries.name = "Total evaluator responded";
                lineSeries.strokeWidth = 3;
                lineSeries.tooltipText = "Total evaluator responded in {categoryY}: {valueX.value}";
                
                //add bullets
                var circleBullet = lineSeries.bullets.push(new am4charts.CircleBullet());
                circleBullet.circle.fill = am4core.color("#fff");
                circleBullet.circle.strokeWidth = 2;
                
                //add chart cursor
                chart.cursor = new am4charts.XYCursor();
                chart.cursor.behavior = "zoomY";
                
                //add legend
                chart.legend = new am4charts.Legend();

            },  
            initRadar: function(){
                if(!document.getElementById('assessment_radar')) return;
                //get program id selected                
                fetch(baseUrl + 'admin/fetch_radar_data')
                .then(response => response.json())
                .then(result => {  
                    am4core.ready(function() {

                        // Themes begin
                        am4core.useTheme(am4themes_animated);
                        // Themes end
                        
                        /* Create chart instance */
                        var chart = am4core.create("assessment_radar", am4charts.RadarChart);
                        
                        /* Add data */
                        chart.data = result.data;
                        
                        /* Create axes */
                        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                        categoryAxis.dataFields.category = "competency";
                        var label = categoryAxis.renderer.labels.template;
                        label.wrap = true;
                        label.maxWidth = 100;
                        
                        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                        valueAxis.min = 0;
                        valueAxis.max = 5;
                        
                        /* Create and configure series */
                        var series = chart.series.push(new am4charts.RadarSeries());
                        series.dataFields.valueY = "score";
                        series.dataFields.categoryX = "competency";
                        series.name = "Competencies";
                        series.strokeWidth = 1; 
                        series.fill = am4core.color("#005CC8");
                        // series.tooltipText = "Series: {name}\nCategory: {categoryX}\nScore: {valueY}";  
                                            
                        bullet = series.bullets.push(new am4charts.Bullet());
                        square = bullet.createChild(am4core.Circle);
                        square.width = 8;
                        square.height = 8;
                        
                    }); // end am4core.ready()    
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            },
            initDatatableAllParticipant: function(){ 
                if(!$('#dt_allparticipant').length) return;               
                const table = $('#dt_allparticipant').DataTable({
                    responsive: true, 
                    dom: 'tip', 
                });   

                //set search listener                
                $('.search-input').on( 'keyup', function () {
                    table.search($(this).val()).draw();
                });

                // generate paginate menu
                Analyze.generatePaging(table.page.info(), '.paginate-select');

                //paginate select
                $('.paginate-select').on('change', function(){
                    const page = $(this).find('option:selected').data('page');
                    const index = parseInt(page);  
                    table.page(index).draw('page');
                });

                let selectedArr = [];
                $('#dt_allparticipant tbody').on( 'click', '.compare-btn', function () {
                    const $this = $(this);
                    if(!$this.closest('tr').hasClass('selected') && table.rows('.selected').data().length == 4){
                        alert('Cannot select more than four participants')
                        return
                    }
                    $this.closest('tr').toggleClass('selected');
                    $this.closest('tr').hasClass('selected') ? $this.text('Cancel selection') : $this.text('Select participant');
                    table.rows('.selected').data().length > 1 ? $('.goto-compare-btn').removeClass('hide') : $('.goto-compare-btn').addClass('hide');

                    if(selectedArr.findIndex(function(v){ return v == $this.data('number') }) == -1){
                        selectedArr.push({
                            number: $this.data('number'),
                            name: $this.data('name')
                        })
                    }else{
                        selectedArr = selectedArr.filter(function(obj){
                            return obj.number != $this.data('number');
                        });
                    }                    
                    localStorage.setItem('participants', JSON.stringify(selectedArr));
                });
            },
            initAssessment360: function(){
                if(!document.getElementById('surveydate-dropdown-360')) return;

                const $surveydate = $('#surveydate-dropdown-360');
                fetch(baseUrl + 'admin/fetch_daterange/')
                .then(response => response.json())
                .then(result => { 
                    const dateRange = result ? result.date_range : {};
                    const dates = Analyze.generateDate(new Date(dateRange.start_date), new Date(dateRange.end_date)); 

                    Analyze.initPiechart();
                    Analyze.initRadar();                    
                    // Analyze.responseRate('company');

                    $surveydate.daterangepicker({
                        startDate: moment(dateRange.start_date).format('MM/DD/YYYY'),
                        endDate  : moment(dateRange.end_date).format('MM/DD/YYYY'),                        
                        minDate: moment(dateRange.start_date).format('MM/DD/YYYY'),
                        maxDate  : moment(dateRange.end_date).format('MM/DD/YYYY'),
                        // singleDatePicker: true,
                        showCustomRangeLabel: false,
                        autoUpdateInput: true
                      }, function (start, end) {
                        // window.alert('You chose: ' + start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                        Analyze.initPiechart(start.format('YYYY-MM-DD'));
                        Analyze.initRadar(start.format('YYYY-MM-DD'));
                      });

                    //register on change benchmark-program
                    $('#benchmark-program').on('change', function(){
                        const program_id = $(this).val();
                        if(!program_id) return;
                        localStorage.setItem('past_program_id', program_id);
                        //load benchmark page
                        window.location.href = baseUrl + 'admin/benchmark_program'
                    });
                }) 
                .catch(error => {
                    console.error('Error:', error);
                });

            },

            //Page 3: Evaluator
            renderEvaluatorDt: function(options){
                //register download event
                $('.download_pending_evaluator').off('click').on('click', function(){
                    var btndom = $(this);
                    btndom.addClass("loading-start");
                    btndom.attr("disabled",true);

                    const surveyBaseUrl = baseUrl + 'survey/get-started/';  
                    $.ajax({
                        url: baseUrl + 'admin/download_pending_evaluators/',
                        type: 'POST',
                        data: { base_url: surveyBaseUrl },
                        error: function(err) {
                            console.log(err, ' something went wrong'); 
                            btndom.removeClass("loading-start").removeAttr("disabled");
                        },
                        success: function(result){ 
                            const data = JSON.parse(result);   
                            const tableData = [ {  "sheetName": "Sheet1", "data": data.pending_evaluators ? (function(data){
                                let result = [];
                                //create header
                                if(data.length > 0){
                                    let header = [];
                                    Object.keys(data[0]).forEach(function(k){
                                        header.push({text: k});
                                    });
                                    result.push(header);
                                    
                                    //create body
                                    data.forEach(function(row,i){
                                        let rowArr = [];
                                        Object.values(row).forEach(function(value){
                                            rowArr.push({text: value});
                                        })
                                        result.push(rowArr);
                                    });
                                }

                                return result;
                            }(data.pending_evaluators)) : [] }];
                            const options = {
                                fileName: "Pending_Evaluators_" + moment(new Date()).format('DD-MMM-YYYY')
                            };
                            Jhxlsx.export(tableData, options);
                            btndom.removeClass("loading-start").removeAttr("disabled");
                        }
                    });  
                
                })

                const dataTable = $('#dt_evaluator').DataTable(options);   

                // //add toggle more event
                dataTable.off('click', '.table-accordion').on('click', '.table-accordion', function(){            
                    //show more detail on each cells
                    $(this).toggleClass('collapsed');
                    $(this).closest('tr').find('.more-info').toggleClass('hide');
                })

                // //set search listener                
                $('.search-input').on( 'keyup', function () {
                    dataTable.search($(this).val()).draw();
                });

                // // generate paginate menu
                Analyze.generatePaging(dataTable.page.info(), '.paginate-select');

                // //paginate select
                $('.paginate-select').on('change', function(){
                    const page = $(this).find('option:selected').data('page');
                    const index = parseInt(page); 
                    dataTable.page(index).draw(false);
                });

                $('.card-skeleton').remove();     
            },
            initDatatableEvaluator: function(){ 
                if(!$('#dt_evaluator').length) return;

                //get program id selected
                fetch(baseUrl + 'admin/fetch_evaluator/')
                .then(response => response.json())
                .then(result => { 
                    let dataSet = [];

                    let all_evaluators = result.data.all_evaluators; 

                    $('#total_participants').html(all_evaluators.length + (all_evaluators.length <= 1 ? ' participant' : ' participants'));

                    if(all_evaluators.length > 0){
                        all_evaluators.forEach(function(evaluator){
                            const obj = {};
                            obj['Participant'] = evaluator.first_name + ' ' + evaluator.last_name;  
                            //add all evaluators data
                            evaluator.surveyors.forEach(function(s){ 
                                if((s.relationship == 'Peer' && company_setting.use_peer == 1) || (s.relationship == 'Direct Report' && company_setting.use_direct_report == 1) || 
                                        (s.relationship !== 'Peer' && s.relationship != 'Direct Report')
                                    ){
                                    s.relationship = Analyze.replaceSettingName(s.relationship);
                                    obj[s.relationship.replace(/\s/g,'_') + '_' + s.relationship_index] = {
                                        name: s.name,
                                        status: s.surveyors_response.total_response == 0 ? 'Not Started' : 
                                            s.surveyors_response.total_question == s.surveyors_response.total_response ? 'Completed' : 'Ongoing',
                                        email: s.email,
                                        phone: s.phone
                                    } 
                                } 
                                
                            });
                            dataSet.push(obj);
                        })
                    }
 
                    const table = $('#dt_evaluator');  
                    if(dataSet.length > 0){
                        //define dynamic columns header
                        const firstData = dataSet[0];
                        const keys = Object.keys(firstData);
                        const length = keys.length; 
                        let tr = '<tr class="dark-text">'; 

                        console.log(`dt_evaluator keys`, keys, dataSet);

                        keys.forEach(function(prop, i){
                            // if(i === 0) tr += '<th scope="col"><input type="checkbox" /></th>';
                            tr += '<th scope="col">' + prop.replace(/_/g, " ") + '</th>';
                            if(i === length - 1) tr += '<th scope="col"></th>';
                        })
                        tr += '</tr>'; 
                        table.find('thead').html(tr); 

                        //table body
                        let tbody = '';
                        const status_color = {
                            'Not Started' : 'blue',
                            'Ongoing': 'orange',
                            'Completed': 'green'
                        }
                        dataSet.forEach(function(cell, index){
                            let tr = '<tr>';
                            Object.values(cell).forEach(function(obj, i){ 
                                if(i === 0){ 
                                    // tr += `<td>
                                    //         <input type="checkbox" />
                                    //     </td>
                                    // <td class="text-blue">${obj}</td>`;
                                    tr += `<td class="text-blue">${obj}</td>`;
                                }else{
                                    tr += `<td class="collapse-cell"> 
                                            <span class="btn-status-${status_color[obj.status]}">${obj.status}</span> 
                                            <div class="table-communicate-icons hide more-info">
                                                <a href="mailto:${obj.email}">                                      
                                                    <i class="fa fa-envelope"></i>
                                                </a>
                                                <a href="tel:${obj.phone}">                                     
                                                    <i class="fa fa-phone"></i>  
                                                </a>
                                            </div>                                       
                                            <span class="hide more-info">${obj.name}</span>
                                    </td>`;
                                }
                                if(i === length - 1){
                                    tr += `<td>
                                    <span data-toggle="collapse" href="#tr${index}" role="button" aria-expanded="false" aria-controls="tr1"
                                        class="collapsed table-accordion">
                                        <svg class="arrow-down"
                                            width="14" height="9" viewBox="0 0 14 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0.5 1.25L7 7.75L13.5 1.25" stroke="#7E9EC2"/>
                                        </svg>
                                        <svg class="arrow-right"
                                            width="8" height="15" viewBox="0 0 8 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0.75 14L7.25 7.5L0.75 1" stroke="#7E9EC2"/>
                                        </svg>
                                    </span>
                                </td>`;
                                }
                            })
                            tr += '</tr>'; 
                            tbody += tr;  
                        })
                        table.find('tbody').html(tbody); 
                        Analyze.renderEvaluatorDt({
                            // responsive: true, 
                            dom: 'tip', 
                            scrollX: true,
                            columnDefs: [
                                // { "orderable": false, "searchable": false, "targets": 0 }, 
                                // { "orderable": false, "searchable": false, "targets": length + 1 },
                                { "orderable": false, "searchable": false, "targets": length },
                                // { "width": ((100 - 10) / length) + '%', "targets": [2,3] }
                            ],
                        });
                    }else{
                        Analyze.renderEvaluatorDt({
                            responsive: true, 
                            dom: 'tp'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                }); 
            }, 

            //Page 4: Analyze Participants
            initSurveyorsummary: function(data, date_from = '', date_to = ''){
                if(!document.getElementById('no_of_self')) return;   
                const participant = data; 
 
                $('.participant_title').html(participant ? participant.first_name + ' ' + participant.last_name : '');
                
                $('.no_of_surveyors').html(participant ? participant.surveyors.total_surveyors : '0');
                
                $('#participant_grade').html(participant.grade);
                $('#no_of_self').html(participant.surveyors.leaders);
                $('#no_of_manager').html(participant.surveyors.managers);

                const colors = {
                    self: '#0071F7',
                    manager: '#029942',
                    peers: '#F70085', //'#FF2372',
                    direct_report: '#F70085'
                }
                
                if(company_setting.use_peer == 1){
                    $('#use_peer').find('.balls-label').html(company_setting.peer_name + ' (<span id="no_of_dreport">'+ participant.surveyors.peers +'</span>)');                                                        
                }else{
                    $('#use_peer').remove();                    
                    delete colors['peers']; 
                }

                if(company_setting.use_direct_report == 1){
                    $('#use_direct_report').find('.balls-label').html(company_setting.direct_report_name + ' (<span id="no_of_dreport">'+ participant.surveyors.direct_reports +'</span>)');                   
                }else{
                    $('#use_direct_report').remove();
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
                    $('.ball-content.' + key).find('span.balls').css({backgroundColor: colors[key] });
                    processedData.push({
                        label: Analyze.getSettingName(key),
                        total_invited: evaluator_responded[key],
                        total_responded: evaluator_responded[key],
                        color: colors[key]
                    })
                });
                
                const total_response = (participant.surveyors.leaders + participant.surveyors.managers + participant.surveyors.peers + participant.surveyors.direct_reports);
                $('.total_sresponse').html(total_response);

                const source = document.getElementById("pmf_evaluator_rows").innerHTML;
                const htmlstr = JSTemplate.compile(source)({ evaluators: processedData });  
                $('#pmf_evaluator_body').html(htmlstr);   
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
                            if(key !== 'competencies'){
                                if(key !== 'description'){
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
                            }
                        });
                    }                        
                    
                });

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

                    if((obNew.manager.avg == 0 || obNew.manager.avg == '0') && (obNew.direct_report.avg == 0 || obNew.direct_report.avg == '0')){
                        obNew['is_blind'] = false;
                        obNew['is_hidden'] = false;
                    }
                    else if((obNew.manager.avg == 0 || obNew.manager.avg == '0') || (obNew.direct_report.avg == 0 || obNew.direct_report.avg == '0')){
                        obNew['is_blind'] = (obNew.self.avg - ((obNew.manager.avg + obNew.direct_report.avg)) ) > 1.0;
                        obNew['is_hidden'] = (((obNew.manager.avg + obNew.direct_report.avg)) - obNew.self.avg) > 1.0;
                    }else {
                        obNew['is_blind'] = (obNew.self.avg - ((obNew.manager.avg + obNew.direct_report.avg)/2) ) > 1.0;
                        obNew['is_hidden'] = (((obNew.manager.avg + obNew.direct_report.avg)/2) - obNew.self.avg) > 1.0;  
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

                return processedData;
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
                    fetch(baseUrl + 'admin/fetch_open_ended_response/' + survey_participant_id)
                    .then(response => response.json())
                    .then(result => { 
                        console.log('result.data.open_ended_response', result.data.open_ended_response)
                        Analyze.initOpenEndedResponses(result.data.open_ended_response);  
                    }).catch(function(err){
                        reject(err);
                    })
                }) 
            },    
            fetchAnalyzeComptenciesQuestionScore: function(survey_participant_id, competency_id, $question_detail_cont){
                return new Promise(function(resolve, reject){
                    fetch(baseUrl + 'admin/fetch_competencies_question_score/' + survey_participant_id +'/' + competency_id)
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

                        Analyze.initMultipleRadar('multiple_radar',data);
                        if(company_setting.use_pmf == 1) Analyze.initMultipleRadar('multiple_radar_2',data);                       
                        
                        Analyze.initCompetencyResponses(result.data.competencies_radar_score); 
                        Analyze.initPMFCompetencyResponses(result.data.competencies_radar_score);

                    }).catch(function(err){
                        reject(err);
                    })
                })                 
            },
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
            fetchAnalyzeSurveyor: function(survey_participant_id){
                return new Promise(function(resolve, reject){
                    fetch(baseUrl + 'admin/fetch_analyze_surveyors/' + survey_participant_id)
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
                    // await Analyze.fetchAnalyzeComptenciesOverallScore(survey_participant_id);
                    $('#fetchpmf').on('click', function(){
                        $('#download-report').html('Loading, Please wait...');
                        Analyze.fetchPMFRadarChart(survey_participant_id);
                        Analyze.fetchPMFStrengthAndOpportunity(survey_participant_id);
                        Analyze.fetchPMFQuestionsCriteriaScore(survey_participant_id);
                        Analyze.fetchPMFDetailAnalysis(survey_participant_id);
                    });
                }

                const $surveydate = $('#surveydate-dropdown');
                fetch(baseUrl + 'admin/fetch_daterange/')
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

            //Page 5: Compare Participants  
            initCompareCompetencyResponses: function(competency_summary, date_from = '', date_to = ''){                             

                function compute_percentage_avg($my_surveyors, $total_comp_questions, $max_option_value, $compute_average){ 
                    //expected_average result to value that makes 100%
                    if($my_surveyors == 0) return 0;
                    $expected_average = (($max_option_value * $total_comp_questions * $my_surveyors) / ($my_surveyors * $total_comp_questions)); 
                    return Math.round((100 * $compute_average) / $expected_average);
                }

                const processedData = competency_summary.map(function(obj){ 
                    let newObj = $.extend(true,{},obj); 
                    const keys = Object.keys(obj);
                    newObj['participants'] = [];
                    keys.forEach(function(key, i){
                        if(['participant_1','participant_2','participant_3','participant_4'].indexOf(key) !== -1){
                            const compute_average = (newObj[key].my_surveyors == 0) ? 0 : (newObj[key].total_score / (newObj[key].my_surveyors * newObj[key].total_comp_questions));
                            newObj[key]['percent'] = compute_percentage_avg(newObj[key].my_surveyors, newObj[key].total_comp_questions, newObj[key].max_option_value, compute_average); 
                            newObj['participants'].push(newObj[key]);                
                        }                                  
                    });  
                    return newObj;
                }); 

                const source = document.getElementById("competency_responses").innerHTML;
                const htmlstr = JSTemplate.compile(source)({ competency_summary: processedData });  
                $('.competency_responses').html(htmlstr);   

                //view_questions_response
                $('body .view_questions_response').on('click', function(){
                    const $question_detail_cont = $(this).closest('.competency-response-header').siblings('.competency-response-detail');                   

                    const participants = localStorage.getItem('participants') || [];
                    if($.isArray(participants)){
                        alert('You need to select participants from assessment page');
                        return;
                    }
                    const selectedArr = JSON.parse(participants);

                    if($question_detail_cont.find('.card-skeleton').length){
                        //fetch questions 
                        const competency_id = $(this).data('comid'); 
                        Analyze.fetchComparisonAnalyzeComptenciesQuestionScore(selectedArr, competency_id,  $question_detail_cont);
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
            initCompareMultipleRadar: function(data, date_from = '', date_to = ''){    
                if(!document.getElementById('multiple_compare_radar')) return;
                am4core.ready(function() {

                    // Themes begin
                    am4core.useTheme(am4themes_animated);
                    // Themes end
                    
                    /* Create chart instance */
                    var chart = am4core.create("multiple_compare_radar", am4charts.RadarChart);
                    
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
                    valueAxis.max = 5; //hardcode 5
                    
                    /* Create and configure series */
                    if(chart.data.length > 0){
                        const keys = Object.keys(chart.data[0]);
                        const colors = {
                            participant_1: '#0071F7',
                            participant_2: '#029942',
                            participant_3: '#FF2372',
                            participant_4: '#001E42' //#F70085
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
            fetchComparisonAnalyzeComptenciesQuestionScore: function(selectedArr, competency_id, $question_detail_cont){
                return new Promise(function(resolve, reject){
                    $.ajax({
                        url: baseUrl + 'admin/fetch_comparison_question_score/',
                        type: 'POST',
                        data: {participants: selectedArr, survey_competency_id: competency_id },
                        error: function(err) {
                            console.log(err, ' something went wrong');
                            reject(err);
                        },
                        success: function(result){
                            resolve();
                            const data = JSON.parse(result);  
                            // Analyze.initCompetencyQuestionResponses(data.competencies_question_score, $question_detail_cont);

                            function compute_percentage_avg($my_surveyors, $total_comp_questions, $max_option_value, $compute_average){ 
                                //expected_average result to value that makes 100%
                                if($my_surveyors == 0) return 0;
                                $expected_average = (($max_option_value * $total_comp_questions * $my_surveyors) / ($my_surveyors * $total_comp_questions)); 
                                return Math.round((100 * $compute_average) / $expected_average);
                            }
            
                            const processedData = data.competencies_question_score.map(function(obj){
                                let obNew = $.extend(true,{},obj); 
                                const keys = Object.keys(obj);
                                obNew['participants'] = [];
                                keys.forEach(function(key, i){
                                    if(['participant_1','participant_2','participant_3','participant_4'].indexOf(key) !== -1){
                                        const avg = (obNew[key].my_surveyors == 0) ? 0 : (obNew[key].total_score / obNew[key].my_surveyors);
                                        obNew[key]['percent'] = compute_percentage_avg(obNew[key].my_surveyors, obNew[key].total_comp_questions, obNew[key].max_option_value, avg);
                                        obNew['participants'].push(obNew[key]);
                                    }                                      
                                });
                                return obNew; 
                            });  
            
                            const source = document.getElementById("competency_questions_responses").innerHTML;
                            const htmlstr = JSTemplate.compile(source)({ questions: processedData });  
                            $question_detail_cont.html(htmlstr); 


                        }
                    });  
                }) 
            },     
            fetchCompareOpenEndedResponse: function(survey_participant_id){                
                return new Promise(function(resolve, reject){
                    fetch(baseUrl + 'admin/fetch_open_ended_response/' + survey_participant_id)
                    .then(response => response.json())
                    .then(result => { 
                        Analyze.initOpenEndedResponses(result.data.open_ended_response);  
                    }).catch(function(err){
                        reject(err);
                    })
                }) 
            },              
            fetchCompareAnalyzeRadarChart: function(selectedArr){
                return new Promise(function(resolve, reject){
                    $.ajax({
                        url: baseUrl + 'admin/fetch_comparison_radar_score/',
                        type: 'POST',
                        data: {participants: selectedArr},
                        error: function(err) {
                            console.log(err, ' something went wrong');
                            reject(err);
                        },
                        success: function(result){
                            resolve();
                            const data = JSON.parse(result); 
                            Analyze.initCompareMultipleRadar((function(data){
                                return data.map(function(obj, index){
                                    let newObj = $.extend(true,{},obj);
                                    const keys = Object.keys(obj);
                                    keys.forEach(function(key, i){
                                        if(['participant_1','participant_2','participant_3','participant_4'].indexOf(key) !== -1){
                                            newObj[key] = (obj[key].avg); //force average to be 5 max;
                                        }                                      
                                    });  
                                    return newObj;                              
                                });
                            }(data.competencies_radar_score)));                            
                            Analyze.initCompareCompetencyResponses(data.competencies_radar_score);
                        }
                     }); 
                })                 
            },
            fetchCompareAnalyzeSurveyor: function(selectedArr){
                return new Promise(function(resolve, reject){
                    $.ajax({
                        url: baseUrl + 'admin/fetch_comparison_analyze_surveyors/',
                        type: 'POST',
                        data: {participants: selectedArr},
                        error: function(err) {
                            console.log(err, ' something went wrong');
                            reject(err);
                        },
                        success: function(result){
                            resolve();
                            const data = JSON.parse(result);  

                            let overallTotalSurveyors = 0;
                            let overallTotalRespondedSurveyors = 0;

                            const processedData = data.surveyors.map(function(obj){ 
                                let newObj = $.extend(true,{},obj); 
                                const keys = Object.keys(obj);
                                keys.forEach(function(key, i){
                                    if(['participant_1','participant_2','participant_3','participant_4'].indexOf(key) !== -1){  

                                        newObj['total_response']  =  (obj[key].surveyors.leaders + obj[key].surveyors.managers + obj[key].surveyors.peers + obj[key].surveyors.direct_reports);
                                        newObj['total_surveyors'] =  obj[key].surveyors.total_surveyors;

                                        overallTotalSurveyors += parseInt(newObj['total_surveyors']);
                                        overallTotalRespondedSurveyors += newObj['total_response'];
                                    }                                      
                                });  
                                return newObj;
                            });  
                            const context = { 
                                participants: processedData, 
                                total_sureyors: overallTotalSurveyors, 
                                total_response: overallTotalRespondedSurveyors 
                            };                         
                            const source = document.getElementById("compare_surveyors_cont").innerHTML;
                            const htmlstr = JSTemplate.compile(source)(context);  
                            $('.compare_surveyors_cont').html(htmlstr); 

                        }
                    }); 
                }) 
            },   
            initCompareParticipants: function(){
                if(!document.getElementById('multiple_compare_radar')) return; 
     
                async function loadCompareAnalyzeParticipant(date_from = '', date_to = ''){
                    const participants = localStorage.getItem('participants') || [];
                    if($.isArray(participants)){
                        alert('You need to select participants from assessment page');
                        return;
                    }
                    const selectedArr = JSON.parse(participants);
                    Analyze.fetchCompareAnalyzeSurveyor(selectedArr);
                    Analyze.fetchCompareAnalyzeRadarChart(selectedArr);
                    // await Analyze.fetchCompareOpenEndedResponse(selectedArr);
                }
                
                const $surveydate = $('#surveydate-dropdown');
                fetch(baseUrl + 'admin/fetch_daterange/')
                .then(response => response.json())
                .then(result => { 
                    
                    loadCompareAnalyzeParticipant();

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
                        loadCompareAnalyzeParticipant(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));  
                    });
                })
            },
            initEngagementLineChart: function(){
                if(!document.getElementById('engagement-line-chart')) return;

                am4core.ready(function() {

                    // Themes begin
                    // am4core.useTheme(am4themes_animated);

                    // Themes end
                    var chart = am4core.create("engagement-line-chart", am4charts.XYChart);

                    var data = [];

                    chart.data = [
                      {
                        "month": "Jan",
                        "score": 0,
                      }, 
                      {
                        "month": "Feb",
                        "score": 0,
                      }, 
                      {
                        "month": "Mar",
                        "score": 0,
                      }, 
                      {
                        "month": "Apr",
                        "score": 0,
                      }, 
                      {
                        "month": "May",
                        "score": 1,
                      }, 
                      {
                        "month": "Jun",
                        "score": 3,
                      }, 
                      {
                        "month": "Jul",
                        "score": 5,
                      }, 
                      {
                        "month": "Aug",
                        "score": 6,
                      }, 
                      {
                        "month": "Sep",
                        "score": 9,
                      }, 
                      {
                        "month": "Oct",
                        "score": 8,
                      }, 
                      {
                        "month": "Nov",
                        "score": 6,
                      }, 
                      {
                        "month": "Dec",
                        "score": 4,
                      }, 
                    ];
                    
                    var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                    categoryAxis.renderer.grid.template.location = 0;
                    categoryAxis.renderer.ticks.template.disabled = true;
                    categoryAxis.renderer.line.opacity = 0;
                    categoryAxis.renderer.grid.template.disabled = false;
                    categoryAxis.renderer.minGridDistance = 10;
                    categoryAxis.dataFields.category = "month";
                    categoryAxis.startLocation = 0.4;
                    categoryAxis.endLocation = 0.6;
                    
                    
                    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                    valueAxis.tooltip.disabled = true;
                    valueAxis.renderer.line.opacity = 0;
                    valueAxis.renderer.ticks.template.disabled = true;
                    valueAxis.min = 0;
                    valueAxis.max = 10;
                    
                    var lineSeries = chart.series.push(new am4charts.LineSeries());
                    lineSeries.dataFields.categoryX = "month";
                    lineSeries.dataFields.valueY = "score";
                    lineSeries.tooltipText = "score: {valueY.value}";
                    lineSeries.fillOpacity = 0.5;
                    lineSeries.strokeWidth = 3;
                    lineSeries.propertyFields.stroke = "lineColor";
                    lineSeries.propertyFields.fill = "lineColor";
                    
                    var bullet = lineSeries.bullets.push(new am4charts.CircleBullet());
                    bullet.circle.radius = 2;
                    bullet.circle.fill = am4core.color("#0071F7");
                    bullet.circle.stroke = am4core.color("#0071F7");
                    bullet.circle.strokeWidth = 3;
                    
                    chart.cursor = new am4charts.XYCursor();
                    chart.cursor.behavior = "panX";
                    chart.cursor.lineX.opacity = 0;
                    chart.cursor.lineY.opacity = 0;
                    
                    // chart.scrollbarX = new am4core.Scrollbar();
                    // chart.scrollbarX.parent = chart.bottomAxesContainer;
                    
                }); // end am4core.ready()
            },
            loadAnalyzeMe: function(){
                if(!document.getElementById('multiple_radar')) return; 
     
                async function loadAnalyzeParticipant(date_from = '', date_to = ''){
                    const url = window.location.pathname.split('/');
                    const survey_participant_id = window.location.pathname.endsWith('/') ? url[url.length - 2] : url[url.length - 1];

                    await Analyze.fetchAnalyzeSurveyor(survey_participant_id);
                    await Analyze.fetchAnalyzeRadarChart(survey_participant_id);
                    await Analyze.fetchOpenEndedResponse(survey_participant_id);
                    // await Analyze.fetchAnalyzeComptenciesOverallScore(survey_participant_id);
                }

                const $surveydate = $('#surveydate-dropdown');
                fetch(baseUrl + 'admin/fetch_daterange/')
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
            initAnalyzeMeSummary: function(){ 

                if(!document.getElementById('program-select-participant')) return;
                let program_id = $('#program-select-participant').val();
                if(!program_id) return;

                localStorage.setItem('pid', program_id);

                //call to tweak and set program id
                function fetch_analyze_summary(program_id){
                    fetch(baseUrl + 'admin/fetch_analyze_summary/'+ program_id)
                    .then(response => response.json())
                    .then(result => {
                        //set views 
                        Analyze.loadAnalyzeMe();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    }) 
                }
                
                fetch_analyze_summary(program_id);

                $('#program-select-participant').on('change', function(){
                    program_id = $(this).val();
                    if(!program_id) return;
                    localStorage.setItem('pid', program_id);
                    fetch_analyze_summary(program_id);
                });

            },

            //Page 6 
            initBenchmarkCompetencyResponses: function(competency_summary, date_from = '', date_to = ''){
                function compute_percentage_avg($my_surveyors, $total_comp_questions, $max_option_value, $compute_average){ 
                    //expected_average result to value that makes 100%
                    if($my_surveyors == 0 || $total_comp_questions == 0) return 0;
                    $expected_average = (($max_option_value * $total_comp_questions * $my_surveyors) / ($my_surveyors * $total_comp_questions)); 
                    return Math.round((100 * $compute_average) / $expected_average);
                }

                const processedData = competency_summary.map(function(obj){ 
                    let newObj = $.extend(true,{},obj); 
                    const keys = Object.keys(obj);
                    keys.forEach(function(key, i){
                        if(['p_current','p_current_participant','p_past','p_past_participant','p_industry'].indexOf(key) !== -1){
                            if(newObj[key]){
                                const compute_average = (newObj[key].my_surveyors == 0) ? 0 : (newObj[key].total_score / (newObj[key].my_surveyors * newObj[key].total_comp_questions));
                                newObj[key]['percent'] = compute_percentage_avg(newObj[key].my_surveyors, newObj[key].total_comp_questions, newObj[key].max_option_value, compute_average); 
                            }
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
            },        
            initBenchmarkMultipleRadar: function(data, date_from = '', date_to = ''){   
                
                if(!document.getElementById('multiple_benchmark_radar')) return;
                am4core.ready(function() {

                    // Themes begin
                    am4core.useTheme(am4themes_animated);
                    // Themes end
                    
                    /* Create chart instance */
                    var chart = am4core.create("multiple_benchmark_radar", am4charts.RadarChart);
                    
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
                        const colors = {
                            p_current: '#0071F7',
                            p_current_participant: '#029942',
                            p_past: '#FF2372',
                            p_past_participant: '#F70085',
                            p_industry: '#001E42'
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
            fetchBenchmarkRadarChart: function(){
                return new Promise(function(resolve, reject){                    
                    const past_program_id = localStorage.getItem('past_program_id') || 0;

                    fetch(baseUrl + 'admin/fetch_benchmark_radar_score/' + past_program_id)
                    .then(response => response.json())
                    .then(result => { 
                        resolve(); 
                        Analyze.initBenchmarkMultipleRadar((function(data){
                            return data.map(function(obj, index){
                                let newObj = $.extend(true,{},obj);
                                const keys = Object.keys(obj);
                                keys.forEach(function(key, i){
                                    if(['p_current','p_current_participant','p_past','p_past_participant','p_industry'].indexOf(key) !== -1){
                                        newObj[key] = obj[key] ? (obj[key]['avg']) : {}; //force average to be 5 max;
                                    }                                      
                                });  
                                return newObj;                              
                            });
                        }(result.competencies_radar_score))); 
                        
                        const source = document.getElementById("compare_surveyors_cont").innerHTML;
                        const htmlstr = JSTemplate.compile(source)({ current_survey: result.current_survey, past_survey: result.past_survey });  
                        $('.compare_surveyors_cont').html(htmlstr);
                            
                        Analyze.initBenchmarkCompetencyResponses(result.competencies_radar_score); 
                        
                    }).catch(function(err){
                        console.error(err);
                        reject(err);
                    })
                })                 
            },
            initBenchmark: function(){
                if(!document.getElementById('multiple_benchmark_radar')) return;                 
     
                async function loadAnalyzeParticipant(date_from = '', date_to = ''){                    // await Analyze.fetchAnalyzeSurveyor(survey_participant_id);
                    await Analyze.fetchBenchmarkRadarChart();  
                }

                loadAnalyzeParticipant();
            },  

            //Page 7: Action Plans
            renderActionPlansDt: function(options){
                const dataTable = $('#dt_action_plans').DataTable(options);   

                // //add toggle more event
                dataTable.off('click', '.table-accordion').on('click', '.table-accordion', function(){            
                    //show more detail on each cells
                    $(this).toggleClass('collapsed');
                    $(this).closest('tr').find('.more-info').toggleClass('hide');
                })

                dataTable.off('click', '.drop-status').on('change', '.drop-status', function(e){            
                    //show more detail on each cells
                    e.preventDefault();
                    const $this = $(this);
                    const data = $this.data();
                    const status = $this.val();
                    const color = {
                        'Not Started' : 'blue',
                        'Started' : 'orange',
                        'Completed' : 'green'
                    }
                    Object.values(color).forEach(function(v){
                        $this.removeClass(v);
                    });                    

                    $.ajax({
                        url: baseUrl + 'admin/update_action_status/',
                        type: 'POST',
                        data: { status: status, action_plan_id: data.actionplanid },
                        error: function(err) {
                            console.log(err, ' something went wrong'); 
                        },
                        success: function(result){ 
                            const data = JSON.parse(result);  
                            $this.addClass(color[status]); 
                        }
                    });                    
                });

                // //set search listener                
                $('.search-input').on( 'keyup', function () {
                    dataTable.search($(this).val()).draw();
                });

                // // generate paginate menu
                Analyze.generatePaging(dataTable.page.info(), '.paginate-select');

                // //paginate select
                $('.paginate-select').on('change', function(){
                    const page = $(this).find('option:selected').data('page');
                    const index = parseInt(page); 
                    dataTable.page(index).draw(false);
                });
            },
            initDatatableActionPlans: function(){ 
                if(!$('#dt_action_plans').length) return;
                Analyze.renderActionPlansDt({
                    // responsive: true, 
                    dom: 'tip', 
                    scrollX: true,
                    columnDefs: [
                        // { "orderable": false, "searchable": false, "targets": 0 }, 
                        // { "orderable": false, "searchable": false, "targets": length + 1 },
                        { "orderable": false, "searchable": false, "targets": length },
                        // { "width": ((100 - 10) / length) + '%', "targets": [2,3] }
                    ],
                }); 
            }, 

            //Page 8: Response Rate
            responseRate: function(filter){
                if(!document.getElementById('response_rate_pie')) return;
                //get program id selected
                fetch(baseUrl + 'admin/response_rate_criteria/' + filter)
                .then(response => response.json())
                .then(result => { 
                    
                    // Themes begin
                    am4core.useTheme(am4themes_animated);
                    var chart = am4core.create("response_rate_pie", am4charts.PieChart);
                    // Add data
                    chart.data = result.response_rate_criteria;

                    // Add and configure Series
                    var pieSeries = chart.series.push(new am4charts.PieSeries());
                    pieSeries.dataFields.value = "total_surveyor_responded";
                    pieSeries.dataFields.category = "title";
                    pieSeries.dataFields['total_surveyor_invited'] = "total_surveyor_invited";
                    pieSeries.dataFields['total_participants'] = "total_participants";

                    chart.innerRadius = am4core.percent(40);

                    // pieSeries.slices.template.stroke = am4core.color("#fff");
                    pieSeries.slices.template.strokeWidth = 1;
                    pieSeries.slices.template.strokeOpacity = 1;

                    pieSeries.colors.list = [
                        am4core.color("#EB5757"),
                        am4core.color("#6FCF97"),
                        am4core.color("#001E42"),
                        am4core.color("#F2C94C"), 
                    ];

                    pieSeries.ticks.template.disabled = true;
                    pieSeries.alignLabels = false;
                    pieSeries.labels.template.text = "{value.percent.formatNumber('#.0')}%";
                    pieSeries.labels.template.radius = am4core.percent(-30);
                    pieSeries.labels.template.fill = am4core.color("white");
                    
                    pieSeries.slices.template.tooltipText = "{category} {value.percent.formatNumber('#.0')}%";

                    chart.legend = new am4charts.Legend(); 
                    chart.legend.position = 'bottom';
                    var marker = chart.legend.markers.template;
                    marker.height = 5; 

                    chart.legend.labels.template.text = "{name}";
                    pieSeries.legendSettings.valueText = "{value.percent.formatNumber('#.0')}% ({value} of {total_surveyor_invited})"; 

                    var label = chart.seriesContainer.createChild(am4core.Label);
                    let total_sureyors_responded = 0;
                    let total_surveyors_invited = 0;
                    result.response_rate_criteria.forEach(function(obj,i){
                        total_surveyors_invited += parseInt(obj.total_surveyor_invited);
                        total_sureyors_responded += parseInt(obj.total_surveyor_responded);
                    }); 
                    label.html = '<p style="text-align:center;"><b>' + total_sureyors_responded + " of " + total_surveyors_invited + '</b><br><b>Evaluators<b>';
                    label.horizontalCenter = "middle";
                    label.verticalCenter = "middle";
                    label.fontSize = 14;

                    //call barline
                    Analyze.initResponseRateBarLine(result.response_rate_criteria);

                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }, 
            initResponseRatePiechart: function(){
                Analyze.responseRate('department');
                
                $('#response-filter').on('change', function(){
                    const filter = $(this).val();
                    if(!filter) return;
                    localStorage.setItem('filter', filter);
                    //load benchmark page
                    Analyze.responseRate(filter);                        
                });
            },

            //Page 9: PMF Report
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
                        company_setting.company_logo = `${baseUrl}asset/images/company-logo/${company_setting.company_logo}`;

                        //set placholders
                        $('.pmf-image-logo').attr('src', company_setting.company_logo);
                        $('.placeholder-company__name').html(company_setting.company_name);
                        $('.placeholder-competency__count').html(company_setting.competency_count);
                        if(company_setting.use_pmf == 1){
                            $('.placeholder-perspective').html('Understanding your Report: Two Perspectives')
                            $('.placeholder-view').html('The first view we provide')
                            $('.placeholder-section__count').html(6)
                            $('.placeholder-no__pmf').remove();
                        }else{
                            $('.placeholder-perspective').html('Understanding your Report');
                            $('.placeholder-view').html('This view provides');
                            $('.placeholder-section__count').html(5);
                            $('.placeholder-multiple__radar--pmf').remove();
                            $('.placeholder-use__pmf').remove();
                        }
                        if(company_setting.use_direct_report == 1) $('#placeholder-drpt').html(`, and ${company_setting.direct_report_name}`)                       

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
                if(company_setting.use_pmf == 0){
                    $('.people-mgt-fwk').remove();
                    $('#download-report').html('Download'); 
                    $('#download-report').attr('disabled',false);
                    $('#download-report').on('click', function(){
                        window.print();
                    })
                    return
                }

                return new Promise(function(resolve, reject){
                    fetch(baseUrl + 'evaluation/fetch_pmf_detail/' + survey_participant_id)
                    .then(response => response.json())
                    .then(result => {  
                        resolve();
                        
                        if(result.data.length === 0){
                            bootbox.alert({ 
                            title: 'Notice',
                            message: `<p>
                                Dear Participant, <br/><br/>
                                                
                                Due to the lack of responses received to your evaluation request, there is insufficient data to generate a report for you. <br/><br/>
                                        
                                Please contact your HR business Partner for more information or guidance.<br/><br/>
                                        
                                        Sincerely <br/>
                                        MTN 180 Assessment Team
                                    </p>`,
                            closeButton: false, 
                            callback: function(){
                               window.close()
                            }
                        });
                            return
                        }
                        
                        const group = result.data.reduce((r, a) => { 
                            r[a.pmf_category] = [...r[a.pmf_category] || [], a];
                            return r;
                        }, {});

                        if(company_setting.use_pmf == 1){
                            const arr = ['Focus Me', 'Guide Me', 'Know Me', 'Recognize Me'];
                            arr.forEach(function(item){                                
                                const source = document.getElementById("pmf_detail_analysis").innerHTML;
                                $('.'+ item.replace(/\s/g,'_').toLowerCase()).html(JSTemplate.compile(source)({ data: group[item] })); 
                                $('body').find('.'+ item.replace(/\s/g,'_').toLowerCase()).find('.pmf-type').html(item);
                            });
                        }else{
                            $('.people-mgt-fwk').remove();
                        }
                        
                        $('#download-report').html('Download'); 
                        $('#download-report').attr('disabled',false);
                        $('#download-report').on('click', function(){
                            window.print();
                        })

                    }).catch(function(err){
                        reject(err);
                    })
                }) 
            },

            //Page 10: Engagement Survey
            initEngagementSurvey: function(){
                Analyze.initEngagementPiechart();
                Analyze.initWordCloud();
                Analyze.initCarousel();
                Analyze.initGaugeChart();
                Analyze.initBarchart();                
            },
            initEngagementPiechart: function(selected_date){
                if(!document.getElementById('assessment_pie')) return;
                //get program id selected
                //TODO: USE CORRECT URL
                fetch(baseUrl + 'admin/fetch_chart_data/')
                .then(response => response.json())
                .then(result => { 

                    var chart = am4core.create("assessment_pie", am4charts.PieChart);
                    // Add data 
                    chart.data = [
                        {
                            title: 'Participated',
                            value: 8
                        },
                        {
                            title: 'Awaited Responses',
                            value: 2
                        }
                    ]
                    
                    // Add and configure Series
                    var pieSeries = chart.series.push(new am4charts.PieSeries());
                    pieSeries.dataFields.value = "value";
                    pieSeries.dataFields.category = "title";
                    // pieSeries.dataFields['total_surveyors'] = "total_surveyors";

                    chart.innerRadius = am4core.percent(40);

                    // pieSeries.slices.template.stroke = am4core.color("#fff");
                    pieSeries.slices.template.strokeWidth = 1;
                    pieSeries.slices.template.strokeOpacity = 1;

                    pieSeries.colors.list = [
                        am4core.color("#1d3557"),
                        am4core.color("#74c69d"),
                    ];

                    pieSeries.ticks.template.disabled = true;
                    pieSeries.alignLabels = false;
                    pieSeries.labels.template.text = "{value.percent.formatNumber('#.0')}%";
                    pieSeries.labels.template.radius = am4core.percent(-30);
                    pieSeries.labels.template.fill = am4core.color("white");
                    
                    pieSeries.slices.template.tooltipText = "{category} {value.percent.formatNumber('#.0')}%";

                    var label = chart.seriesContainer.createChild(am4core.Label);
                    label.html = '<p style="text-align:center;"><b>' + (100) + " of " + 120 + '</b><br><b>Participants<b>';
                    label.horizontalCenter = "middle";
                    label.verticalCenter = "middle";
                    label.fontSize = 14;

                })
                .catch(error => {
                    console.error('Error:', error);
                }) 
            },
            initWordCloud: function(){
                if(!$('.word-cloud-generator').length > 0) return;

                $('.word-cloud-generator').each(function(i,elem){
                    am4core.useTheme(am4themes_animated);
                    let chart = am4core.create(elem.id, am4plugins_wordCloud.WordCloud);  
                    let series = chart.series.push(new am4plugins_wordCloud.WordCloudSeries());

                    // using text list
                    //series.text = "The cat has been let out of the bag, so the cat jump off the fence to play with other cat";
                     
                    //using structured data
                    series.data = [{
                        "tag": "Breaking News",
                        "weight": 60
                    }, {
                        "tag": "Environment",
                        "weight": 80
                    }, {
                        "tag": "Politics",
                        "weight": 90
                    }, {
                        "tag": "Business",
                        "weight": 25
                    }, {
                        "tag": "Lifestyle",
                        "weight": 30
                    }, {
                        "tag": "World",
                        "weight": 45
                    }, {
                        "tag": "Sports",
                        "weight": 160
                    }, {
                        "tag": "Fashion",
                        "weight": 20
                    }, {
                        "tag": "Education",
                        "weight": 78
                    }];
                    
                    series.dataFields.word = "tag";
                    series.dataFields.value = "weight";
                    
                    //color theme
                    series.colors = new am4core.ColorSet();
                    series.colors.passOptions = {};
                    
                    //same color
                    // series.labels.template.fill = am4core.color("#9F6BA0"); 
                });
            },
            initCarousel: function(){
                const totalItems = $('.word-cloud--content.item').length;
                $(".question-slide-btn").click(function(){
                    $("#wordCloudCarousel").carousel($(this).data('action'));
                });

                let currentIndex = $('.word-cloud--content.active').index() + 1;
                $('.question-slide-controller .question-number').html('Q' + currentIndex);

                $('#wordCloudCarousel').on('slid.bs.carousel', function() {
                    currentIndex = $('.word-cloud--content.active').index() + 1;
                   $('.question-slide-controller .question-number').html('Q' + currentIndex);
                });
            },
            initGaugeChart: function(){
                // Enable gauge chart
                if(!$('#gauge-chart').length > 0) return;

                am4core.useTheme(am4themes_animated);

                // create chart
                $('#gauge-chart').css('height', '150px');
                var chart = am4core.create("gauge-chart", am4charts.GaugeChart);

                chart.innerRadius = -50;
                
                var axis = chart.xAxes.push(new am4charts.ValueAxis());
                axis.min = 0;
                axis.max = 100;
                axis.strictMinMax = true;

                // var axis = chart.xAxes.push(new am4charts.CategoryAxis());
                // axis.dataFields.category = "category";
                // axis.data = [{
                //     category: "One"
                //     }, {
                //     category: "Two"
                //     }, {
                //     category: "Three"
                //     }, {
                //     category: "Four"
                //     }, {
                //     category: "Five"
                //     }, {
                //     category: "Six"
                // }];                
                // axis.renderer.labels.template.location = 0.5;
                // axis.renderer.grid.template.location = 0.5;
                // axis.startLocation = 0.5;
                // axis.endLocation = 0.5;

                axis.renderer.grid.template.disabled = true;
                axis.renderer.labels.template.disabled = true;                

                var colorSet = new am4core.ColorSet();

                var range0 = axis.axisRanges.create();
                // range0.category = "One";
                // range0.endCategory = "Three";
                range0.value = 0;
                range0.endValue = 20;
                range0.axisFill.fillOpacity = 1;
                range0.axisFill.fill = '#7E9EC2';
                range0.axisFill.zIndex = -1;
                // range0.locations.category = 0.5;
                // range0.locations.endCategory = 0.5;
                range0.label.text = "";
                range0.grid.disabled = true;

                var range1 = axis.axisRanges.create();
                // range1.category = "Three";
                // range1.endCategory = "Five";
                range1.value = 20;
                range1.endValue = 90;
                range1.axisFill.fillOpacity = 1;
                range1.axisFill.fill = '#F70085'//colorSet.getIndex(1);
                range1.axisFill.zIndex = -1;
                // range1.locations.category = 0.5;
                // range1.locations.endCategory = 0.5;
                range1.label.text = "";
                range1.grid.disabled = true;

                var range2 = axis.axisRanges.create();
                // range2.category = "Five";
                // range2.endCategory = "Six";
                range2.value = 90;
                range2.endValue = 100;
                range2.axisFill.fillOpacity = 1;
                range2.axisFill.fill = '#0071F7' //colorSet.getIndex(2);
                range2.axisFill.zIndex = -1;
                // range2.locations.category = 0.5;
                // range2.locations.endCategory = 0.5;
                range2.label.text = "";
                range2.grid.disabled = true;

                var hand = chart.hands.push(new am4charts.ClockHand());
                hand.value = 40
            },
            initBarchart: function(response_rate){
                if(!document.getElementById('pulse_barchart')) return;

                am4core.useTheme(am4themes_animated);
                let chart = am4core.create("pulse_barchart", am4charts.XYChart); 

                // Add data
                chart.data = [
                    {
                        "score": 0,
                        "percentage": 3
                    },
                    {
                        "score": 1,
                        "percentage": 4
                    },
                    {
                        "score": 2,
                        "percentage": 3
                    },
                    {
                        "score": 3,
                        "percentage": 5
                    },
                    {
                        "score": 4,
                        "percentage": 4
                    },
                    {
                        "score": 5,
                        "percentage": 6
                    },
                    {
                        "score": 6,
                        "percentage": 2
                    },
                    {
                        "score": 7,
                        "percentage": 4
                    },
                    {
                        "score": 8,
                        "percentage": 5
                    },
                    {
                        "score": 9,
                        "percentage": 20
                    },
                    {
                        "score": 10,
                        "percentage": 44
                    },
                ];
                
                // Create axes
                
                let categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                categoryAxis.dataFields.category = "score";
                categoryAxis.renderer.grid.template.location = 0;
                categoryAxis.renderer.minGridDistance = 30;
                
                // categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
                //     if (target.dataItem && target.dataItem.index & 2 == 2) {
                //     return dy + 25;
                //     }
                //     return dy;
                // });
                
                let valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                valueAxis.min = 0;
                valueAxis.max = 100;  
                
                // Create series
                let series = chart.series.push(new am4charts.ColumnSeries());
                series.dataFields.valueY = "percentage";
                series.dataFields.categoryX = "score";
                series.name = "percentage";
                series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
                series.columns.template.fillOpacity = .8;
                
                let columnTemplate = series.columns.template;
                columnTemplate.strokeWidth = 2;
                columnTemplate.strokeOpacity = 1;

                series.columns.template.adapter.add("fill", function(fill, target) {
                    return (target.dataItem.index <= 6) ? '#7E9EC2' : ((target.dataItem.index <= 8) ? '#F70085' : '#0071F7');
                });

                // let detractorsRange = valueAxis.createSeriesRange(series);
                // detractorsRange.value = 0;
                // detractorsRange.endValue = 6;
                // detractorsRange.contents.stroke = am4core.color("#7E9EC2");
                // detractorsRange.contents.fill = detractorsRange.contents.stroke;

                // let passiveRange = valueAxis.createSeriesRange(series);
                // passiveRange.value = 7;
                // passiveRange.endValue = 8;
                // passiveRange.contents.stroke = am4core.color("#F70085");
                // passiveRange.contents.fill = passiveRange.contents.stroke;

                // let promotersRange = valueAxis.createSeriesRange(series);
                // promotersRange.value = 9;
                // promotersRange.endValue = 10;
                // promotersRange.contents.stroke = am4core.color("#0071F7");
                // promotersRange.contents.fill = promotersRange.contents.stroke;

            }
        }
    }());

    Analyze.reisterHelpers();

    Analyze.getCompanySetting(function(setting){ 

        Analyze.initAnalyzeSummary();
        Analyze.initAssessment360();
    
        Analyze.initDatatableAllParticipant();
        Analyze.initDatatableEvaluator();
        Analyze.initAnalyze();
        Analyze.initCompareParticipants();
        Analyze.initEngagementLineChart();
        
        // Analyze.initAnalyzeMeSummary();
        Analyze.initBenchmark();
        Analyze.initDatatableActionPlans();

        Analyze.initResponseRatePiechart();
        
        Analyze.initEvaluationReport();

        Analyze.initEngagementSurvey();

    });


}())