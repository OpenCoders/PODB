<?php

namespace OpenCoders\Podb\Entity;

use DateTime;

/**
 * Class DataSet
 * @package OpenCoders\Podb\Entity
 * @Entity(repositoryClass="OpenCoders\Podb\Repository\DataSetRepository")
 */
class DataSet
{

    /**
     * @var
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;

    /**
     * @var
     * @Column(type="string")
     */
    protected $name;

    /**
     * @var
     * @ManyToOne(targetEntity="Domain")
     */
    protected $domainId;

    /**
     * @var
     * @Column(type="string")
     */
    protected $msgId;

    /**
     * @var
     * @ManyToOne(targetEntity="User")
     */
    protected $createdBy;

    /**
     * @var
     * @Column(type="datetime")
     */
    protected $createDate;

    /**
     * @var
     * @ManyToOne(targetEntity="User")
     */
    protected $lastUpdateBy;

    /**
     * @var
     * @Column(type="datetime")
     */
    protected $lastUpdateDate;

    /**
     * @param DateTime $createDate
     */
    public function setCreateDate(DateTime $createDate = null)
    {
        $this->createDate = $createDate ? clone $createDate : null;
    }

    /**
     * @return DateTime|null
     */
    public function getCreateDate()
    {
        return $this->createDate ? clone $this->createDate : null;
    }

    /**
     * @param string $userId
     */
    public function setCreatedBy($userId)
    {
        $this->createdBy = $userId;
    }

    /**
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param string $domainId
     */
    public function setDomainId($domainId)
    {
        $this->domainId = $domainId;
    }

    /**
     * @return string
     */
    public function getDomainId()
    {
        return $this->domainId;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $userId
     */
    public function setLastUpdateBy($userId)
    {
        $this->lastUpdateBy = $userId;
    }

    /**
     * @return string
     */
    public function getLastUpdateBy()
    {
        return $this->lastUpdateBy;
    }

    /**
     * @param DateTime $lastUpdateDate
     */
    public function setLastUpdateDate(DateTime $lastUpdateDate = null)
    {
        $this->lastUpdateDate = $lastUpdateDate ? clone $lastUpdateDate : null;
    }

    /**
     * @return DateTime|null
     */
    public function getLastUpdateDate()
    {
        return $this->lastUpdateDate ? clone $this->lastUpdateDate : null;
    }

    /**
     * @param string $msgId
     */
    public function setMsgId($msgId)
    {
        $this->msgId = $msgId;
    }

    /**
     * @return string
     */
    public function getMsgId()
    {
        return $this->msgId;
    }

    /**
     * @return array
     */
    public function asArray()
    {
        return array(
            'id' => $this->getId(),
            'domainId' => $this->getDomainId(),
            'msgId' => $this->getMsgId(),
            'lastUpdatedDate' => $this->getLastUpdateDate(),
            'lastUpdatedBy' => $this->getLastUpdateBy(),
            'createdDate' => $this->getCreateDate(),
            'createdBy' => $this->getCreatedBy(),
        );
    }

    public function asShortArray()
    {
        return array(
            'id' => $this->getId(),
            'name' => $this->getName(),
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
} 