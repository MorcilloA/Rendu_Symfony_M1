<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\GifRepository;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=GifRepository::class)
 */
class Gif
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *  message="Vous devez sélectionner une image"
     * )
     * @Assert\Image(
     *  mimeTypes={"image/gif", "image/webp"},
     *  mimeTypesMessage="Veuillez choisir un gif ou un webp"
     * )
     */
    private $source;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="gifs")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(
     *  message = "Vous devez sélectionner une sous-catégorie"
     * )
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="gifs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function setSource($source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
