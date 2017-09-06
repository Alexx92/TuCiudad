<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pedidos
 *
 * @ORM\Table(name="pedidos", indexes={@ORM\Index(name="fk_pedidos_contac_empre1_idx", columns={"contac_empre_id"}), @ORM\Index(name="fk_pedidos_personal1_idx", columns={"personal_id"}), @ORM\Index(name="fk_pedidos_etapa_proceso1_idx", columns={"etapa_proceso_id"}), @ORM\Index(name="fk_pedidos_etapa1_idx", columns={"etapa_id"})})
 * @ORM\Entity
 */
class Pedidos
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
     * @ORM\Column(name="codigo_pedido", type="string", length=200, nullable=true)
     */
    private $codigoPedido;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_cotizacion", type="string", length=200, nullable=true)
     */
    private $codigoCotizacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_ingreso", type="datetime", nullable=false)
     */
    private $fechaIngreso;

    /**
     * @var integer
     *
     * @ORM\Column(name="descuentos", type="integer", nullable=true)
     */
    private $descuentos;

    /**
     * @var integer
     *
     * @ORM\Column(name="iva_actual", type="integer", nullable=true)
     */
    private $ivaActual;

    /**
     * @var integer
     *
     * @ORM\Column(name="valor_neto", type="integer", nullable=true)
     */
    private $valorNeto;

    /**
     * @var integer
     *
     * @ORM\Column(name="total", type="integer", nullable=true)
     */
    private $total;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="text", length=65535, nullable=true)
     */
    private $observacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_modificacion", type="datetime", nullable=true)
     */
    private $fechaModificacion;

    /**
     * @var \ContacEmpre
     *
     * @ORM\ManyToOne(targetEntity="ContacEmpre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="contac_empre_id", referencedColumnName="id")
     * })
     */
    private $contacEmpre;

    /**
     * @var \Etapa
     *
     * @ORM\ManyToOne(targetEntity="Etapa")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="etapa_id", referencedColumnName="id")
     * })
     */
    private $etapa;

    /**
     * @var \EtapaProceso
     *
     * @ORM\ManyToOne(targetEntity="EtapaProceso")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="etapa_proceso_id", referencedColumnName="id")
     * })
     */
    private $etapaProceso;

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
     * Set codigoPedido
     *
     * @param string $codigoPedido
     * @return Pedidos
     */
    public function setCodigoPedido($codigoPedido)
    {
        $this->codigoPedido = $codigoPedido;

        return $this;
    }

    /**
     * Get codigoPedido
     *
     * @return string 
     */
    public function getCodigoPedido()
    {
        return $this->codigoPedido;
    }

    /**
     * Set codigoCotizacion
     *
     * @param string $codigoCotizacion
     * @return Pedidos
     */
    public function setCodigoCotizacion($codigoCotizacion)
    {
        $this->codigoCotizacion = $codigoCotizacion;

        return $this;
    }

    /**
     * Get codigoCotizacion
     *
     * @return string 
     */
    public function getCodigoCotizacion()
    {
        return $this->codigoCotizacion;
    }

    /**
     * Set fechaIngreso
     *
     * @param \DateTime $fechaIngreso
     * @return Pedidos
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
     * Set descuentos
     *
     * @param integer $descuentos
     * @return Pedidos
     */
    public function setDescuentos($descuentos)
    {
        $this->descuentos = $descuentos;

        return $this;
    }

    /**
     * Get descuentos
     *
     * @return integer 
     */
    public function getDescuentos()
    {
        return $this->descuentos;
    }

    /**
     * Set ivaActual
     *
     * @param integer $ivaActual
     * @return Pedidos
     */
    public function setIvaActual($ivaActual)
    {
        $this->ivaActual = $ivaActual;

        return $this;
    }

    /**
     * Get ivaActual
     *
     * @return integer 
     */
    public function getIvaActual()
    {
        return $this->ivaActual;
    }

    /**
     * Set valorNeto
     *
     * @param integer $valorNeto
     * @return Pedidos
     */
    public function setValorNeto($valorNeto)
    {
        $this->valorNeto = $valorNeto;

        return $this;
    }

    /**
     * Get valorNeto
     *
     * @return integer 
     */
    public function getValorNeto()
    {
        return $this->valorNeto;
    }

    /**
     * Set total
     *
     * @param integer $total
     * @return Pedidos
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
     * @return Pedidos
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
     * Set fechaModificacion
     *
     * @param \DateTime $fechaModificacion
     * @return Pedidos
     */
    public function setFechaModificacion($fechaModificacion)
    {
        $this->fechaModificacion = $fechaModificacion;

        return $this;
    }

    /**
     * Get fechaModificacion
     *
     * @return \DateTime 
     */
    public function getFechaModificacion()
    {
        return $this->fechaModificacion;
    }

    /**
     * Set contacEmpre
     *
     * @param \AdminBundle\Entity\ContacEmpre $contacEmpre
     * @return Pedidos
     */
    public function setContacEmpre(\AdminBundle\Entity\ContacEmpre $contacEmpre = null)
    {
        $this->contacEmpre = $contacEmpre;

        return $this;
    }

    /**
     * Get contacEmpre
     *
     * @return \AdminBundle\Entity\ContacEmpre 
     */
    public function getContacEmpre()
    {
        return $this->contacEmpre;
    }

    /**
     * Set etapa
     *
     * @param \AdminBundle\Entity\Etapa $etapa
     * @return Pedidos
     */
    public function setEtapa(\AdminBundle\Entity\Etapa $etapa = null)
    {
        $this->etapa = $etapa;

        return $this;
    }

    /**
     * Get etapa
     *
     * @return \AdminBundle\Entity\Etapa 
     */
    public function getEtapa()
    {
        return $this->etapa;
    }

    /**
     * Set etapaProceso
     *
     * @param \AdminBundle\Entity\EtapaProceso $etapaProceso
     * @return Pedidos
     */
    public function setEtapaProceso(\AdminBundle\Entity\EtapaProceso $etapaProceso = null)
    {
        $this->etapaProceso = $etapaProceso;

        return $this;
    }

    /**
     * Get etapaProceso
     *
     * @return \AdminBundle\Entity\EtapaProceso 
     */
    public function getEtapaProceso()
    {
        return $this->etapaProceso;
    }

    /**
     * Set personal
     *
     * @param \AdminBundle\Entity\Personal $personal
     * @return Pedidos
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
