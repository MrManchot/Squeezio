<?php

namespace Sqz;

class SqueezioJpg extends Squeezio {
	
	public function getCommand() {
		# Jpegoptim
		$this->addCommand('jpegoptim ' . $this->squeezed_file . ' --strip-all -o  --m ' . $this->quality);
	}
	
}