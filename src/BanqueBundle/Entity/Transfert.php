<?php

namespace BanqueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transfert
 *
 * @ORM\Table(name="transfert")
 * @ORM\Entity(repositoryClass="BanqueBundle\Repository\TransfertRepository")
 */
class Transfert
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
     * @ORM\Column(name="Somme", type="float")
     */
    private $somme;

    /**
     *
     *
     * @ORM\Column(name="motif", type="string")
     */
    private $motif;
    /**
     * @var bool
     *
     * @ORM\Column(name="ValidationCrediteur", type="boolean", nullable=true)
     */
    private $validationCrediteur;

    /**
     * @var bool
     *
     * @ORM\Column(name="ValidationDebiteur", type="boolean", nullable=true)
     */
    private $validationDebiteur;


    /**
     * @ORM\ManyToOne(targetEntity="BanqueBundle\Entity\CompteCourant")
     * @ORM\JoinColumn(nullable=false)
     */
    private $crediteur;

    /**
     * @ORM\ManyToOne(targetEntity="BanqueBundle\Entity\CompteCourant")
     * @ORM\JoinColumn(nullable=false)
     */
    private $debiteur;


    /**
     *
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;



    public function getMotif(){
        return $this->motif;
    }

    public function setMotif($motif){
        $this->motif = $motif;
        return $this;
    }

    public function getDate(){
        return $this->date;
    }

    public function setDate($date){
        $this->date = $date;
    }
    
    public function getCrediteur(){
        return $this->crediteur;
    }
    public function setCrediteur($compte){
        $this->crediteur = $compte;
        return $this;
    }

    public function getDebiteur(){
        return $this->debiteur;
    }
    public function setDebiteur($compte){
        $this->debiteur = $compte;
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
     * Set somme
     *
     * @param float $somme
     * @return Transfert
     */
    public function setSomme($somme)
    {
        $this->somme = $somme;

        return $this;
    }

    /**
     * Get somme
     *
     * @return float 
     */
    public function getSomme()
    {
        return $this->somme;
    }

    /**
     * Set validationCrediteur
     *
     * @param boolean $validationCrediteur
     * @return Transfert
     */
    public function setValidationCrediteur($validationCrediteur)
    {
        $this->validationCrediteur = $validationCrediteur;

        return $this;
    }

    /**
     * Get validationCrediteur
     *
     * @return boolean 
     */
    public function getValidationCrediteur()
    {
        return $this->validationCrediteur;
    }

    /**
     * Set validationDebiteur
     *
     * @param boolean $validationDebiteur
     * @return Transfert
     */
    public function setValidationDebiteur($validationDebiteur)
    {
        $this->validationDebiteur = $validationDebiteur;

        return $this;
    }

    /**
     * Get validationDebiteur
     *
     * @return boolean 
     */
    public function getValidationDebiteur()
    {
        return $this->validationDebiteur;
    }
    
    public function virementArgent()
    {
        $this->getCrediteur()->setSolde($this->getCrediteur()->getSolde() + $this->getSomme());
        $this->getDebiteur()->setSolde($this->getDebiteur()->getSolde() - $this->getSomme());
    }
}
