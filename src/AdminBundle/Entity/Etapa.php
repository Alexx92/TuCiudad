<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etapa
 *
 * @ORM\Table(name="etapa")
 * @ORM\Entity
 */
class Etapa
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
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=30, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="siglas", type="string", length=45, nullable=false)
     */
    private $siglas;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="string", length=200, nullable=true)
     */
    private $observacion;



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
     * Set nombre
     *
     * @param string $nombre
     * @return Etapa
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set siglas
     *
     * @param string $siglas
     * @return Etapa
     */
    public function setSiglas($siglas)
    {
        $this->siglas = $siglas;

        return $this;
    }

    /**
     * Get siglas
     *
     * @return string 
     */
    public function getSiglas()
    {
        return $this->siglas;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     * @return Etapa
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get observacion
     *
     * @return string 
     */
    public function getObservacion()
    {
        return $this->observacion;
    }
}
