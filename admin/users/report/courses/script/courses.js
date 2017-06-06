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
			
	$("#year").val(getParameterByName("year"));
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
	
	var oTable = $('#example').dataTable({ "bSort": true, "sPaginationType": "full_numbers" });
		
});
			
function Search()
{
	var year = $("#year :selected").text();
	var cuatrimestre = $("#cuatrimestre :selected").text();
		
	location.href = "index.php?year=" + year + "&cuatrimestre=" + cuatrimestre;
}	

