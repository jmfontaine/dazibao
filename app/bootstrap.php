<?php
use Dazibao\Dazibao;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\SymfonyBridgesServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Dazibao\Provider\Service\RepositoryServiceProvider;

require_once __DIR__ . '/../vendor/silex/autoload.php';

$app = new Silex\Application();

$app['autoloader']->registerNamespaces(array(
    'Dazibao'          => __DIR__ . '/../src',
    'Doctrine\\Common' => __DIR__ . '/../vendor/doctrine-common/lib',
    'Symfony'          => __DIR__ . '/../vendor/',
));

$app->register(new DoctrineServiceProvider(), array(
    'db.dbal.class_path'    => __DIR__.'/../vendor/doctrine-dbal/lib',
    'db.common.class_path'  => __DIR__.'/../vendor/doctrine-common/lib',
));

$app->register(new TwigServiceProvider(), array(
    'twig.path'       => array(__DIR__ . '/../src/Resources/views'),
    'twig.class_path' => __DIR__.'/../vendor/silex/vendor/twig/lib',
));

$app->register(new SymfonyBridgesServiceProvider());
$app->register(new UrlGeneratorServiceProvider());

$app->register(new RepositoryServiceProvider(), array('repository.definitions' => array(
    'project' => 'Dazibao\\Repository\\ProjectRepository',
)));

if (!file_exists(__DIR__ . '/config.php')) {
    throw new RuntimeException('You must create your own configuration file ("src/config.php"). See "src/config.php.dist" for an example config file.');
}

require_once __DIR__ . '/config.php';

return $app;
