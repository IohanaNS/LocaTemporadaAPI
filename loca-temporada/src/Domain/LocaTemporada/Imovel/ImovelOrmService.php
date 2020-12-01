<?php
namespace App\Domain\LocaTemporada\Imovel;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;

class ImovelOrmService
{
    protected EntityManagerInterface $em;


    /**
     * ImovelOrmService constructor.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $em
     */
    public function __construct(
        EntityManagerInterface $em
    ) {
        $this->em = $em;
    }

    public function obterTodosImoveis(array $filtros)
    {
        $criteria = new Criteria();

        if (isset($filtros['id'])) {
            $criteria->andWhere(
                $criteria->expr()->eq('id', $filtros['id'])
            );
        }

        if (isset($filtros['nome'])) {
            $criteria->andWhere(
                $criteria->expr()->gte('nome', $filtros['nome']),
            );
        }

        if (isset($filtros['local'])) {
            $criteria->andWhere(
                $criteria->expr()->lte('local', $filtros['local']),
            );
        }
        if (isset($filtros['descricao'])) {
            $criteria->andWhere(
                $criteria->expr()->lte('descricao', $filtros['descricao']),
            );
        }
        if (isset($filtros['valorDiaria'])) {
            $criteria->andWhere(
                $criteria->expr()->lte('valorDiaria', $filtros['valorDiaria']),
            );
        }
        if (isset($filtros['foto'])) {
            $criteria->andWhere(
                $criteria->expr()->lte('foto', $filtros['foto']),
            );
        }

        return $this->em->getRepository(ImovelEntity::class)->matching($criteria);    }

    /**
     * @param int $id
     *
     * @return \App\Domain\Imovel\ImovelEntity|object|null
     */
    public function obterImovelPorId(int $id)
    {
        return $this->em->getRepository(ImovelEntity::class)->find($id);
    }

    /**
     * @param string $nome
     *
     * @return object[]
     */
    public function obterImovelPorNome(string $nome)
    {
        return $this->em->getRepository(ImovelEntity::class)->findBy([
            'nome' => $nome,
        ]);
    }
    public function obterImovelPorDesc(string $nome)
    {
        return $this->em->getRepository(ImovelEntity::class)->findBy([
            'descricao' => $nome,
        ]);
    }
    public function obterImovelPorLocal(string $nome)
    {
        return $this->em->getRepository(ImovelEntity::class)->findBy([
            'local' => $nome,
        ]);
    }
    public function obterImovelPelaFaixa(string $nome)
    {
        return $this->em->getRepository(ImovelEntity::class)->findBy([
            'valorDiaria' => $nome,
        ]);
    }
    public function obterImovelPelaData(string $dataInicio,$dataFim)
    {
        return $this->em->getRepository(ImovelEntity::class)->findBy([
            'dataInicio' => new \DateTime($dataInicio),
            'dataFim' => new \DateTime($dataFim),
        ]);
    }

    /**
     * @param \App\Domain\Imovel\ImovelEntity $imovel
     *
     * @return mixed
     * @throws Exception
     */
    public function inserirImovel(ImovelEntity $imovel)
    {
        // Verificar se já existe imovel com este nome
        $ImovelComEsteNome = $this->obterImovelPorNome($imovel->getNome());

        if (count($ImovelComEsteNome) > 0) {
            throw new Exception('Imovel já cadastrado para o nome informado');
        }

        $this->em->persist($imovel);
        $this->em->flush();

        return $imovel;
    }

    /**
     * @param \App\Domain\Imovel\ImovelEntity $imovel
     *
     * @throws Exception
     */
    public function editarImovel(ImovelEntity $imovel)
    {
        // Verificar se já existe imovel com este nome
        $ImovelComEsteNome = $this->obterImovelPorNome($imovel->getNome());

        if (count($ImovelComEsteNome) > 0) {
            throw new Exception('Imovel já cadastrado para o nome informado');
        }

        $this->em->persist($imovel);
        $this->em->flush();
    }

    /**
     * @param \App\Domain\Imovel\ImovelEntity $imovel
     */
    public function removerImovel(ImovelEntity $imovel)
    {
        $this->em->remove($imovel);
        $this->em->flush();
    }
}
