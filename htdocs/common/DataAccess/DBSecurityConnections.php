<?php	
	require_once(__ROOT__.'/common/dataAccess/BDSettings.php'); 
	
	$dbInformation = new DBInformation("127.0.0.1","ees_db","ees_uai","QERA7854");
	$dbSetting = new DBSetting($dbInformation);
	
?>


