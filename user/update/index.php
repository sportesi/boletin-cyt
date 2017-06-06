<?php 
	//Important need to be defined in the top page required pages
  	define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);
   
    require_once(__ROOT__.'/common/session/Session.php');
  	require_once(__ROOT__.'/common/DataAccess/DBSecurityConnections.php');
			
	//Check if the user is still login
	if($session->GetSessionValue('valid') != 'valid')
	{
		header("location:../../../login/index.php");
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html> 
	<head> 
		<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
		<?php
			//Get User to used in the title
			$title_description = ' - Usuario: ' . $session->GetSessionValue('login_user');
			echo '<title>EES - UAI - Actualizar Usuario ' . $title_description .'</title>';
		?>			
		<link rel="stylesheet" type="text/css" href="/style/css/general.css" media="screen"/>
		<script type="text/javascript" language="javascript" src="/scripts/jquery/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="/controls/menu/ddsmoothmenu.css" />
		<link rel="stylesheet" type="text/css" href="/controls/menu/ddsmoothmenu-v.css" />
		<link rel="stylesheet" type="text/css" href="/style/css/register.css">
		<script type="text/javascript" src="/controls/menu/ddsmoothmenu.js"></script> 
   		<script type="text/javascript">    
				ddsmoothmenu.init({
					mainmenuid: "smoothmenu-ajax",
					orientation: 'h',
					classname: 'ddsmoothmenu',
					contentsource: ["smoothmenu1", "/controls/menu/menu.php"],
					image: ['/controls/menu/down.gif','/controls/menu/down.gif']
				});
		</script> 
   		<script type="text/javascript">    
		    $(function()
		    {		 
		    	
		    	function Validate()
				{
					 var value = true;
					 
					 $("#firstname_div").hide();
					 $("#lastname_div").hide();
					 $("#done_div").hide();
					 
					 
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
				 	
					 var first_name = $("#first_name").val();
					 var last_name = $("#last_name").val();
					 var campus_id = $("#campus").val();
					 var turn_id = $("#turns").val();
					 var comission = $("#comission :selected").text();
					 var year = $("#year :selected").text();
					
					 var ajaxOpts = {
						 type: "get",
						 url: "/user/operation.php?operation=update",
						 data: "&first_name=" + first_name.replace(/<.*?>/g, '') + "&last_name=" + last_name.replace(/<.*?>/g, '') + "&campus_id=" + campus_id + "&turn_id=" + turn_id + "&comission=" + comission + "&year=" + year,
						 success: function(data) 
						 {
						 	$("#done_div").show("slow");
						 }
					 };
							
					 $.ajax(ajaxOpts);
						
					});
				 
				 
				var user_id = 0;
				<?php 
					
				 	echo 'var user_id =' . $session->GetSessionValue('user_id') . ';';
					if($session->GetSessionValue('permission') == 2)
					{
						echo '$("#schoolstudents_div_1").hide();';
						echo '$("#schoolstudents_div_2").hide();';
						echo '$("#schoolstudents_div_3").hide();';
						echo '$("#schoolstudents_div_4").hide();';
						echo '$("#schoolstudents_div_5").hide();';
						echo '$("#schoolstudents_div_6").hide();';
						echo '$("#schoolstudents_div_7").hide();';
						echo '$("#schoolstudents_div_8").hide();';
					}
				?>
				
				if(user_id > 0)
				{
					var userUrl = "/user/operation.php?operation=user&id=" + user_id;
					
					$.getJSON(userUrl, function(data) {
								
	                    for (var i = 0; i < data.length; i++) 
	                    {
	                    	 $("#first_name").val(data[i].firstname);
							 $("#last_name").val(data[i].lastname);
							 $("#campus").val(data[i].campus);
							 $("#turns").val(data[i].turn);
							 $("#comission").val(data[i].comission);
							 $("#year").val(data[i].year_coursed);
	                    }
		  			});	
				}
		    });
		   	    
		    
		  </script>
		 
    
	</head> 
	<body> 

	<div id="smoothmenu1" class="ddsmoothmenu"></div>
	<div>
	<br/>
	<center>
	<div style="width: 400px; text-align: left;" class="form">
	<h1>Actualizar Datos</h1>	
	<table style=" width: 400px;">
		<tr>
			<td>
				<label class="label">Nombre<span class="ErrorFont">*</span></label>
			</td>
		</tr>
		<tr>
			<td>
				<input id="first_name" type="text" class="textbox"/>
			</td>
		</tr>
		<tr>
			<td>
				<label class="label">Apellido<span class="ErrorFont">*</span></label>
			</td>
		</tr>
		<tr>
			<td>
				<input id="last_name" type="text" class="textbox"/>
			</td>
		</tr>
		<tr>
			<td>
				<div id="schoolstudents_div_1">
					<label class="label">Localización<span class="ErrorFont">*</span></label>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<div id="schoolstudents_div_2">
				<select id="campus" class="textbox"></select>
				</div>
			</td>
		</tr>				
		<tr>
			<td>
				<div id="schoolstudents_div_3">
				<label class="label">Turno<span class="ErrorFont">*</span></label>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<div>
					<div id="schoolstudents_div_4">
					<select id="turns" class="textbox"></select>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<div id="schoolstudents_div_5">
				<label class="label">Comisión<span class="ErrorFont">*</span></label>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<div id="schoolstudents_div_6">
					<select id="comission" class="textbox">
						<option>A</option>
						<option>B</option>
						<option>C</option>
						<option>D</option>
						<option>E</option>
						<option>F</option>
						<option>G</option>
						<option>H</option>
						<option>I</option>
						<option>J</option>
						<option>K</option>
					</select>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<div id="schoolstudents_div_7">
				<label class="label">Año<span class="ErrorFont">*</span></label>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<div id="schoolstudents_div_8">
					<select id="year" class="textbox">
						<option>4</option>
						<option>5</option>
					</select>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<div id="summary" style="text-align: left;">
					<div id="firstname_div" style="display:none;text-align: left;"><span class="ErrorFont">- Escriba el Nombre.</span></div>
					<div id="lastname_div" style="display:none;text-align: left;"><span class="ErrorFont">- Escriba el Apellido.</span></div>
					<div id="done_div" style="display:none;text-align: left;" class="ConfirmationDialog"> <strong>La actualizaión se realizo satisfactoriamente</strong></div>
 				</div>
				<div style="float: right;"><input id="send" type="button" value="Guardar" class="GeneralButtons" style="width: 120px;"/></div>
				<div style="float:left; text-align: left;"><span class="ErrorFont">* Campos requeridos.</span></div>
			</td>
		</tr>						
	</table>
		
	</div>
	
	</center>
	
	<script type="text/javascript">

			  var _gaq = _gaq || [];
			  _gaq.push(['_setAccount', 'UA-10081016-2']);
			  _gaq.push(['_trackPageview']);
			
			  (function() {
			    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			  })();
		
	</script>
	</body> 
</html>