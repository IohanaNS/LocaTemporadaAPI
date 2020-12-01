<?php
namespace App\Domain\LocaTemporada\Imovel;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table("imoveis")
 */
class ImovelEntity
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected int $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=200, nullable=false)
     */
    protected string $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="local", type="string", length=200, nullable=false)
     */
    protected string $local;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="text", nullable=false)
     */
    protected string $descricao;

    /**
     * @var float
     *
     * @ORM\Column(name="valor_diaria", type="decimal", precision=15, scale=2, nullable=false)
     */
    protected float $valorDiaria;

    /**
     * @var string
     *
     * @ORM\Column(name="foto", type="string", length=200, nullable=false)
     */
    protected string $foto;


    /* GETTERS/SETTERS */

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return ImovelEntity
     */
    public function setId(int $id): ImovelEntity
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     *
     * @return ImovelEntity
     */
    public function setNome(string $nome): ImovelEntity
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocal(): string
    {
        return $this->local;
    }

    /**
     * @param string $local
     *
     * @return ImovelEntity
     */
    public function setLocal(string $local): ImovelEntity
    {
        $this->local = $local;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescricao(): string
    {
        return $this->descricao;
    }

    /**
     * @param string $descricao
     *
     * @return ImovelEntity
     */
    public function setDescricao(string $descricao): ImovelEntity
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * @return float
     */
    public function getValorDiaria(): float
    {
        return $this->valorDiaria;
    }

    /**
     * @param float $valorDiaria
     *
     * @return ImovelEntity
     */
    public function setValorDiaria(float $valorDiaria): ImovelEntity
    {
        $this->valorDiaria = $valorDiaria;

        return $this;
    }

    /**
     * @return string
     */
    public function getFoto(): string
    {
        return $this->foto;
    }

    /**
     * @param string $foto
     *
     * @return ImovelEntity
     */
    public function setFoto(string $foto): ImovelEntity
    {
        $this->foto = $foto;

        return $this;
    }
}
