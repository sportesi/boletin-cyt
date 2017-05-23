<?php 
	//Important need to be defined in the top page required pages
  	define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);
   
    require_once(__ROOT__.'/common/session/Session.php');
  	require_once(__ROOT__.'/common/dataAccess/DBSecurityConnections.php');
		
	//Check if the user is still login
	if($session->GetSessionValue('valid') != 'valid')
	{
		header("location:../../../login/index.php");
	}
	
	if($session->GetSessionValue('permission') < 2)
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
			echo '<title>EES - UAI - Crear Categoría ' . $title_description .'</title>';
		?>
		<script type="text/javascript" language="JavaScript" src="/scripts/jquery/jquery.min.js"></script>
		<script type="text/javascript" src="/controls/menu/ddsmoothmenu.js"></script> 
		<script type="text/javascript" language="JavaScript" src="/admin/category/create/script/create_category.js"></script> 
		<link rel="stylesheet" type="text/css" href="/style/css/general.css" media="screen"/>
		<link rel="stylesheet" type="text/css" href="/controls/menu/ddsmoothmenu.css" />
		<link rel="stylesheet" type="text/css" href="/controls/menu/ddsmoothmenu-v.css" />
		<link rel="stylesheet" type="text/css" href="/style/css/category.css" />
	</head> 
	<body> 

	<div id="smoothmenu1" class="ddsmoothmenu"></div>
	<br/>
	<center>
	<div style="width: 600px; text-align: left;" class="form">
		<h1>Crear Categoría</h1>	
		<table style="width: 600px;">
			<tr>
				<td>
					<label class="label">Nombre<span class="ErrorFont">*</span></label>
				</td>
			</tr>
			<tr>
				<td>
					<input id="name" type="text" class="textbox"/>
				</td>
			</tr>
			<tr>
				<td>
					<div id="name_div" style="display:none; position: relative;text-align: left;"><span class="ErrorFont">*    El nombre de la categoría es requerido.</span></div>
				</td>
			</tr>
			<tr>
				<td>
					<div id="duplicated_div" style="display:none; position: relative;text-align: left;"><span class="ErrorFont">*    El nombre de la categoría ya se encuentra registado.</span></div>
				</td>
			</tr>
			<tr>
				<td>
					<div style="float:left;"><span class="ErrorFont">* Campos requeridos.</span></div>
					<div style="float:right;"><input id="send" type="button" value="Guardar" class="GeneralButtons" style="width: 120px;"/></div>					
				</td>
			</tr>
			
		</table>	
		
		<br/>
		<div style="text-align: left;">
			
			<span class="ErrorFont"> Una vez creada la categoria debe habilitarla, sino no podra ser utilizada.</span>
			
		</div>
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