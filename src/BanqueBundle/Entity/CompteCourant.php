<?php

namespace BanqueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CompteCourant
 *
 * @ORM\Table(name="compte_courant")
 * @ORM\Entity(repositoryClass="BanqueBundle\Repository\CompteCourantRepository")
 */
class CompteCourant
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
     * @ORM\Column(name="Solde", type="float")
     */
    private $solde;

    /**
     * @var int
     *
     * @ORM\Column(name="NumeroCompte", type="integer")
     */
    private $numeroCompte;
    

    /**
     * @ORM\OneToOne(targetEntity="BanqueBundle\Entity\User", cascade={"persist"})
     */
    private $user;


    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

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
     * @return CompteCourant
     */
    public function setSolde($solde)
    {
        $this->solde = $solde;

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

    /**
     * Set numeroCompte
     *
     * @param integer $numeroCompte
     * @return CompteCourant
     */
    public function setNumeroCompte($numeroCompte)
    {
        $this->numeroCompte = $numeroCompte;

        return $this;
    }

    /**
     * Get numeroCompte
     *
     * @return integer 
     */
    public function getNumeroCompte()
    {
        return $this->numeroCompte;
    }
}
