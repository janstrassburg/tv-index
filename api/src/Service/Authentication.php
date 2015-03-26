<?php

namespace JanStrassburg\TvIndex\Service;

use JanStrassburg\TvIndex\Model\Repository\UserRepository;

class Authentication {

	/**
	 * @var UserRepository
	 */
	private $userRepository;

	/**
	 * @param UserRepository $userRepository
	 */
	public function __construct(UserRepository $userRepository) {
		$this->userRepository = $userRepository;
	}

	/**
	 * @param string $email
	 * @param string $password
	 * @return array
	 */
	public function login($email, $password) {
		if ($user = $this->userRepository->findByEmail($email, $password)) {
			$key = sha1(rand());
			$user->setAuthToken(sha1($key));
			$user->save();
			return [
				'success' => true,
				'auth' => [
					'user' => $user->getId(),
					'key' => $key
				]
			];
		}
		return ['success' => false];
	}

	/**
	 * @param string $credentials
	 * @return bool
	 */
	public function authenticate($credentials) {
		$credentials = json_decode($credentials, 'true');
		if (is_array($credentials) && array_key_exists('key', $credentials)) {
			if ($user = $this->userRepository->findById((int)$credentials['user'])) {
				if (sha1($credentials['key']) == $user->getAuthToken()) {
					return $user;
				}
			}
		}
		return false;
	}

}
