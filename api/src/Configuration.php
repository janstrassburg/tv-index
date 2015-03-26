<?php

namespace JanStrassburg\TvIndex;

class Configuration {

	/**
	 * @var array
	 */
	private static $conf;

	/**
	 * @return array
	 */
	public static function get() {
		if (!self::$conf) {
			self::$conf = array();
			$configDir = APP_DIR . '/config/';
			$files = scandir($configDir);
			foreach ($files as $file) {
				if (substr($file, -4) == '.php') {
					$tempConfigArray = require($configDir . $file);
					$key = str_replace('.php', '', $file);
					if (isset($tempConfigArray['default'])) {
						self::$conf[$key] = $tempConfigArray['default'];
					}
					if ($_SERVER['ENVIRONMENT'] == 'dev' && isset($tempConfigArray['dev'])) {
						self::$conf[$key] = array_replace_recursive(self::$conf[$key], $tempConfigArray['dev']);
					}
					if (is_file($configDir . 'passwords/' . $file)) {
						self::$conf[$key] = array_merge(
							self::$conf[$key], require($configDir . 'passwords/' . $file)
						);
					}
				}
			}
		}

		return self::$conf;
	}

}
