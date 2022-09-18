// JavaScript Document
$(init);
function init(){
	var dataString = 'lod=';
 $.ajax({ 
		type:"POST", 
		url:"includes/tt.php",
		data: dataString,
		cache: false, 
		success:function(data){
		$('head').append(data);

		},
		error:function(data){
		}
	 });	
}