<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Producto
 *
 * @ORM\Table(name="producto")
 * @ORM\Entity
 */
class Producto
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
     * @ORM\Column(name="nombre", type="string", length=200, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_prod", type="string", length=30, nullable=true)
     */
    private $codigoProd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_ingreso", type="datetime", nullable=false)
     */
    private $fechaIngreso;

    /**
     * @var integer
     *
     * @ORM\Column(name="valor_unitario", type="integer", nullable=true)
     */
    private $valorUnitario;

    /**
     * @var string
     *
     * @ORM\Column(name="imagen", type="string", length=200, nullable=true)
     */
    private $imagen;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="text", length=65535, nullable=true)
     */
    private $observacion;

    /**
     * @var integer
     *
     * @ORM\Column(name="estado", type="integer", nullable=false)
     */
    private $estado;

    /**
     * @var integer
     *
     * @ORM\Column(name="tipo", type="integer", nullable=false)
     */
    private $tipo;

    /**
     * @var integer
     *
     * @ORM\Column(name="tiempo_apx_produccion", type="integer", nullable=true)
     */
    private $tiempoApxProduccion;

    /**
     * @var integer
     *
     * @ORM\Column(name="valor_minimo_venta", type="integer", nullable=true)
     */
    private $valorMinimoVenta;



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
     * @return Producto
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
     * Set codigoProd
     *
     * @param string $codigoProd
     * @return Producto
     */
    public function setCodigoProd($codigoProd)
    {
        $this->codigoProd = $codigoProd;

        return $this;
    }

    /**
     * Get codigoProd
     *
     * @return string 
     */
    public function getCodigoProd()
    {
        return $this->codigoProd;
    }

    /**
     * Set fechaIngreso
     *
     * @param \DateTime $fechaIngreso
     * @return Producto
     */
    public function setFechaIngreso($fechaIngreso)
    {
        $this->fechaIngreso = $fechaIngreso;

        return $this;
    }

    /**
     * Get fechaIngreso
     *
     * @return \DateTime 
     */
    public function getFechaIngreso()
    {
        return $this->fechaIngreso;
    }

    /**
     * Set valorUnitario
     *
     * @param integer $valorUnitario
     * @return Producto
     */
    public function setValorUnitario($valorUnitario)
    {
        $this->valorUnitario = $valorUnitario;

        return $this;
    }

    /**
     * Get valorUnitario
     *
     * @return integer 
     */
    public function getValorUnitario()
    {
        return $this->valorUnitario;
    }

    /**
     * Set imagen
     *
     * @param string $imagen
     * @return Producto
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
     * Set observacion
     *
     * @param string $observacion
     * @return Producto
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

    /**
     * Set estado
     *
     * @param integer $estado
     * @return Producto
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return integer 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set tipo
     *
     * @param integer $tipo
     * @return Producto
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return integer 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set tiempoApxProduccion
     *
     * @param integer $tiempoApxProduccion
     * @return Producto
     */
    public function setTiempoApxProduccion($tiempoApxProduccion)
    {
        $this->tiempoApxProduccion = $tiempoApxProduccion;

        return $this;
    }

    /**
     * Get tiempoApxProduccion
     *
     * @return integer 
     */
    public function getTiempoApxProduccion()
    {
        return $this->tiempoApxProduccion;
    }

    /**
     * Set valorMinimoVenta
     *
     * @param integer $valorMinimoVenta
     * @return Producto
     */
    public function setValorMinimoVenta($valorMinimoVenta)
    {
        $this->valorMinimoVenta = $valorMinimoVenta;

        return $this;
    }

    /**
     * Get valorMinimoVenta
     *
     * @return integer 
     */
    public function getValorMinimoVenta()
    {
        return $this->valorMinimoVenta;
    }
}
