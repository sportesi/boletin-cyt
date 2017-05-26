<?php 
	//Important need to be defined in the top page required pages
  	define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);
   
    require_once(__ROOT__.'/common/session/Session.php');
  	require_once(__ROOT__.'/common/DataAccess/DBSecurityConnections.php');
	
	//Queries
 	define('__QUERY_GET_ALL_CATEGORIES_ORDER_BY_NAME__', 'SELECT 
 																C.* 
 														  FROM Category C 
 														  WHERE C.deleted = 0 
 														  ORDER BY C.name DESC');
		
	//Check if the user is still login
	if($session->GetSessionValue('valid') != 'valid')
	{
		header('location:../../login/index.php');
	}
	
	if($session->GetSessionValue('permission') < 2)
	{
		header('location:../../login/index.php');
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html> 
	<head> 
		<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
		<?php
			//Get User to used in the title
			$title_description = ' - Usuario: ' . $session->GetSessionValue('login_user');
			echo '<title>EES - UAI - Administrador de Caregorías ' . $title_description .'</title>';
		?>		
		<link rel="stylesheet" type="text/css" href="/style/css/general.css" media="screen"/>
		<style type="text/css" title="currentStyle"> 
			@import "/controls/grid/datatables-grid/css/demo_page.css";
			@import "/controls/grid/datatables-grid/css/demo_table.css";</style> 
		
		<script type="text/javascript" language="JavaScript" src="/scripts/jquery/jquery.min.js"></script>
		<script type="text/javascript" language="JavaScript" src="/controls/menu/ddsmoothmenu.js"></script> 
		<script type="text/javascript" language="JavaScript" src="/admin/category/list/script/list_categories.js"></script> 
		<script type="text/javascript" language="javascript" src="/controls/grid/datatables-grid/js/jquery.dataTables.js"></script> 		
		<link rel="stylesheet" type='text/css' href='/controls/menu/ddsmoothmenu.css' />
		<link rel="stylesheet" type='text/css' href='/controls/menu/ddsmoothmenu-v.css' />
		<link rel="stylesheet" type="text/css" href="/style/css/list.css" />
	</head> 
	
	<body id="dt_example">
		<div id="smoothmenu1" class="ddsmoothmenu"></div>
		<h1>Categorías</h1>
		<div>
		
		<div id="container"> 
			
			<div id="output"></div> 
			
			<div id="demo"> 
				<table cellpadding="0" cellspacing="0" border="0" class="display" id="example"> 
				<thead> 
					<tr>
						<th>Nombre</th>
						<th>Estado</th>
						<th>Borrar</th>
					</tr> 
				</thead> 
	<tbody> 

	<?php
		
	  try
	  {    			
			$rs =  $dbSetting->ExecuteQuery(__QUERY_GET_ALL_CATEGORIES_ORDER_BY_NAME__);
			
			while($row = mysql_fetch_assoc($rs))
			{
				echo "<tr class='center'>" .  
					 "<td class='center'> {$row['name']} </td>"  .
					 "<td class='center'> <input id='button_change_{$row['id']}' type='button' value='" . GetButtonDescription($row["status"]) . "' onclick='ChangeStatus(" . $row['id'] . "," . GetStatus($row['status']) . ")' style='width:150px;' /> </td>" .
					 "<td class='center'> <input id='button_delete_{$row['id']}' type='button' value='Borrar' onclick='Delete(" . $row['id'] . ")' style='width:150px;'/>" . "</tr>";
			} 
			
	   }
	   catch (Exception $e)
	   {
		  echo $e;
	   }
	   
	   
	   function GetButtonDescription($status)
	   {
	   	 if($status == 0)
		 {
		 	return "Habilitar";
		 }
		 {
		 	return "Desabilitar";
		 }
	   }
	   
	   function GetStatus($status)
	   {
	     if($status == 0)
		 {
		 	return 1;
		 }
		 else 
		 {
			return 0;	 
		 }
	   }	
	   
	?>
	</tbody> 
	<tfoot> 
		<tr> 
			<th>Nombre</th>
			<th>Estado</th>
			<th>Borrar</th>
		</tr> 
	</tfoot> 
</table> 

			</div> 
			<div class="spacer"></div> 
			
		</div> 
	
		</div>
	
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