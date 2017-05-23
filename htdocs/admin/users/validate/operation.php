<?php
  //Important need to be defined in the top page required pages
  define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);
  
  require_once(__ROOT__.'/common/session/Session.php');  
  require_once(__ROOT__.'/common/dataAccess/DBSecurityConnections.php');

  //Queries
  define('__QUERY_UPDATE_USER_VALIDATED_STATUS_AND_DATE__', "UPDATE User 
  															 SET validated = 1,
  															 date = CONCAT( YEAR( CURDATE( ) ) ,  '-', MOD( MONTH( CURDATE( ) ) , 12 ) +1,  '-1' ) 
  															 WHERE id = [0]");
  
  define('__QUERY_UPDATE_USER_VALIDATED_STATUS__', 'UPDATE User 
  													SET validated = 1 
  													WHERE id = [0]');
													
  define('__QUERY_DELETE_USER__', 'DELETE FROM User WHERE id = [0]');
  
  define('__QUERY_RESET_USER_PASSWORD__', "UPDATE User SET password='123456' WHERE id = [0]");
													  
  switch($_GET['operation'])
  {
	case "validate":
		Validate($dbSetting,$session);
		break;	
	case "delete":
		Delete($dbSetting,$session);
		break;
	case "reset":
		ResetPassword($dbSetting,$session);
		break;			
  }
	
	
	 exit();

function Validate($dbSetting,$session)
{
	//Check if the user is still login
	if($session->GetSessionValue('valid') != 'valid')
	{
		return 0;
	}
			
	try
	{
		$user_id = $_GET["user_id"];
		
		$user_id = stripslashes($user_id);
		$user_id = mysql_real_escape_string($user_id);
			
		if(date("m") == 8)
		{
			$str = __QUERY_UPDATE_USER_VALIDATED_STATUS_AND_DATE__;
			$str = $dbSetting->ReplaceParameter($str, '[0]', $user_id);
		}	
		else
		{
			$str =__QUERY_UPDATE_USER_VALIDATED_STATUS__;
			$str = $dbSetting->ReplaceParameter($str, '[0]', $user_id);
		}
	    
		$rs = $dbSetting->ExecuteQuery($str);			
			
		echo json_encode(array("successful" => "true" ));		
	 }
	 catch (Exception $e)
	 {
		  echo $e;
		  echo "error";
	 }	
}	


function Delete($dbSetting,$session)
{
  //Check if the user is still login
  if($session->GetSessionValue('valid') != 'valid')
  {
 	return 0;
  }
 		
  try
  {	
		$user_id = $_GET["user_id"];
		
		$user_id = stripslashes($user_id);
		$user_id = mysql_real_escape_string($user_id);
		
		$str = __QUERY_DELETE_USER__;
		$str = $dbSetting->ReplaceParameter($str, '[0]', $user_id);			
       
		$rs = $dbSetting->ExecuteQuery($str);	
		
		echo json_encode(array("successful" => "true" ));		
   }
   catch (Exception $e)
   {
	  echo $e;
	  echo "error";
   }	
}	

function ResetPassword($dbSetting,$session)
{
  //Check if the user is still login
  if($session->GetSessionValue('valid') != 'valid')
  {
 	return 0;
  }
			
  try
  {
	$str = "";
	$user_id = $_GET["user_id"];
	
	$user_id = stripslashes($user_id);
	$user_id = mysql_real_escape_string($user_id);
				
	$str =  __QUERY_RESET_USER_PASSWORD__; 
    $str = $dbSetting->ReplaceParameter($str, '[0]', $user_id);
		
	$rs = $dbSetting->ExecuteQuery($str);
	
	echo json_encode(array("successful" => "true" ));		
   }
   catch (Exception $e)
   {
	  echo $e;
	  echo "error";
   }	
}	
   
?>