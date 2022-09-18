// JavaScript Document
$(init);

var link = "http://localhost:90/pipa/";

//var link = "https://www.aeriksoftsolutions.com/pipa/";

//var link = "https://www.mannapatisserie.com/pipa/";

// var link = "https://www.naama.io/sandbox/";

var wasSubmitted = false;

var optionalArray	=	Array;

function init(){
	
	//poll();
	
	//check_menu_accordion();
								   
	$(".phone_n_").keyup(validate_inputed_number);
	
	$('.prod_image_upl').click(function(){
		
		$('#upload_prod_img').click();
		
	});
	
	$(".chnge-homebanner").click(function(){
		$('.first-app').hide();
		$('.banner-img').show();
		$('.banner_link').val('');	
	});
	
	$('.survey-standard-clicked-side-question').click(show_survey_question);
	
	$('.survey-optional-clicked-side-question').click(show_survey_optional_question);
	
	$('.datepicker').datepicker({
		format: 'yyyy-mm-dd'
	});
	
	$( "#add-custom-question" ).click(function(){
		
		if($('#option_options').val() != '')
		{	
		
			add_question($('#option_options').val());
			//$('#option_options').val('');
						
		}
		
		
	});
	
	$('.role-page-action').click(hold_role_action);
	
	$('.role-select-action').click(hold_role_select_action);
	
	$('.country').change(fetch_country_states);
		
	$('.state').change(fetch_state_lga);
	
	$('.businesscountry').change(fetch_business_country_states);
	
	$('.businessstate').change(fetch_business_state_lga);
	
	$('#gc_check_all').click(function(){
		
		if(this.checked)
		{
			$('.gc_check').attr('checked', 'checked');
		}
		else
		{
			 $(".gc_check").removeAttr("checked"); 
		}
		
	});
	
	
	$('.del-admin-page').click(delete_admin_page);
	
	$('.chng_pswd').click(function(){

		$.post(link + 'admin/password_form/',
			function(data){
				$('#password-form-container').html(data).modal('show');
			}
		);

	});
	
	
	if( $('#example1').length )         // use this if you are using id to check
	{
		
		var table = $('#example1').DataTable( {
			responsive: true,
			"order": [[ 0, "desc" ]]
		} );
	 
		new $.fn.dataTable.FixedHeader( table );
	
	}
		
	/*$('.surv-standardcheck-checkbox').click(surv_standardcheck_checkbox_action);
	
	$('.surv-standardcheck-checkbox').on('change', function(){
		
		alert('hello world 2');
			
	});*/
	
	$('.surv-standardcheck-checkbox').on('ifChanged', function(event){
	  			
		//console.log($(this).is(':checked'));
		
		var id			=	$(this).val();
		
		//console.log('The value = '+id);
		
		if($(this).is(':checked'))
		{
			
			//console.log('It was checked');
			$('.surv-standard-general-'+id+'').addClass('competency-list-selected');
			
			$('.disapprove-standard-'+id+'').show();
		
			$('.approve-standard-'+id+'').hide();
				
		}else{
			
			//console.log('It was unchecked');
			
			$('.surv-standard-general-'+id+'').removeClass('competency-list-selected');
			
			$('.disapprove-standard-'+id+'').hide();
		
			$('.approve-standard-'+id+'').show();
		}

		surv_standardcheck_checkbox_action();
		
	});
	
	$('.surv-standard-btn-appr').click(function(){
		
				
		var competency_id 					= 	$(this).attr('lang');
		
		$(this).hide();
		
		$('.disapprove-standard-'+competency_id+'').show();
		
		//$('.surv-stand-checkbox-'+competency_id+'').trigger('change');
		
		$('.surv-stand-checkbox-'+competency_id+'').iCheck('toggle');
				
		/*var standardhldLoad					=	$('.standard_hldr').val();

		standardhldLoad					+= 	competency_id+',';
		
		$('.standard_hldr').val(standardhldLoad);
		
		
		
		if($('.surv-standard-general-'+competency_id+'').hasClass('competency-list-selected'))
		{	
			
			$('.surv-standard-general-'+competency_id+'').removeClass('competency-list-selected');
			
		}else{
		
			$('.surv-standard-general-'+competency_id+'').addClass('competency-list-selected');
		
		}*/
		
	});
	
	$('.surv-standard-btn-remove').click(function(){
		
		var competency_id 					= 	$(this).attr('lang');
		
		$(this).hide();
		
		$('.approve-standard-'+competency_id+'').show();
		
		$('.surv-stand-checkbox-'+competency_id+'').iCheck('toggle');
		
		
		/*if($('.surv-standard-general-'+competency_id+'').hasClass('competency-list-selected'))
		{	
			
			$('.surv-standard-general-'+competency_id+'').removeClass('competency-list-selected');
			
		}else{
		
			$('.surv-standard-general-'+competency_id+'').addClass('competency-list-selected');
		
		}*/
		
/*		var standardhldLoad					=	$('.standard_hldr').val();
		
		var replaceLastVal					=	standardhldLoad.substring(0, standardhldLoad.length - 1);
												
		var pageloadres 					= 	replaceLastVal.split(",");
		
		var compareRes						=	pageloadres.includes(competency_id);
		
		var newHld							=	'';
		
		//console.log(pageloadres);
						
		if(compareRes == true)
		{
			
			var index 						= 	pageloadres.indexOf(competency_id);
			
			pageloadres.splice(index, 1);
						
			//console.log('The id exists in the array of Approved, the index ='+index);
			
			//console.log(pageloadres);
			
			$.each(pageloadres, function(index, value) {
											
			  //assign all the users to a variable					  
				newHld						+= 	value+',';
													
			});
			
			//console.log(newHld);
		
		}else{
					
		}
				
		$('.standard_hldr').val(newHld);*/
		
	});
	
	$('.surv-optn-btn-appr').click(function(){
		
		if($(this).hasClass('surv-btn-appr-dull'))
		{
			
			
		}else{
					
			var competency_id 					= 	$(this).attr('dir');
			
			var competency_question_id 			= 	$(this).attr('lang');
			
			//$(this).addClass('check-opt-rem-approved-'+competency_id+'');
			
			//var checkoptclass					=	$('.check-opt-rem-'+competency_id+'');
			
			//console.log('This class has this number of questions = '+checkoptclass.length);
			
			if($('.surv-option-checkbox-'+competency_id+'').is(':checked'))
			{
								
			}else{
				
				$('.surv-option-checkbox-'+competency_id+'').iCheck('toggle');
				
				$('.surv-optional-general-'+competency_id+'').addClass('competency-list-selected');
								
			}
			
			
			
			$(this).addClass('surv-btn-appr-dull');
			
			$('.surv-opt-remove-'+competency_question_id+'').removeClass('surv-btn-appr-dull');
			
			$('.surv-opt-remove-'+competency_question_id+'').addClass('check-opt-rem-approved-'+competency_id+'');

			var optionalhldLoad					=	$('.optional_hldr').val();

			optionalhldLoad						+= 	competency_question_id+',';
		
			$('.optional_hldr').val(optionalhldLoad);
		
		}
		
	});
	
	$('.surv-optn-btn-remove').click(function(){
		
		var checkRemove		=	$('.surv-btn-appr-dull');
		
		console.log('Length = '+checkRemove.length);
		
		if($(this).hasClass('surv-btn-appr-dull'))
		{
			
			
		}else{
					
			var competency_id 					= 	$(this).attr('dir');
			
			var competency_question_id 			= 	$(this).attr('lang');
			
			$(this).addClass('surv-btn-appr-dull');
			
			$(this).removeClass('check-opt-rem-approved-'+competency_id+'');
						
			var checkoptclass					=	$('.check-opt-rem-approved-'+competency_id+'');

			if(checkoptclass.length > 0)
			{
				//means there are still questions that have been approved	
			
			}else{
				
				$('.surv-option-checkbox-'+competency_id+'').iCheck('toggle');
				
				$('.surv-optional-general-'+competency_id+'').removeClass('competency-list-selected');
					
			}
			
			
			$('.surv-opt-appr-'+competency_question_id+'').removeClass('surv-btn-appr-dull');
			
			var optionalhldLoad					=	$('.optional_hldr').val();
		
			var replaceLastVal					=	optionalhldLoad.substring(0, optionalhldLoad.length - 1);
													
			var pageloadres 					= 	replaceLastVal.split(",");
			
			var compareRes						=	pageloadres.includes(competency_question_id);
			
			var newHld							=	'';
			
			//console.log(pageloadres);
							
			if(compareRes == true)
			{
				
				var index 						= 	pageloadres.indexOf(competency_question_id);
				
				pageloadres.splice(index, 1);
							
				//console.log('The id exists in the array of Approved, the index ='+index);
				
				//console.log(pageloadres);
				
				$.each(pageloadres, function(index, value) {
												
				  //assign all the users to a variable					  
					newHld						+= 	value+',';
														
				});
				
				//console.log(newHld);
			
			}else{
				
				//console.log('This id does not exist in the array of Approved');
			
			}
					
			$('.optional_hldr').val(newHld);

		}
		
	});
	
}

