<?php

namespace JanStrassburg\TvIndex\Model\Repository;

use JanStrassburg\TvIndex\Model\Entity\User;

class UserRepository extends AbstractRepository {

	/**
	 * @param int $id
	 * @return bool|User
	 */
	public function findById($id) {
		$statement = $this->db->prepare('SELECT * FROM users WHERE id = :id LIMIT 1;');
		$statement->bindParam(':id', $id);
		$statement->execute();
		$result = $statement->fetch(\PDO::FETCH_ASSOC);
		if ($result) {
			return new User($this->db, $result);
		}
		return false;
	}

	/**
	 * @param string $email
	 * @param string $password
	 * @return bool|User
	 */
	public function findByEmail($email, $password) {
		if ($email) {
			$statement = $this->db->prepare('SELECT * FROM users WHERE email = :email LIMIT 1;');
			$statement->bindParam(':email', $email);
			$statement->execute();
			$result = $statement->fetch(\PDO::FETCH_ASSOC);
			if ($result && password_verify($password, $result['password'])) {
				return new User($this->db, $result);
			}
		}
		return false;
	}

	/**
	 * @param $authToken
	 * @return bool|User
	 */
	public function findByAuthToken($authToken) {
		$statement = $this->db->prepare('SELECT * FROM users WHERE auth_token = :auth_token LIMIT 1;');
		$statement->bindParam(':auth_token', $authToken);
		$statement->execute();
		if ($result = $statement->fetch(\PDO::FETCH_ASSOC)) {
			return new User($this->db, $result);
		}
		return false;
	}

}
