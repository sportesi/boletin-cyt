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
		<meta http-equiv="X-UA-Compatible" content="IE=8"/> 
		<meta name="description" content="Electromagnetismo y Estado Solido Universidad Abierta Internacional, EES UAI Joaquin Abraham Wessolowski, oftware, Seguridad Informatica, Salud , Robótica e Inteligenia Artificial,Politicas y Ética, Periféricos y Auxiliares, Otros, Nanotecnologia, Matematica y Lógica, IT & Infraestuctura Informatica, Fuentes RRS varias, Fisica y Quimica, Comunicaciones, Computación Cuantica, Circuitos Integrados, Almacenamiento y Memorias "/> 
		<meta name="keywords" content="Software, Seguridad Informatica, Salud , Robótica e Inteligenia Artificial,Politicas y Ética, Periféricos y Auxiliares, Otros, Nanotecnologia, Matematica y Lógica, IT & Infraestuctura Informatica, Fuentes RRS varias, Fisica y Quimica, Comunicaciones, Computación Cuantica, Circuitos Integrados, Almacenamiento y Memorias "/> 

		<?php
			//Get User to used in the title
			$title_description = '';
			$user_name =  $session->GetSessionValue('login_user');
			
			if($user_name != '') 
			{
				$title_description = ' - Usuario: ' . $user_name;
			}
			echo '<title>EES - UAI - BOLETIN ' . $title_description .'</title>';
		?>
		
		<script type="text/javascript" language="JavaScript" src="scripts/jquery/jquery.min.js"></script> 
		<script type="text/javascript" language="JavaScript" src="controls/menu/ddsmoothmenu.js"></script>
		<script type="text/javascript" language="JavaScript" src="/scripts/home/home.js"></script>
		<link rel="stylesheet" type="text/css" href="style/css/general.css" media="screen"/>
		<link rel="stylesheet" type="text/css" href="controls/menu/ddsmoothmenu.css" />
		<link rel="stylesheet" type="text/css" href="controls/menu/ddsmoothmenu-v.css" />
		<link rel="stylesheet" type="text/css" href="controls/categories/css/categories.css" />
	
	</head> 
	<body> 
		<div style="position:relative;">
			<div id="smoothmenu1" class="ddsmoothmenu">
			</div>
		</div>
		
		<center>
			<div>
						<table>
							<tr valign="top">
								<td style="width:720px; text-align: left;">
									<h1>BOLETÍN CIENTÍFICIO - TECNOLÓGICO</h1>
									<div id="news" style="width:705px;">						
									</div>
									</td>
								<td style="vertical-align: top; text-align: left;">
									<img src="/style/images/uai-logo.gif" id="Logo UAI" /><br />
									<img src="/style/images/home_boleting.jpg" id="boleting" /><br />
									<div><h2><strong>Categorias</strong></h2></div>
									<div id="categories"></div>
									<br/>
									<!-- Place this tag where you want the +1 button to render -->
									<g:plusone></g:plusone>
									
									<!-- Place this tag after the last plusone tag -->
									<script type="text/javascript">
									  window.___gcfg = {lang: 'es-419'};
									
									  (function() {
									    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
									    po.src = 'https://apis.google.com/js/plusone.js';
									    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
									  })();
									</script>
									
									<br/>
									<div id="fb-root"></div>
									<script>(function(d, s, id) {
									  var js, fjs = d.getElementsByTagName(s)[0];
									  if (d.getElementById(id)) {return;}
									  js = d.createElement(s); js.id = id;
									  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
									  fjs.parentNode.insertBefore(js, fjs);
									}(document, 'script', 'facebook-jssdk'));</script>
									
									<div class="fb-like" data-href="http://www.ees-uai.com.ar/" data-send="true" data-layout="box_count" data-width="200px" data-show-faces="true"></div>
									<div id="fb-root"></div>
									<script>(function(d, s, id) {
									  var js, fjs = d.getElementsByTagName(s)[0];
									  if (d.getElementById(id)) {return;}
									  js = d.createElement(s); js.id = id;
									  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
									  fjs.parentNode.insertBefore(js, fjs);
									}(document, 'script', 'facebook-jssdk'));</script>
									
									<div class="fb-facepile" data-href="http://www.ees-uai.com.ar/" data-width="200px" data-max-rows="1"></div>
								</td>
							</tr>
							<tr>
								<td>
								<div id="pages_numbers"></div>
								</td>
								<td></td>
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