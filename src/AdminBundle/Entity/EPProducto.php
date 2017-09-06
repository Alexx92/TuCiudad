<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EPProducto
 *
 * @ORM\Table(name="e_p_producto", indexes={@ORM\Index(name="fk_e_p_producto_pedido_detalle1_idx", columns={"pedido_detalle_id"}), @ORM\Index(name="fk_e_p_producto_etapa_produccion1_idx", columns={"etapa_produccion_id"})})
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
     * @var \EtapaProduccion
     *
     * @ORM\ManyToOne(targetEntity="EtapaProduccion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="etapa_produccion_id", referencedColumnName="id")
     * })
     */
    private $etapaProduccion;

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
     * Set etapaProduccion
     *
     * @param \AdminBundle\Entity\EtapaProduccion $etapaProduccion
     * @return EPProducto
     */
    public function setEtapaProduccion(\AdminBundle\Entity\EtapaProduccion $etapaProduccion = null)
    {
        $this->etapaProduccion = $etapaProduccion;

        return $this;
    }

    /**
     * Get etapaProduccion
     *
     * @return \AdminBundle\Entity\EtapaProduccion 
     */
    public function getEtapaProduccion()
    {
        return $this->etapaProduccion;
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
}
