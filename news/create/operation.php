<?php

  //Important need to be defined in the top page required pages
  define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);
  
  require_once(__ROOT__.'/common/session/Session.php'); 
  require_once(__ROOT__.'/common/DataAccess/DBSecurityConnections.php');

  define('__QUERY_INSERT_NEWS__', "INSERT INTO 
  										  news(
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

  define('__QUERY_UPDATE_NEWS__',"UPDATE news SET  
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
      $title = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "title"));
      $subtitle = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "subtitle"));
      $summary = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "summary"));
      $subsummary = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "subsummary"));
      $category  = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "category"));
      $image_url = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "image_url"));
      $image_comment = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "image_comment"));
      $link_1 = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "link_1"));
      $link_2 = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "link_2"));
      $link_3 = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "link_3"));

      $user_id = $session->GetSessionValue('user_id');

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
      $news_id = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "id"));
      $title = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "title"));
      $subtitle = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "subtitle"));
      $summary = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "summary"));
      $subsummary = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "subsummary"));
      $category  = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "category"));
      $image_url = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "image_url"));
      $image_comment = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "image_comment"));
      $link_1 = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "link_1"));
      $link_2 = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "link_2"));
      $link_3 = DBInformation::mysql_escape_mimic(filter_input(INPUT_GET, "link_3"));

      $user_id = $session->GetSessionValue('user_id');

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

      if ($session->GetSessionValue('permission') != 2) {
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