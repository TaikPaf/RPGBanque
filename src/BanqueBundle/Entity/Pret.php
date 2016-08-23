<?php

namespace BanqueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pret
 *
 * @ORM\Table(name="pret")
 * @ORM\Entity(repositoryClass="BanqueBundle\Repository\PretRepository")
 */
class Pret
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="Somme", type="integer")
     */
    private $somme;

    /**
     * @var float
     *
     * @ORM\Column(name="interet", type="float")
     */
    private $interet;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="date")
     */
    private $dateCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFin", type="date")
     */
    private $dateFin;


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
     * Set somme
     *
     * @param integer $somme
     * @return Pret
     */
    public function setSomme($somme)
    {
        $this->somme = $somme;

        return $this;
    }

    /**
     * Get somme
     *
     * @return integer 
     */
    public function getSomme()
    {
        return $this->somme;
    }

    /**
     * Set interet
     *
     * @param float $interet
     * @return Pret
     */
    public function setInteret($interet)
    {
        $this->interet = $interet;

        return $this;
    }

    /**
     * Get interet
     *
     * @return float 
     */
    public function getInteret()
    {
        return $this->interet;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     * @return Pret
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime 
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     * @return Pret
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime 
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }
}
