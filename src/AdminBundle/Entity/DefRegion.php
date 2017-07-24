<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DefRegion
 *
 * @ORM\Table(name="def_region")
 * @ORM\Entity
 */
class DefRegion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="reg_id_pk", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $regIdPk;

    /**
     * @var string
     *
     * @ORM\Column(name="reg_nombre", type="string", length=40, nullable=true)
     */
    private $regNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="reg_romano", type="string", length=4, nullable=true)
     */
    private $regRomano;

    /**
     * @var integer
     *
     * @ORM\Column(name="reg_provincias", type="integer", nullable=true)
     */
    private $regProvincias;

    /**
     * @var integer
     *
     * @ORM\Column(name="reg_comunas", type="integer", nullable=true)
     */
    private $regComunas;

    /**
     * @var integer
     *
     * @ORM\Column(name="reg_orden", type="integer", nullable=true)
     */
    private $regOrden;



    /**
     * Get regIdPk
     *
     * @return integer 
     */
    public function getRegIdPk()
    {
        return $this->regIdPk;
    }

    /**
     * Set regNombre
     *
     * @param string $regNombre
     * @return DefRegion
     */
    public function setRegNombre($regNombre)
    {
        $this->regNombre = $regNombre;

        return $this;
    }

    /**
     * Get regNombre
     *
     * @return string 
     */
    public function getRegNombre()
    {
        return $this->regNombre;
    }

    /**
     * Set regRomano
     *
     * @param string $regRomano
     * @return DefRegion
     */
    public function setRegRomano($regRomano)
    {
        $this->regRomano = $regRomano;

        return $this;
    }

    /**
     * Get regRomano
     *
     * @return string 
     */
    public function getRegRomano()
    {
        return $this->regRomano;
    }

    /**
     * Set regProvincias
     *
     * @param integer $regProvincias
     * @return DefRegion
     */
    public function setRegProvincias($regProvincias)
    {
        $this->regProvincias = $regProvincias;

        return $this;
    }

    /**
     * Get regProvincias
     *
     * @return integer 
     */
    public function getRegProvincias()
    {
        return $this->regProvincias;
    }

    /**
     * Set regComunas
     *
     * @param integer $regComunas
     * @return DefRegion
     */
    public function setRegComunas($regComunas)
    {
        $this->regComunas = $regComunas;

        return $this;
    }

    /**
     * Get regComunas
     *
     * @return integer 
     */
    public function getRegComunas()
    {
        return $this->regComunas;
    }

    /**
     * Set regOrden
     *
     * @param integer $regOrden
     * @return DefRegion
     */
    public function setRegOrden($regOrden)
    {
        $this->regOrden = $regOrden;

        return $this;
    }

    /**
     * Get regOrden
     *
     * @return integer 
     */
    public function getRegOrden()
    {
        return $this->regOrden;
    }
}
