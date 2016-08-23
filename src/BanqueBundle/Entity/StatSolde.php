<?php

namespace BanqueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StatSolde
 *
 * @ORM\Table(name="stat_solde")
 * @ORM\Entity(repositoryClass="BanqueBundle\Repository\StatSoldeRepository")
 */
class StatSolde
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
     * @var float
     *
     * @ORM\Column(name="solde", type="float")
     */
    private $solde;

    /**
     * @ORM\ManyToOne(targetEntity="BanqueBundle\Entity\CompteCourant")
     * @ORM\JoinColumn(nullable=false)
     */
    private $comptecourant;

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
     * Set solde
     *
     * @param float $solde
     * @return StatSolde
     */
    public function setSolde($solde)
    {
        $this->solde = $solde;

        return $this;
    }

    /**
     * Get solde
     *
     * @return float 
     */
    public function getSolde()
    {
        return $this->solde;
    }
}
