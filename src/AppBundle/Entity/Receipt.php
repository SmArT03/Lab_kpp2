<?php

namespace AppBundle\Entity;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\Table()
 */
class Receipt {

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
     * @ORM\ManyToOne(targetEntity="Material", inversedBy="receipts")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    protected $material;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @Assert\Range(
     *      min = 0,
     *      minMessage = "Введенное значение должно быть больше 0"
     * )
     */
    private $quantity;

    /**
     * @ORM\Column(type="decimal", precision=8, scale=2, nullable=false)
     */
    private $price;

    /**
     * @ORM\Column(type="date", nullable=false)
     *   
     * @Assert\Date()
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $supplier;

    /**
     * Constructor
     */
    public function __construct() {
        $this->material = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString() {
        return $this->description;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return Consumption
     */
    public function setQuantity($quantity) {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity() {
        return $this->quantity;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Receipt
     */
    public function setPrice($price) {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Receipt
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set material
     *
     * @param \AppBundle\Entity\Material $material
     * @return Receipt
     */
    public function setMaterial(\AppBundle\Entity\Material $material = null) {
        $this->material = $material;

        return $this;
    }

    /**
     * Get material
     *
     * @return \AppBundle\Entity\Material 
     */
    public function getMaterial() {
        try {
            if (($this->material) && ($this->material->__toString())) {
                return $this->material;
            }
        } catch (\Exception $e) {
            return "Материал удален";
        }
    }

    /**
     * Set supplier
     *
     * @param string $supplier
     * @return Receipt
     */
    public function setSupplier($supplier) {
        $this->supplier = $supplier;

        return $this;
    }

    /**
     * Get supplier
     *
     * @return string 
     */
    public function getSupplier() {
        return $this->supplier;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Receipt
     */
    public function setDate($date) {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate() {
        return $this->date;
    }

}
