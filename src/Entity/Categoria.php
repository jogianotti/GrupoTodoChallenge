<?php

namespace App\Entity;

use App\Repository\CategoriaRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoriaRepository::class)
 * @ORM\Table(name="categorias")
 * @ORM\HasLifecycleCallbacks()
 */
class Categoria
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
     * @ORM\Column(type="text", name="descripcion", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Categoria::class, inversedBy="children")
     */
    private $parent;

    /** @ORM\OneToMany(targetEntity=Categoria::class, mappedBy="parent", cascade={"remove"}) */
    private $children;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $path;

    public function __construct(?int $id = null)
    {
        if ($id) {
            $this->id = $id;
        }
    }

    public static function create(string $name, ?string $description, ?Categoria $parent = null): self
    {
        $category = new self();

        $category->setName($name);
        $category->setDescription($description);
        $category->setParent($parent);

        return $category;
    }

    /**
     * @ORM\PrePersist
     */
    public function onPersist()
    {
        $datetime = new DateTime();
        $this->setCreatedAt($datetime);
        $this->setUpdatedAt($datetime);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription($description): void
    {
        $this->description = $description;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        $this->makePath();

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

    public function getPath(): ?string
    {
        return $this->path ?? $this->getName() . ' / ';
    }

    public function setPath(?string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        $this->makePath();

        return $this;
    }

    public function makePath(): self
    {
        $parentPath = ($this->getParent()) ? $this->getParent()->getPath() : '';

        $this->setPath($parentPath . $this->getName() . ' / ');

        return $this;
    }
}
