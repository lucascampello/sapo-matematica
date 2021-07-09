<?php

namespace App\Entity;

use App\Repository\AlternativasRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AlternativasRepository::class)
 */
class Alternativas
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Questao::class, inversedBy="alternativas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $questao;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titulo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestao(): ?Questao
    {
        return $this->questao;
    }

    public function setQuestao(?Questao $questao): self
    {
        $this->questao = $questao;

        return $this;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }
}
