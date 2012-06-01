<?php
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/

class Configuration
{
	var $mDsp;

	var $config_file = "../includes/config.inc.php";

	/**
	* Saves configuration to a file
	*
	* @param array $aConfigs modified configuration array
	*
	* @return bool
	*/
	function saveConfig($aConfigs)
	{
		global $gXpAdmin;

		$configs = $this->mergeConfig($aConfigs);

		/** now build string that will be written to config file **/
		$out_config = "<?php\n";
		foreach($configs as $key => $value)
		{
			/** writes to database **/
			$gXpAdmin->setParameterByName($key, addslashes($value));

			$out_config .= '$gXpConfig[\''.$key."'] = '".addslashes($value)."';\n";
		}
		$out_config .= "?>";
		
		/** write configuration to a file **/
		$f = fopen($this->config_file, 'w');
		if(!$f)
			return false;
		if (0 != get_magic_quotes_gpc())
		{
			$out_config = $out_config;
		}
		fwrite($f, $out_config);
		fclose($f);

		return true;
	}

	/**
	* Compares current config and changed one
	*
	* @param arr $aConfigs modified configuration array
	*
	* @return arr
	*/
	function mergeConfig($aConfigs)
	{
		global $gXpConfig;

		$merged = array_merge($gXpConfig, $aConfigs);
		
		foreach($merged as $key => $value)
		{
			$config[$key] = stripslashes($value);
		}

		return $config;
	}
	
}
