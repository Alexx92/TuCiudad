<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Empresa
 *
 * @ORM\Table(name="empresa", indexes={@ORM\Index(name="fk_empresa_estado_empresa1_idx", columns={"estado_empresa_id"})})
 * @ORM\Entity
 */
class Empresa
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
     * @ORM\Column(name="razonsocial", type="string", length=200, nullable=true)
     */
    private $razonsocial;

    /**
     * @var string
     *
     * @ORM\Column(name="rut", type="string", length=200, nullable=true)
     */
    private $rut;

    /**
     * @var string
     *
     * @ORM\Column(name="comuna", type="string", length=30, nullable=false)
     */
    private $comuna;

    /**
     * @var string
     *
     * @ORM\Column(name="provincia", type="string", length=30, nullable=false)
     */
    private $provincia;

    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", length=30, nullable=false)
     */
    private $region;

    /**
     * @var string
     *
     * @ORM\Column(name="dir_villa_pbla", type="string", length=50, nullable=true)
     */
    private $dirVillaPbla;

    /**
     * @var string
     *
     * @ORM\Column(name="dir_calle", type="string", length=50, nullable=true)
     */
    private $dirCalle;

    /**
     * @var integer
     *
     * @ORM\Column(name="dir_numero", type="integer", nullable=true)
     */
    private $dirNumero;

    /**
     * @var integer
     *
     * @ORM\Column(name="dir_numero_departamento", type="integer", nullable=true)
     */
    private $dirNumeroDepartamento;

    /**
     * @var integer
     *
     * @ORM\Column(name="dir_numero_piso", type="integer", nullable=true)
     */
    private $dirNumeroPiso;

    /**
     * @var integer
     *
     * @ORM\Column(name="telefono", type="integer", nullable=true)
     */
    private $telefono;

    /**
     * @var integer
     *
     * @ORM\Column(name="celular", type="integer", nullable=true)
     */
    private $celular;

    /**
     * @var string
     *
     * @ORM\Column(name="correo", type="string", length=200, nullable=true)
     */
    private $correo;

    /**
     * @var string
     *
     * @ORM\Column(name="web", type="string", length=200, nullable=true)
     */
    private $web;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="text", length=65535, nullable=true)
     */
    private $observacion;

    /**
     * @var string
     *
     * @ORM\Column(name="coordenadas", type="string", length=200, nullable=true)
     */
    private $coordenadas;

    /**
     * @var string
     *
     * @ORM\Column(name="imagen", type="string", length=200, nullable=true)
     */
    private $imagen;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_ingreso", type="datetime", nullable=false)
     */
    private $fechaIngreso;

    /**
     * @var integer
     *
     * @ORM\Column(name="estado", type="integer", nullable=false)
     */
    private $estado;

    /**
     * @var \EstadoEmpresa
     *
     * @ORM\ManyToOne(targetEntity="EstadoEmpresa")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="estado_empresa_id", referencedColumnName="id")
     * })
     */
    private $estadoEmpresa;



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
     * @return Empresa
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
     * Set razonsocial
     *
     * @param string $razonsocial
     * @return Empresa
     */
    public function setRazonsocial($razonsocial)
    {
        $this->razonsocial = $razonsocial;

        return $this;
    }

    /**
     * Get razonsocial
     *
     * @return string 
     */
    public function getRazonsocial()
    {
        return $this->razonsocial;
    }

    /**
     * Set rut
     *
     * @param string $rut
     * @return Empresa
     */
    public function setRut($rut)
    {
        $this->rut = $rut;

        return $this;
    }

    /**
     * Get rut
     *
     * @return string 
     */
    public function getRut()
    {
        return $this->rut;
    }

    /**
     * Set comuna
     *
     * @param string $comuna
     * @return Empresa
     */
    public function setComuna($comuna)
    {
        $this->comuna = $comuna;

        return $this;
    }

    /**
     * Get comuna
     *
     * @return string 
     */
    public function getComuna()
    {
        return $this->comuna;
    }

    /**
     * Set provincia
     *
     * @param string $provincia
     * @return Empresa
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return string 
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Set region
     *
     * @param string $region
     * @return Empresa
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string 
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set dirVillaPbla
     *
     * @param string $dirVillaPbla
     * @return Empresa
     */
    public function setDirVillaPbla($dirVillaPbla)
    {
        $this->dirVillaPbla = $dirVillaPbla;

        return $this;
    }

    /**
     * Get dirVillaPbla
     *
     * @return string 
     */
    public function getDirVillaPbla()
    {
        return $this->dirVillaPbla;
    }

    /**
     * Set dirCalle
     *
     * @param string $dirCalle
     * @return Empresa
     */
    public function setDirCalle($dirCalle)
    {
        $this->dirCalle = $dirCalle;

        return $this;
    }

    /**
     * Get dirCalle
     *
     * @return string 
     */
    public function getDirCalle()
    {
        return $this->dirCalle;
    }

    /**
     * Set dirNumero
     *
     * @param integer $dirNumero
     * @return Empresa
     */
    public function setDirNumero($dirNumero)
    {
        $this->dirNumero = $dirNumero;

        return $this;
    }

    /**
     * Get dirNumero
     *
     * @return integer 
     */
    public function getDirNumero()
    {
        return $this->dirNumero;
    }

    /**
     * Set dirNumeroDepartamento
     *
     * @param integer $dirNumeroDepartamento
     * @return Empresa
     */
    public function setDirNumeroDepartamento($dirNumeroDepartamento)
    {
        $this->dirNumeroDepartamento = $dirNumeroDepartamento;

        return $this;
    }

    /**
     * Get dirNumeroDepartamento
     *
     * @return integer 
     */
    public function getDirNumeroDepartamento()
    {
        return $this->dirNumeroDepartamento;
    }

    /**
     * Set dirNumeroPiso
     *
     * @param integer $dirNumeroPiso
     * @return Empresa
     */
    public function setDirNumeroPiso($dirNumeroPiso)
    {
        $this->dirNumeroPiso = $dirNumeroPiso;

        return $this;
    }

    /**
     * Get dirNumeroPiso
     *
     * @return integer 
     */
    public function getDirNumeroPiso()
    {
        return $this->dirNumeroPiso;
    }

    /**
     * Set telefono
     *
     * @param integer $telefono
     * @return Empresa
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return integer 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set celular
     *
     * @param integer $celular
     * @return Empresa
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;

        return $this;
    }

    /**
     * Get celular
     *
     * @return integer 
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * Set correo
     *
     * @param string $correo
     * @return Empresa
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get correo
     *
     * @return string 
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Set web
     *
     * @param string $web
     * @return Empresa
     */
    public function setWeb($web)
    {
        $this->web = $web;

        return $this;
    }

    /**
     * Get web
     *
     * @return string 
     */
    public function getWeb()
    {
        return $this->web;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     * @return Empresa
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
     * Set coordenadas
     *
     * @param string $coordenadas
     * @return Empresa
     */
    public function setCoordenadas($coordenadas)
    {
        $this->coordenadas = $coordenadas;

        return $this;
    }

    /**
     * Get coordenadas
     *
     * @return string 
     */
    public function getCoordenadas()
    {
        return $this->coordenadas;
    }

    /**
     * Set imagen
     *
     * @param string $imagen
     * @return Empresa
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
     * Set fechaIngreso
     *
     * @param \DateTime $fechaIngreso
     * @return Empresa
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
     * Set estado
     *
     * @param integer $estado
     * @return Empresa
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
     * Set estadoEmpresa
     *
     * @param \AdminBundle\Entity\EstadoEmpresa $estadoEmpresa
     * @return Empresa
     */
    public function setEstadoEmpresa(\AdminBundle\Entity\EstadoEmpresa $estadoEmpresa = null)
    {
        $this->estadoEmpresa = $estadoEmpresa;

        return $this;
    }

    /**
     * Get estadoEmpresa
     *
     * @return \AdminBundle\Entity\EstadoEmpresa 
     */
    public function getEstadoEmpresa()
    {
        return $this->estadoEmpresa;
    }
}
