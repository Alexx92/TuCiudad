<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pedidos
 *
 * @ORM\Table(name="pedidos", indexes={@ORM\Index(name="fk_empresa", columns={"fk_empresa"}), @ORM\Index(name="fk_vendedor", columns={"fk_vendedor"}), @ORM\Index(name="fk_etapa", columns={"fk_etapa"})})
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
     * @ORM\Column(name="valor_bruto", type="string", length=50, nullable=true)
     */
    private $valorBruto;

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
     * @var \Vendedor
     *
     * @ORM\ManyToOne(targetEntity="Vendedor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_vendedor", referencedColumnName="id")
     * })
     */
    private $fkVendedor;

    /**
     * @var \Empresa
     *
     * @ORM\ManyToOne(targetEntity="Empresa")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_empresa", referencedColumnName="id")
     * })
     */
    private $fkEmpresa;

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
     * Set valorBruto
     *
     * @param string $valorBruto
     * @return Pedidos
     */
    public function setValorBruto($valorBruto)
    {
        $this->valorBruto = $valorBruto;

        return $this;
    }

    /**
     * Get valorBruto
     *
     * @return string 
     */
    public function getValorBruto()
    {
        return $this->valorBruto;
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
     * Set fkVendedor
     *
     * @param \AdminBundle\Entity\Vendedor $fkVendedor
     * @return Pedidos
     */
    public function setFkVendedor(\AdminBundle\Entity\Vendedor $fkVendedor = null)
    {
        $this->fkVendedor = $fkVendedor;

        return $this;
    }

    /**
     * Get fkVendedor
     *
     * @return \AdminBundle\Entity\Vendedor 
     */
    public function getFkVendedor()
    {
        return $this->fkVendedor;
    }

    /**
     * Set fkEmpresa
     *
     * @param \AdminBundle\Entity\Empresa $fkEmpresa
     * @return Pedidos
     */
    public function setFkEmpresa(\AdminBundle\Entity\Empresa $fkEmpresa = null)
    {
        $this->fkEmpresa = $fkEmpresa;

        return $this;
    }

    /**
     * Get fkEmpresa
     *
     * @return \AdminBundle\Entity\Empresa 
     */
    public function getFkEmpresa()
    {
        return $this->fkEmpresa;
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
