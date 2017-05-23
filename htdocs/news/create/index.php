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
	

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html> 
	<head> 
		<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
		<?php
			//Get User to used in the title
			$title_description = ' - Usuario: ' . $session->GetSessionValue('login_user');
			echo '<title>EES - UAI - Crear Noticia ' . $title_description .'</title>';
		?>		
		<script type="text/javascript" language="JavaScript" src="/scripts/jquery/jquery.min.js"></script> 
		<script type="text/javascript" language="JavaScript" src="/controls/menu/ddsmoothmenu.js"></script>
		<script type="text/javascript" language="JavaScript" src="/news/create/script/create_news.js"></script>
		<link rel="stylesheet" type="text/css" href="/style/css/general.css" media="screen"/>
		<link rel="stylesheet" type="text/css" href="/controls/menu/ddsmoothmenu.css" />
		<link rel="stylesheet" type="text/css" href="/controls/menu/ddsmoothmenu-v.css" />
		<link rel="stylesheet" type="text/css" href="/style/css/create_news.css" />
	</head> 
	<body> 

	<div id="smoothmenu1" class="ddsmoothmenu"></div>

	<center>
	<br/>
	<div style="width: 500px; text-align: left;" class="form">
		<h1>Crear Nota</h1>	
		<table style="width: 500px;">
			<tr>
				<td>
					<label class="label">Titulo<span class="ErrorFont">*</span></label>
				</td>
			</tr>
			<tr>
				<td>
					<input id="title" type="text" class="textbox"/>
				</td>
			</tr>
			<tr>
				<td>
					<div id="title_div" style="display:none; position: relative;text-align: left;"><span class="ErrorFont">*    El titulo de la nota es requerido.</span></div>
				</td>
			</tr>
			<tr>
				<td>
					<label class="label">Sub Titulo</label>
				</td>
			</tr>
			<tr>
				<td>
					<input id="subtitle" type="text" class="textbox"/>
				</td>
			</tr>
			<tr>
				<td>
					<label class="label">Sub Resumen (max 250)</label>
				</td>
			</tr>
			<tr>
				<td>
					<textarea id="subsummary" rows="4" cols="20" class="textbox"></textarea>
				</td>
			</tr>
			<tr>
				<td>
					<label class="label">Resumen<span class="ErrorFont">*</span> (max 250)</label>
				</td>
			</tr>
			<tr>
				<td>
					<div>
						<textarea id="summary" rows="4" cols="20" class="textbox"></textarea>
						<div id="summary_div" style="display:none; position: relative;text-align: left;"><span class="ErrorFont">*    El resumen de la nota es requerido.</span></div>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<label class="label">Categoria<span class="ErrorFont">*</span></label>
				</td>
			</tr>
			<tr>
				<td>
					<select id="category" class="textbox">
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<label class="label">Imagen url<span class="ErrorFont">*</span></label>
				</td>
			</tr>
			<tr>
				<td>
					<div>
						<input id="image_url" type="text" class="textbox"/>
						<div id="image_div" style="display:none; position: relative;text-align: left;"><span class="ErrorFont">*    El image de la nota es requerido.</span></div>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<label class="label">Comentario de la Imagen<span class="ErrorFont">*</span></label>
				</td>
			</tr>
			<tr>
				<td>
					<div>
						<input id="image_comment" type="text" class="textbox"/>
						<div id="comment_image_div" style="display:none; position: relative;text-align: left;"><span class="ErrorFont">*    La comentario de la image es requerido.</span></div>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<label class="label">Link de la nota completa</label>
				</td>
			</tr>
			<tr>
				<td>
					<div>
						<input id="link_1" type="text" class="textbox"/>
						<div id="link_1_div" style="display:none; position: relative;text-align: left;"><span class="ErrorFont">*    El link no posee un formato correcto.</span></div>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<label class="label">Link relacionados</label>
				</td>
			</tr>
			<tr>
				<td>
					<div>
						<input id="link_2" type="text" class="textbox"/>
						<div id="link_2_div" style="display:none; position: relative;text-align: left;" ><span class="ErrorFont">*    El link no posee un formato correcto.</span></div>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<label class="label">Link PDF</label>
				</td>
			</tr>
			<tr>
				<td>
					<div>
						<input id="link_3" type="text" class="textbox"/>
						<div id="link_3_div" style="display:none; position: relative;text-align: left;"><span class="ErrorFont">*    El link no posee un formato correcto.</span></div>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div style="float:left;text-align: left;"><span class="ErrorFont">* Campos requeridos.</span></div>
					<div style="float:right;"><input id="send" type="button" value="Guardar" class="GeneralButtons" style="width: 120px;"/></div>					
				</td>
			</tr>
		</table>			
	</div>
	<br />
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