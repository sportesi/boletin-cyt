<?php	
	session_start();
	
	$session = new Session($_SESSION);

class Session
{
	private $_session;
	
	public function __construct($currentSession)
	{
		$this->_session = $currentSession;
	}
	
	function SetSessionValue($key,$value)
	{
		$this->_session[$key] = $value;
	}
	
	function GetSessionValue($key)
	{
		$validKey = FALSE;
		
		foreach ($this->_session as $originalkey => $value) 
		{				
			if($originalkey == $key) 
			{
				$validKey = TRUE; 
			}
		}
		
		return $validKey ? $this->_session[$key] : '';
	}
}	

?>