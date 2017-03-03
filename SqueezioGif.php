<?php

namespace Sqz;

class SqueezioGif extends Squeezio {
	
	public function getCommand() {
		$this->addCommand('gifsicle ' . $this->squeezed_file . ' -o ' . $this->squeezed_file . ' -O3');
	}
	
}