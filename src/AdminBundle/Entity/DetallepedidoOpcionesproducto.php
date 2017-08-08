<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DetallepedidoOpcionesproducto
 *
 * @ORM\Table(name="detallepedido_opcionesproducto", indexes={@ORM\Index(name="fk_detallePedido_opcionesProducto_pedido_detalle1_idx", columns={"pedido_detalle_id"}), @ORM\Index(name="fk_detallePedido_opcionesProducto_opciones_producto1_idx", columns={"opciones_producto_id"})})
 * @ORM\Entity
 */
class DetallepedidoOpcionesproducto
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
     * @ORM\Column(name="cantidad", type="string", length=45, nullable=true)
     */
    private $cantidad;

    /**
     * @var string
     *
     * @ORM\Column(name="valor", type="string", length=45, nullable=true)
     */
    private $valor;

    /**
     * @var \OpcionesProducto
     *
     * @ORM\ManyToOne(targetEntity="OpcionesProducto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="opciones_producto_id", referencedColumnName="id")
     * })
     */
    private $opcionesProducto;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set cantidad
     *
     * @param string $cantidad
     * @return DetallepedidoOpcionesproducto
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
     * Set valor
     *
     * @param string $valor
     * @return DetallepedidoOpcionesproducto
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return string 
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set opcionesProducto
     *
     * @param \AdminBundle\Entity\OpcionesProducto $opcionesProducto
     * @return DetallepedidoOpcionesproducto
     */
    public function setOpcionesProducto(\AdminBundle\Entity\OpcionesProducto $opcionesProducto = null)
    {
        $this->opcionesProducto = $opcionesProducto;

        return $this;
    }

    /**
     * Get opcionesProducto
     *
     * @return \AdminBundle\Entity\OpcionesProducto 
     */
    public function getOpcionesProducto()
    {
        return $this->opcionesProducto;
    }

    /**
     * Set pedidoDetalle
     *
     * @param \AdminBundle\Entity\PedidoDetalle $pedidoDetalle
     * @return DetallepedidoOpcionesproducto
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
}
