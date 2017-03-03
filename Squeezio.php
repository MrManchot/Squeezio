<?php

/*
 * TODO :
 * Psd / Raw / tiff ...
 * Si gif pas anime => png ?
 * Test du md5file
 * allowedfileextensions: ['.jpg','.jpeg','.png','.gif']
 * Au changement de valeur du formulaire, on re-execute
 * Affichage des champs en fonction du format
 */

namespace Sqz;

use SplFileInfo;

class Squeezio
{
	
	public $file;
	public $squeezed_file;
	public $infos;
	public $cmd;
	public $errors;
	
	protected $force = true;
	protected $quality = null;
	protected $quality_max = null;
	protected $progressive = false;
	
	private static $extensionAlias = array(
		'jpeg' => 'jpg'
	);
	
	public function __construct($file = null, $squeezed_file = null)
	{
		if (!is_null($file)) {
			$this->file = $file;
			@chmod($this->file, 0777);
			$this->squeezed_file = is_null($squeezed_file) ? dirname($this->file) . '/squeezed_' . basename($file) : $squeezed_file;
			copy($this->file, $this->squeezed_file);
			@chmod($this->squeezed_file, 0777);
		}
	}
	
	public static function getExtension($file)
	{
		$info      = new SplFileInfo($file);
		$extension = $info->getExtension();
		
		return array_key_exists($extension, self::$extensionAlias) ? self::$extensionAlias[$extension] : $extension;
	}
	
	public static function getInstance($file, $squeezed_file = null)
	{
		$ext   = self::getExtension($file);
		$class = 'Squeezio' . ucfirst($ext);
		if (file_exists(__DIR__ . '/' . $class . '.php')) {
			$className = 'Sqz\\' . $class;
			
			return new $className($file, $squeezed_file);
		} else {
			$sqz = new Squeezio();
			$sqz->setError('Squeeze can\'t handle this type of file : ' . $ext);
			
			return $sqz;
		}
	}
	
	public function exec()
	{
		$this->getCommand();
		if ($this->cmd) {
			exec($this->cmd);
		}
		$this->getInfos();
	}
	
	public static function getFormatSize($bytes, $decimals = 1)
	{
		$size   = array('b', 'ko', 'Mo');
		$factor = floor((strlen($bytes) - 1) / 3);
		
		return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[(int)$factor];
	}
	
	public function getCommand()
	{
	}
	
	public function setQuality($min, $max = null)
	{
		if ($min >= 0 && $min <= 100) {
			$this->quality = $min;
		}
		if ($max && $max >= 0 && $max <= 100 && $max > $this->quality) {
			$this->quality_max = $max;
		}
	}
	
	public function setSize($w, $h = null, $crop = false)
	{
		if (!$h) {
			$h = $w;
		}
		
		$size = getimagesize($this->file);
		if ($w > $size[0] && $h > $size[1]) {
			return false;
		}
		
		$cmd = 'convert ' . $this->squeezed_file . ' -resize ' . $w . 'x' . $h;
		if ($crop) {
			$cmd .= '^ -gravity center -extent ' . $w . 'x' . $h;
		}
		$cmd .= ' ' . $this->squeezed_file;
		$this->addCommand($cmd);
	}
	
	protected function addCommand($cmd)
	{
		$this->cmd .= $cmd . ';' . "\n";
	}
	
	protected function getInfos()
	{
		
		if (!empty($this->errors)) {
			$this->infos = array('errors' => $this->errors);
		} else {
			$original_size = filesize($this->file);
			$new_size      = filesize($this->squeezed_file);
			$saved_size    = $original_size - $new_size;
			$percent_saved = 100 - ((100 * $new_size) / $original_size);
			$this->infos   = array(
				'original_size' => $original_size,
				'new_size'      => self::getFormatSize($new_size),
				'saved_size'    => self::getFormatSize($saved_size),
				'saved_percent' => round($percent_saved, 2),
				'file'          => basename($this->file),
				'squeezed_file' => basename($this->squeezed_file)
			);
		}
	}
	
	public function setError($error)
	{
		$this->errors[] = $error;
	}
	
}