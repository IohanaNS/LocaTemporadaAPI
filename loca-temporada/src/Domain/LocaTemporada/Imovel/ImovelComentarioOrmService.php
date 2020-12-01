<?php
namespace App\Domain\LocaTemporada\Imovel;

use App\Domain\LocaTemporada\Imovel\ImovelComentarioEntity;
use App\Domain\LocaTemporada\Imovel\ImovelComentarioEntity as ImovelntityAlias;
use App\Domain\LocaTemporada\Locacao\LocacaoEntity;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;

class ImovelComentarioOrmService
{
    protected EntityManagerInterface $em;


    /**
     * ImovelComentarioOrmService constructor.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $em
     */
    public function __construct(
        EntityManagerInterface $em
    ) {
        $this->em = $em;
    }
    public function obterTodosComentarios(array $filter)
    {
        $criteria = new Criteria();

        if (isset($filtros['id'])) {
            $criteria->andWhere(
                $criteria->expr()->eq('id', $filtros['id'])
            );
        }

        if (isset($filtros['imovelId'])) {
            $criteria->andWhere(
                $criteria->expr()->gte('id_imovel', $filtros['imovelId']),
            );
        }

        if (isset($filtros['idCliente'])) {
            $criteria->andWhere(
                $criteria->expr()->lte('id_cliente', $filtros['idCliente']),
            );
        }
        if (isset($filtros['dataHora'])) {
            $criteria->andWhere(
                $criteria->expr()->lte('data_hora', $filtros['dataHora']),
            );
        }
        if (isset($filtros['texto'])) {
            $criteria->andWhere(
                $criteria->expr()->lte('texto', $filtros['texto']),
            );
        }

        return $this->em->getRepository(ImovelComentarioEntity::class)->matching($criteria);    }

    /**
     * @param int $id
     *
     * @return \App\Domain\Imovel\ImovelComentarioEntity|object|null
     */
    public function obterComentarioPorImovelId(int $id)
    {
        return $this->em->getRepository(ImovelComentarioEntity::class)->findBy([
            'idImovel' => $id,
        ]);    }


    /**
     * @param string $nome
     *
     * @return object[]
     */
    public function obterComentarioPorDescImovel(string $nome)
    {
        return $this->em->getRepository(ImovelComentarioEntity::class)->findBy([
            'nome' => $nome,
        ]);
    }

    /**
     * @param \App\Domain\Imovel\ImovelComentarioEntity $imovelComentario
     *
     * @return mixed
     * @throws Exception
     */
    public function inserirComentario(ImovelntityAlias $imovelComentario)
    {
        $this->em->persist($imovelComentario);
        $this->em->flush();

        return $imovelComentario;
    }

}
