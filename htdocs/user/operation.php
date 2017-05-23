<?php
  error_reporting (E_ALL ^ E_NOTICE);
  
  //Important need to be defined in the top page required pages
  define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);

  require_once(__ROOT__.'/common/session/Session.php');   
  require_once(__ROOT__.'/common/dataAccess/DBSecurityConnections.php');

  //Queries
  define('__QUERY_INSERT_USER__', "INSERT INTO User
  												   (turn_id,
  												    campus_id,
  												    permission_id,
  												    year,
  												    firstname,
  												    lastname,
  												    password,
  												    email,
  												    comission,
  												    validated,
  												    date
												   )
								  VALUES ([0],[1],[2],[3],'[4]','[5]','[6]','[7]','[8]',[9],[10])");
  
  define('__QUERY_GET_USER_BY_EMAIL__', "SELECT * 
  										 FROM User 
  										 WHERE email='[0]' 
  										 ORDER BY date DESC limit 1");
										 
  define('__QUERY_GET_VALID_USER__', "SELECT * 
  									  FROM User 
  									  WHERE id=[0] 
  									        AND CASE  when MONTH(date) > 3 then 1 when MONTH(date) > 8 then 2 END = CASE  when MONTH(NOW()) > 3 then 1 when MONTH(NOW()) > 8 then 2 END AND YEAR(date) = YEAR(NOW())");
 
 define('__QUERY_CHECK_USER_PASSWORD__', "SELECT * 
 										  FROM User 
 										  WHERE email ='[0]' 
 										  		AND password ='123456'");
    
 define('__QUERY_UPDATE_USER_PASSWORD__', "UPDATE User SET password = '[0]' 
 										   WHERE email = '[1]' 
 										   		 AND password = '[2]'");

 define('__QUERY_GET_USERS_BY_FILTERS__', "SELECT U.id,
 												  U.firstname,
 												  U.lastname, 
 												  C.id 'campus_id',
 												  C.name 'campus',
 												  U.year 'year_coursed',
 												  T.id 'turn_id',
 												  T.name 'turn',
 												  U.comission 'comission',
 												  CASE  when MONTH(U.date) > 3 then 1 when MONTH(U.date) > 8 then 2 END 'cuatrimestre',
 												  YEAR(U.date) 'year' 
 											FROM User U,
 											     Turn T,
 											     Campus C
 											WHERE U.turn_id = T.id 
 												  AND U.campus_id = C.id 
 												  AND U.validated = 1 ");

 define('__QUERY_UPDATE_USER__', "UPDATE User SET firstname = '[0]',
  												  lastname = '[1]',
  												  campus_id = [2],
  												  year = [3],
  												  turn_id = [4],
  												  comission='[5]'
  											  WHERE id=[6]"); 												  
 												    
    	switch($_GET['operation'])
	    {
			case "save":
				SaveUser($dbSetting);
				break;
			case "verify":
				ValidateUser($dbSetting);
				break;
			case "check_status";
				CheckPassword($dbSetting,$session);
				break;	
			case "password":
				ChangePassword($dbSetting,$session);
				break;
			case "user":
				GetUser($dbSetting);
				break;	
			case "update";
				UpdateUser($dbSetting,$session);
				break;	
		}
	exit();

function SaveUser($dbSetting)
{			
	  try
	  {			
		$firstname = urldecode($_GET["first_name"]);
		$lastname = urldecode($_GET["last_name"]);
		$turn_id = urldecode($_GET["turn_id"]);
		$campus_id = urldecode($_GET["campus_id"]);
		$email = urldecode($_GET["email"]);
		$comission = urldecode($_GET["comission"]);
		$year = urldecode($_GET["year"]);
		
		$firstname = stripslashes($firstname);
		$firstname = mysql_real_escape_string($firstname);
		$lastname = stripslashes($lastname);
		$lastname = mysql_real_escape_string($lastname);
		$turn_id = stripslashes($turn_id);
		$turn_id = mysql_real_escape_string($turn_id);
		$campus_id = stripslashes($campus_id);
		$campus_id = mysql_real_escape_string($campus_id);
		$email = stripslashes($email);
		$email = mysql_real_escape_string($email);
		$comission = stripslashes($comission);
		$comission = mysql_real_escape_string($comission);
		$year = stripslashes($year);
		$year = mysql_real_escape_string($year);
		
		$query = __QUERY_INSERT_USER__;
		$query = $dbSetting->ReplaceParameter($query, '[0]', $turn_id);
		$query = $dbSetting->ReplaceParameter($query, '[1]', $campus_id);	
		$query = $dbSetting->ReplaceParameter($query, '[2]', '1');
		$query = $dbSetting->ReplaceParameter($query, '[3]', $year);
		$query = $dbSetting->ReplaceParameter($query, '[4]', $firstname);
		$query = $dbSetting->ReplaceParameter($query, '[5]', $lastname);	
		$query = $dbSetting->ReplaceParameter($query, '[6]', '123456');	
		$query = $dbSetting->ReplaceParameter($query, '[7]', $email);
		$query = $dbSetting->ReplaceParameter($query, '[8]', $comission);
		$query = $dbSetting->ReplaceParameter($query, '[9]', 'false');
		$query = $dbSetting->ReplaceParameter($query, '[10]', 'NOW()');

		$dbSetting->ExecuteQuery($query);
		
		echo json_encode(array("successful" => "true" ));
	  }
	  catch (Exception $e)
	  {
		  echo $e;
		  echo "error";
	  }	
}

function ValidateUser($dbSetting)
{			
	  try
	  {
		$email = $_GET["email"];
		$email = stripslashes($email);
		$email = mysql_real_escape_string($email);
		
		$query = __QUERY_GET_USER_BY_EMAIL__;
		$query = $dbSetting->ReplaceParameter($query, '[0]', $email);						
		$rs = $dbSetting->ExecuteQuery($query);
		
		$row = mysql_fetch_assoc($rs);
		$numrows = mysql_num_rows($rs);
		
		if($numrows > 0)
		{
			if($row["permission_id"] == 1)
			{
				//check if the user is of the other cuatrimestre
				$query = __QUERY_GET_VALID_USER__;
				$query = $dbSetting->ReplaceParameter($query, '[0]', $row["id"]);
		   		$rss = $dbSetting->ExecuteQuery($query);
				$Validationnumrows = mysql_num_rows($rss);
				
				if($Validationnumrows == 0)
				{
					 echo json_encode(array("status" => "free" ));
				}
				else
				{
					echo json_encode(array("status" => "duplicated" ));
				}
				
				return;
			}
			
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


function CheckPassword($dbSetting, $session)
{			
	  try
	  {
		$email = $session->GetSessionValue('login_user');
		
		$query = __QUERY_CHECK_USER_PASSWORD__;
		$query = $dbSetting->ReplaceParameter($query, '[0]', $email);
		$rs = $dbSetting->ExecuteQuery($query);
		
		$numrows = mysql_num_rows($rs);
		
		if($numrows > 0)
		{
			echo json_encode(array("status" => "need_change" ));
		}
		else
		{
			echo json_encode(array("status" => "good" ));	
		}			
	  }
	  catch (Exception $e)
	  {
		  echo $e;
		  echo "error";
	  }	
}

function ChangePassword($dbSetting,$session)
{
	//Check if the user is still login
	if($session->GetSessionValue('valid') != 'valid')
	{
		return 0;
	}
	
	try
	{
		$email = $session->GetSessionValue('login_user');
		
		$prev_password = $_GET["prev_password"];
		$password = $_GET["password"];
		
		$prev_password = stripslashes($prev_password);
		$prev_password = mysql_real_escape_string($prev_password);
		$password = stripslashes($password);
		$password = mysql_real_escape_string($password);
		
		$query = __QUERY_UPDATE_USER_PASSWORD__;
		$query = $dbSetting->ReplaceParameter($query, '[0]', $password);
		$query = $dbSetting->ReplaceParameter($query, '[1]', $email);
		$query = $dbSetting->ReplaceParameter($query, '[2]', $prev_password);
		
		$dbSetting->ExecuteQuery($query);
		
		echo json_encode(array("successful" => "true" ));
					
	 }
	 catch (Exception $e)
	 {
	 	echo $e;
	  	echo "error";
	 }	
}  

function GetUser($dbSetting)
{	  
  try
   	{	  	    				
		$query = __QUERY_GET_USERS_BY_FILTERS__;
		
		if($_GET["id"] != null)
	  	{
	  		$id = $_GET["id"];
			$id = stripslashes($id);
			$id = mysql_real_escape_string($id);
			 
	  		$query = $query . " AND U.id =" . $id; 
	  	}
		
		if($_GET["campus"] != null)
	  	{
	  		$campus = $_GET["campus"];
			$campus = stripslashes($campus);
			$campus = mysql_real_escape_string($campus);
			
	  		$query = $query . " AND C.id =" . $campus; 
	  	}
	  	
		if($_GET["turn"] != null)
	  	{
	  		$turn = $_GET["turn"];
			$turn = stripslashes($turn);
			$turn = mysql_real_escape_string($turn);
			
	  		$query = $query . " AND T.id =" . $turn; 
	  	}
		
		if($_GET["comission"] != null)
	  	{
	  		$comission = $_GET["comission"];
			$comission = stripslashes($comission);
			$comission = mysql_real_escape_string($comission);
			
	  		$query = $query . " AND U.comission ='" . $comission . "'"; 
	  	}
		
		if($_GET["year_cursed"] != null)
	  	{
	  		$year_cursed = $_GET["year_cursed"];
			$year_cursed = stripslashes($year_cursed);
			$year_cursed = mysql_real_escape_string($year_cursed);
			
	  		$query = $query . " AND U.year =" . $year_cursed; 
	  	}
		
		if($_GET["year"] != null)
	  	{
	  		$year = $_GET["year"];
			$year = stripslashes($year);
			$year = mysql_real_escape_string($year);
			
	  		$query = $query . " AND YEAR(U.date) =" . $year; 
	  	}
	  	
		if($_GET["cuatrimestre"] != null)
		{
			$cuatrimestre = $_GET["cuatrimestre"];
			$cuatrimestre = stripslashes($cuatrimestre);
			$cuatrimestre = mysql_real_escape_string($cuatrimestre);
			
			$query = $query . " AND CASE  when MONTH(U.date) > 3 then 1 when MONTH(U.date) > 8 then 2 END =" . $cuatrimestre; 
		}
		
		$query = $query . " ORDER BY CONCAT_WS(',',U.firstname,NULL,U.lastname) DESC";
	
		$rs = $dbSetting->ExecuteQuery($query);
		
		for ($x = 0, $numrows = mysql_num_rows($rs); $x < $numrows; $x++) {
			$row = mysql_fetch_assoc($rs);
		
			$result[$x] = array(
								"id" => $row["id"],
								"firstname" => $row["firstname"],
								"lastname" => $row["lastname"],
								"campus" => $row["campus_id"],
								"year_coursed" => $row["year_coursed"],
								"turn" => $row["turn_id"],
								"comission" => $row["comission"]
							   );		
		}
		
		echo  json_encode($result);
		
   }
   catch (Exception $e)
   {
	  echo $e;
   }	
} 
	
function UpdateUser($dbSetting,$session)
{	
	//Check if the user is still login
	if($session->GetSessionValue('valid') != 'valid')
	{
		return 0;
	}
		
	try
	{			
		$first_name = urldecode($_GET["first_name"]);
		$last_name = urldecode($_GET["last_name"]);
		$campus_id = urldecode($_GET["campus_id"]);
		$year = urldecode($_GET["year"]);
		$turn_id  = urldecode($_GET["turn_id"]);
		$comission = urldecode($_GET["comission"]);
		
		$first_name = stripslashes($first_name);
		$first_name = mysql_real_escape_string($first_name);
		$last_name = stripslashes($last_name);
		$last_name = mysql_real_escape_string($last_name);
		$campus_id = stripslashes($campus_id);
		$campus_id = mysql_real_escape_string($campus_id);
		$year = stripslashes($year);
		$year = mysql_real_escape_string($year);
		$turn_id = stripslashes($turn_id);
		$turn_id = mysql_real_escape_string($turn_id);
		$comission = stripslashes($comission);
		$comission = mysql_real_escape_string($comission);
		
		$user_id = $session->GetSessionValue('user_id');
		
		$query = __QUERY_UPDATE_USER__;
		$query = $dbSetting->ReplaceParameter($query, '[0]', $first_name);
		$query = $dbSetting->ReplaceParameter($query, '[1]', $last_name);
		$query = $dbSetting->ReplaceParameter($query, '[2]', $campus_id);
		$query = $dbSetting->ReplaceParameter($query, '[3]', $year);
		$query = $dbSetting->ReplaceParameter($query, '[4]', $turn_id);
		$query = $dbSetting->ReplaceParameter($query, '[5]', $comission);
		$query = $dbSetting->ReplaceParameter($query, '[6]', $user_id);
										    			
		$dbSetting->ExecuteQuery($query);
		
		echo json_encode(array("successful" => "true" ));
	 }
	 catch (Exception $e)
	 {
	  echo $e;
	  echo "error";
	 }	
}


?>