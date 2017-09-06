<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PedidoDetalle
 *
 * @ORM\Table(name="pedido_detalle", indexes={@ORM\Index(name="fk_pedido", columns={"fk_pedido"}), @ORM\Index(name="fk_producto", columns={"fk_producto"}), @ORM\Index(name="fk_pedido_detalle_etapa_pedido_detalle1_idx", columns={"etapa_pedido_detalle_id"}), @ORM\Index(name="fk_pedido_detalle_personal1_idx", columns={"personal_id"})})
 * @ORM\Entity
 */
class PedidoDetalle
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
     * @ORM\Column(name="valor_producto", type="integer", nullable=false)
     */
    private $valorProducto;

    /**
     * @var integer
     *
     * @ORM\Column(name="valor_modificado", type="integer", nullable=false)
     */
    private $valorModificado;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad", type="integer", nullable=false)
     */
    private $cantidad;

    /**
     * @var integer
     *
     * @ORM\Column(name="total", type="integer", nullable=false)
     */
    private $total;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="text", length=65535, nullable=true)
     */
    private $observacion;

    /**
     * @var \EtapaPedidoDetalle
     *
     * @ORM\ManyToOne(targetEntity="EtapaPedidoDetalle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="etapa_pedido_detalle_id", referencedColumnName="id")
     * })
     */
    private $etapaPedidoDetalle;

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
     * @var \Pedidos
     *
     * @ORM\ManyToOne(targetEntity="Pedidos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_pedido", referencedColumnName="id")
     * })
     */
    private $fkPedido;

    /**
     * @var \Producto
     *
     * @ORM\ManyToOne(targetEntity="Producto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_producto", referencedColumnName="id")
     * })
     */
    private $fkProducto;



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
     * Set valorProducto
     *
     * @param integer $valorProducto
     * @return PedidoDetalle
     */
    public function setValorProducto($valorProducto)
    {
        $this->valorProducto = $valorProducto;

        return $this;
    }

    /**
     * Get valorProducto
     *
     * @return integer 
     */
    public function getValorProducto()
    {
        return $this->valorProducto;
    }

    /**
     * Set valorModificado
     *
     * @param integer $valorModificado
     * @return PedidoDetalle
     */
    public function setValorModificado($valorModificado)
    {
        $this->valorModificado = $valorModificado;

        return $this;
    }

    /**
     * Get valorModificado
     *
     * @return integer 
     */
    public function getValorModificado()
    {
        return $this->valorModificado;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     * @return PedidoDetalle
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer 
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set total
     *
     * @param integer $total
     * @return PedidoDetalle
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return integer 
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     * @return PedidoDetalle
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
     * Set etapaPedidoDetalle
     *
     * @param \AdminBundle\Entity\EtapaPedidoDetalle $etapaPedidoDetalle
     * @return PedidoDetalle
     */
    public function setEtapaPedidoDetalle(\AdminBundle\Entity\EtapaPedidoDetalle $etapaPedidoDetalle = null)
    {
        $this->etapaPedidoDetalle = $etapaPedidoDetalle;

        return $this;
    }

    /**
     * Get etapaPedidoDetalle
     *
     * @return \AdminBundle\Entity\EtapaPedidoDetalle 
     */
    public function getEtapaPedidoDetalle()
    {
        return $this->etapaPedidoDetalle;
    }

    /**
     * Set personal
     *
     * @param \AdminBundle\Entity\Personal $personal
     * @return PedidoDetalle
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

    /**
     * Set fkPedido
     *
     * @param \AdminBundle\Entity\Pedidos $fkPedido
     * @return PedidoDetalle
     */
    public function setFkPedido(\AdminBundle\Entity\Pedidos $fkPedido = null)
    {
        $this->fkPedido = $fkPedido;

        return $this;
    }

    /**
     * Get fkPedido
     *
     * @return \AdminBundle\Entity\Pedidos 
     */
    public function getFkPedido()
    {
        return $this->fkPedido;
    }

    /**
     * Set fkProducto
     *
     * @param \AdminBundle\Entity\Producto $fkProducto
     * @return PedidoDetalle
     */
    public function setFkProducto(\AdminBundle\Entity\Producto $fkProducto = null)
    {
        $this->fkProducto = $fkProducto;

        return $this;
    }

    /**
     * Get fkProducto
     *
     * @return \AdminBundle\Entity\Producto 
     */
    public function getFkProducto()
    {
        return $this->fkProducto;
    }
}
