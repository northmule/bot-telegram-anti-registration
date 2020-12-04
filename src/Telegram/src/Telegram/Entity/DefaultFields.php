<?php

namespace Coderun\Telegram\Entity;

use DateTime;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * Поля по умолчанию для установки в Entity
 * В Entitye необходимо добавить @ORM\HasLifecycleCallbacks для
 * того что бы Doctrine обрабатывал события из аннотаций
 *
 * @package ORM\Entity
 */
trait DefaultFields
{
    /**
     * @Doctrine\Id()
     * @Doctrine\Column(name="id", type="integer")
     * @Doctrine\GeneratedValue(strategy = "IDENTITY")
     *
     * @var int
     */
    protected $id;
    
    /**
     * @ORM\Column(name="dateCreated",type="datetime", nullable=true,options={"comment":"Дата создания записи"})
     */
    protected $dateCreated;
    /**
     * @ORM\Column(name="dateUpdated",type="datetime", nullable=true,options={"comment":"Дата обновления записи"})
     */
    protected $dateUpdated;
    
    /**
     * @ORM\Column (name="uuid",type="string",length=36,nullable=true,unique=true,options={"comment":"Уникальный код, автогенерируется при вставке"})
     */
    protected $uuid;
    
    /**
     * Get dateCreated
     *
     * @return DateTime
     */
    public function getDateCreated(): ?DateTime
    {
        return $this->dateCreated;
    }
    
    /**
     * Gets triggered only on insert
     
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->dateCreated = new \DateTime("now");
        $this->uuid = Uuid::uuid4();
    }
    
    /**
     * Gets triggered every time on update
     
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->dateUpdated = new \DateTime("now");
    }
    
    /**
     * Get dateUpdated
     *
     * @return mixed
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }
    
    /**
     * Get id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
    
    /**
     * Set id
     *
     * @param int $id
     *
     * @return DefaultFields
     */
    public function setId(int $id): DefaultFields
    {
        $this->id = $id;
        return $this;
    }
    
    /**
     * Get uuid
     *
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }
    
    
    
}


