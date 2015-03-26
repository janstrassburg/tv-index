<?php

namespace JanStrassburg\TvIndex\Controller;

use JanStrassburg\TvIndex\Model\Entity\User;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController {

	/**
	 * @param Request $request
	 * @param Application $app
	 * @return JsonResponse
	 */
	public function createAction(Request $request, Application $app) {
		$user = new User($app['db']);
		$user->setEmail($request->get('email'));
		$user->setPassword($request->get('password'));
		$user->setConfirmPassword($request->get('confirmPassword'));
		$user->setFirstName($request->get('firstName'));
		$user->setLastName($request->get('lastName'));
		return $app->json(array('success' => $user->save()));
	}

	/**
	 * @param Request $request
	 * @param Application $app
	 * @return JsonResponse
	 */
	public function loginAction(Request $request, Application $app) {
		return $app->json(
			$app['service.auth']->login(
				$request->get('email'),
				$request->get('password')
			)
		);
	}

}
