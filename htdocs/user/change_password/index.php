<?php
	//Important need to be defined in the top page required pages
  	define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);
   
    require_once(__ROOT__.'/common/session/Session.php');
  	require_once(__ROOT__.'/common/dataAccess/DBSecurityConnections.php');
		
	//Check if the user is still login
	if($session->GetSessionValue('valid') != 'valid')
	{
		header("location:../../");
	}
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html> 
	<head> 
		<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
		<?php
			//Get User to used in the title
			$title_description = ' - Usuario: ' . $session->GetSessionValue('login_user');
			echo '<title>EES - UAI - Cambiar Password ' . $title_description .'</title>';
		?>				
		<script type="text/javascript" language="JavaScript" src="/scripts/jquery/jquery.min.js"></script>
		<script type="text/javascript" language="JavaScript" src="/controls/menu/ddsmoothmenu.js"></script>
		<script type="text/javascript" language="JavaScript" src="/user/change_password/script/change_password.js"></script>
		<link rel="stylesheet" type="text/css" href="/style/css/general.css" media="screen"/>
		<link rel="stylesheet" type="text/css" href="/style/css/change_password.css" />
		<link rel="stylesheet" type="text/css" href="/controls/menu/ddsmoothmenu.css" />
		<link rel="stylesheet" type="text/css" href="/controls/menu/ddsmoothmenu-v.css" />
		    
	</head> 
	<body> 	
	<div id="smoothmenu1" class="ddsmoothmenu"></div>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<center>
	<div style=" width: 300px;" class="form">
		<h1>Cambiar Clave de Ingreso</h1>
			<center>
				<div style=" text-align: left">
					<table>
						<tr>
							<td>
								<label class="label">Clave Actual<span class="ErrorFont">*</span></label>
							</td>
						</tr>
						<tr>
							<td>
								<input id="prev_password" type="text" class="textbox" />
							</td>
						</tr>
						<tr>
							<td>
								<label class="label">Nueva Clave<span class="ErrorFont">*</span></label>
							</td> 
						</tr>
						<tr>
							<td>
								<input id="password" type="password" class="textbox" />
							</td>
						</tr>
						<tr>
							<td>
							<div id="summary" style="width: 300px; text-align: left;">
								<div id="prev_password_div" style="display:none;text-align: left;"><span class="ErrorFont">- Escriba la clave actual.</span></div>
								<div id="password_div" style="display:none;text-align: left;"><span class="ErrorFont">- Escriba la nueva clave.</span></div>
								<div id="done_div" style="display:none;text-align: left;"> <strong> La clave ha sido cambiada satisfactoriamente.</strong></div>
 			    			</div>
								<div style="float:right;width: 200px; text-align: right;"><input id="send" type="button" value="Guardar" class="GeneralButtons" style="width: 120px;"/></div>
								<div style="float:left;text-align: left;" ><span class="ErrorFont">* Campos requeridos.</span></div>
							</td>
						</tr>
					</table>
					

			</center>
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