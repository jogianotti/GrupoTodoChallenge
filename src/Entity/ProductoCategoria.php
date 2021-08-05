<?php

namespace App\Entity;

use App\Repository\ProductoCategoriaRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductoCategoriaRepository::class)
 * @ORM\Table(name="producto_categorias")
 */
class ProductoCategoria
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint", length=11)
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Producto::class, inversedBy="productCategory", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false, name="id_producto")
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity=Categoria::class)
     * @ORM\JoinColumn(nullable=false, name="id_categoria")
     */
    private $category;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    public static function create(Producto $product, Categoria $category): self
    {
        $productCategory = new self();

        $productCategory->setProduct($product);
        $productCategory->setCategory($category);

        return $productCategory;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Producto
    {
        return $this->product;
    }

    public function setProduct(Producto $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getCategory(): ?Categoria
    {
        return $this->category;
    }

    public function setCategory(?Categoria $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
