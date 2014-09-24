<?php
class Logging 
{
	private $logPath = "logs/";
	private $logFileName = "";
	private $logMaxSize = 1048576; // max log size before it is truncated
	private $fp = NULL;
	
	function __construct($logFileName) 
	{
		if(!empty($logFileName))
		{
			$this->logFileName = $logFileName;
			$full_path = $this->logPath."".$logFileName;
			if(file_exists($full_path))
			{
				$this->fh = fopen($full_path, "a+");
				return true;
			}
			else
			{
				return false;
			}
			
		}
		
		
	}
	function write($the_string)
	{
		if($the_string <> "")
		{
			fputs( $this->fh, $the_string, strlen($the_string));
			fclose( $this->fh );
			return( true );
		}
		else
		{
			return( false );
		}
	}
	
	/**
	 * Trigger Error
	 *
	 * Use PHP error handling to trigger User Errors or Notices.  If logging is enabled, errors will be written to the log as well.
	 * Disable on screen errors by setting showErrors to false;
	 *
	 * @param string $error Error String
	 * @param int $type Type of Error to Trigger
	 * @access private
	 */
	private function _triggerError($error, $type=E_USER_NOTICE){
		$backtrace = debug_backtrace();
		$backtrace = array_reverse($backtrace);
		$error .= "\n";
		$i=1;
		foreach($backtrace as $errorcode){
			$file = ($errorcode['file']!='') ? "-> File: ".basename($errorcode['file'])." (line ".$errorcode['line'].")":"";
			$error .= "\n\t".$i.") ".$errorcode['class']."::".$errorcode['function']." {$file}";
			$i++;
		}
		$error .= "\n\n";
		if($this->logErrors && file_exists($this->logPath)){
			if(filesize($this->logPath) > $this->logMaxSize) $fh = fopen($this->logPath, 'w');
			else $fh = fopen($this->logPath, 'a');
			fwrite($fh, $error);
			fclose($fh);
		}
		if($this->showErrors) trigger_error($error, $type);
	}
}
?>