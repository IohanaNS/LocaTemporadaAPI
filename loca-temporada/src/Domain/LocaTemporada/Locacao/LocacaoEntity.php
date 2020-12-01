<?php
namespace App\Domain\LocaTemporada\Locacao;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table("locacoes")
 */
class LocacaoEntity
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
     * @ORM\Column(name="id_imovel", type="integer", nullable=false)
     */
    protected int $idImovel;

    /**
     * @var int
     *
     * @ORM\Column(name="id_cliente", type="integer", nullable=false)
     */
    protected int $idCliente;

    /**
     * @var int
     *
     * @ORM\Column(name="id_situacao_locacao", type="integer", nullable=false)
     */
    protected int $idSituacaoLocacao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_inicio", type="date", nullable=false)
     */
    protected \DateTime $dataInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_fim", type="date", nullable=false)
     */
    protected \DateTime $dataFim;


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
     * @return LocacaoEntity
     */
    public function setId(int $id): LocacaoEntity
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getIdImovel(): int
    {
        return $this->idImovel;
    }

    /**
     * @param int $idImovel
     *
     * @return LocacaoEntity
     */
    public function setIdImovel(int $idImovel): LocacaoEntity
    {
        $this->idImovel = $idImovel;

        return $this;
    }

    /**
     * @return int
     */
    public function getIdCliente(): int
    {
        return $this->idCliente;
    }

    /**
     * @param int $idCliente
     *
     * @return LocacaoEntity
     */
    public function setIdCliente(int $idCliente): LocacaoEntity
    {
        $this->idCliente = $idCliente;

        return $this;
    }

    /**
     * @return int
     */
    public function getIdSituacaoLocacao(): int
    {
        return $this->idSituacaoLocacao;
    }

    /**
     * @param int $idSituacaoLocacao
     *
     * @return LocacaoEntity
     */
    public function setIdSituacaoLocacao(int $idSituacaoLocacao): LocacaoEntity
    {
        $this->idSituacaoLocacao = $idSituacaoLocacao;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDataInicio(): \DateTime
    {
        return $this->dataInicio;
    }

    /**
     * @param \DateTime $dataInicio
     *
     * @return LocacaoEntity
     */
    public function setDataInicio(\DateTime $dataInicio): LocacaoEntity
    {
        $this->dataInicio = $dataInicio;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDataFim(): \DateTime
    {
        return $this->dataFim;
    }

    /**
     * @param \DateTime $dataFim
     *
     * @return LocacaoEntity
     */
    public function setDataFim(\DateTime $dataFim): LocacaoEntity
    {
        $this->dataFim = $dataFim;

        return $this;
    }
}
