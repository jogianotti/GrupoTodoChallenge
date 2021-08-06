<?php

namespace App\Entity;

use App\Repository\ProductoRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductoRepository::class)
 * @ORM\Table(name="productos")
 * @ORM\HasLifecycleCallbacks()
 */
class Producto
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint", length=11)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, name="nombre")
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true, name="descripcion")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    public static function create(string $name, string $description): self
    {
        $product = new self();

        $product->setName($name);
        $product->setDescription($description);

        return $product;
    }

    /**
     * @ORM\PrePersist
     */
    public function onPersist(): void
    {
        $datetime = new DateTime();
        $this->setCreatedAt($datetime);
        $this->setUpdatedAt($datetime);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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
