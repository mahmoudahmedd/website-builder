<?php
class Skin 
{
	private $filename;

	public function __construct($filename) 
	{
		$this->filename = $filename;
	}
	
	public function make() 
	{
		global $configs;

		$file   = sprintf(ROOT . DS . "resources" . DS . "html" . DS . "%s.html", $this->filename);
		$fhSkin = fopen($file, 'r');
		$skin   = @fread($fhSkin, filesize($file));
		fclose($fhSkin);
		
		return $this->parse($skin);
	}
	
	public static function parse($skin) 
	{
		$skin = preg_replace_callback('/{\$([a-zA-Z0-9_]+)}/', 
				function($matches) 
				{
					global $themes;
					return (isset($themes[$matches[1]]) ? $themes[$matches[1]] : "");
				}, $skin);
	
		return $skin;
	}
}
?>