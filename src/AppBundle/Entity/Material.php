<?php


namespace AppBundle\Entity;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\VarDumper\VarDumper;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\MaterialRepository")
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
     * @ORM\ManyToOne(targetEntity="Code")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    protected $code;
    
    protected $balance;
    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;
    /**
     * @ORM\OneToMany(targetEntity="Inventory", mappedBy="material")
     */
    protected $inventories;
    /**
     * @ORM\OneToMany(targetEntity="Receipt", mappedBy="material")
     */
    protected $receipts;
    /**
     * @ORM\OneToMany(targetEntity="Consumption", mappedBy="material")
     */
    protected $consumptions;

    public function __toString() {
        try {
            return (string) '('. $this->getCode()->__toString() . ')'. $this->getName();
        } catch (Exception $exception) {
            return '';
        }
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
     * Get balance
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBalance()
    {
        $rec=$this->receipts->toArray();
        $cons=$this->consumptions->toArray();
        $invent=$this->inventories->toArray();
        $sumReceipt=0;  $sumConsumption=0;   $lastInventory=0;
        for ($i=0; $i<count($rec);$i++){
            $sumReceipt+=$rec[$i]->getQuantity();
        }
        for ($i=0; $i<count($cons);$i++){
            $sumConsumption+=$cons[$i]->getQuantity();
        }
        $lastInventory=$invent[count($invent)-1]->getAfterInventory()-$invent[count($invent)-1]->getBeforeInventory();
        $balance=$lastInventory+$sumReceipt-$sumConsumption;
        return $balance;
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
        try {
            if (($this->code) && ($this->code->__toString())) {
                return $this->code;
            }
        } catch (\Exception $e) {
            return "Kод удален";
        }
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->consumptions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->receipts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->inventories = new \Doctrine\Common\Collections\ArrayCollection();
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
    
    /**
     * Add inventories
     *
     * @param \AppBundle\Entity\Consumption $inventories
     * @return Material
     */
    public function addInventory(\AppBundle\Entity\Consumption $inventories)
    {
        $this->inventories[] = $inventories;

        return $this;
    }

    /**
     * Remove inventories
     *
     * @param \AppBundle\Entity\Consumption $inventories
     */
    public function removeInventory(\AppBundle\Entity\Consumption $inventories)
    {
        $this->inventories->removeElement($inventories);
    }

    /**
     * Get inventories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInventories()
    {
        return $this->inventories;
    }
}
