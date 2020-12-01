<?php
namespace App\Domain\LocaTemporada\Imovel;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table("imoveis_comentarios")
 */
class ImovelComentarioEntity
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
     * @var \DateTime
     *
     * @ORM\Column(name="data_hora", type="datetime", nullable=false)
     */
    protected \DateTime $dataHora;

    /**
     * @var string
     *
     * @ORM\Column(name="texto", type="text", nullable=false)
     */
    protected string $texto;


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
     * @return ImovelComentarioEntity
     */
    public function setId(int $id): ImovelComentarioEntity
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
     * @return ImovelComentarioEntity
     */
    public function setIdImovel(int $idImovel): ImovelComentarioEntity
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
     * @return ImovelComentarioEntity
     */
    public function setIdCliente(int $idCliente): ImovelComentarioEntity
    {
        $this->idCliente = $idCliente;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDataHora(): \DateTime
    {
        return $this->dataHora;
    }

    /**
     * @param \DateTime $dataHora
     *
     * @return ImovelComentarioEntity
     */
    public function setDataHora(\DateTime $dataHora): ImovelComentarioEntity
    {
        $this->dataHora = $dataHora;

        return $this;
    }

    /**
     * @return string
     */
    public function getTexto(): string
    {
        return $this->texto;
    }

    /**
     * @param string $texto
     *
     * @return ImovelComentarioEntity
     */
    public function setTexto(string $texto): ImovelComentarioEntity
    {
        $this->texto = $texto;

        return $this;
    }
}
