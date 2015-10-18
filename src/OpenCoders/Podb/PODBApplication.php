<?php

namespace OpenCoders\Podb;

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Knp\Console\ConsoleEvent;
use Knp\Console\ConsoleEvents;
use Knp\Provider\ConsoleServiceProvider;
use OpenCoders\Podb\Api\APIv1ControllerProvider;
use OpenCoders\Podb\Api\ResourceControllerProvider;
use OpenCoders\Podb\Console\CreateInitialUserCommand;
use OpenCoders\Podb\Persistence\AuditServiceProvider;
use OpenCoders\Podb\Persistence\DoctrineORMServiceProvider;
use OpenCoders\Podb\Security\PODBSecurityServiceProvider;
use OpenCoders\Podb\Web\ControllerProvider;
use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Symfony\Component\Console\Helper\HelperSet;

class PODBApplication extends Application
{
    /**
     * @param array $values
     */
    public function __construct(array $values = array())
    {
        parent::__construct($values);

        // Silex provider
        $this->register(new SessionServiceProvider());
        $this->register(new ServiceControllerServiceProvider());
        $this->register(new UrlGeneratorServiceProvider());

        $this->register(new SwiftmailerServiceProvider());
        $this->register(new DoctrineServiceProvider());
        $this->register(new TwigServiceProvider());
        $this->register(new MonologServiceProvider());
        // TODO security
        $this->register(new SecurityServiceProvider());
        // TODO remember me

        // Potential third party service provider
        $this->register(new DoctrineORMServiceProvider());
        $this->register(new AuditServiceProvider());
        $this->register(new RequestRateLimitServiceProvider());
        $this->register(new RequestJsonFormatServiceProvider());


        // Service provider
        $this->register(new PODBSecurityServiceProvider());
        $this->register(new PODBServiceProvider());
        $this->register(new UserServiceProvider());
        $this->register(new ProjectServiceProvider());
        $this->register(new LanguageServiceProvider());
        $this->register(new MessageServiceProvider());
        $this->register(new TranslationServiceProvider());
        $this->register(new DomainServiceProvider());

        $this->register(new AuthenticationServiceProvider());

        $this->register(new ErrorHandlerServiceProvider());

        // Page controller
        $this->mount('', new ControllerProvider());
        // TODO login page
        // TODO register page
        // TODO profile page
        // TODO project page
        // TODO ...

        // API controller
        $this->mount('api', new ResourceControllerProvider());
        $this->mount('api/v1', new APIv1ControllerProvider());
        // TODO version concept

        foreach ($values as $key => $value) {
            $this[$key] = $value;
        }

        $this->initCli();
    }

    private function initCli()
    {
        $this->register(new ConsoleServiceProvider());
        $this['dispatcher']->addListener(ConsoleEvents::INIT, function (ConsoleEvent $event) {
            $console = $event->getApplication();
            $console->setHelperSet(ConsoleRunner::createHelperSet($console->getSilexApplication()->offsetGet('orm')));
            ConsoleRunner::addCommands($console);
            
            $console->add(new CreateInitialUserCommand());
        });
    }

    public function runCli()
    {
        $this['console']->run();
    }
}
