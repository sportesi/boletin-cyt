<?php
  //Important need to be defined in the top page required pages
  define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);
  
  require_once(__ROOT__.'/common/session/Session.php'); 
  require_once(__ROOT__.'/common/DataAccess/DBSecurityConnections.php');
  
  //Queries
  define('__QUERY_DELETE_CATEGORY_BY_ID__', 'UPDATE Category 
  											 SET deleted= 1 
  											 WHERE id = [0]');
 
  define('__QUERY_UPDATE_CATEGORY__STATUS_BY_ID__', 'UPDATE Category 
  											 SET status=[0] 
  											 WHERE id = [1]');

  define('__QUERY_CKECK_IF_IS_CATEGORY_DUPLICATED__', "SELECT * 
  													   FROM Category 
  													   WHERE name='[0]'  
  													   		 AND deleted = 0");
															 
  define('__QUERY_INSERT_CATEGORY__', "INSERT INTO Category(Name) 
  									   VALUES('[0]')");															 
  												 											 
	switch($_GET['operation'])
	    {
			case "delete":
				LogicalDelete($dbSetting,$session);
				break;
			case "update":
				UpdateStatus($dbSetting,$session);
				break;
			case "verify":
				ValidateCategory($dbSetting);
				break;
			case "save":
				CreateCategory($dbSetting,$session);
		}
		
	 exit();

function LogicalDelete($dbSetting,$session)
{
	//Check if the user is still login
	if($session->GetSessionValue('valid') != 'valid')
	{
		return 0;
	}
			
	try
	{					 
		$category_id = urldecode($_GET["category_id"]);
		$category_id = stripslashes($category_id);
			
		$query = __QUERY_DELETE_CATEGORY_BY_ID__;
		$query = $dbSetting->ReplaceParameter($query, '[0]', $category_id);
		
		$rs = $dbSetting->ExecuteQuery($query);			
				    			
		echo json_encode(array("successful" => "true" ));
	 }
	 catch (Exception $e)
	 {
		echo $e;
		echo "error";
	 }	
}

function UpdateStatus($dbSetting,$session)
{
	//Check if the user is still login
	if($session->GetSessionValue('valid') != 'valid')
	{
		return 0;
	}
			
	try
	{			
		$category_id = urldecode($_GET["category_id"]);
		$category_id = stripslashes($category_id);
			
		$status = urldecode($_GET["status"]);
		$status = stripslashes($status);
			
		$query = __QUERY_UPDATE_CATEGORY__STATUS_BY_ID__;
			
		$query = $dbSetting->ReplaceParameter($query, '[0]', $status);
		$query = $dbSetting->ReplaceParameter($query, '[1]', $category_id);		
			
		$rs = $dbSetting->ExecuteQuery($query);
						
		echo json_encode(array("successful" => "true" ));
	 }
	 catch (Exception $e)
	 {
		 echo $e;
		 echo "error";
	 }	
}


function ValidateCategory($dbSetting)
{	 		
	  try
	  {
			$name = $_GET["name"];
			$name = stripslashes($name);
			$name = mysql_real_escape_string($name);
			
			$query = __QUERY_CKECK_IF_IS_CATEGORY_DUPLICATED__;	
			$query = $dbSetting->ReplaceParameter($query, '[0]', $name);
	    
			$rs = $dbSetting->ExecuteQuery($query);
			
			$numrows = mysql_num_rows($rs);
			
			if($numrows > 0)
			{
				echo json_encode(array("status" => "duplicated" ));				
			}
			else
			{
				echo json_encode(array("status" => "free" ));
			}			
	   }
	   catch (Exception $e)
	   {
		  echo $e;
		  echo "error";
	   }	
}	

function CreateCategory($dbSetting,$session)
{
	//Check if the user is still login
	if($session->GetSessionValue('valid') != 'valid')
	{
		return 0;
	}
	  			
	try
	{
		$name = $_GET["name"];
		$name = stripslashes($name);
		$name = mysql_real_escape_string($name);
			
		$query = __QUERY_INSERT_CATEGORY__;			
		$query= $dbSetting->ReplaceParameter($query, '[0]', $name);
            
		$rs = $dbSetting->ExecuteQuery($query);
			
		$numrows = mysql_num_rows($rs);
			
		echo json_encode(array("successful" => "true" ));	
						
	 }
	 catch (Exception $e)
	 {
		 echo $e;
		 echo "error";
	 }
	
}

?>