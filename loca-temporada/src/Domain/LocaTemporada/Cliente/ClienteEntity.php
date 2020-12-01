<?php
namespace App\Domain\LocaTemporada\Cliente;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table("clientes")
 */
class ClienteEntity
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
     * @ORM\Column(name="cpf", type="string", length=200, nullable=false)
     */
    protected string $cpf;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_nascimento", type="date", nullable=false)
     */
    protected \DateTime $dataNascimento;

    /**
     * @var string
     *
     * @ORM\Column(name="senha", type="string", length=200, nullable=false)
     */
    protected string $senha;

    /**
     * @var string|null
     *
     * @ORM\Column(name="token", type="string", length=200, nullable=true)
     */
    protected ?string $token;


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
     * @return ClienteEntity
     */
    public function setId(int $id): ClienteEntity
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
     * @return ClienteEntity
     */
    public function setNome(string $nome): ClienteEntity
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * @return string
     */
    public function getCpf(): string
    {
        return $this->cpf;
    }

    /**
     * @param string $cpf
     *
     * @return ClienteEntity
     */
    public function setCpf(string $cpf): ClienteEntity
    {
        $this->cpf = $cpf;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDataNascimento(): \DateTime
    {
        return $this->dataNascimento;
    }

    /**
     * @param \DateTime $dataNascimento
     *
     * @return ClienteEntity
     */
    public function setDataNascimento(\DateTime $dataNascimento): ClienteEntity
    {
        $this->dataNascimento = $dataNascimento;

        return $this;
    }

    /**
     * @return string
     */
    public function getSenha(): string
    {
        return $this->senha;
    }

    /**
     * @param string $senha
     *
     * @return ClienteEntity
     */
    public function setSenha(string $senha): ClienteEntity
    {
        $this->senha = $senha;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @param string|null $token
     *
     * @return ClienteEntity
     */
    public function setToken(?string $token): ClienteEntity
    {
        $this->token = $token;

        return $this;
    }
}
