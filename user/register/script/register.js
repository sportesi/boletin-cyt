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
		 
		 if($("#first_name").val().length  == 0)
		 {
		 	$("#firstname_div").show("slow");
	 		value = false;
		 }
		 else
		 {
		 	$("#firstname_div").hide();
		 }
		 
		 if($("#last_name").val().length  == 0)
		 {
		 	$("#lastname_div").show("slow");
	 		value = false;
		 }
		 else
		 {
		 	$("#lastname_div").hide();
		 }
		 
		 if($("#email").val().length == 0)  
		 {
		 	$("#email_div").show("slow");
	 		value = false;
		 }
		 else	
		 {
		 	$("#email_div").hide();
		 	var email = $("#email").val();
		 
		 	var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
		 	if(emailPattern.test(email) == false)
		 	{
		 		$("#valid_email").show("slow");
		 		value = false;
		 	}
		 	else
		 	{
		 		$("#valid_email").hide();
		 	}
		 }
		 
		 return value;
	}

	$.getJSON("/content/content.php?operation=campus", function(data) {
				
	    var options = '';
         for (var i = 0; i < data.length; i++) 
         {
             options += '<option value="' + data[i].id +  '">' + data[i].name + '</option>';
         }
   
         $("#campus").html(options);					
	});	
	
	$.getJSON("/content/content.php?operation=turn", function(data) {
				
	    var options = '';
         for (var i = 0; i < data.length; i++) 
         {
             options += '<option value="' + data[i].id +  '">' + data[i].name + '</option>';
         }
         
         $("#turns").html(options);					
	});	

	 $("#send").click(function(){
	 	
	 	if(Validate() == false)
	 	{
	 		return;
	 	}
	 
		 var first_name = encodeURI($("#first_name").val());
		 var last_name = encodeURI($("#last_name").val());
		 var email = encodeURI($("#email").val());
		 var campus_id = encodeURI($("#campus").val());
		 var turn_id = encodeURI($("#turns").val());
		 var comission = encodeURI($("#comission :selected").text());
		 var year = encodeURI($("#year :selected").text());
		
		$.getJSON('/user/operation.php?operation=verify&email=' + email, function(data){ // grab content from another page
			
			$("#exist_user_div").hide();
			$("#done_div").hide();
			
			if(data.status == 'free') 
			{
				var ajaxOpts = {
					type: "get",
					url: "/user/operation.php?operation=save",
					data: "&first_name=" + first_name.replace(/<.*?>/g, '') + "&last_name=" + last_name.replace(/<.*?>/g, '') + "&email=" + email.toLowerCase() + "&campus_id=" + campus_id + "&turn_id=" + turn_id + "&comission=" + comission + "&year=" + year,
					success: function(data) {
						$("#done_div").show("slow");
					}
				};
				
				$.ajax(ajaxOpts);
			}
			else	
			{
				$("#exist_user_div").show("slow");
			}
		});
	 })
 });