<?php

namespace App\Entity;

use App\Repository\QuestionarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuestionarioRepository::class)
 */
class Questionario
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Professor::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $professor;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nome;

    /**
     * @ORM\Column(type="date")
     */
    private $dataInicio;

    /**
     * @ORM\Column(type="date")
     */
    private $dataFim;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $conteudoAbordado;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $hash;

    /**
     * @ORM\OneToMany(targetEntity=Questao::class, mappedBy="questionario")
     */
    private $titulo;

    public function __construct()
    {
        $this->titulo = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProfessor(): ?Professor
    {
        return $this->professor;
    }

    public function setProfessor(?Professor $professor): self
    {
        $this->professor = $professor;

        return $this;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getDataInicio(): ?\DateTimeInterface
    {
        return $this->dataInicio;
    }

    public function setDataInicio(\DateTimeInterface $dataInicio): self
    {
        $this->dataInicio = $dataInicio;

        return $this;
    }

    public function getDataFim(): ?\DateTimeInterface
    {
        return $this->dataFim;
    }

    public function setDataFim(\DateTimeInterface $dataFim): self
    {
        $this->dataFim = $dataFim;

        return $this;
    }

    public function getConteudoAbordado(): ?string
    {
        return $this->conteudoAbordado;
    }

    public function setConteudoAbordado(string $conteudoAbordado): self
    {
        $this->conteudoAbordado = $conteudoAbordado;

        return $this;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * @return Collection|Questao[]
     */
    public function getTitulo(): Collection
    {
        return $this->titulo;
    }

    public function addTitulo(Questao $titulo): self
    {
        if (!$this->titulo->contains($titulo)) {
            $this->titulo[] = $titulo;
            $titulo->setQuestionario($this);
        }

        return $this;
    }

    public function removeTitulo(Questao $titulo): self
    {
        if ($this->titulo->removeElement($titulo)) {
            // set the owning side to null (unless already changed)
            if ($titulo->getQuestionario() === $this) {
                $titulo->setQuestionario(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nome;
    }
}
