<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EPProducto
 *
 * @ORM\Table(name="e_p_producto", indexes={@ORM\Index(name="fk_e_p_producto_pedido_detalle1_idx", columns={"pedido_detalle_id"}), @ORM\Index(name="fk_e_p_producto_etapa_produccion1_idx", columns={"etapa_produccion_id"}), @ORM\Index(name="fk_e_p_producto_etapa_pedido_detalle1_idx", columns={"etapa_pedido_detalle_id"}), @ORM\Index(name="fk_e_p_producto_personal1_idx", columns={"personal_id"})})
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_cambio", type="datetime", nullable=true)
     */
    private $fechaCambio;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="string", length=200, nullable=true)
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
     * @return EPProducto
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
     * Set observacion
     *
     * @param string $observacion
     * @return EPProducto
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
     * @return EPProducto
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

    /**
     * Set personal
     *
     * @param \AdminBundle\Entity\Personal $personal
     * @return EPProducto
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
