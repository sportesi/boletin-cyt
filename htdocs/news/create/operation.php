<?php

  //Important need to be defined in the top page required pages
  define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);
  
  require_once(__ROOT__.'/common/session/Session.php'); 
  require_once(__ROOT__.'/common/DataAccess/DBSecurityConnections.php');

  define('__QUERY_INSERT_NEWS__', "INSERT INTO 
  										  News(
  										  		user_id,
  										  		title,
  										  		sub_title,
  										  		summary,
  										  		sub_summary,
  										  		image_url,
  										  		image_comment,
  										  		link_1,
  										  		link_2,
  										  		link_3,
  										  		category_id,
  										  		date
  										  	   ) 
  										   VALUES ([0],'[1]','[2]','[3]','[4]','[5]','[6]','[7]','[8]','[9]',[10],[11])");	

  define('__QUERY_UPDATE_NEWS__',"UPDATE News SET  
										   title = '[1]',
										   sub_title = '[2]',
										   summary = '[3]',
										   sub_summary = '[4]',
										   image_url = '[5]',
										   image_comment = '[6]',
										   link_1 = '[7]',
										   link_2 = '[8]',
										   link_3 = '[9]',
										   category_id = [10]  
									WHERE id = [0]");

		switch($_GET['operation'])
			{
				case "save":
					SaveNews($dbSetting,$session);
					break;
				case "update":
					UpdateNews($dbSetting,$session);
					break;
			}
	
	 exit();
	 
function SaveNews($dbSetting,$session)
{
  //Check if the user is still login
  if($session->GetSessionValue('valid') != 'valid')
  {
	return 0;
  }
			
  try
  {			 
		$title = urldecode($_GET["title"]);
		$subtitle = urldecode($_GET["subtitle"]);
		$summary = urldecode($_GET["summary"]);
		$subsummary = urldecode($_GET["subsummary"]);
		$category  = urldecode($_GET["category"]);
		$image_url = urldecode($_GET["image_url"]);
		$image_comment = urldecode($_GET["image_comment"]);
		$link_1 = urldecode($_GET["link_1"]);
		$link_2 = urldecode($_GET["link_2"]);
		$link_3 = urldecode($_GET["link_3"]);
		
		$title = stripslashes($title);
		$title = mysql_real_escape_string($title);
		$subtitle = stripslashes($subtitle);
		$subtitle = mysql_real_escape_string($subtitle);
		$summary = stripslashes($summary);
		$summary = mysql_real_escape_string($summary);
		$subsummary = stripslashes($subsummary);
		$subsummary = mysql_real_escape_string($subsummary);
		$category = stripslashes($category);
		$category = mysql_real_escape_string($category);
		$image_url = stripslashes($image_url);
		$image_url = mysql_real_escape_string($image_url);
		$image_comment = stripslashes($image_comment);
		$image_comment = mysql_real_escape_string($image_comment);
		$link_1 = stripslashes($link_1);
		$link_1 = mysql_real_escape_string($link_1);
		$link_2 = stripslashes($link_2);
		$link_2 = mysql_real_escape_string($link_2);
		$link_3 = stripslashes($link_3);
		$link_3 = mysql_real_escape_string($link_3);
		
		
		$user_id =  $session->GetSessionValue('user_id');
					
		$query = __QUERY_INSERT_NEWS__;
		$query = $dbSetting->ReplaceParameter($query, '[0]', $user_id);
		$query = $dbSetting->ReplaceParameter($query, '[1]', $title);
		$query = $dbSetting->ReplaceParameter($query, '[2]', $subtitle);
		$query = $dbSetting->ReplaceParameter($query, '[3]', $summary);
		$query = $dbSetting->ReplaceParameter($query, '[4]', $subsummary);
		$query = $dbSetting->ReplaceParameter($query, '[5]', $image_url);
		$query = $dbSetting->ReplaceParameter($query, '[6]', $image_comment);
		$query = $dbSetting->ReplaceParameter($query, '[7]', $link_1);
		$query = $dbSetting->ReplaceParameter($query, '[8]', $link_2);
		$query = $dbSetting->ReplaceParameter($query, '[9]', $link_3);
		$query = $dbSetting->ReplaceParameter($query, '[10]', $category);
		$query = $dbSetting->ReplaceParameter($query, '[11]', 'NOW()');
		    			
		$rs = $dbSetting->ExecuteQuery($query);	
		
		echo "done";
   }
   catch (Exception $e)
   {
	  //echo $e;
	  echo "Error doing insert";
   }	
}

function UpdateNews($dbSetting,$session)
{
  //Check if the user is still login
  if($session->GetSessionValue('valid') != 'valid')
  {
	return 0;
  }
		
  try
  {	
		$news_id = urldecode($_GET["id"]);	 
		$title = urldecode($_GET["title"]);
		$subtitle = urldecode($_GET["subtitle"]);
		$summary = urldecode($_GET["summary"]);
		$subsummary = urldecode($_GET["subsummary"]);
		$category  = urldecode($_GET["category"]);
		$image_url = urldecode($_GET["image_url"]);
		$image_comment = urldecode($_GET["image_comment"]);
		$link_1 = urldecode($_GET["link_1"]);
		$link_2 = urldecode($_GET["link_2"]);
		$link_3 = urldecode($_GET["link_3"]);
		
		$news_id = stripslashes($news_id);
		$news_id = mysql_real_escape_string($news_id);
		$title = stripslashes($title);
		$title = mysql_real_escape_string($title);
		$subtitle = stripslashes($subtitle);
		$subtitle = mysql_real_escape_string($subtitle);
		$summary = stripslashes($summary);
		$summary = mysql_real_escape_string($summary);
		$subsummary = stripslashes($subsummary);
		$subsummary = mysql_real_escape_string($subsummary);
		$category = stripslashes($category);
		$category = mysql_real_escape_string($category);
		$image_url = stripslashes($image_url);
		$image_url = mysql_real_escape_string($image_url);
		$image_comment = stripslashes($image_comment);
		$image_comment = mysql_real_escape_string($image_comment);
		$link_1 = stripslashes($link_1);
		$link_1 = mysql_real_escape_string($link_1);
		$link_2 = stripslashes($link_2);
		$link_2 = mysql_real_escape_string($link_2);
		$link_3 = stripslashes($link_3);
		$link_3 = mysql_real_escape_string($link_3);
		

		$user_id =  $session->GetSessionValue('user_id');
					
		$query = __QUERY_UPDATE_NEWS__;
		$query = $dbSetting->ReplaceParameter($query, '[0]', $news_id);
		$query = $dbSetting->ReplaceParameter($query, '[1]', $title);
		$query = $dbSetting->ReplaceParameter($query, '[2]', $subtitle);
		$query = $dbSetting->ReplaceParameter($query, '[3]', $summary);
		$query = $dbSetting->ReplaceParameter($query, '[4]', $subsummary);
		$query = $dbSetting->ReplaceParameter($query, '[5]', $image_url);
		$query = $dbSetting->ReplaceParameter($query, '[6]', $image_comment);
		$query = $dbSetting->ReplaceParameter($query, '[7]', $link_1);
		$query = $dbSetting->ReplaceParameter($query, '[8]', $link_2);
		$query = $dbSetting->ReplaceParameter($query, '[9]', $link_3);
		$query = $dbSetting->ReplaceParameter($query, '[10]', $category);
				
		if($session->GetSessionValue('permission') != 2)
		{
			  $query = $query . " AND user_id=" . $user_id;
		}
		  			
		$rs = $dbSetting->ExecuteQuery($query);	
					
		echo "done";
   }
   catch (Exception $e)
   {
	  //echo $e;
	  echo "Error doing update";
   }	
}
?>