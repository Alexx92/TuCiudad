<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContacEmpre
 *
 * @ORM\Table(name="contac_empre", indexes={@ORM\Index(name="fk_contacto", columns={"fk_contacto"}), @ORM\Index(name="fk_empresa", columns={"fk_empresa"})})
 * @ORM\Entity
 */
class ContacEmpre
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
     * @var \Contacto
     *
     * @ORM\ManyToOne(targetEntity="Contacto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_contacto", referencedColumnName="id")
     * })
     */
    private $fkContacto;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fkContacto
     *
     * @param \AdminBundle\Entity\Contacto $fkContacto
     * @return ContacEmpre
     */
    public function setFkContacto(\AdminBundle\Entity\Contacto $fkContacto = null)
    {
        $this->fkContacto = $fkContacto;

        return $this;
    }

    /**
     * Get fkContacto
     *
     * @return \AdminBundle\Entity\Contacto 
     */
    public function getFkContacto()
    {
        return $this->fkContacto;
    }

    /**
     * Set fkEmpresa
     *
     * @param \AdminBundle\Entity\Empresa $fkEmpresa
     * @return ContacEmpre
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
}
