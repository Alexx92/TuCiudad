<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EtapaProduccion
 *
 * @ORM\Table(name="etapa_produccion", uniqueConstraints={@ORM\UniqueConstraint(name="nombre_UNIQUE", columns={"nombre"})})
 * @ORM\Entity
 */
class EtapaProduccion
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
     * @ORM\Column(name="nombre", type="string", length=200, nullable=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="siglas", type="string", length=10, nullable=true)
     */
    private $siglas;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="string", length=45, nullable=true)
     */
    private $observaciones;

    /**
     * @var string
     *
     * @ORM\Column(name="prioridad", type="string", length=45, nullable=true)
     */
    private $prioridad;



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
     * @return EtapaProduccion
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
     * @return EtapaProduccion
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
     * Set observaciones
     *
     * @param string $observaciones
     * @return EtapaProduccion
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string 
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set prioridad
     *
     * @param string $prioridad
     * @return EtapaProduccion
     */
    public function setPrioridad($prioridad)
    {
        $this->prioridad = $prioridad;

        return $this;
    }

    /**
     * Get prioridad
     *
     * @return string 
     */
    public function getPrioridad()
    {
        return $this->prioridad;
    }
}
