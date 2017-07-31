<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Servicio
 *
 * @ORM\Table(name="servicio")
 * @ORM\Entity
 */
class Servicio
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="tiempo_de_desarrollo", type="integer", nullable=true)
     */
    private $tiempoDeDesarrollo;

    /**
     * @var string
     *
     * @ORM\Column(name="caracteristicas", type="text", length=65535, nullable=true)
     */
    private $caracteristicas;



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
     * Set tiempoDeDesarrollo
     *
     * @param integer $tiempoDeDesarrollo
     * @return Servicio
     */
    public function setTiempoDeDesarrollo($tiempoDeDesarrollo)
    {
        $this->tiempoDeDesarrollo = $tiempoDeDesarrollo;

        return $this;
    }

    /**
     * Get tiempoDeDesarrollo
     *
     * @return integer 
     */
    public function getTiempoDeDesarrollo()
    {
        return $this->tiempoDeDesarrollo;
    }

    /**
     * Set caracteristicas
     *
     * @param string $caracteristicas
     * @return Servicio
     */
    public function setCaracteristicas($caracteristicas)
    {
        $this->caracteristicas = $caracteristicas;

        return $this;
    }

    /**
     * Get caracteristicas
     *
     * @return string 
     */
    public function getCaracteristicas()
    {
        return $this->caracteristicas;
    }
}
