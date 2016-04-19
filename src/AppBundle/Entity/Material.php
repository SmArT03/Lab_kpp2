<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
/**
 * @ORM\Entity
 * @ORM\Table()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Material {
    use \Gedmo\Timestampable\Traits\TimestampableEntity,
        \Gedmo\Blameable\Traits\BlameableEntity,
        \Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * 
     * @ORM\OneToMany(targetEntity="Consumption", mappedBy="material")
     */
    protected $consumptions;
    /**
     * 
     * @ORM\OneToMany(targetEntity="Receipt", mappedBy="material")
     */
    protected $receipts;
    /**
     * 
     * @ORM\ManyToOne(targetEntity="Code")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    protected $code;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;
    
    public function __toString() {
        return $this->name;
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
     * Set name
     *
     * @param string $name
     * @return Material
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
     * Set code
     *
     * @param \AppBundle\Entity\Code $code
     * @return Material
     */
    public function setCode(\AppBundle\Entity\Code $code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return \AppBundle\Entity\Code 
     */
    public function getCode()
    {
        return $this->code;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->consumptions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add consumptions
     *
     * @param \AppBundle\Entity\Consumption $consumptions
     * @return Material
     */
    public function addConsumption(\AppBundle\Entity\Consumption $consumptions)
    {
        $this->consumptions[] = $consumptions;

        return $this;
    }

    /**
     * Remove consumptions
     *
     * @param \AppBundle\Entity\Consumption $consumptions
     */
    public function removeConsumption(\AppBundle\Entity\Consumption $consumptions)
    {
        $this->consumptions->removeElement($consumptions);
    }

    /**
     * Get consumptions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getConsumptions()
    {
        return $this->consumptions;
    }

    /**
     * Add receipts
     *
     * @param \AppBundle\Entity\Receipt $receipts
     * @return Material
     */
    public function addReceipt(\AppBundle\Entity\Receipt $receipts)
    {
        $this->receipts[] = $receipts;

        return $this;
    }

    /**
     * Remove receipts
     *
     * @param \AppBundle\Entity\Receipt $receipts
     */
    public function removeReceipt(\AppBundle\Entity\Receipt $receipts)
    {
        $this->receipts->removeElement($receipts);
    }

    /**
     * Get receipts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReceipts()
    {
        return $this->receipts;
    }
}
