<?php

namespace BanqueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Facture
 *
 * @ORM\Table(name="facture")
 * @ORM\Entity(repositoryClass="BanqueBundle\Repository\FactureRepository")
 */
class Facture
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
     * @var string
     *
     * @ORM\Column(name="NomSociete", type="string", length=255)
     */
    private $nomSociete;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateachat", type="date")
     */
    private $dateachat;

    /**
     * @var string
     *
     * @ORM\Column(name="labelarticle", type="text", length=255)
     */
    private $labelarticle;
    

    /**
     * *@ORM\Column(name="isvalide", type="boolean")
     */
    private $isvalide;

    /**
     * @ORM\OneToOne(targetEntity="BanqueBundle\Entity\Transfert", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $transfert;
    

    public function getTransfert(){
        return $this->transfert;
    }
    public function setTransfert($transfert){
        $this->transfert = $transfert;
    }
    


    public function getIsValide(){
        return $this->isvalide;
    }
    public function setIsValide($bool){
        $this->isvalide = $bool;
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
     * Set nomSociete
     *
     * @param string $nomSociete
     * @return Facture
     */
    public function setNomSociete($nomSociete)
    {
        $this->nomSociete = $nomSociete;

        return $this;
    }

    /**
     * Get nomSociete
     *
     * @return string 
     */
    public function getNomSociete()
    {
        return $this->nomSociete;
    }

    /**
     * Set dateachat
     *
     * @param \DateTime $dateachat
     * @return Facture
     */
    public function setDateachat($dateachat)
    {
        $this->dateachat = $dateachat;

        return $this;
    }

    /**
     * Get dateachat
     *
     * @return \DateTime 
     */
    public function getDateachat()
    {
        return $this->dateachat;
    }

    /**
     * Set labelarticle
     *
     * @param string $labelarticle
     * @return Facture
     */
    public function setLabelarticle($labelarticle)
    {
        $this->labelarticle = $labelarticle;

        return $this;
    }

    /**
     * Get labelarticle
     *
     * @return string 
     */
    public function getLabelarticle()
    {
        return $this->labelarticle;
    }

    /**
     * Set montant
     *
     * @param float $montant
     * @return Facture
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return float 
     */
    public function getMontant()
    {
        return $this->montant;
    }

    public function __construct()
    {
        $this->setIsValide(false);

    }
}
