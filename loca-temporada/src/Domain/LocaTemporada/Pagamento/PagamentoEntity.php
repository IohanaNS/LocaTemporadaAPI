<?php
namespace App\Domain\LocaTemporada\Pagamento;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table("pagamentos")
 */
class PagamentoEntity
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
     * @var int
     *
     * @ORM\Column(name="id_locacao", type="integer", nullable=false)
     */
    protected int $idLocacao;

    /**
     * @var int
     *
     * @ORM\Column(name="id_tipo_pagamento", type="integer", nullable=false)
     */
    protected int $idTipoPagamento;

    /**
     * @var float
     *
     * @ORM\Column(name="valor", type="decimal", precision=15, scale=2, nullable=false)
     */
    protected float $valor;

    /**
     * @var string
     *
     * @ORM\Column(name="id_transacao_pagamento", type="string", length=200, nullable=false)
     */
    protected string $idTransacaoPagamento;


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
     * @return PagamentoEntity
     */
    public function setId(int $id): PagamentoEntity
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getIdLocacao(): int
    {
        return $this->idLocacao;
    }

    /**
     * @param int $idLocacao
     *
     * @return PagamentoEntity
     */
    public function setIdLocacao(int $idLocacao): PagamentoEntity
    {
        $this->idLocacao = $idLocacao;

        return $this;
    }

    /**
     * @return int
     */
    public function getIdTipoPagamento(): int
    {
        return $this->idTipoPagamento;
    }

    /**
     * @param int $idTipoPagamento
     *
     * @return PagamentoEntity
     */
    public function setIdTipoPagamento(int $idTipoPagamento): PagamentoEntity
    {
        $this->idTipoPagamento = $idTipoPagamento;

        return $this;
    }

    /**
     * @return float
     */
    public function getValor(): float
    {
        return $this->valor;
    }

    /**
     * @param float $valor
     *
     * @return PagamentoEntity
     */
    public function setValor(float $valor): PagamentoEntity
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * @return string
     */
    public function getIdTransacaoPagamento(): string
    {
        return $this->idTransacaoPagamento;
    }

    /**
     * @param string $idTransacaoPagamento
     *
     * @return PagamentoEntity
     */
    public function setIdTransacaoPagamento(string $idTransacaoPagamento): PagamentoEntity
    {
        $this->idTransacaoPagamento = $idTransacaoPagamento;

        return $this;
    }
}
