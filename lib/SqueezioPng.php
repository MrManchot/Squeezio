<?php

namespace Sqz;

class SqueezioPng extends Squeezio {
	
	public function getCommand() {
		$this->addCommand(
			'pngquant ' . $this->squeezed_file .' -o ' . $this->squeezed_file.' --force'.
			($this->quality && $this->quality_max ? ' --quality=' . $this->quality . '-' . $this->quality_max : '')
		);
	}
	
}