function surv_standardcheck_checkbox_action(){
			
	var long_list 		= 	"";
	
	$('.surv-standardcheck-checkbox:checked').each(function(){ // walk through each div with 'chat_p' as class
	
		var the_id_list = $(this).val();// extract the number contained in the id of the class
				
		long_list += the_id_list+','; 
	
	//member_ids.push(the_id_list); // creation of array with number of each status div
	});

	$(".standard_hldr").val(long_list);

}


function addcomas(str){
	var amount = new String(str);
	amount = amount.split("").reverse();
	var output = "";
	for ( var i = 0; i <= amount.length-1; i++){
		output = amount[i] + output;
		if((i+1) % 3 == 0 && (amount.length-1) !== i)output = ',' + output;
	}
	return output;
	
}


function checkall_inspection(){
	
	$('.inspect_chckbox').attr('checked', this.checked);

}


function show_animation()
{
	$('#saving_container').css('display', 'block');
	$('#saving').css('opacity', '.8');
}

function hide_animation()
{
	$('#saving_container').fadeOut();
}

function validate_inputed_number(){
	
	//remove lettes and commas
	var the_box_value = $(this).val().replace(/[^\d.]/g, '');
	$(this).val(the_box_value);
	
	//Remove double dots
	the_box_value = $(this).val();
	var occurances = occurrences(the_box_value, ".", "");
	var last_char = the_box_value.charAt( the_box_value.length-1 );
	
	if(last_char == "." && occurances > 1) {
		$(this).val( the_box_value.slice(0, the_box_value.length-1) );	
	}
}


