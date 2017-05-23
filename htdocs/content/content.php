<?php
  //Important need to be defined in the top page required pages
  define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);
   
  require_once(__ROOT__.'/common/dataAccess/DBSecurityConnections.php');
  
  //Queries
  define('__QUERY_GET_ALL_CAMPUS_ORDER_BY_NAME__', 'SELECT * 
  													FROM Campus 
  													ORDER BY Name ASC');
  
  define('__QUERY_GET_ALL_TURNS__', 'SELECT * 
  									FROM Turn');													

  define('__QUERY_GET_ALL_CATEGORIES__', 'SELECT C.*, (SELECT COUNT(*) FROM News WHERE category_id = C.id) NewsCount 
  										  FROM Category C
  										  WHERE C.status = 1 
  										  		AND C.deleted = 0 
  										  ORDER BY C.Name ASC');

  define('__QUERY_GET_ALL_PERMISSIONS_ORDER_BY_NAME__', 'SELECT * 
  										  				 FROM Permission 
  										  				 ORDER BY Name ASC');
										  
  switch($_GET['operation'])
	{
			case "campus":
				GetCampus($dbSetting);
				break;
			case "turn":
				GetTurn($dbSetting);
				break;
			case "category":
				GetCategory($dbSetting);
				break;
			case "permission":
				GetPermission($dbSetting);
				break;			
	}
  
  exit();
	  
	   
function GetCampus($dbSetting)
{	   		
	  try
	  {								
		$rs = $dbSetting->ExecuteQuery(__QUERY_GET_ALL_CAMPUS_ORDER_BY_NAME__);
					
		for ($x = 0, $numrows = mysql_num_rows($rs); $x < $numrows; $x++) 
		{
			$row = mysql_fetch_assoc($rs);
		 
			$result[$x] = array("id" => $row["id"], "name" => htmlentities($row["name"]));		
		}
			
			echo  json_encode($result);
	
	   }
	   catch (Exception $e)
	   {
		  echo $e;
	   }	
}

function GetTurn($dbSetting)
{	   		
	  try
	  {
		$rs =  $dbSetting->ExecuteQuery(__QUERY_GET_ALL_TURNS__);
			
		for ($x = 0, $numrows = mysql_num_rows($rs); $x < $numrows; $x++) 
		{
			$row = mysql_fetch_assoc($rs);
		    
			$result[$x] = array("id" => $row["id"], "name" => htmlentities($row["Name"]));		
		}
			
		echo  json_encode($result);
			
	   }
	   catch (Exception $e)
	   {
		  echo $e;
	   }	
}

function GetCategory($dbSetting)
{	   		
	  try
	  {				
		$rs =  $dbSetting->ExecuteQuery(__QUERY_GET_ALL_CATEGORIES__);
		
		for ($x = 0, $numrows = mysql_num_rows($rs); $x < $numrows; $x++) 
		{
			$row = mysql_fetch_assoc($rs);
		    
			$result[$x] = array("id" => $row["id"], "name" => $row["name"], "NewsCount" => $row["NewsCount"]);		
		}
			
		echo  json_encode($result);
			
	   }
	   catch (Exception $e)
	   {
		  echo $e;
	   }	
}

function GetPermission($dbSetting)
{	   		
	  try
	  {				
		$rs =  $dbSetting->ExecuteQuery(__QUERY_GET_ALL_PERMISSIONS_ORDER_BY_NAME__);
		
		for ($x = 0, $numrows = mysql_num_rows($rs); $x < $numrows; $x++) 
		{
			$row = mysql_fetch_assoc($rs);
		    
			$result[$x] = array("id" => $row["id"], "name" => htmlentities($row["name"]));		
		}
			
		echo  json_encode($result);
			
	   }
	   catch (Exception $e)
	   {
		  echo $e;
	   }	
}
	
?>
