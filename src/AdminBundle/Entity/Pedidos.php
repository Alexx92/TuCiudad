<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pedidos
 *
 * @ORM\Table(name="pedidos", indexes={@ORM\Index(name="fk_etapa", columns={"fk_etapa"}), @ORM\Index(name="fk_pedidos_contac_empre1_idx", columns={"contac_empre_id"}), @ORM\Index(name="fk_pedidos_personal1_idx", columns={"personal_id"}), @ORM\Index(name="fk_pedidos_estapas_proceso1_idx", columns={"estapas_proceso_id"})})
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_ingreso", type="datetime", nullable=true)
     */
    private $fechaIngreso;

    /**
     * @var string
     *
     * @ORM\Column(name="descuentos", type="string", length=50, nullable=true)
     */
    private $descuentos;

    /**
     * @var string
     *
     * @ORM\Column(name="valor_neto", type="string", length=50, nullable=true)
     */
    private $valorNeto;

    /**
     * @var string
     *
     * @ORM\Column(name="total", type="string", length=50, nullable=true)
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
     * @var \EstapasProceso
     *
     * @ORM\ManyToOne(targetEntity="EstapasProceso")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="estapas_proceso_id", referencedColumnName="id")
     * })
     */
    private $estapasProceso;

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
     * @var \Etapas
     *
     * @ORM\ManyToOne(targetEntity="Etapas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_etapa", referencedColumnName="id")
     * })
     */
    private $fkEtapa;



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
     * @param string $descuentos
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
     * @return string 
     */
    public function getDescuentos()
    {
        return $this->descuentos;
    }

    /**
     * Set valorNeto
     *
     * @param string $valorNeto
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
     * @return string 
     */
    public function getValorNeto()
    {
        return $this->valorNeto;
    }

    /**
     * Set total
     *
     * @param string $total
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
     * Set estapasProceso
     *
     * @param \AdminBundle\Entity\EstapasProceso $estapasProceso
     * @return Pedidos
     */
    public function setEstapasProceso(\AdminBundle\Entity\EstapasProceso $estapasProceso = null)
    {
        $this->estapasProceso = $estapasProceso;

        return $this;
    }

    /**
     * Get estapasProceso
     *
     * @return \AdminBundle\Entity\EstapasProceso 
     */
    public function getEstapasProceso()
    {
        return $this->estapasProceso;
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

    /**
     * Set fkEtapa
     *
     * @param \AdminBundle\Entity\Etapas $fkEtapa
     * @return Pedidos
     */
    public function setFkEtapa(\AdminBundle\Entity\Etapas $fkEtapa = null)
    {
        $this->fkEtapa = $fkEtapa;

        return $this;
    }

    /**
     * Get fkEtapa
     *
     * @return \AdminBundle\Entity\Etapas 
     */
    public function getFkEtapa()
    {
        return $this->fkEtapa;
    }
}
