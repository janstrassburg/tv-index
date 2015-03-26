<?php

namespace JanStrassburg\TvIndex\Model\Entity;

use Assert;

class User extends AbstractEntity {

	/**
	 * @var int
	 */
	private $email;

	/**
	 * @var string
	 */
	private $password;

	/**
	 * @var string
	 */
	private $confirmPassword;

	/**
	 * @var string
	 */
	private $firstName;

	/**
	 * @var string
	 */
	private $lastName;

	/**
	 * @var string
	 */
	private $authToken;

	/**
	 * @return int
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @param int $email
	 */
	public function setEmail($email) {
		$this->email = trim($email);
	}

	/**
	 * @return int
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * @param int $password
	 */
	public function setPassword($password) {
		$this->password = $password;
	}

	/**
	 * @return string
	 */
	public function getConfirmPassword() {
		return $this->confirmPassword;
	}

	/**
	 * @param string $confirmPassword
	 */
	public function setConfirmPassword($confirmPassword) {
		$this->confirmPassword = $confirmPassword;
	}

	/**
	 * @return string
	 */
	public function getFirstName() {
		return $this->firstName;
	}

	/**
	 * @param string $firstName
	 */
	public function setFirstName($firstName) {
		$this->firstName = trim($firstName);
	}

	/**
	 * @return string
	 */
	public function getLastName() {
		return $this->lastName;
	}

	/**
	 * @param string $lastName
	 */
	public function setLastName($lastName) {
		$this->lastName = trim($lastName);
	}

	/**
	 * @return string
	 */
	public function getAuthToken() {
		return $this->authToken;
	}

	/**
	 * @param string $authToken
	 */
	public function setAuthToken($authToken) {
		$this->authToken = $authToken;
	}

	/**
	 * @return bool
	 */
	public function save() {
		if ($this->id) {
			$statement = $this->db->prepare(
				'UPDATE users SET ' .
				'email=:email,password=:password,first_name=:first_name,last_name=:last_name,auth_token=:auth_token' .
				' WHERE id = :id;'
			);
			$statement->bindParam(':id', $this->id);
			$statement->bindParam(':auth_token', $this->authToken);
		} else {
			if (!$this->validate()) {
				return false;
			}
			$statement = $this->db->prepare(
				'INSERT INTO users (email,password,first_name,last_name) ' .
				'VALUES (:email,:password,:first_name,:last_name);'
			);
			$this->password = password_hash($this->password, PASSWORD_DEFAULT);
		}

		$statement->bindParam(':email', $this->email);
		$statement->bindParam(':password', $this->password);
		$statement->bindParam(':first_name', $this->firstName);
		$statement->bindParam(':last_name', $this->lastName);
		return $statement->execute();
	}

	/**
	 * @return array
	 */
	public function toArray() {
		return [
			'id' => $this->getId(),
			'email' => $this->getEmail(),
			'password' => $this->getPassword(),
			'firstName' => $this->getFirstName(),
			'lastName' => $this->getLastName(),
			'authToken' => $this->getAuthToken()
		];
	}


	private function validate() {
		try {
			Assert\that($this->firstName)->notEmpty();
			Assert\that($this->lastName)->notEmpty();
			Assert\that($this->email)->email();
			Assert\that($this->password)->regex('/(?=^[^\s]{6,128}$)((?=.*?\d)(?=.*?[A-Z])(?=.*?[a-z])|(?=.*?\d)(?=.*' .
				'?[^\w\d\s])(?=.*?[a-z])|(?=.*?[^\w\d\s])(?=.*?[A-Z])(?=.*?[a-z])|(?=.*?\d)(?=.*?[A-Z])(?=.*?[^\w\d\s' .
				']))^.*/');
			Assert\that($this->confirmPassword)->same($this->password);
		} catch (Assert\AssertionFailedException $error) {
			return false;
		}
		return true;
	}
}
