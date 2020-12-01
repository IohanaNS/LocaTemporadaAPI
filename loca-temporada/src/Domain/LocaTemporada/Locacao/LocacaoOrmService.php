<?php
namespace App\Domain\LocaTemporada\Locacao;

use App\Domain\LocaTemporada\Imovel\ImovelEntity;
use App\Domain\LocaTemporada\Locacao\LocacaoEntity as LocacaontityAlias;
use DatePeriod;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;

class LocacaoOrmService
{
    protected EntityManagerInterface $em;
    /**
     * LocacaoOrmService constructor.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $em
     */
    public function __construct(
        EntityManagerInterface $em
    ) {
        $this->em = $em;
    }
    public function obterTodasLocaoes(array $filtros)
    {
        $criteria = new Criteria();

        if (isset($filtros['id'])) {
            $criteria->andWhere(
                $criteria->expr()->eq('id', $filtros['id'])
            );
        }

        if (isset($filtros['imovelId'])) {
            $criteria->andWhere(
                $criteria->expr()->gte('idImovel', $filtros['imovelId']),
            );
        }

        if (isset($filtros['idCliente'])) {
            $criteria->andWhere(
                $criteria->expr()->lte('idCliente', $filtros['idCliente']),
            );
        }
        if (isset($filtros['idSituacaoLocacao'])) {
            $criteria->andWhere(
                $criteria->expr()->lte('idSituacaoLocacao', $filtros['idSituacaoLocacao']),
            );
        }
        if (isset($filtros['dataInicio'])) {
            $criteria->andWhere(
                $criteria->expr()->lte('dataInicio', new \DateTime($filtros['dataInicio'])),
            );
        }
        if (isset($filtros['dataFim'])) {
            $criteria->andWhere(
                $criteria->expr()->lte('dataFim', new \DateTime($filtros['dataFim'])),
            );
        }

        return $this->em->getRepository(LocacaoEntity::class)->matching($criteria);    }



    /**
     * @param int $id
     *
     * @return \App\Domain\Locacao\LocacaoEntity|object|null
     */
    public function obterLocacaoPorId(int $id)
    {
        return $this->em->getRepository(LocacaoEntity::class)->find($id);
    }

    /**
     * @param string $nome
     *
     * @return object[]
     */
    public function obterLocacaoPorNome(string $nome)
    {
        return $this->em->getRepository(LocacaoEntity::class)->findBy([
            'nome' => $nome,
        ]);
    }
    /**
     * @param LocacaoEntity $locacaoEntity
     *
     * @return bool
     */
    public function podeCancelar(LocacaoEntity $locacaoEntity){
        $intervalo = date_diff($locacaoEntity->getDataInicio(), new \DateTime());
        return  $intervalo->days >= 30;
    }
    public function obterLocacaoPorIdCliente(string $idCliente)
    {
        return $this->em->getRepository(LocacaoEntity::class)->findBy([
            'idCliente' => $idCliente,
        ]);
    }
    public function obterLocacaoPorIdImovel(string $id)
    {
        return $this->em->getRepository(LocacaoEntity::class)->findBy([
            'idImovel' => $id,
        ]);
    }

    /**
     * @param \App\Domain\Locacao\LocacaoEntity $locacao
     *
     * @return mixed
     * @throws Exception
     */
    public function inserirLocacao(LocacaoEntity $locacao)
    {
        $LocacaoComEsteImovel = $this->obterLocacaoPorIdImovel($locacao->getIdImovel());
        $alocado = false;
        foreach ($LocacaoComEsteImovel as $loc) {

            if($locacao->getDataInicio() >= $loc->getDataInicio() &&
                $locacao->getDataInicio() <= $loc->getDataFim()
            ){
                $alocado = true;
                break;
            }
        }
        if($alocado) return null;
        else{
            $this->em->persist($locacao);
            $this->em->flush();

            return $locacao;
        }
    }

    /**
     * @param \App\Domain\Locacao\LocacaoEntity $locacao
     *
     * @throws Exception
     */
    public function editarLocacao(LocacaoEntity $locacao)
    {
        $this->em->flush();
        return $locacao;
    }

    /**
     * @param \App\Domain\Locacao\LocacaoEntity $locacao
     */
    public function removerLocacao(LocacaontityAlias $locacao)
    {
        $this->em->remove($locacao);
        $this->em->flush();
    }
}
