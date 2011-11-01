<?php
namespace Dazibao\Provider\Service;

use Silex\Application;
use Silex\ServiceProviderInterface;

class RepositoryServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app->before(function() use ($app) {
            foreach ($app['repository.definitions'] as $label => $class) {
                $app["repository.$label"] = $app->share(function() use ($class, $app) {
                   return new $class($app['db']);
                });
            }
        });
    }
}
