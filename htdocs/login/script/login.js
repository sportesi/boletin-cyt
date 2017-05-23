/**
 * @author Joaquin
 */

 $(function(){		 

	ddsmoothmenu.init({
		mainmenuid: "smoothmenu-ajax",
		orientation: 'h',
		classname: 'ddsmoothmenu',
		contentsource: ["smoothmenu1", "/controls/menu/menu.php"],
		image: ['/controls/menu/down.gif','/controls/menu/down.gif']
	});
				 
 function Validate()
 {
 	var value = true;
 
 	if($("#email").val().length == 0)
 	{
 		$("#username").show("slow");
 		value = false;
 	}
 	else
 	{
 		$("#username").hide();
 	}
 	
 	if($("#password").val().length == 0)
 	{
 		$("#password_div").show("slow");
 		value = false;
 	}
 	else	
 	{
 		$("#password_div").hide();
 	}	
 	
 	return value;	
 } 
 
 $("#send").click(function(){ 
 	
 	if(Validate() == false)
 	{
 		return;
 	}
 	
	var myusername = $("#email").val();
	var mypassword = $("#password").val();
	
	var ajaxOpts = {
		type: "GET",
		dataType: 'json',
		url: "operation.php?operation=login",
		data: "&myusername=" + myusername.toLowerCase() + "&mypassword=" + mypassword.toLowerCase(),
		success: function(data) 
		{			
			if(data.status == 'valid')
			{
				location.href = "/";							 	 
			}
			
			if(data.status == 'change_password')
			{
				location.href = "../user/change_password/index.php";
			}
			
			if(data.status =='not_verified')
			{
				$("#notVerified").show("slow");
			}
			else	
			{
				$("#notVerified").hide();
			}
			
			if(data.status == 'unregister')
			{
				$("#dosentExist").show("slow");
			}
			else
			{
				$("#dosentExist").hide();
			}
			
	    }
    };
			
	$.ajax(ajaxOpts);
 })

 $("#email").keyup(function(event){
    CallToSendButton(); 
 });

 $("#password").keyup(function(event){
    CallToSendButton();
 });

 function CallToSendButton()
 {
	var myusername = $("#email").val();
	var mypassword = $("#password").val();

	if(myusername.length > 0 || mypassword.length > 0) 
	{
		 if(event.keyCode == 13){
		        $("#send").click();
		    }
	}   
 }
 
});