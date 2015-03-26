<?php

namespace JanStrassburg\TvIndex;

use JanStrassburg\TvIndex\Model\Repository\UserRepository;
use JanStrassburg\TvIndex\Provider\ControllerProvider;
use Silex\Application;
use JanStrassburg\TvIndex\Service\Authentication;
use JanStrassburg\TvIndex\Service\Trakt;

class App {

	public static function run() {
		$app = new Application();

		if ($_SERVER['ENVIRONMENT'] == 'dev') {
			$app['debug'] = true;
		}

		$app['config'] = Configuration::get();

		$app['db'] = $app->share(function ($app) {
			$db = $app['config']['db'];
			return new \PDO(
				'mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'] . ';charset=utf8',
				$db['username'],
				$db['password']
			);
		});

		$app->register(new ControllerProvider());

		$app['service.trakt'] = $app->share(function ($app) {
			return new Trakt($app['config']['trakt']);
		});

		$app['service.auth'] = $app->share(function ($app) {
			return new Authentication(new UserRepository($app['db']));
		});

		Router::dispatch($app);
		$app->run();
	}
}
