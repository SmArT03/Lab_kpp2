<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Consumption")
 */
class Consumption {
     use \Gedmo\Timestampable\Traits\Timestampable, 
        \Gedmo\SoftDeleteable\Traits\SoftDeleteable,
        \Gedmo\Blameable\Traits\Blameable;
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
     /**
     * 
     * @ORM\ManyToOne(targetEntity="Material")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    protected $material;
     /**
     * 
     * @ORM\ManyToOne(targetEntity="Group")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    protected $group;
    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $quantity;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;
    
    

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
     * Set quantity
     *
     * @param integer $quantity
     * @return Consumption
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Consumption
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set material
     *
     * @param \AppBundle\Entity\Material $material
     * @return Consumption
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
        return $this->material;
    }

    /**
     * Set group
     *
     * @param \AppBundle\Entity\Group $group
     * @return Consumption
     */
    public function setGroup(\AppBundle\Entity\Group $group)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \AppBundle\Entity\Group 
     */
    public function getGroup()
    {
        return $this->group;
    }
}
