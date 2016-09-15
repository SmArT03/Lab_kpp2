<?php

namespace AppBundle\Entity;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\Table()
 */
class Consumption {
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
     * @ORM\ManyToOne(targetEntity="Material", inversedBy="consumptions")
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
     * @Assert\Range(
     *      min = 0,
     *      minMessage = "Введенное значение должно быть больше 0"
     * )
     */
    private $quantity;
    

     /**
     * @ORM\Column(type="date", nullable=false)
     */
    private $date;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;
    
    
    public function __toString() {
        return $this->description;
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
        try {
            if (($this->material) && ($this->material->__toString())) {
                return $this->material;
            }
        } catch (\Exception $e) {
            return "Материал удален";
        }
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
        try {
            if (($this->group) && ($this->group->__toString())) {
                return $this->group;
            }
        } catch (\Exception $e) {
            return "Группа удалена";
        }
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Consumption
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }
}
