<?php
	//Important need to be defined in the top page required pages
  	define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);
   
    require_once(__ROOT__.'/common/session/Session.php');
  	require_once(__ROOT__.'/common/DataAccess/DBSecurityConnections.php');
	
?>	

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html> 
	<head> 
		<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
		<?php
			//Get User to used in the title
			$title_description = '';
			$user_name =  $session->GetSessionValue('login_user');
			
			if($user_name != '') 
			{
				$title_description = ' - Usuario: ' . $user_name;
			}
			echo '<title>EES - UAI - Registro de Usuario ' . $title_description .'</title>';
		?>		
			
		
		<script type="text/javascript" language="JavaScript" src="/scripts/jquery/jquery.min.js"></script>
		<script type="text/javascript" language="JavaScript" src="/controls/menu/ddsmoothmenu.js"></script>
		<script type="text/javascript" language="JavaScript" src="/user/register/script/register.js"></script> 
		<link rel="stylesheet" type="text/css" href="/style/css/general.css" media="screen"/>
		<link rel="stylesheet" type="text/css" href="/controls/menu/ddsmoothmenu.css" />
		<link rel="stylesheet" type="text/css" href="/controls/menu/ddsmoothmenu-v.css" />
		<link rel="stylesheet" type="text/css" href="/style/css/register.css" />
		    
	</head> 
	<body> 

	<div id="smoothmenu1" class="ddsmoothmenu"></div>
	<br/>
	
	<center>
		<div style=" width: 400px; text-align: left;" class="form">
			<h1>Registrarse</h1>
			<table width="400px">
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
						<label class="label">Email<span class="ErrorFont">*</span></label>
					</td>
				</tr>
				<tr>
					<td>
						<input id="email" type="text" class="textbox"/>
					</td>
				</tr>
				<tr>
					<td>
						<label class="label">Localización<span class="ErrorFont">*</span></label>
					</td>
				</tr>
				<tr>
					<td>
					    <select id="campus" class="textbox"></select>
					</td>
				</tr>
				<tr>
					<td>
						<label class="label">Turno<span class="ErrorFont">*</span></label>
					</td>
				</tr>
				<tr>
					<td>
						<select id="turns" class="textbox"></select>
					</td>
				</tr>
				<tr>
					<td>
						<label class="label">Comisión<span class="ErrorFont">*</span></label>
					</td>
				</tr>
				<tr>
					<td>
						<div>
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
						<label class="label">Año<span class="ErrorFont">*</span></label>
					</td>
				</tr>
				<tr>
					<td>
						<div>
							<select id="year" class="textbox">
								<option>1</option>
								<option>2</option>
								<option>3</option>
								<option>4</option>
								<option>5</option>
							</select>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div>
							<div id="summary" style="width: 300px; text-align: left;">
							<div id="email_div" style="display:none;text-align: left;"><span class="ErrorFont">- Escriba una dirección de correo electrónico.</span></div>
							<div id="firstname_div" style="display:none;text-align: left;"><span class="ErrorFont">- Escriba el Nombre.</span></div>
							<div id="lastname_div" style="display:none;text-align: left;"><span class="ErrorFont">- Escriba el Apellido.</span></div>
							<div id="valid_email" style="display:none;text-align: left;"><span class="ErrorFont">- La dirección de correo electrónico no es una dirección valida. Ej: nombre@seridor.com</span></div>
							<div id="exist_user_div" style="display:none;text-align: left;"><span class="ErrorFont">- La dirección de correo electrónico se encuentra ocupada por otro alumno.</span></div>
							<div id="done_div" style="display:none;text-align: left;" class="ConfirmationDialog"> <strong>La registración se realizo satisfactoriamente</strong>, para acceder al sistema debe hacerlo con el <span class="ErrorFont"><strong>email y el password por defecto 123456</strong></span> al ingresar por primera vez se le pedira que cambie la clave de registro.</div>
 						</div>
							<div style="float: right;"><input id="send" type="button" value="Enviar Solicitud" class="GeneralButtons" style="width: 120px;"/></div> 
							<br/>
							<div style="float:left; text-align: left;" style="height: 400px"><span class="ErrorFont">* Campos requeridos.</span></div>
						</div>
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