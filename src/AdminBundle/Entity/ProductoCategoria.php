<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductoCategoria
 *
 * @ORM\Table(name="producto_categoria", indexes={@ORM\Index(name="fk_producto", columns={"fk_producto"}), @ORM\Index(name="fk_categoria", columns={"fk_categoria"})})
 * @ORM\Entity
 */
class ProductoCategoria
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
     * @var \Producto
     *
     * @ORM\ManyToOne(targetEntity="Producto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_producto", referencedColumnName="id")
     * })
     */
    private $fkProducto;

    /**
     * @var \Categorias
     *
     * @ORM\ManyToOne(targetEntity="Categorias")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_categoria", referencedColumnName="id")
     * })
     */
    private $fkCategoria;



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
     * Set fkProducto
     *
     * @param \AdminBundle\Entity\Producto $fkProducto
     * @return ProductoCategoria
     */
    public function setFkProducto(\AdminBundle\Entity\Producto $fkProducto = null)
    {
        $this->fkProducto = $fkProducto;

        return $this;
    }

    /**
     * Get fkProducto
     *
     * @return \AdminBundle\Entity\Producto 
     */
    public function getFkProducto()
    {
        return $this->fkProducto;
    }

    /**
     * Set fkCategoria
     *
     * @param \AdminBundle\Entity\Categorias $fkCategoria
     * @return ProductoCategoria
     */
    public function setFkCategoria(\AdminBundle\Entity\Categorias $fkCategoria = null)
    {
        $this->fkCategoria = $fkCategoria;

        return $this;
    }

    /**
     * Get fkCategoria
     *
     * @return \AdminBundle\Entity\Categorias 
     */
    public function getFkCategoria()
    {
        return $this->fkCategoria;
    }
}
