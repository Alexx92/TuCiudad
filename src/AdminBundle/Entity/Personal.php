<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Personal
 *
 * @ORM\Table(name="personal", indexes={@ORM\Index(name="fk_personal_empresa1_idx", columns={"empresa_id"})})
 * @ORM\Entity
 */
class Personal
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
     * @ORM\Column(name="primer_nombre", type="string", length=30, nullable=true)
     */
    private $primerNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="segundo_nombre", type="string", length=30, nullable=true)
     */
    private $segundoNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido_paterno", type="string", length=30, nullable=true)
     */
    private $apellidoPaterno;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido_materno", type="string", length=30, nullable=true)
     */
    private $apellidoMaterno;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=180, nullable=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="dni", type="string", length=30, nullable=true)
     */
    private $dni;

    /**
     * @var string
     *
     * @ORM\Column(name="sexo", type="string", length=1, nullable=true)
     */
    private $sexo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_nacimiento", type="date", nullable=true)
     */
    private $fechaNacimiento;

    /**
     * @var string
     *
     * @ORM\Column(name="comuna", type="string", length=30, nullable=true)
     */
    private $comuna;

    /**
     * @var string
     *
     * @ORM\Column(name="provincia", type="string", length=30, nullable=true)
     */
    private $provincia;

    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", length=30, nullable=true)
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
     * @var string
     *
     * @ORM\Column(name="dir_numero_casa", type="string", length=10, nullable=true)
     */
    private $dirNumeroCasa;

    /**
     * @var string
     *
     * @ORM\Column(name="dir_numero_departamento", type="string", length=10, nullable=true)
     */
    private $dirNumeroDepartamento;

    /**
     * @var string
     *
     * @ORM\Column(name="dir_numero_piso", type="string", length=10, nullable=true)
     */
    private $dirNumeroPiso;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=15, nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="celular", type="string", length=15, nullable=true)
     */
    private $celular;

    /**
     * @var string
     *
     * @ORM\Column(name="correo", type="string", length=30, nullable=true)
     */
    private $correo;

    /**
     * @var string
     *
     * @ORM\Column(name="skype", type="string", length=30, nullable=true)
     */
    private $skype;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="text", length=65535, nullable=true)
     */
    private $observacion;

    /**
     * @var string
     *
     * @ORM\Column(name="imagen", type="string", length=200, nullable=true)
     */
    private $imagen;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_ingreso", type="datetime", nullable=true)
     */
    private $fechaIngreso;

    /**
     * @var integer
     *
     * @ORM\Column(name="estado", type="integer", nullable=true)
     */
    private $estado;

    /**
     * @var \Empresa
     *
     * @ORM\ManyToOne(targetEntity="Empresa")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="empresa_id", referencedColumnName="id")
     * })
     */
    private $empresa;



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
     * Set primerNombre
     *
     * @param string $primerNombre
     * @return Personal
     */
    public function setPrimerNombre($primerNombre)
    {
        $this->primerNombre = $primerNombre;

        return $this;
    }

    /**
     * Get primerNombre
     *
     * @return string 
     */
    public function getPrimerNombre()
    {
        return $this->primerNombre;
    }

    /**
     * Set segundoNombre
     *
     * @param string $segundoNombre
     * @return Personal
     */
    public function setSegundoNombre($segundoNombre)
    {
        $this->segundoNombre = $segundoNombre;

        return $this;
    }

    /**
     * Get segundoNombre
     *
     * @return string 
     */
    public function getSegundoNombre()
    {
        return $this->segundoNombre;
    }

    /**
     * Set apellidoPaterno
     *
     * @param string $apellidoPaterno
     * @return Personal
     */
    public function setApellidoPaterno($apellidoPaterno)
    {
        $this->apellidoPaterno = $apellidoPaterno;

        return $this;
    }

    /**
     * Get apellidoPaterno
     *
     * @return string 
     */
    public function getApellidoPaterno()
    {
        return $this->apellidoPaterno;
    }

    /**
     * Set apellidoMaterno
     *
     * @param string $apellidoMaterno
     * @return Personal
     */
    public function setApellidoMaterno($apellidoMaterno)
    {
        $this->apellidoMaterno = $apellidoMaterno;

        return $this;
    }

    /**
     * Get apellidoMaterno
     *
     * @return string 
     */
    public function getApellidoMaterno()
    {
        return $this->apellidoMaterno;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return Personal
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set dni
     *
     * @param string $dni
     * @return Personal
     */
    public function setDni($dni)
    {
        $this->dni = $dni;

        return $this;
    }

    /**
     * Get dni
     *
     * @return string 
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set sexo
     *
     * @param string $sexo
     * @return Personal
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;

        return $this;
    }

    /**
     * Get sexo
     *
     * @return string 
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * Set fechaNacimiento
     *
     * @param \DateTime $fechaNacimiento
     * @return Personal
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    /**
     * Get fechaNacimiento
     *
     * @return \DateTime 
     */
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    /**
     * Set comuna
     *
     * @param string $comuna
     * @return Personal
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
     * @return Personal
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
     * @return Personal
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
     * @return Personal
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
     * @return Personal
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
     * Set dirNumeroCasa
     *
     * @param string $dirNumeroCasa
     * @return Personal
     */
    public function setDirNumeroCasa($dirNumeroCasa)
    {
        $this->dirNumeroCasa = $dirNumeroCasa;

        return $this;
    }

    /**
     * Get dirNumeroCasa
     *
     * @return string 
     */
    public function getDirNumeroCasa()
    {
        return $this->dirNumeroCasa;
    }

    /**
     * Set dirNumeroDepartamento
     *
     * @param string $dirNumeroDepartamento
     * @return Personal
     */
    public function setDirNumeroDepartamento($dirNumeroDepartamento)
    {
        $this->dirNumeroDepartamento = $dirNumeroDepartamento;

        return $this;
    }

    /**
     * Get dirNumeroDepartamento
     *
     * @return string 
     */
    public function getDirNumeroDepartamento()
    {
        return $this->dirNumeroDepartamento;
    }

    /**
     * Set dirNumeroPiso
     *
     * @param string $dirNumeroPiso
     * @return Personal
     */
    public function setDirNumeroPiso($dirNumeroPiso)
    {
        $this->dirNumeroPiso = $dirNumeroPiso;

        return $this;
    }

    /**
     * Get dirNumeroPiso
     *
     * @return string 
     */
    public function getDirNumeroPiso()
    {
        return $this->dirNumeroPiso;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Personal
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set celular
     *
     * @param string $celular
     * @return Personal
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;

        return $this;
    }

    /**
     * Get celular
     *
     * @return string 
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * Set correo
     *
     * @param string $correo
     * @return Personal
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
     * Set skype
     *
     * @param string $skype
     * @return Personal
     */
    public function setSkype($skype)
    {
        $this->skype = $skype;

        return $this;
    }

    /**
     * Get skype
     *
     * @return string 
     */
    public function getSkype()
    {
        return $this->skype;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     * @return Personal
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
     * Set imagen
     *
     * @param string $imagen
     * @return Personal
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
     * @return Personal
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
     * @return Personal
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
     * Set empresa
     *
     * @param \AdminBundle\Entity\Empresa $empresa
     * @return Personal
     */
    public function setEmpresa(\AdminBundle\Entity\Empresa $empresa = null)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return \AdminBundle\Entity\Empresa 
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }
}
