<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')] 
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $slug;

    #[ORM\Column(type: 'string', length: 255)]
    private $illustration;

    #[ORM\Column(type: 'string', length: 255)]
    private $subtitle;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'float')]
    private $price;

    #[ORM\ManyToOne(targetEntity: Categry::class, inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private $categry;

    #[ORM\ManyToMany(targetEntity: self::class)]
    private $products;

    #[ORM\Column(type: 'boolean')]
    private $meilleur;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $baklawa;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $nosSpecialites;


    #[ORM\Column(type: 'boolean', nullable: true)]
    private $autre;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $fruitSec;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->carts = new ArrayCollection();
    }

    public function __toString() {
        return $this->getId();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getIllustration(): ?string
    {
        return $this->illustration;
    }

    public function setIllustration(string $illustration): self
    {
        $this->illustration = $illustration;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): self
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCategry(): ?Categry
    {
        return $this->categry;
    }

    public function setCategry(?Categry $categry): self
    {
        $this->categry = $categry;

        return $this;
    }

    
    // public function getIsBest(): ?bool
    // {
    //     return $this->isBest;
    // }

    // public function setIsBest(bool $isBest): self
    // {
    //     $this->isBest = $isBest;

    //     return $this;
    // }

    /**
     * @return Collection<int, self>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(self $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
        }
        return $this;
    }

    public function removeProduct(self $product): self
    {
        $this->products->removeElement($product);

        return $this;
    }

    public function isMeilleur(): ?bool
    {
        return $this->meilleur;
    }

    public function setMeilleur(bool $meilleur): self
    {
        $this->meilleur = $meilleur;

        return $this;
    }

    public function isBaklawa(): ?bool
    {
        return $this->baklawa;
    }

    public function setBaklawa(?bool $baklawa): self
    {
        $this->baklawa = $baklawa;

        return $this;
    }

    public function isNosSpecialites(): ?bool
    {
        return $this->nosSpecialites;
    }

    public function setNosSpecialites(?bool $nosSpecialites): self
    {
        $this->nosSpecialites = $nosSpecialites;

        return $this;
    }

    public function isAutre(): ?bool
    {
        return $this->autre;
    }

    public function setAutre(?bool $autre): self
    {
        $this->autre = $autre;

        return $this;
    }

    public function isFruitSec(): ?bool
    {
        return $this->fruitSec;
    }

    public function setfruitSec(?bool $fruitSec): self
    {
        $this->fruitSec = $fruitSec;

        return $this;
    }

}