<?php

class scss_compass {
	protected $libFunctions = array("lib_compact");

	static public $true = array("keyword", "true");
	static public $false = array("keyword", "false");

	public function __construct($scss) {
		$this->scss = $scss;
		$this->updateImportPath();
		$this->registerFunctions();
	}

	protected function updateImportPath() {
		$this->scss->addImportPath(__DIR__ . "/stylesheets/");
	}

	protected function registerFunctions() {
		foreach ($this->libFunctions as $fn) {
			$registerName = $fn;
			if (preg_match('/^lib_(.*)$/', $fn, $m)) {
				$registerName = $m[1];
			}
			$this->scss->registerFunction($registerName, array($this, $fn));
		}
	}

	public function lib_compact($args) {
		$list = $args;
		$separator = ',';
		$filtered = array();

		if (count($args) == 1 && $args[0][0] == 'list') {
			$list = $args[0][2];
			$separator = $args[0][1];
		}

		foreach ($list as $item) {
			if ($item != self::$false) {
				$filtered[] = $item;
			}
		}

		return array('list', $separator, $filtered);
	}
}

