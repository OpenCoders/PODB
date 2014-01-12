<?php

namespace OpenCoders\Podb\Api;


use OpenCoders\Podb\Persistence\Doctrine;
use OpenCoders\Podb\Persistence\Repository\ProjectRepository;
use OpenCoders\Podb\Session\SessionManager;

abstract class AbstractBaseApi {

    /**
     * @var string EntityClassName (FQN)
     */
    protected $entityName;

    /**
     * @var string Api Version
     */
    protected $apiVersion = 'v1';

    /**
     * @var
     */
    private $em;

    function __construct()
    {
        $this->em = Doctrine::getEntityManager();
    }

    /**
     * Returns the ProjectsRepository
     * @return ProjectRepository
     */
    protected function getRepository()
    {
        $repository = $this->getEntityManager()->getRepository($this->entityName);
        return $repository;
    }

    /**
     * Returns the Singleton Instance of the EntityManger
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return $this->em;
    }

    /**
     * Returns the used API Version
     * @return string
     */
    protected function getApiVersion()
    {
        return $this->apiVersion;
    }

    /**
     * Returns true, if $value is an integer
     *
     * @param $value
     * @return bool
     */
    protected function isId($value)
    {
        return isset($value) && intval($value) != 0;
    }

    /**
     * Returns the Session
     *
     * @return \OpenCoders\Podb\Session\Session
     */
    protected function getSession() {
        $sm = new SessionManager();
        return $sm->getSession();
    }
}