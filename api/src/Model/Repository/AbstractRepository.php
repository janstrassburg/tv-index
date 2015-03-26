<?php

namespace JanStrassburg\TvIndex\Model\Repository;

abstract class AbstractRepository {

	/**
	 * @var \PDO
	 */
	protected $db;

	/**
	 * @param \PDO $db
	 */
	public function __construct(\PDO $db) {
		$this->db = $db;
	}

}
