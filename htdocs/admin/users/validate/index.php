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
	
	//Queries
 	define('__QUERY_GET_ALL_STUDENT_TO_VALIDATE_ORDER_BY_NAME__', "SELECT U.id,
 																		  CONCAT_WS(',',U.firstname,NULL,U.lastname) 'fullname',
 																		  C.name 'campus',
 																		  U.year,
 																		  T.name 'turn',
 																		  U.comission 'comission',
 																		  U.validated,
 																		  U.date 
 																	FROM User U,
 																		 Turn T,
 																		 Campus C
 																	WHERE U.turn_id = T.id 
 																		  AND U.campus_id = C.id 
 																		  AND U.validated = 0 
 																		  AND U.permission_id = 1 ");
		
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html> 
	<head> 
		<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
		<?php
			//Get User to used in the title
			$title_description = ' - Usuario: ' . $session->GetSessionValue('login_user');
			echo '<title>EES - UAI - Validar Usuarios ' . $title_description .'</title>';
		?>

		<script type="text/javascript" language="JavaScript" src="/scripts/jquery/jquery.min.js"></script> 
		<script type="text/javascript" language="JavaScript" src="/controls/grid/datatables-grid/js/jquery.dataTables.js"></script>
		<script type="text/javascript" language="JavaScript" src="/controls/menu/ddsmoothmenu.js"></script>
		<script type="text/javascript" language="JavaScript" src="/admin/users/validate/script/validate.js"></script> 		
		<style type="text/css" title="currentStyle"> 
			@import "/controls/grid/datatables-grid/css/demo_page.css";
			@import "/controls/grid/datatables-grid/css/demo_table.css";
		</style> 
		<link rel="stylesheet" type="text/css" href="/style/css/general.css" media="screen"/>
		<link rel="stylesheet" type="text/css" href="/controls/menu/ddsmoothmenu.css" />
		<link rel="stylesheet" type="text/css" href="/controls/menu/ddsmoothmenu-v.css" />
		<link rel="stylesheet" type="text/css" href="/style/css/list.css" />
	</head> 
	<body id="dt_example"> 
		<div id="smoothmenu1" class="ddsmoothmenu"></div>
		<div>
		<h1>Validar Incriptción de Usuarios</h1>
		<table style="width:300px; padding-left: 10px; ">
			<tr>
				<td>
					<div>Año</div>
					<div>
						<select id="year" class="textbox">
						<option>2011</option>
						<option>2012</option>
						<option>2013</option>
						<option>2014</option>
						<option>2015</option>
						<option>2016</option>
						<option>2017</option>
						<option>2018</option>
						<option>2019</option>
						<option>2020</option>
						</select>
					</div>
				</td>
				<td>
					<div>Cuatrimestre</div> 
					<div>
						<select id="cuatrimestre" class="textbox">
							<option>1</option>
							<option>2</option>
						</select>
					</div>
				</td>
				<td valign="bottom">
					<div>
						<input type="button" value="Buscar" onclick="Search()" class="GeneralButtons"/>
					</div>
				</td>
			</tr>
		</table>
		
		<div id="container"> 
			
			<div id="output"></div> 
			
			<div id="demo"> 
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example"> 
	<thead> 
		<tr> 
			<th>Nombre completo</th> 
			<th>Campus</th>
			<th>Año</th> 
			<th>Turno</th> 
			<th>Comisión</th> 
			<th>Verificado</th>
			<th>Fecha de Registo</th>
			<th></th>			
		</tr> 
	</thead> 
	<tbody> 

	<?php
		
	  try
	  {
			$str= __QUERY_GET_ALL_STUDENT_TO_VALIDATE_ORDER_BY_NAME__; 
			
			if($_GET["year"] != null)
	  	    {
	  	    	$str= $str . " AND YEAR(U.date) =" . $_GET["year"]; 
	  	    }
	  	    
			if($_GET["cuatrimestre"] != null)
			{
				$str= $str . " AND CASE  when MONTH(U.date) > 8 then 2 when MONTH(U.date) > 1 then 1 END =" . $_GET["cuatrimestre"]; 
			}
			
			$str= $str . " ORDER BY U.date, U.validated DESC";
			
			$rs =  $dbSetting->ExecuteQuery($str);
		
			while($row = mysql_fetch_assoc($rs))
			{
				echo "<tr " . Validated($row['validated']) . " class='center'>" .
					 "<td class='center'> <a href='../../../user/statistics/index.php?id=" . $row['id'] . "' >{$row['fullname']}</a> </td>" . 
					 "<td class='center'> {$row['campus']} </td>" . 
					 "<td class='center'> {$row['year']} </td>" . 
					 "<td class='center'> {$row['turn']} </td>" . 
					 "<td class='center'> {$row['comission']} </td>" . 
					 "<td class='center'> <input id='button_{$row['id']}' type='button' value='Validar' onclick='ValidateUser(" . boolean($row['validated']) ."," . $row['id'] . ")'/></td>" . 
					 "<td class='center'> {$row['date']} </td>" . 
					 "<td class='center'> <input id='button__{$row['id']}' type='button' value='Borrar' onclick='Delete(" . $row['id'] . ")'/> </td>" . 
					 "</tr>";
			} 
			
	   }
	   catch (Exception $e)
	   {
		  echo $e;
	   }	
		
	   
	   function Validated($value)
	   {
			if($value == 0)
			{
				return "";
			}
			else
			{
				return "class='gradeD'";
			}
	   }
	    
	   function boolean($value)
	   {
			if($value == 0)
			{
				return "false";
			}
			else
			{
				return "true";
			}
	   }
	   
	?>
	</tbody> 
	<tfoot> 
		<tr> 
			<th>Nombre completo</th> 
			<th>Campus</th> 
			<th>Año</th>
			<th>Turno</th> 
			<th>Comisión</th> 
			<th>Verificado</th>
			<th>Fecha de Registo</th>
			<th></th>
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