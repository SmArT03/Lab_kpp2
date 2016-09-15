<?php

namespace AppBundle\Entity;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\Table()
 */
class Inventory {
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
     * @ORM\ManyToOne(targetEntity="Material", inversedBy="inventories")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    protected $material;
     /**
     * @ORM\Column(type="date", nullable=false)
     */
    private $date;
     /**
     * @ORM\Column(type="float", precision=8, scale=2, nullable=false)
     */
    private $beforeInventory;
     /**
     * @ORM\Column(type="float", precision=2, scale=8, nullable=false)
     */
    private $afterInventory;
        


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
     * Set date
     *
     * @param integer $date
     * @return Inventory
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return integer 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set beforeInventory
     *
     * @param float $beforeInventory
     * @return Inventory
     */
    public function setBeforeInventory($beforeInventory)
    {
        $this->beforeInventory = $beforeInventory;

        return $this;
    }

    /**
     * Get beforeInventory
     *
     * @return float 
     */
    public function getBeforeInventory()
    {
        return $this->beforeInventory;
    }

    /**
     * Set afterInventory
     *
     * @param float $afterInventory
     * @return Inventory
     */
    public function setAfterInventory($afterInventory)
    {
        $this->afterInventory = $afterInventory;

        return $this;
    }

    /**
     * Get afterInventory
     *
     * @return float 
     */
    public function getAfterInventory()
    {
        return $this->afterInventory;
    }



    /**
     * Set material
     *
     * @param \AppBundle\Entity\Material $material
     * @return Inventory
     */
    public function setMaterial(\AppBundle\Entity\Material $material)
    {
        $this->material = $material;

        return $this;
    }

    /**
     * Get material
     *
     * @return \AppBundle\Entity\Material 
     */
    public function getMaterial()
    {
        try {
            if (($this->material) && ($this->material->__toString())) {
                return $this->material;
            }
        } catch (\Exception $e) {
            return "Материал удален";
        }
    }
}
