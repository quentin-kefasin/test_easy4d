<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use App\Validator\ValidDesignationBrand;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: 'Le code Easy4D ne peut pas être vide.')]
    #[Assert\Regex(
        pattern: '/^[A-Z]\d+$/',
        message: 'Le code Easy4D doit commencer par une lettre suivie de chiffres.'
    )]
    private ?string $easyCode = null;

    #[ORM\Column(type: "bigint", options: ["unsigned" => true])]
    #[Assert\NotBlank(message: 'Le code EAN est obligatoire.')]
    private ?int $eanCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: 'La désignation est obligatoire.')]
    #[ValidDesignationBrand]
    private ?string $designation = null;


    #[ORM\Column]
    private ?int $width = null;

    #[ORM\Column]
    private ?int $height = null;

    #[ORM\Column]
    private ?int $diameter = null;

    #[ORM\Column(length: 3)]
    #[Assert\NotBlank(message: 'Le type de construction est obligatoire.')]
    private ?string $construction = null;

    #[ORM\Column(length: 3)]
    #[Assert\NotBlank(message: 'L\'indice de vitesse est obligatoire.')]
    private ?string $speedIndex = null;

    #[ORM\Column(length: 10)]
    #[Assert\NotBlank(message: 'L\'indice de chargement est obligatoire.')]
    private ?string $loadIndex = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CategoryTyre $categoryTyre = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Brand $brand = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Family $family = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Segment $segment = null;


    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEasyCode(): ?string
    {
        return $this->easyCode;
    }

    public function setEasyCode(string $easyCode): static
    {
        $this->easyCode = $easyCode;

        return $this;
    }

    public function getEanCode(): ?int
    {
        return $this->eanCode;
    }

    public function setEanCode(int $eanCode): static
    {
        $this->eanCode = $eanCode;

        return $this;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(?string $designation): static
    {
        $this->designation = $designation;

        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(int $width): static
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(int $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function getDiameter(): ?int
    {
        return $this->diameter;
    }

    public function setDiameter(int $diameter): static
    {
        $this->diameter = $diameter;

        return $this;
    }

    public function getConstruction(): ?string
    {
        return $this->construction;
    }

    public function setConstruction(string $construction): static
    {
        $this->construction = $construction;

        return $this;
    }

    public function getSpeedIndex(): ?string
    {
        return $this->speedIndex;
    }

    public function setSpeedIndex(string $speedIndex): static
    {
        $this->speedIndex = $speedIndex;

        return $this;
    }

    public function getLoadIndex(): ?string
    {
        return $this->loadIndex;
    }

    public function setLoadIndex(string $loadIndex): static
    {
        $this->loadIndex = $loadIndex;

        return $this;
    }

    public function getCategoryTyre(): ?CategoryTyre
    {
        return $this->categoryTyre;
    }

    public function setCategoryTyre(?CategoryTyre $categoryTyre): static
    {
        $this->categoryTyre = $categoryTyre;

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getFamily(): ?Family
    {
        return $this->family;
    }

    public function setFamily(?Family $family): static
    {
        $this->family = $family;

        return $this;
    }

    public function getSegment(): ?Segment
    {
        return $this->segment;
    }

    public function setSegment(?Segment $segment): static
    {
        $this->segment = $segment;

        return $this;
    }

    
}
