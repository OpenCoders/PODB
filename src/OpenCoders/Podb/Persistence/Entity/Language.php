<?php

namespace OpenCoders\Podb\Persistence\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use OpenCoders\Podb\Exception\EmptyParameterException;
use OpenCoders\Podb\Exception\PodbException;

/**
 * Class Language
 * @package OpenCoders\Podb\Persistence\Entity
 * @Entity(repositoryClass="OpenCoders\Podb\Persistence\Repository\LanguageRepository")
 */
class Language
{
    const ENTITY_NAME = 'OpenCoders\Podb\Persistence\Entity\Language';

    // region attributes

    /**
     * @var int
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;

    /**
     * @var string
     * @Column(type="string", unique=true, nullable=false)
     */
    protected $label;

    /**
     * (de_DE, en_GB, ...)
     * @var string
     * @Column(type="string", unique=true, nullable=false)
     */
    protected $locale;

    /**
     * @var User[]|ArrayCollection
     * @ManyToMany(targetEntity="User", mappedBy="supportedLanguages")
     * @JoinTable(name="users_languages")
     */
    protected $supportedBy;

    /**
     * @var Project[]|ArrayCollection
     * @OneToMany(targetEntity="Project", mappedBy="defaultLanguage")
     */
    protected $projects;

    /**
     * @var Translation[]|ArrayCollection
     * @OneToMany(targetEntity="Translation", mappedBy="language")
     */
    protected $translations;

    // endregion

    public function __construct()
    {
        $this->supportedBy = new ArrayCollection();
        $this->projects = new ArrayCollection();
        $this->translations = new ArrayCollection();
    }

    // region getter and setter

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @throws \Exception
     */
    public function getCreatedBy()
    {
        throw new \Exception('Not implemented!');
    }

    /**
     * @throws \Exception
     */
    public function getCreateDate()
    {
        throw new \Exception('Not implemented!');
    }

    /**
     * @throws \Exception
     */
    public function getLastUpdateDate()
    {
        throw new \Exception('Not implemented!');
    }

    /**
     * @param string $label
     *
     * @throws EmptyParameterException
     */
    public function setLabel($label)
    {
        if ($label == null || $label == '') {
            throw new EmptyParameterException('Name not allowed to be empty.');
        }
        $this->label = $label;
    }

    /**
     * @param string $locale
     *
     * @throws EmptyParameterException
     */
    public function setLocale($locale)
    {
        if ($locale == null || $locale == '') {
            throw new EmptyParameterException('Locale not allowed to be empty.');
        }
        $this->locale = $locale;
    }

    /**
     * @throws \Exception
     */
    public function getLastUpdateBy()
    {
        throw new \Exception('Not implemented!');
    }

    /**
     * @param mixed $supportedBy
     */
    public function setSupportedBy($supportedBy)
    {
        $this->supportedBy = $supportedBy;
    }

    /**
     * @return mixed
     */
    public function getSupportedBy()
    {
        return $this->supportedBy;
    }

    // endregion
}
