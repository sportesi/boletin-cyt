<?php
  //Important need to be defined in the top page required pages
  define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);
  
  require_once(__ROOT__ . '/common/session/Session.php');
  require_once(__ROOT__ . '/common/DataAccess/DBSecurityConnections.php');
  
  //Queries
  define('__QUERY_GET_USER_BY_NAME_AND_PASSWORD', "SELECT * 
  												   FROM user U 
  												   WHERE U.email='[0]' 
  												   		 AND U.password ='[1]' 
  												   ORDER BY date DESC limit 1");
  														 	
  define('__QUERY_GET_COUNT_EQUAL_ONE_IF_USER_EXISTS_IN_SAME_QUARTER', "SELECT * 
  																		FROM user 
  																		WHERE id=[0] 
  																			  AND CASE  when MONTH(date) > 8 then 2 when MONTH(date) > 1 then 1 END = CASE  when MONTH(NOW()) > 8 then 2 when MONTH(NOW()) > 1 then 1 END AND YEAR(date) = YEAR(NOW())");
  														
	switch($_GET['operation'])
	    {
			 case "login":
				VerifyUser($dbSetting,$session);
				break;
		}
	
	 exit();

function VerifyUser($dbSetting,$session)
{	
	  try
	  {
	  		header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
			
			$myusername= DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "myusername"));
			$mypassword= DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "mypassword"));

			$query = __QUERY_GET_USER_BY_NAME_AND_PASSWORD;

			$query = str_replace('[0]', $myusername, $query);
			$query = str_replace('[1]', $mypassword, $query);

			$rs = $dbSetting->ExecuteQuery($query);

			$row = mysql_fetch_assoc($rs);

			if(count($row) == 0 )
			{
				echo json_encode(array("status" => "unregister" ));
				return;
			}

			if($row["validated"] == "1")
			{
			   if($row["permission_id"] == 1)
			   {
			   		//check if the user is of the other cuatrimestre
			   		$checkStr = __QUERY_GET_COUNT_EQUAL_ONE_IF_USER_EXISTS_IN_SAME_QUARTER;

					$checkStr =	$dbSetting->ReplaceParameter($checkStr,'[0]',$row["id"]);

					$rss = $dbSetting->ExecuteQuery($checkStr);

					$Validationnumrows = mysql_num_rows($rss);

					if($Validationnumrows == 0)
					{
						 echo json_encode(array("status" => "unregister" ));
						 return;
					}
			   }

	    		$_SESSION['login_user'] = $myusername;
	    		$_SESSION['valid'] = 'valid';
	    		$_SESSION['permission'] = $row["permission_id"];
	    		$_SESSION['user_id'] = $row["id"];

	    		if($row["password"] != '123456')
	    		{
	    			echo json_encode(array("status" => "valid" ));
	    		}
	    		else
	    		{
	    			echo json_encode(array("status" => "change_password" ));
	    		}
		    }
			else
			{
			    echo json_encode(array("status" => "not_verified" ));
			}

	   }
	   catch (Exception $e)
	   {
		  echo $e;
		  echo "error";
	   }
}