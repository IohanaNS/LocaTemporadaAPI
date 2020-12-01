<?php
namespace App\Domain\LocaTemporada\Cliente;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;

class ClienteOrmService
{
    protected EntityManagerInterface $em;


    /**
     * ClienteOrmService constructor.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $em
     */
    public function __construct(
        EntityManagerInterface $em
    ) {
        $this->em = $em;
    }
    public function obterTodosClientes(array $filtros)
    {
        $criteria = new Criteria();

        if (isset($filtros['id'])) {
            $criteria->andWhere(
                $criteria->expr()->eq('id', $filtros['id'])
            );
        }
        if (isset($filtros['cpf'])) {
            $criteria->andWhere(
                $criteria->expr()->eq('cpf', $filtros['cpf'])
            );
        }
        if (isset($filtros['dataNascimento'])) {
            $criteria->andWhere(
                $criteria->expr()->eq('data_nascimento', $filtros['dataNascimento'])
            );
        }
        if (isset($filtros['senha'])) {
            $criteria->andWhere(
                $criteria->expr()->eq('senha', $filtros['senha'])
            );
        }
        if (isset($filtros['token'])) {
            $criteria->andWhere(
                $criteria->expr()->eq('token', $filtros['token'])
            );
        }



        return $this->em->getRepository(ClienteEntity::class)->matching($criteria);    }



    /**
     * @param int $id
     *
     * @return \App\Domain\Cliente\ClienteEntity|object|null
     */
    public function obterClientePorId(int $id)
    {
        return $this->em->getRepository(ClienteEntity::class)->find($id);
    }

    /**
     * @param string $nome
     *
     * @return object[]
     */
    public function obterClientePorNome(string $nome)
    {
        return $this->em->getRepository(ClienteEntity::class)->findBy([
            'nome' => $nome,
        ]);
    }
    public function obterPorCpfESenha(string $cpf,string $senha)
    {
        return $this->em->getRepository(ClienteEntity::class)->findBy([
            'cpf' => $cpf,
            'senha'=>$senha
        ]);
    }
    public function obterClientePorToken(string $token)
    {
        return $this->em->getRepository(ClienteEntity::class)->findBy([
            'token' => $token,
        ]);
    }
    public function obterClientePorCpf(string $cpf)
    {
        return $this->em->getRepository(ClienteEntity::class)->findBy([
            'cpf' => $cpf,
        ]);
    }

    /**
     * @param \App\Domain\Cliente\ClienteEntity $cliente
     *
     * @return mixed
     * @throws Exception
     */
    public function inserirCliente(ClienteEntity $cliente)
    {
        // Verificar se já existe cliente com este nome
        $ClienteComEsteNome = $this->obterClientePorNome($cliente->getNome());

        if (count($ClienteComEsteNome) > 0) {
            throw new Exception('Cliente já cadastrado para o nome informado');
        }

        $this->em->persist($cliente);
        $this->em->flush();

        return $cliente;
    }

    /**
     * @param \App\Domain\Cliente\ClienteEntity $cliente
     *
     * @throws Exception
     */
    public function editarCliente()
    {
        $this->em->flush();
    }

    /**
     * @param \App\Domain\Cliente\ClienteEntity $cliente
     */
    public function removerCliente(Cliententity $cliente)
    {
        $this->em->remove($cliente);
        $this->em->flush();
    }
}
