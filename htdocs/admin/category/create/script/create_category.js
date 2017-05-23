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
	
	$("#send").click(function()
	{			
		if(Validate() == false)
		{
			return;
		}
				
	})
		
	function Validate()
	{
		var value = true;
					 
		if($("#name").val().length  == 0)
		{
			$("#name_div").show("slow");
			value = false;
		}
		else
		{
			$("#name_div").hide();
					 	
			$.getJSON('../operation.php?operation=verify&name=' + $("#name").val(), function(data)
			{ 
				$("#duplicated_div").hide();
								
				if(data.status == 'free') 
				{
					var name = encodeURI($("#name").val());
					 
					var ajaxOpts = {
									 type: "get",
									 url: "../operation.php?operation=save",
									 data: "&name=" + name,
									 success: function(data) 
										      {
												location.href = "../list/index.php";
											  }
									};
											
					$.ajax(ajaxOpts);
				}
				else	
				{
					$("#duplicated_div").show("slow");
				}
			});
		 }
					
   		 return value;
	}						
});