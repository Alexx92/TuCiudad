<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DefProvincia
 *
 * @ORM\Table(name="def_provincia", indexes={@ORM\Index(name="pro_region_fk", columns={"pro_region_fk"})})
 * @ORM\Entity
 */
class DefProvincia
{
    /**
     * @var integer
     *
     * @ORM\Column(name="pro_id_pk", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $proIdPk;

    /**
     * @var string
     *
     * @ORM\Column(name="pro_nombre", type="string", length=25, nullable=true)
     */
    private $proNombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="pro_comunas", type="integer", nullable=true)
     */
    private $proComunas;

    /**
     * @var \DefRegion
     *
     * @ORM\ManyToOne(targetEntity="DefRegion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pro_region_fk", referencedColumnName="reg_id_pk")
     * })
     */
    private $proRegionFk;



    /**
     * Get proIdPk
     *
     * @return integer 
     */
    public function getProIdPk()
    {
        return $this->proIdPk;
    }

    /**
     * Set proNombre
     *
     * @param string $proNombre
     * @return DefProvincia
     */
    public function setProNombre($proNombre)
    {
        $this->proNombre = $proNombre;

        return $this;
    }

    /**
     * Get proNombre
     *
     * @return string 
     */
    public function getProNombre()
    {
        return $this->proNombre;
    }

    /**
     * Set proComunas
     *
     * @param integer $proComunas
     * @return DefProvincia
     */
    public function setProComunas($proComunas)
    {
        $this->proComunas = $proComunas;

        return $this;
    }

    /**
     * Get proComunas
     *
     * @return integer 
     */
    public function getProComunas()
    {
        return $this->proComunas;
    }

    /**
     * Set proRegionFk
     *
     * @param \AdminBundle\Entity\DefRegion $proRegionFk
     * @return DefProvincia
     */
    public function setProRegionFk(\AdminBundle\Entity\DefRegion $proRegionFk = null)
    {
        $this->proRegionFk = $proRegionFk;

        return $this;
    }

    /**
     * Get proRegionFk
     *
     * @return \AdminBundle\Entity\DefRegion 
     */
    public function getProRegionFk()
    {
        return $this->proRegionFk;
    }
}
