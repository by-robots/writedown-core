<?php

namespace ByRobots\WriteDown\Providers;

use ByRobots\WriteDown\API\API;
use ByRobots\WriteDown\API\MetaBuilder;
use ByRobots\WriteDown\API\ResponseBuilder;
use ByRobots\WriteDown\Auth\Auth;
use ByRobots\WriteDown\Auth\Token;
use ByRobots\WriteDown\CSRF\Hash;
use ByRobots\WriteDown\Database\DoctrineConfigBuilder;
use ByRobots\WriteDown\Database\DoctrineDriver;
use ByRobots\WriteDown\Http\Interfaces\ControllerInterface;
use ByRobots\WriteDown\Markdown\Markdown;
use ByRobots\WriteDown\Sessions\AuraSession;
use ByRobots\WriteDown\Slugs\Slugger;
use ByRobots\WriteDown\Validator\ByRobots;
use ByRobots\WriteDown\Validator\Rules\Exists;
use ByRobots\WriteDown\Validator\Rules\Unique;
use ByRobots\WriteDown\Validator\Rules\ValidSlug;
use ByRobots\WriteDown\Validator\ValidatorInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;

/**
 * Registers all our services.
 *
 * I did have service split up in category type classes, but ultimately found
 * that a bit confusing as some categorisations were a bit nebulous.
 */
class WriteDownServiceProvider extends AbstractServiceProvider
{
    /**
     * Services provided by the service provider.
     *
     * @var array
     */
    protected $provides = [
        'api',
        'auth',
        'csrf',
        'emitter',
        'entityManager',
        'markdown',
        'metaBuilder',
        'request',
        'responseBuilder',
        'session',
        'slugger',
        'validation',
    ];

    /**
     * Register providers into the container.
     */
    public function register()
    {
        $this->api();
        $this->auth();
        $this->controller();
        $this->csrf();
        $this->emitter();
        $this->entityManager();
        $this->markdown();
        $this->metaBuilder();
        $this->request();
        $this->responseBuilder();
        $this->session();
        $this->slugger();
        $this->validation();
    }

    /**
     * The following are a series of emthods that add services to the container.
     */
    private function api()
    {
        $this->getContainer()
            ->add('api', API::class)
            ->withArgument('entityManager')
            ->withArgument('responseBuilder')
            ->withArgument('validation');
    }

    private function auth()
    {
        $this->getContainer()
            ->add('auth', Auth::class)
            ->withArgument('entityManager');
    }

    private function csrf()
    {
        $this->getContainer()
            ->share('csrf', Hash::class)
            ->withArgument('session')
            ->withArgument(new Token);
    }

    private function controller()
    {
        $this->getContainer()
            ->inflector(ControllerInterface::class)
            ->invokeMethod('setRequest', ['request']);
    }

    private function emitter()
    {
        $this->getContainer()->add('emitter', SapiEmitter::class);
    }

    private function entityManager()
    {
        $this->getContainer()
            ->add('entityManager', function() {
                $configBuilder = new DoctrineConfigBuilder;
                $database      = new DoctrineDriver($configBuilder->generate());
                return $database->getManager();
            });
    }

    private function markdown()
    {
        $this->getContainer()->add('markdown', Markdown::class);
    }

    private function metaBuilder()
    {
        $this->getContainer()->add('metaBuilder', MetaBuilder::class);
    }

    private function request()
    {
        $this->getContainer()->add('request', function() {
            return ServerRequestFactory::fromGlobals(
                $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
            );
        });
    }

    private function responseBuilder()
    {
        $this->getContainer()
            ->add('responseBuilder', ResponseBuilder::class)
            ->withArgument('metaBuilder');
    }

    private function session()
    {
        $this->getContainer()->share('session', AuraSession::class);
    }

    private function slugger()
    {
        $this->getContainer()
            ->add('slugger', Slugger::class)
            ->withArgument('entityManager');
    }

    private function validation()
    {
        $this->getContainer()->add('validation', ByRobots::class);

        // Add custom validation rules.
        $this->getContainer()
            ->inflector(ValidatorInterface::class)
            ->invokeMethod('addRules', [[
                new Exists($this->getContainer()->get('entityManager')),
                new Unique($this->getContainer()->get('entityManager')),
                new ValidSlug($this->getContainer()->get('slugger')),
            ]]);
    }
}
