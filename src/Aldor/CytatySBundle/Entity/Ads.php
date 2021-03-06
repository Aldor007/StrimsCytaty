<?php

namespace Aldor\CytatySBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ads
 */
class Ads
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $image;

    /**
     * @var string
     */
    private $script;


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
     * @param \DateTime $date
     * @return Ads
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

    /**
     * Set name
     *
     * @param string $name
     * @return Ads
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
     * Set image
     *
     * @param string $image
     * @return Ads
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set script
     *
     * @param string $script
     * @return Ads
     */
    public function setScript($script)
    {
        $this->script = $script;

        return $this;
    }

    /**
     * Get script
     *
     * @return string
     */
    public function getScript()
    {
        return $this->script;
    }
    /**
     * @var boolean
     */
    private $status;


    /**
     * Set status
     *
     * @param boolean $status
     * @return Ads
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $value;


    /**
     * Set type
     *
     * @param string $type
     * @return Ads
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return Ads
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
    /**
     * @var int
     */
    private $weight;


    /**
     * Set weight
     *
     * @param \int $weight
     * @return Ads
     */
    public function setWeight( $weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return \int
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @ORM\PrePersist
     */
    public function setDateAtValue()
    {
        $this->date = new \DateTime();
    }
    /**
     * @var boolean
     */
    private $onoff;


    /**
     * Set onoff
     *
     * @param boolean $onoff
     * @return Ads
     */
    public function setOnoff($onoff)
    {
        $this->onoff = $onoff;

        return $this;
    }

    /**
     * Get onoff
     *
     * @return boolean 
     */
    public function getOnoff()
    {
        return $this->onoff;
    }
    /**
     * @var boolean
     */
    private $onstatus;


    /**
     * Set onstatus
     *
     * @param boolean $onstatus
     * @return Ads
     */
    public function setOnstatus($onstatus)
    {
        $this->onstatus = $onstatus;

        return $this;
    }

    /**
     * Get onstatus
     *
     * @return boolean 
     */
    public function getOnstatus()
    {
        return $this->onstatus;
    }
}
