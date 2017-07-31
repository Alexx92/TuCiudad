<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Historial
 *
 * @ORM\Table(name="historial", indexes={@ORM\Index(name="fk_historial_pedido_detalle1_idx", columns={"pedido_detalle_id"}), @ORM\Index(name="fk_historial_personal1_idx", columns={"personal_id"})})
 * @ORM\Entity
 */
class Historial
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_cambio", type="datetime", nullable=true)
     */
    private $fechaCambio;

    /**
     * @var string
     *
     * @ORM\Column(name="comentarios", type="string", length=200, nullable=true)
     */
    private $comentarios;

    /**
     * @var string
     *
     * @ORM\Column(name="valor_producto", type="string", length=50, nullable=true)
     */
    private $valorProducto;

    /**
     * @var string
     *
     * @ORM\Column(name="valor_modificado", type="string", length=45, nullable=true)
     */
    private $valorModificado;

    /**
     * @var string
     *
     * @ORM\Column(name="cantidad", type="string", length=45, nullable=true)
     */
    private $cantidad;

    /**
     * @var string
     *
     * @ORM\Column(name="total", type="string", length=45, nullable=true)
     */
    private $total;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="text", length=65535, nullable=true)
     */
    private $observacion;

    /**
     * @var string
     *
     * @ORM\Column(name="largo", type="string", length=45, nullable=true)
     */
    private $largo;

    /**
     * @var string
     *
     * @ORM\Column(name="ancho", type="string", length=45, nullable=true)
     */
    private $ancho;

    /**
     * @var string
     *
     * @ORM\Column(name="peso", type="string", length=45, nullable=true)
     */
    private $peso;

    /**
     * @var \PedidoDetalle
     *
     * @ORM\ManyToOne(targetEntity="PedidoDetalle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pedido_detalle_id", referencedColumnName="id")
     * })
     */
    private $pedidoDetalle;

    /**
     * @var \Personal
     *
     * @ORM\ManyToOne(targetEntity="Personal")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="personal_id", referencedColumnName="id")
     * })
     */
    private $personal;



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
     * Set fechaCambio
     *
     * @param \DateTime $fechaCambio
     * @return Historial
     */
    public function setFechaCambio($fechaCambio)
    {
        $this->fechaCambio = $fechaCambio;

        return $this;
    }

    /**
     * Get fechaCambio
     *
     * @return \DateTime 
     */
    public function getFechaCambio()
    {
        return $this->fechaCambio;
    }

    /**
     * Set comentarios
     *
     * @param string $comentarios
     * @return Historial
     */
    public function setComentarios($comentarios)
    {
        $this->comentarios = $comentarios;

        return $this;
    }

    /**
     * Get comentarios
     *
     * @return string 
     */
    public function getComentarios()
    {
        return $this->comentarios;
    }

    /**
     * Set valorProducto
     *
     * @param string $valorProducto
     * @return Historial
     */
    public function setValorProducto($valorProducto)
    {
        $this->valorProducto = $valorProducto;

        return $this;
    }

    /**
     * Get valorProducto
     *
     * @return string 
     */
    public function getValorProducto()
    {
        return $this->valorProducto;
    }

    /**
     * Set valorModificado
     *
     * @param string $valorModificado
     * @return Historial
     */
    public function setValorModificado($valorModificado)
    {
        $this->valorModificado = $valorModificado;

        return $this;
    }

    /**
     * Get valorModificado
     *
     * @return string 
     */
    public function getValorModificado()
    {
        return $this->valorModificado;
    }

    /**
     * Set cantidad
     *
     * @param string $cantidad
     * @return Historial
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return string 
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set total
     *
     * @param string $total
     * @return Historial
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return string 
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     * @return Historial
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
     * Set largo
     *
     * @param string $largo
     * @return Historial
     */
    public function setLargo($largo)
    {
        $this->largo = $largo;

        return $this;
    }

    /**
     * Get largo
     *
     * @return string 
     */
    public function getLargo()
    {
        return $this->largo;
    }

    /**
     * Set ancho
     *
     * @param string $ancho
     * @return Historial
     */
    public function setAncho($ancho)
    {
        $this->ancho = $ancho;

        return $this;
    }

    /**
     * Get ancho
     *
     * @return string 
     */
    public function getAncho()
    {
        return $this->ancho;
    }

    /**
     * Set peso
     *
     * @param string $peso
     * @return Historial
     */
    public function setPeso($peso)
    {
        $this->peso = $peso;

        return $this;
    }

    /**
     * Get peso
     *
     * @return string 
     */
    public function getPeso()
    {
        return $this->peso;
    }

    /**
     * Set pedidoDetalle
     *
     * @param \AdminBundle\Entity\PedidoDetalle $pedidoDetalle
     * @return Historial
     */
    public function setPedidoDetalle(\AdminBundle\Entity\PedidoDetalle $pedidoDetalle = null)
    {
        $this->pedidoDetalle = $pedidoDetalle;

        return $this;
    }

    /**
     * Get pedidoDetalle
     *
     * @return \AdminBundle\Entity\PedidoDetalle 
     */
    public function getPedidoDetalle()
    {
        return $this->pedidoDetalle;
    }

    /**
     * Set personal
     *
     * @param \AdminBundle\Entity\Personal $personal
     * @return Historial
     */
    public function setPersonal(\AdminBundle\Entity\Personal $personal = null)
    {
        $this->personal = $personal;

        return $this;
    }

    /**
     * Get personal
     *
     * @return \AdminBundle\Entity\Personal 
     */
    public function getPersonal()
    {
        return $this->personal;
    }
}
