<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OpcionesProducto
 *
 * @ORM\Table(name="opciones_producto", indexes={@ORM\Index(name="fk_opciones_producto_unidad_medida_peso1_idx", columns={"unidad_medida_peso_id"}), @ORM\Index(name="fk_opciones_producto_unidad_medida_dimension1_idx", columns={"unidad_medida_dimension_id"}), @ORM\Index(name="fk_opciones_producto_categorias1_idx", columns={"categorias_id"})})
 * @ORM\Entity
 */
class OpcionesProducto
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
     * @ORM\Column(name="nombre", type="string", length=45, nullable=false)
     */
    private $nombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="valor", type="integer", nullable=false)
     */
    private $valor;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=200, nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="imagen", type="string", length=200, nullable=true)
     */
    private $imagen;

    /**
     * @var \Categorias
     *
     * @ORM\ManyToOne(targetEntity="Categorias")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categorias_id", referencedColumnName="id")
     * })
     */
    private $categorias;

    /**
     * @var \UnidadMedidaDimension
     *
     * @ORM\ManyToOne(targetEntity="UnidadMedidaDimension")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="unidad_medida_dimension_id", referencedColumnName="id")
     * })
     */
    private $unidadMedidaDimension;

    /**
     * @var \UnidadMedidaPeso
     *
     * @ORM\ManyToOne(targetEntity="UnidadMedidaPeso")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="unidad_medida_peso_id", referencedColumnName="id")
     * })
     */
    private $unidadMedidaPeso;



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
     * @return OpcionesProducto
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
     * Set valor
     *
     * @param integer $valor
     * @return OpcionesProducto
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return integer 
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return OpcionesProducto
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set imagen
     *
     * @param string $imagen
     * @return OpcionesProducto
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * Get imagen
     *
     * @return string 
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * Set categorias
     *
     * @param \AdminBundle\Entity\Categorias $categorias
     * @return OpcionesProducto
     */
    public function setCategorias(\AdminBundle\Entity\Categorias $categorias = null)
    {
        $this->categorias = $categorias;

        return $this;
    }

    /**
     * Get categorias
     *
     * @return \AdminBundle\Entity\Categorias 
     */
    public function getCategorias()
    {
        return $this->categorias;
    }

    /**
     * Set unidadMedidaDimension
     *
     * @param \AdminBundle\Entity\UnidadMedidaDimension $unidadMedidaDimension
     * @return OpcionesProducto
     */
    public function setUnidadMedidaDimension(\AdminBundle\Entity\UnidadMedidaDimension $unidadMedidaDimension = null)
    {
        $this->unidadMedidaDimension = $unidadMedidaDimension;

        return $this;
    }

    /**
     * Get unidadMedidaDimension
     *
     * @return \AdminBundle\Entity\UnidadMedidaDimension 
     */
    public function getUnidadMedidaDimension()
    {
        return $this->unidadMedidaDimension;
    }

    /**
     * Set unidadMedidaPeso
     *
     * @param \AdminBundle\Entity\UnidadMedidaPeso $unidadMedidaPeso
     * @return OpcionesProducto
     */
    public function setUnidadMedidaPeso(\AdminBundle\Entity\UnidadMedidaPeso $unidadMedidaPeso = null)
    {
        $this->unidadMedidaPeso = $unidadMedidaPeso;

        return $this;
    }

    /**
     * Get unidadMedidaPeso
     *
     * @return \AdminBundle\Entity\UnidadMedidaPeso 
     */
    public function getUnidadMedidaPeso()
    {
        return $this->unidadMedidaPeso;
    }
}
