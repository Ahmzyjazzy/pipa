var base_url = "http://localhost/1community/";
//var base_url = "https://www.aeriksftsolutions.com/1community/";
//var base_url = "https://www.1community.africa/";

var wasSubmitted = false;

$(function () {
    'use strict';
	
	//alert('hello world');
	
	$(".phone_n_").keyup(validate_inputed_number);
	
	$('.sltn-img-click').click(function(){
		
		var id	=	$(this).attr('lang');
		
		$('.sltn-img-overall').hide();
		
		$('.homesoltnlst').hide();
		
		$('.homesoltn-ten-'+id).slideDown('slow');
			
	});
	
	$('.sltn-bck').click(function(){
		
		$('.homesoltnlst').hide();
		$('.sltn-img-overall').slideDown('slow');
		
	});
	
	new WOW().init();
	
	/*var o = $('html');
			
	if ((navigator.userAgent.toLowerCase().indexOf('msie') == -1 ) || (isIE() && isIE() > 9)) {
		if (o.hasClass('desktop')) {
			//include('<?php echo base_url(); ?>asset/js/wow.js');
			
			
		}
	}*/
	
	
	
	 //Recall Form Submit/Validation
    //--------------------------------------------------------
    var emailerrorvalidation 	= 	0;
    var formObj 				= 	$('#recall');
    var recallFormObj 			= 	$('#submit-recall-form');
    var nameFieldObj 			= 	$("#name");
    var vinFieldObj 			= 	$("#vin");
    var emailFieldObj 			= 	$("#email");
    var phoneFieldObj 			= 	$("#phone");
    var stateFieldObj 			= 	$("#state");
	var areaFieldObj 			= 	$("#area");
    var successObj 				= 	$('#success');
    var errorObj 				= 	$('#error');

    recallFormObj.on('click', function () {
		
        var emailaddress = emailFieldObj.val();
        
		function validateEmail(emailaddress) {
            
			var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
            
			if (filter.test(emailaddress)) {
                
				return true;
				
            } else {
				
                return false;
            
			}
        }

        var datax = {
			
            name: nameFieldObj.val(),
            vin: vinFieldObj.val(),
            email: emailFieldObj.val(),
            phone: phoneFieldObj.val(),
            state: stateFieldObj.val(),
			area: areaFieldObj.val()
        };
        
		if (datax.name === '' || datax.vin === '' || datax.email === '' || datax.phone === '' || datax.state === '') {
			
            alert("All fields are mandatory");
        
		} else {
        
		    if (validateEmail(emailaddress)) {
                
				
				/*if (emailerrorvalidation === 1) {
                
				    alert('Nice! your Email is valid, you can proceed now.');
                
				}*/
                
				emailerrorvalidation = 0;
                
				if(vinFieldObj.val().length < 17)
				{
					
					alert('Oops! Vin must be 17 Characters Long');
					
				}else if(vinFieldObj.val().length > 17)
				{
					
					alert('Oops! Vin can only be 17 Characters Long');
					
				}else{
					
					$.ajax({
						type: "POST",
						url: base_url+"pages/recall-form",
						data: datax,
						cache: false,
						dataType: 'json',
						success: function (data) {
	
							if(data.status == 'Success')
							{
								
								successObj.fadeIn(1000);
								successObj.fadeOut(8000);
								formObj[0].reset();
								
							}else{
											
								alert(data.status);
								errorObj.fadeIn(1000);
								errorObj.fadeOut(8000);
							}
							
						},
						error: function () {
							
							errorObj.fadeIn(1000);
							errorObj.fadeOut(8000);
							
						}
					});
				
				}
            
			} else {
				
                emailerrorvalidation 	= 	1;
            
			    alert('Oops! Invalid Email Address');
            
			}
        }
        return false;
    });
	
	//Contact Form Submit/Validation
    //--------------------------------------------------------
    var emailerrorvalidation 	= 	0;
    var formBrochureObj 		= 	$('#brochure');
    var brochureFormObj 		= 	$('#dwnl-brochure');
    var brochNameFieldObj 		= 	$("#name");
	var brochProdFieldObj 		= 	$("#product");
    var brochEmailFieldObj 		= 	$("#email");
    var brochPhoneFieldObj 		= 	$("#phone");
    var successObj 				= 	$('#success');
    var errorObj 				= 	$('#error');


    brochureFormObj.on('click', function () {
		
        var emailaddress 		= 	brochEmailFieldObj.val();
        
		function validateEmail(emailaddress) {
            
			var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
            
			if (filter.test(emailaddress)) {
                
				return true;
				
            } else {
				
                return false;
            
			}
        }

        var datax = {
			
            name: 		brochNameFieldObj.val(),
			product: 	brochProdFieldObj.val(),
            email: 		brochEmailFieldObj.val(),
            phone: 		brochPhoneFieldObj.val()
			
        };
        
		
		if (datax.name === '' || datax.email === '' || datax.phone === '') {
			
            alert("All fields are mandatory");
        
		} else {
        
		    if (validateEmail(emailaddress)) {
                
				/*if (emailerrorvalidation === 1) {
                
				    alert('Nice! your Email is valid, you can proceed now.');
                
				}*/
                
				emailerrorvalidation = 0;
                
				$.ajax({
                    type: "POST",
                    url: base_url+"pages/download-product-brochure",
                    data: datax,
                    cache: false,
					dataType: 'json',
                    success: function (data) {

						
						if(data.status == 'Success')
						{
							
							//successObj.fadeIn(1000);
                        	formBrochureObj[0].reset();
							window.location		=	base_url+'download/dlbrochure/'+datax.product+'/'+data.filename;
							
						}else{
										
							alert(data.status);
							errorObj.fadeIn(1000);
							errorObj.fadeOut(8000);
						}
						
                    },
                    error: function () {
						
                        errorObj.fadeIn(1000);
						errorObj.fadeOut(8000);
						
                    }
                });
            
			} else {
				
                emailerrorvalidation 	= 	1;
            
			    alert('Oops! Invalid Email Address');
            
			}
        }
        return false;
    });
	
	//Book test drive Form Submit/Validation
    //--------------------------------------------------------
    var emailerrorvalidation 		= 	0;
    var formBookTestDriveObj 		= 	$('#book-test-drive');
    var bookTestDriveFormObj 		= 	$('#book-test-btn');
    var bookTestNameFieldObj 		= 	$("#name");
	var bookTestProdFieldObj 		= 	$("#product");
    var bookTestEmailFieldObj 		= 	$("#email");
    var bookTestPhoneFieldObj 		= 	$("#phone");
    var successObj 					= 	$('#success');
    var errorObj 					= 	$('#error');


    bookTestDriveFormObj.on('click', function () {
		
		$('#book-test-btn').hide();
		
		$('.btn-loader').show();
		
        var emailaddress 		= 	bookTestEmailFieldObj.val();
        
		function validateEmail(emailaddress) {
            
			var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
            
			if (filter.test(emailaddress)) {
                
				return true;
				
            } else {
				
                return false;
            
			}
        }

        var datax = {
			
            name: 		bookTestNameFieldObj.val(),
			product: 	bookTestProdFieldObj.val(),
            email: 		bookTestEmailFieldObj.val(),
            phone: 		bookTestPhoneFieldObj.val()
			
        };
        
		
		if (datax.name === '' || datax.email === '' || datax.phone === '' || datax.product === 0) {
			
            alert("All fields are mandatory");
			
			$('#book-test-btn').show();
		
			$('.btn-loader').hide();
        
		} else {
        
		    if (validateEmail(emailaddress)) {
                
				/*if (emailerrorvalidation === 1) {
                
				    alert('Nice! your Email is valid, you can proceed now.');
                
				}*/
                
				emailerrorvalidation = 0;
                
				$.ajax({
                    type: "POST",
                    url: base_url+"pages/process-book-test-drive/",
                    data: datax,
                    cache: false,
					dataType: 'json',
                    success: function (data) {

						
						if(data.status == 'Success')
						{
							
							$('#book-test-btn').show();
		
							$('.btn-loader').hide();
						
							successObj.fadeIn(1000);
							successObj.fadeOut(8000);
                        	formBookTestDriveObj[0].reset();
							
						}else{
										
							alert(data.status);
							
							$('#book-test-btn').show();
		
							$('.btn-loader').hide();
						
							errorObj.fadeIn(1000);
						
							errorObj.fadeOut(8000);
						
						}
												
                    },
                    error: function () {
						
						
						$('#book-test-btn').show();
		
						$('.btn-loader').hide();
						
                        errorObj.fadeIn(1000);
						
						errorObj.fadeOut(8000);
						
                    }
                });
            
			} else {
				
                emailerrorvalidation 	= 	1;
            
			    alert('Oops! Invalid Email Address');
				
				$('#book-test-btn').show();
		
				$('.btn-loader').hide();
            
			}
        }
        return false;
    });
		
});


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

function checkBeforeSubmit(){
  
  if(!wasSubmitted) {
	
	wasSubmitted = true;
	
	return wasSubmitted;
  
  }
  
  return false;
  
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
};
