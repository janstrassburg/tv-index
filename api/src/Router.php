<?php

namespace JanStrassburg\TvIndex;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class Router {

	public static function dispatch(Application $app) {
		$app->get('/search/{showName}', $app['ctrl']('trakt/search'));
		$app->post('/register', $app['ctrl']('user/create'));
		$app->post('/login', $app['ctrl']('user/login'));

		$app->get('/auth', function () use ($app) {
			return true;
		});

		$app->before(function (Request $request) use ($app) {

			if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
				$data = json_decode($request->getContent(), true);
				$request->request->replace(is_array($data) ? $data : array());
			}

			$user = null;
			if ($request->getPathInfo() != '/register' && $request->getPathInfo() != '/login') {
				if (!$user = $app['service.auth']->authenticate($request->headers->get('Auth'))) {
					return $app->json(array('authentication' => 'failed'));
				}
			}

			$app['user'] = $user;
			return true;
		});

	}

}