function occurrences(string, subString, allowOverlapping){

    string+=""; subString+="";
    if(subString.length<=0) return string.length+1;

    var n=0, pos=0;
    var step=(allowOverlapping)?(1):(subString.length);

    while(true){
        pos=string.indexOf(subString,pos);
        if(pos>=0){ n++; pos+=step; } else break;
    }
    return(n);
}

function addCommas(nStr){
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}

function check_menu_accordion(){
	
	$('.active').parents('ul').slideDown();
}

function show_survey_question()
{
	
	var competency		=	$(this).attr('lang');
	
	$('.competency-lst').removeClass('competency-list-active');
	
	$(this).addClass('competency-list-active');
	
	$('.surv-standard-cont').hide();
	
	$('.survey-clicked-standard-main-question-'+competency+'').show();	
	
	/*var currentHeight = $('.survey-clicked-standard-main-question-'+competency+'').outerHeight();

    console.log("set current height on load = " + currentHeight);*/
	
   // console.log("content height function (should be 374)  = " + contentHeight());   

}

function show_survey_optional_question()
{
	
	var competency		=	$(this).attr('lang');
	
	$('.competency-opt-lst').removeClass('competency-list-active');
	
	$(this).addClass('competency-list-active');
	
	$('.surv-optional-cont').hide();
	
	$('.survey-clicked-optional-main-question-'+competency+'').show();	
}

function fetch_country_states(){
	
	var country_id 		= 	$('.country').val();
	
	$('.lgahold').val(0);
	
	$('.lgahold').attr("disabled", true);
	
	if(country_id  == 0){
		
		$('.statehold').attr("disabled", true);
		
		$('.state').val(0);
		
		$('.stateoforigin').val(0);
				
	}else{
		
		$('.statehold').attr("disabled", false);
		
		$.ajax({ 			 
			type: "POST",
			url:link+"admin/get-country-state",
			data: { "country_id" :country_id},
			cache: false,
			success: function (data) {
				
				$('.statehold').html(data);
						
			},
			 error: function(data){
				  
			 }
			
		});
	
	}
			
}

function fetch_state_lga(){
	
	var state_id 		= 	$('.state').val();
	
	if(state_id == 0){
		
		$('.lgahold').attr("disabled", true);
		
		$('.lgahold').val(0);
		
	}else{
		
		$('.lgahold').attr("disabled", false);
		
		$('.lgahold').html('Loading...');
		
		
		$.ajax({ 
			type:"POST", 
			url:link+"admin/get-state-lga", 
			data:{ "state_id" :state_id},
			success:function(data){
				
						//doCheck(data);
				$('.lgahold').html(data);
						
			},
			 error: function(data){
				  
			 }
			
		});
		
	}
}

