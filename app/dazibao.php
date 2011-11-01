<?php
use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

$app = require_once __DIR__ . '/bootstrap.php';

$app->get('/', function(Application $app) {
    return $app['twig']->render(
        'projects.twig',
        array('projects' => $app['repository.project']->findAll())
    );
})->bind('projects');

$app->get('/project/{slug}', function(Application $app, $slug) {
    return $app['twig']->render(
        'project.twig',
        array('project' => $app['repository.project']->findBySlug($slug))
    );
})->bind('project');

$app->error(function (\Exception $exception, $code) use ($app) {
    // Display nice debug page if in debug mode
    if ($app['debug']) {
        return;
    }

    switch ($code) {
        case 404:
            $message = 'The requested page could not be found.';
            break;
        default:
            $message = 'We are sorry, but something went terribly wrong.';
    }

    return new Response($message, $code);
});

return $app;
