<?php

namespace JanStrassburg\TvIndex\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class TraktController {

	/**
	 * @param Request $request
	 * @param Application $app
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function searchAction(Request $request, Application $app) {
		return $app->json($app['service.trakt']->search($request->get('showName')));
	}

}
