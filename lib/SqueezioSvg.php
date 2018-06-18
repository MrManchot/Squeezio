<?php

namespace Sqz;

class SqueezioSvg extends Squeezio {
	
	public function getCommand() {
		$this->addCommand('svgo ' . $this->squeezed_file . ' ' . $this->squeezed_file);
	}
	
	public function setSize( $w, $h = null, $crop = false ) {
		return false;
	}
	
}
