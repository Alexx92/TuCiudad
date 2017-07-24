<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EPProducto
 *
 * @ORM\Table(name="e_p_producto", indexes={@ORM\Index(name="fk_etapas_produccion_producto_etapas_produccion1_idx", columns={"etapas_produccion_id"}), @ORM\Index(name="fk_e_p_producto_pedido_detalle1_idx", columns={"pedido_detalle_id"})})
 * @ORM\Entity
 */
class EPProducto
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
     * @var \PedidoDetalle
     *
     * @ORM\ManyToOne(targetEntity="PedidoDetalle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pedido_detalle_id", referencedColumnName="id")
     * })
     */
    private $pedidoDetalle;

    /**
     * @var \EtapasProduccion
     *
     * @ORM\ManyToOne(targetEntity="EtapasProduccion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="etapas_produccion_id", referencedColumnName="id")
     * })
     */
    private $etapasProduccion;



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
     * Set pedidoDetalle
     *
     * @param \AdminBundle\Entity\PedidoDetalle $pedidoDetalle
     * @return EPProducto
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
     * Set etapasProduccion
     *
     * @param \AdminBundle\Entity\EtapasProduccion $etapasProduccion
     * @return EPProducto
     */
    public function setEtapasProduccion(\AdminBundle\Entity\EtapasProduccion $etapasProduccion = null)
    {
        $this->etapasProduccion = $etapasProduccion;

        return $this;
    }

    /**
     * Get etapasProduccion
     *
     * @return \AdminBundle\Entity\EtapasProduccion 
     */
    public function getEtapasProduccion()
    {
        return $this->etapasProduccion;
    }
}
