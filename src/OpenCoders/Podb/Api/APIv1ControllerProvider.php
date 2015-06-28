<?php

namespace OpenCoders\Podb\Api;


use OpenCoders\Podb\PODBServices;
use OpenCoders\Podb\REST\v1\json\AuditController;
use OpenCoders\Podb\REST\v1\json\AuthenticationController;
use OpenCoders\Podb\REST\v1\json\LanguageController;
use OpenCoders\Podb\REST\v1\json\ProjectController;
use OpenCoders\Podb\REST\v1\json\TranslationController;
use OpenCoders\Podb\REST\v1\json\UserController;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;

class APIv1ControllerProvider implements ControllerProviderInterface
{

    /**
     * Returns routes to connect to the given application.
     *
     * @param Application $app An Application instance
     *
     * @return ControllerCollection A ControllerCollection instance
     */
    public function connect(Application $app)
    {
        $app[APIServices::V1_USER_CONTROLLER] = $app->share(function ($app) {
            return new UserController($app, $app[PODBServices::USER_REPOSITORY], $app['authentication']);
        });

        $app[APIServices::V1_PROJECT_CONTROLLER] = $app->share(function ($app) {
            return new ProjectController($app, $app[PODBServices::PROJECT_REPOSITORY], $app['authentication']);
        });

        $app[APIServices::V1_LANGUAGE_CONTROLLER] = $app->share(function ($app) {
            return new LanguageController($app, $app[PODBServices::LANGUAGE_REPOSITORY], $app['authentication']);
        });

        $app[APIServices::V1_TRANSLATION_CONTROLLER] = $app->share(function ($app) {
            return new TranslationController($app, $app[PODBServices::TRANSLATION_REPOSITORY], $app['authentication']);
        });

        $app[APIServices::V1_AUDIT_CONTROLLER] = $app->share(function ($app) {
            return new AuditController($app['audit.revision.manager']);
        });

        $app[APIServices::V1_AUTHENTICATION_CONTROLLER] = $app->share(function ($app) {
            return new AuthenticationController($app, $app['authentication']);
        });


        /** @var ControllerCollection $collection */
        $collection = $app[PODBServices::CONTROLLER_FACTORY];


        $collection->get('/user', APIServices::V1_USER_CONTROLLER . ':getList')->bind('rest.v1.json.user.list');
        $collection->get('/user/{userName}', APIServices::V1_USER_CONTROLLER . ':get')->bind('rest.v1.json.user.get');
        $collection->get('/user/{userName}/projects', APIServices::V1_USER_CONTROLLER . ':getProjects')->bind('rest.v1.json.user.project.list');
        $collection->get('/user/{userName}/own/projects', APIServices::V1_USER_CONTROLLER . ':getOwnedProjects')
            ->bind('rest.v1.json.user.own.project.list');
        $collection->get('/user/{userName}/languages', APIServices::V1_USER_CONTROLLER . ':getLanguages')->bind('rest.v1.json.user.language.list');
        $collection->get('/user/{userName}/translations', APIServices::V1_USER_CONTROLLER . ':getTranslations')
            ->bind('rest.v1.json.user.translation.list');

        $collection->post('/user/register', APIServices::V1_USER_CONTROLLER . ':register')->bind('rest.v1.json.user.register');
        $collection->post('/user', APIServices::V1_USER_CONTROLLER . ':post')->bind('rest.v1.json.user.create');
        $collection->put('/user/{id}', APIServices::V1_USER_CONTROLLER . ':put')->bind('rest.v1.json.user.update');
        $collection->delete('/user/{id}', APIServices::V1_USER_CONTROLLER . ':delete')->bind('rest.v1.json.user.delete');


        $collection->get('/project', APIServices::V1_PROJECT_CONTROLLER . ':getList')->bind('rest.v1.json.project.list');
        $collection->get('/project/{projectName}', APIServices::V1_PROJECT_CONTROLLER . ':get')->bind('rest.v1.json.project.get');
        $collection->get('/project/{projectName}/contributors', APIServices::V1_PROJECT_CONTROLLER . ':getContributors')
            ->bind('rest.v1.json.project.contributor.list');
        $collection->get('/project/{projectName}/categories', APIServices::V1_PROJECT_CONTROLLER . ':getCategories')
            ->bind('rest.v1.json.project.category.list');
        $collection->get('/project/{projectName}/languages', APIServices::V1_PROJECT_CONTROLLER . ':getLanguages')
            ->bind('rest.v1.json.project.language.list');

        $collection->post('/project', APIServices::V1_PROJECT_CONTROLLER . ':post')->bind('rest.v1.json.project.create');
        $collection->put('/project/{id}', APIServices::V1_PROJECT_CONTROLLER . ':put')->bind('rest.v1.json.project.update');
        $collection->delete('/project/{id}', APIServices::V1_PROJECT_CONTROLLER . ':delete')->bind('rest.v1.json.project.delete');


        $collection->get('/language', APIServices::V1_LANGUAGE_CONTROLLER . ':getList')->bind('rest.v1.json.language.list');
        $collection->get('/language/{locale}', APIServices::V1_LANGUAGE_CONTROLLER . ':get')->bind('rest.v1.json.language.get');
        $collection->get('/language/{locale}/supporter', APIServices::V1_LANGUAGE_CONTROLLER . ':getSupporters')
            ->bind('rest.v1.json.language.supporter.list');

        $collection->post('/language', APIServices::V1_LANGUAGE_CONTROLLER . ':post')->bind('rest.v1.json.language.create');
        $collection->put('/language/{id}', APIServices::V1_LANGUAGE_CONTROLLER . ':put')->bind('rest.v1.json.language.update');
        $collection->delete('/language/{id}', APIServices::V1_LANGUAGE_CONTROLLER . ':delete')->bind('rest.v1.json.language.delete');


        $collection->get('/translation', APIServices::V1_TRANSLATION_CONTROLLER . ':getList')->bind('rest.v1.json.translation.list');
        $collection->get('/translation/{id}', APIServices::V1_TRANSLATION_CONTROLLER . ':get')->bind('rest.v1.json.translation.get');

        $collection->post('/translation', APIServices::V1_TRANSLATION_CONTROLLER . ':post')->bind('rest.v1.json.translation.create');
        $collection->put('/translation/{id}', APIServices::V1_TRANSLATION_CONTROLLER . ':put')->bind('rest.v1.json.translation.update');
        $collection->delete('/translation/{id}', APIServices::V1_TRANSLATION_CONTROLLER . ':delete')->bind('rest.v1.json.translation.delete');


        $collection->get('/audit', APIServices::V1_AUDIT_CONTROLLER . ':getList');
        $collection->get('/audit/entity/{className}/{id}/revision', APIServices::V1_AUDIT_CONTROLLER . ':getEntityRevisions');
        $collection->get('/audit/entity/{className}/{id}/revision/first', APIServices::V1_AUDIT_CONTROLLER . ':getFirstRevision');
        $collection->get('/audit/entity/{className}/{id}/revision/current', APIServices::V1_AUDIT_CONTROLLER . ':getCurrentRevision');
        $collection->get('/audit/entity/{className}/{id}/diff/{oldRevisionId}/{newRevisionId}', APIServices::V1_AUDIT_CONTROLLER . ':getDiff');


        $collection->post('/authentication/login', APIServices::V1_AUTHENTICATION_CONTROLLER . ':login')
            ->bind('rest.v1.json.authentication.login');
        $collection->post('/authentication/logout', APIServices::V1_AUTHENTICATION_CONTROLLER . ':logout')
            ->bind('rest.v1.json.authentication.logout');
        $collection->get('/authentication/isLoggedIn', APIServices::V1_AUTHENTICATION_CONTROLLER . ':isLoggedIn')
            ->bind('rest.v1.json.authentication.isLoggedIn');

        $collection->get('/authentication/lock', APIServices::V1_AUTHENTICATION_CONTROLLER . ':lock')
            ->bind(APIServices::V1_AUTHENTICATION_CONTROLLER . ':lock');
        $collection->get('/authentication/unlock', APIServices::V1_AUTHENTICATION_CONTROLLER . ':unlock')
            ->bind(APIServices::V1_AUTHENTICATION_CONTROLLER . ':unlock');

        return $collection;
    }
}