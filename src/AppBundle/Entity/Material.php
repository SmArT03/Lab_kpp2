<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Material")
 */
class Material {
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
     * @ORM\ManyToOne(targetEntity="Code")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    protected $code;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;
    
    

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
}
