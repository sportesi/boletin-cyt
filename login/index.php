<?php
	header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
	
	//Important need to be defined in the top page required pages
  	define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);
   
    require_once(__ROOT__.'/common/session/Session.php');
		
	//Check if the user is still login
	if($session->GetSessionValue('valid') == 'valid')
	{
		header("location:../");
	}	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html> 
	<head> 
		<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
	
		<title>EES - UAI - Ingresar</title> 		
		<script type="text/javascript" language="JavaScript" src="/scripts/jquery/jquery.min.js"></script>
		<script type="text/javascript" language="JavaScript" src="/controls/menu/ddsmoothmenu.js"></script>
		<script type="text/javascript" language="JavaScript" src="/login/script/login.js"></script>
		<link rel="stylesheet" type="text/css" href="/style/css/login.css" />
		<link rel="stylesheet" type="text/css" href="/style/css/general.css" media="screen"/>
		<link rel="stylesheet" type="text/css" href="/controls/menu/ddsmoothmenu.css" />
		<link rel="stylesheet" type="text/css" href="/controls/menu/ddsmoothmenu-v.css" />
		 
	</head> 
	<body>
	<div id="smoothmenu1" class="ddsmoothmenu"></div>
	<br/>
	
	<center>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<div style=" width: 300px;" class="form">
		<h1>Login</h1>
		<div style=" text-align: left">
					<table>
						<tr>
							<td>
								<label class="label">Email<span class="ErrorFont">*</span></label>
							</td>
						</tr>
						<tr>
							<td>
								<div><input id="email" type="text" class="textbox" autocomplete="on"/></div>
							</td>
						</tr>
						<tr>
							<td>
								<label class="label">Password<span class="ErrorFont">*</span></label>
							</td>
						</tr>
						<tr>
							<td>
								<div><input id="password" type="password" class="textbox" autocomplete="on" /></div>
							</td>
						</tr>
						<tr>
							<td>
								<div style="width: 300px;" >					
									<div id="summary" style="width: 300px; text-align: left;">
												<div id="username" style="display:none; text-align: left;"><span class="ErrorFont">- Escriba una dirección de correo electrónico.</span></div>
												<div id="password_div" style="display:none;text-align: left;"><span class="ErrorFont">- Escriba el password.</span></div>
												<div id="dosentExist" style="display:none;text-align: left;" ><span class="ErrorFont">- La dirección de correo electrónico o contraseña es incorrectas.</span></div>
												<div id="notVerified" style="display:none;text-align: left;"><span class="ErrorFont">- El usuario no ha sido verificado por un docente.</span></div>
									</div>
								</div>	
								<div style="float:right;"><input id="send" type="button" value="Ingresar" class="GeneralButtons" /></div>
							</td>
						</tr>		
					</table>
			
					<br/>
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