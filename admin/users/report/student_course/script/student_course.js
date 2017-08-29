/**
 * @author Joaquin
 */


$(document).ready(function() 
{
	ddsmoothmenu.init({
		mainmenuid: "smoothmenu-ajax",
		orientation: 'h',
		classname: 'ddsmoothmenu',
		contentsource: ["smoothmenu1", "/controls/menu/menu.php"],
		image: ['/controls/menu/down.gif','/controls/menu/down.gif']
	});

			
	$.getJSON("/content/content.php?operation=campus", function(data) {
				
	    var options = '';
        for (var i = 0; i < data.length; i++) 
        {
            options += '<option value="' + data[i].id +  '">' + data[i].name + '</option>';
        }
  
        $("#campus").html(options);		
       
		$("#campus").val(getParameterByName("campus"));			
	});	
	
	$.getJSON("/content/content.php?operation=turn", function(data) {
				
	    var options = '';
        for (var i = 0; i < data.length; i++) 
        {
            options += '<option value="' + data[i].id +  '">' + data[i].name + '</option>';
        }
        
        $("#turns").html(options);
        $("#turns").val(getParameterByName("turn"));					
	});	

	$("#year").val(getParameterByName("year"));
	$("#year_coursed").val(getParameterByName("year_coursed"));
	$("#comission").val(getParameterByName("comission"));
	$("#cuatrimestre").val(getParameterByName("cuatrimestre"));
	
	
	
	function getParameterByName(name)
	{
	  name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
	  var regexS = "[\\?&]" + name + "=([^&#]*)";
	  var regex = new RegExp(regexS);
	  var results = regex.exec(window.location.href);
	  if(results == null)
	    return "";
	  else
	    return decodeURIComponent(results[1].replace(/\+/g, " "));
	}
	
	var oTable = $('#example').dataTable({ "bSort": true, "sPaginationType": "full_numbers","bPaginate": false,"bLengthChange": false });	
	
});

	function Delete(user_id)
	{
			var url = "/admin/users/validate/validate.php?operation=delete&user_id=" + user_id;
			
			var value = confirm("¿Esta seguro que desea eliminar el alumno?");
			if(value == true)
			{
				$.getJSON(url, function(data) {
	            	
	            	if(data.successful == 'true')
	            	{
	                	var campus = $("#campus").val();
						var turn = $("#turns").val();
						var year = $("#year :selected").text();
						var comission = $("#comission :selected").text();
						var cuatrimestre = $("#cuatrimestre :selected").text();
						var year_coursed = $("#year_coursed :selected").text();
			
						location.href = "index.php?campus=" + campus + "&turn=" + turn + "&year=" + year + "&comission=" + comission + "&cuatrimestre=" + cuatrimestre + "&year_coursed=" + year_coursed;
					}				
				});
				
				var button = document.getElementById("button__" + user_id);
	    		button.style.display = 'none';
			}		
	}
		
	function Reset(user_id)
	{
			var url = "/admin/users/validate/validate.php?operation=reset&user_id=" + user_id;
			
			var value = confirm("¿Esta seguro que desea resetear la clave?");
			if(value == true)
			{
				$.getJSON(url, function(data) {
	            	
	            	if(data.successful == 'true')
	            	{
	                	var campus = $("#campus").val();
						var turn = $("#turns").val();
						var year = $("#year :selected").text();
						var comission = $("#comission :selected").text();
						var cuatrimestre = $("#cuatrimestre :selected").text();
						var year_coursed = $("#year_coursed :selected").text();
			
						location.href = "index.php?campus=" + campus + "&turn=" + turn + "&year=" + year + "&comission=" + comission + "&cuatrimestre=" + cuatrimestre + "&year_coursed=" + year_coursed;
					}				
				});
				
				var button = document.getElementById("button_reset_" + user_id);
	    		button.style.display = 'none';
			}		
	}
	
	function Search()
	{
		var campus = $("#campus").val();
		var turn = $("#turns").val();
		var year = $("#year :selected").text();
		var comission = $("#comission :selected").text();
		var cuatrimestre = $("#cuatrimestre :selected").text();
		var year_coursed = $("#year_coursed :selected").text();
		
		location.href = "index.php?campus=" + campus + "&turn=" + turn + "&year=" + year + "&comission=" + comission + "&cuatrimestre=" + cuatrimestre + "&year_coursed=" + year_coursed;
	}
		
