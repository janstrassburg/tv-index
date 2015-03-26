<?php

namespace JanStrassburg\TvIndex\Model\Entity;

abstract class AbstractEntity {

	/**
	 * @var \PDO
	 */
	protected $db;

	/**
	 * @var int
	 */
	protected $id;

	/**
	 * @param \PDO $db
	 * @param array $array
	 */
	public function __construct(\PDO $db, $array = null) {
		$this->db = $db;
		if ($array) {
			$this->map($array);
		}
	}

	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param int $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @param array $array
	 */
	private function map($array) {
		foreach ($array as $propertyName => $value) {
			$setterName = 'set' . $this->snakeToCamel($propertyName);
			$this->$setterName($value);
		}
	}

	/**
	 * @param string $string
	 * @param bool $firstCharCaps
	 * @return string
	 */
	function snakeToCamel($string, $firstCharCaps = false) {
		if ($firstCharCaps == true) {
			$string[0] = strtoupper($string[0]);
		}
		$func = create_function('$c', 'return strtoupper($c[1]);');
		return preg_replace_callback('/_([a-z])/', $func, $string);
	}

}
