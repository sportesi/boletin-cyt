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
			echo '<title>EES - UAI - Lista de noticias cargadas ' . $title_description .'</title>';
		?>		
		
		<script type="text/javascript">    
		<?php
			echo 'var user_id =' . $session->GetSessionValue('user_id') . '; ';
		?>
		</script>
		
		<script type="text/javascript" language="JavaScript" src="/scripts/jquery/jquery.min.js"></script> 
		<script type="text/javascript" language="JavaScript" src="/controls/menu/ddsmoothmenu.js"></script>
		<script type="text/javascript" language="JavaScript" src="/news/list/script/news_list.js"></script>
		<link rel="stylesheet" type="text/css" href="/style/css/general.css" media="screen"/>
		<link rel="stylesheet" type="text/css" href="/controls/menu/ddsmoothmenu.css" />
		<link rel="stylesheet" type="text/css" href="/controls/menu/ddsmoothmenu-v.css" />
	
	</head> 
	<body> 
		<div id="smoothmenu1" class="ddsmoothmenu">
		</div>
		<div id="news"></div>
		<div id="pages_numbers"></div>
		
		<div style="position:relative;">
			<div id="smoothmenu1" class="ddsmoothmenu">
			</div>
		</div>
	
		<table>
			<tr>
				<td style="width: 800px"><div id="news"></div></td>
			</tr>
			<tr>
				<td style="height: 20px;" align="center">
					<div id="pages_numbers" style="width: 800px; text-align: center;"></div>
				</td>
			</tr>
		</table>
	
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