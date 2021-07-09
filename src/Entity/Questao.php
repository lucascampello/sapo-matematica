<?php

namespace App\Entity;

use App\Repository\QuestaoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuestaoRepository::class)
 */
class Questao
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Questionario::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $questionario;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titulo;

    /**
     * @ORM\Column(type="text")
     */
    private $descricao;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $resultado;

    /**
     * @ORM\OneToMany(targetEntity=Alternativas::class, mappedBy="questao")
     */
    private $alternativas;

    public function __construct()
    {
        $this->alternativas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestionario(): ?Questionario
    {
        return $this->questionario;
    }

    public function setQuestionario(?Questionario $questionario): self
    {
        $this->questionario = $questionario;

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

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }

    public function getResultado(): ?string
    {
        return $this->resultado;
    }

    public function setResultado(string $resultado): self
    {
        $this->resultado = $resultado;

        return $this;
    }

    /**
     * @return Collection|Alternativas[]
     */
    public function getAlternativas(): Collection
    {
        return $this->alternativas;
    }

    public function addAlternativa(Alternativas $alternativa): self
    {
        if (!$this->alternativas->contains($alternativa)) {
            $this->alternativas[] = $alternativa;
            $alternativa->setQuestao($this);
        }

        return $this;
    }

    public function removeAlternativa(Alternativas $alternativa): self
    {
        if ($this->alternativas->removeElement($alternativa)) {
            // set the owning side to null (unless already changed)
            if ($alternativa->getQuestao() === $this) {
                $alternativa->setQuestao(null);
            }
        }

        return $this;
    }
}
