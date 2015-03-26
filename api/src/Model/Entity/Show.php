<?php

namespace JanStrassburg\TvIndex\Model\Entity;

class Show extends AbstractEntity {

	/**
	 * @var string
	 */
	private $title;

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * @return string
	 */
	public function toArray() {
		return array(
			'id' => $this->getId(),
			'title' => $this->getTitle()
		);
	}

}
