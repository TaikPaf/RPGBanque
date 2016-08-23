<?php

namespace BanqueBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="HabboName", type="string", length=255)
     */
    private $habboName;

    /**
     * @var string
     *
     * @ORM\Column(name="Rank", type="string", length=255)
     */
    private $rank;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set habboName
     *
     * @param string $habboName
     * @return User
     */
    public function setHabboName($habboName)
    {
        $this->habboName = $habboName;

        return $this;
    }

    /**
     * Get habboName
     *
     * @return string 
     */
    public function getHabboName()
    {
        return $this->habboName;
    }

    /**
     * Set rank
     *
     * @param string $rank
     * @return User
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank
     *
     * @return string 
     */
    public function getRank()
    {
        return $this->rank;
    }
    
    public function __construct(){
        parent::__construct();
        $this->setName("Inconnu");
        $this->setHabboName("Inconnu");
        $this->setRank("client");
}
}
