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
			 
			 if($("#prev_password").val().length  == 0)
			 {
			 	$("#prev_password_div").show("slow");
		 		value = false;
			 }
			 else
			 {
			 	$("#prev_password_div").hide();
			 }
			 
			 if($("#password").val().length  == 0)
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
		
		var prev_password = $("#prev_password").val();
		var mypassword = $("#password").val();
		
		var ajaxOpts = {
			type: "GET",
			dataType: 'json',
			url: "/user/operation.php?operation=password",
			data: "&prev_password=" + prev_password + "&password=" + mypassword,
			success: function(data) {				

				if(data.successful == 'true')
				{
					location.href = "/";							 	 
				}
		    }
        };
				
    	$.ajax(ajaxOpts);
	 });
	 
	 
	 $("#prev_password").keyup(function(event){
		CallToSaveButton(); 
	 });

	 $("#password").keyup(function(event){
		CallToSaveButton();
	 });
	 
	 
	function CallToSaveButton()
	{
		var prevPassword = $("#prev_password").val();
		var password = $("#password").val();

		if(prevPassword.length > 0 || password.length > 0) 
		{
			 if(event.keyCode == 13){
					$("#send").click();
				}
		}   
	}

});