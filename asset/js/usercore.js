var base_url 	= 	"http://localhost/1community/";

//var base_url 	= 	"https://www.aeriksoftsolutions.com/1community/";

//var base_url = "https://www.1community.africa/";

var wasSubmitted = false;

$(function () {
    'use strict';
	
	
	$(".change-img").click(function(){
		$('.first-app').hide();
		$('.banner-img').show();
		$('.banner_link').val('');	
	});
	
	$(".change-img2").click(function(){
		$('.first-app2').hide();
		$('.banner-img2').show();
		$('.banner_link2').val('');	
	});
	
	$(".change-img3").click(function(){
		$('.first-app3').hide();
		$('.banner-img3').show();
		$('.banner_link3').val('');	
	});
	
	$('.country').change(fetch_country_states);
		
	$('.state').change(fetch_state_lga);
	
	$('.businesscountry').change(fetch_business_country_states);
	
	$('.businessstate').change(fetch_business_state_lga);
	
	//check_fetch_lga();

	
	$(".phone_n_").keyup(validate_inputed_number);
	
	$(".phone_n_").on("paste",function(e) { 
	 
        var $this = $(this);
		
        setTimeout(function(){
			
          //var val = $this.val();
            
          //alert(val); 
		  
		  validate_inputed_number_paste($this);
		     
        },0);

	});
										
	$('.del-message').click(delete_message);
	
	$('.userRegRefMedium').change(function(){
		
		var selOpt		=	$(this).val();
		
		if(selOpt == 'Others')
		{
			$('.othersReg').show();
			
		}else{
			
			$('.othersReg').hide();
				
		}
		
	});
	
	$('.idType').change(function(){
		
		var selOpt		=	$(this).val();
		
		if(selOpt == 'Others')
		{
			$('.idothers').show();
			
		}else{
			
			$('.ifIDothers').val('');
			
			$('.idothers').hide();
				
		}
		
	});
	
	$('.utilityType').change(function(){
		
		var selOpt		=	$(this).val();
				
		if(selOpt == 'Others')
		{
			$('.utilityothers').show();
			
		}else{
			
			$('.ifUtilityothers').val('');
			
			$('.utilityothers').hide();
				
		}
		
	});
			
	var table = $('#example1').DataTable( {
		responsive: true,
		"order": [[ 0, "desc" ]]
	} );
	
	var table2 = $('#bank1').DataTable( {
		responsive: true,
		"order": [[ 0, "asc" ]]
	} );
 
	new $.fn.dataTable.FixedHeader( table );
	
	new $.fn.dataTable.FixedHeader( table2 );
	
	
});

function checkBeforeSubmit(){
  if(!wasSubmitted) {
	wasSubmitted = true;
	return wasSubmitted;
  }
  return false;
}    

function isNumeric(s) {
    return !isNaN(s - parseFloat(s));
}

function round(value, exp) {
  if (typeof exp === 'undefined' || +exp === 0)
    return Math.round(value);

  value = +value;
  exp = +exp;

  if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0))
    return NaN;

  // Shift
  value = value.toString().split('e');
  value = Math.round(+(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp)));

  // Shift back
  value = value.toString().split('e');
  return +(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp));
}

function copyToClipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val($.trim($(element).text())).select();
  document.execCommand("copy");
  $temp.remove();
   
    $('.tpcpySell').html('Address Copied');
	
  setTimeout(function(){ $('.tpcpySell').html('Tap to copy'); }, 6000);
  
}


function addcomas(str){
	
	/*var amount 		= 	new String(str);
	
	amount 			= 	amount.split("").reverse();
	
	var output 		= 	"";
	
	for ( var i = 0; i <= amount.length-1; i++){
		
		output 		= amount[i] + output;
	
		if((i+1) % 3 == 0 && (amount.length-1) !== i)output = ',' + output;
	
	}
	
	return output;*/
	
	const options = { 
	  minimumFractionDigits: 2,
	  maximumFractionDigits: 2 
	};
	
	const formatted = Number(str).toLocaleString('en', options);
	
	return formatted;
	
}

function validate_inputed_number(){
	
	//remove lettes and commas
	var the_box_value 		= 	$(this).val().replace(/[^\d.]/g, '');
	
	$(this).val(the_box_value);
	
	//Remove double dots
	the_box_value 			= 	$(this).val();
	var occurances 			= 	occurrences(the_box_value, ".", "");
	var last_char 			= 	the_box_value.charAt( the_box_value.length-1 );
	
	if(last_char == "." && occurances > 1) {
		
		$(this).val( the_box_value.slice(0, the_box_value.length-1) );	
	
	}
}

function validate_inputed_number_paste(digitSupplied){
	
	//var digitSupplied 		= 	$('.phone_n_');
	 
	//remove lettes and commas
	var the_box_value 		= 	digitSupplied.val().replace(/[^\d.]/g, '');
	
	digitSupplied.val(the_box_value);
	
	//Remove double dots
	the_box_value 			= 	digitSupplied.val();
	
	var occurances 			= 	occurrences(the_box_value, ".", "");
	
	var last_char 			= 	the_box_value.charAt( the_box_value.length-1 );
	
	if(last_char == "." && occurances > 1) {
		
		digitSupplied.val( the_box_value.slice(0, the_box_value.length-1) );	
	
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

// delete message
function delete_message(){
	
	var id 			= 	$(this).attr('lang');
	
	var action 		= 	confirm('Are you sure you want to Delete This Message?');
	
	if(action){

		
		if(!wasSubmitted)  //this here is for checking if this approval button has been clicked previously
		{
			wasSubmitted = true;
			
			$(this).hide();
		
			$('.btn-loader-'+id).show();
		
			$.ajax({ 			 
				type: "POST",
				url:base_url+"user/delete-message",
				data: { "id" :id},
				cache: false,
				dataType: 'json',
				success: function (data) {
					
					if(data.status == "Please Login")
					{
						window.location 	= 	base_url+'user/';
					
					}
					else if(data.status == "Error")
					{
						alert(data.status);
						
						$('.btn-loader-'+id).hide();
						
						$(this).show();
						
					}
					else if(data.status == "Success")
					{
						alert(data.message);
						
						$('.btn-loader-'+id).hide();
												
						setTimeout(window.location 	= 	base_url+'user/messages/', 4000);

							
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
			url:base_url+"msme/get-country-state",
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
			url:base_url+"msme/get-state-lga", 
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
			url:base_url+"msme/get-country-state",
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
			url:base_url+"msme/get-state-lga", 
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