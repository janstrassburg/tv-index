<?php

namespace JanStrassburg\TvIndex\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

class ControllerProvider implements ServiceProviderInterface {

	/**
	 * @param Application $app
	 */
	public function register(Application $app) {
		$app['ctrl'] = $app->protect(function ($shortName) use ($app) {
			list($shortClass, $shortMethod) = explode('/', $shortName, 2);
			return sprintf(
				'JanStrassburg\TvIndex\Controller\%sController::%sAction',
				ucfirst($shortClass), $shortMethod
			);
		});
	}

	/**
	 * @param Application $app
	 */
	public function boot(Application $app) {
	}
}