function check_fetch_lga(){
		
	var state_id 		= 	$('.state').val();
		
	if(state_id == 0){
		
		$('.lgahold').attr("disabled", true);	
		
	}else{
		
		fetch_state_lga();
		
	}
}

function fetch_business_country_states(){
	
	var country_id 		= 	$('.businesscountry').val();
	
	$('.businesslgahold').val(0);
	
	$('.businesslgahold').attr("disabled", true);
	
	if(country_id  == 0){
		
		$('.businessStatehold').attr("disabled", true);
		
		$('.businessstate').val(0);
				
	}else{
		
		$('.businessStatehold').attr("disabled", false);
		
		$.ajax({ 			 
			type: "POST",
			url:link+"admin/get-country-state",
			data: { "country_id" :country_id},
			cache: false,
			success: function (data) {
				
				$('.businessStatehold').html(data);
						
			},
			 error: function(data){
				  
			 }
			
		});
	
	}
			
}

function fetch_business_state_lga(){
	
	var state_id 		= 	$('.businessstate').val();
	
	
	if(state_id == 0){
		
		$('.businesslgahold').attr("disabled", true);
		
		$('.businesslgahold').val(0);
		
	}else{
		
		$('.businesslgahold').attr("disabled", false);
		
		$('.businesslgahold').html('Loading...');
		
		
		$.ajax({ 
			type:"POST", 
			url:link+"admin/get-state-lga", 
			data:{ "state_id" :state_id},
			success:function(data){
				
						//doCheck(data);
				$('.businesslgahold').html(data);
						
			},
			 error: function(data){
				  
			 }
			
		});
		
	}
}


// delete message
function delete_admin_page(){
	
	var id 			= 	$(this).attr('rel');
	
	var action 		= 	confirm('Are you sure you want to Delete This Page?');
	
	if(action){

		
		if(!wasSubmitted)  //this here is for checking if this approval button has been clicked previously
		{
			wasSubmitted = true;
			
			$(this).hide();
		
		
			$.ajax({ 			 
				type: "POST",
				url:link+"admin/delete-admin-page",
				data: { "id" :id},
				cache: false,
				dataType: 'json',
				success: function (data) {
					
					if(data.status == "Please Login")
					{
						window.location 	= 	link+'admin/';
					
					}
					else if(data.status == "Error")
					{
						alert(data.status);
												
						$(this).show();
						
					}
					else if(data.status == "Success")
					{
						alert(data.message);
																		
						setTimeout(window.location 	= 	link+'admin/admin-pages/', 4000);

							
					}
							
				},
				 error: function(data){
					  
				 }
				
			});
		
		}else{
			
			return false;
			
		}
		
	}else{
		
		
	}
}

function hold_role_action(){
	
	var long_list 		= 	"";
	
	$('.role-page-action:checked').each(function(){ // walk through each div with 'chat_p' as class
	
		var the_id_list = $(this).val();// extract the number contained in the id of the class
		
		long_list += the_id_list+','; 
	
	//member_ids.push(the_id_list); // creation of array with number of each status div
	});

	$(".action_hldr").val(long_list);

}

function hold_role_select_action(){
	
	var long_list 		= 	"";
	
	var page 			=	$(this).attr('lang');
		
	$('.role-select-'+page+':checked').each(function(){ // walk through each div with 'chat_p' as class
	
		var the_id_list = $(this).val();// extract the number contained in the id of the class
		
		long_list += the_id_list+','; 
	
	//member_ids.push(the_id_list); // creation of array with number of each status div
	});

	$("."+page+"").val(long_list);

}

function add_question(type)
{
	//increase option_count by 1
	option_count++;

	$.post(link+"admin/create-custom-question/", { type: type, count:option_count},
		function(data) {
					
			$('#hold-quest-div').append(data);

	});

}

function remove_question(id)
{
	
	if(confirm('Are you sure you want to remove this Question?'))
	{
		$('#option-'+id).remove();

	}
}

function readURL(input) {
	
	$("#preview").show();
	
	if (input.files && input.files[0]) {
		
		var reader = new FileReader();

		reader.onload = function (e) {
			
			$('#preview').attr('src', e.target.result);
		
		};

		reader.readAsDataURL(input.files[0]);
		
	}
	
}

