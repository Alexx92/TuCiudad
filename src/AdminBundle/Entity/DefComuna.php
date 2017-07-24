<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DefComuna
 *
 * @ORM\Table(name="def_comuna", indexes={@ORM\Index(name="com_provincia_fk", columns={"com_provincia_fk"})})
 * @ORM\Entity
 */
class DefComuna
{
    /**
     * @var integer
     *
     * @ORM\Column(name="com_id_pk", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $comIdPk;

    /**
     * @var string
     *
     * @ORM\Column(name="com_nombre", type="string", length=25, nullable=true)
     */
    private $comNombre;

    /**
     * @var \DefProvincia
     *
     * @ORM\ManyToOne(targetEntity="DefProvincia")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="com_provincia_fk", referencedColumnName="pro_id_pk")
     * })
     */
    private $comProvinciaFk;



    /**
     * Get comIdPk
     *
     * @return integer 
     */
    public function getComIdPk()
    {
        return $this->comIdPk;
    }

    /**
     * Set comNombre
     *
     * @param string $comNombre
     * @return DefComuna
     */
    public function setComNombre($comNombre)
    {
        $this->comNombre = $comNombre;

        return $this;
    }

    /**
     * Get comNombre
     *
     * @return string 
     */
    public function getComNombre()
    {
        return $this->comNombre;
    }

    /**
     * Set comProvinciaFk
     *
     * @param \AdminBundle\Entity\DefProvincia $comProvinciaFk
     * @return DefComuna
     */
    public function setComProvinciaFk(\AdminBundle\Entity\DefProvincia $comProvinciaFk = null)
    {
        $this->comProvinciaFk = $comProvinciaFk;

        return $this;
    }

    /**
     * Get comProvinciaFk
     *
     * @return \AdminBundle\Entity\DefProvincia 
     */
    public function getComProvinciaFk()
    {
        return $this->comProvinciaFk;
    }
}
