<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Inventory")
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
     * @ORM\ManyToOne(targetEntity="Material")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    protected $material;
     /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $date;
     /**
     * @ORM\Column(type="float", precision=8, scale=2, nullable=false)
     */
    private $before;
     /**
     * @ORM\Column(type="float", precision=8, scale=2, nullable=false)
     */
    private $after;
        


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
     * Set before
     *
     * @param float $before
     * @return Inventory
     */
    public function setBefore($before)
    {
        $this->before = $before;

        return $this;
    }

    /**
     * Get before
     *
     * @return float 
     */
    public function getBefore()
    {
        return $this->before;
    }

    /**
     * Set after
     *
     * @param float $after
     * @return Inventory
     */
    public function setAfter($after)
    {
        $this->after = $after;

        return $this;
    }

    /**
     * Get after
     *
     * @return float 
     */
    public function getAfter()
    {
        return $this->after;
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
        return $this->material;
    }
}
