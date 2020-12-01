<?php
namespace App\Domain\LocaTemporada\Pagamento;

use App\Domain\LocaTemporada\Locacao\LocacaoEntity;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class PagamentoOrmService
{
    protected EntityManagerInterface $em;

    /**
     * PagamentoOrmService constructor.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $em
     */
    public function __construct(
        EntityManagerInterface $em
    ) {
        $this->em = $em;
    }
    public function obterPagamentoPorIdTransacao(string $idTransacaoPagamento)
    {

        $client = new Client();

        try {
            $res = $client->get('http://18.224.228.18/transacoes/'.$idTransacaoPagamento);
        } catch (GuzzleException $e) {
            return $retorno=[
                'msg'=>'Deu ruim: '.$e->getMessage(),
            ];
        }

       return $retorno = json_decode($res->getBody(),true);

    }
    public function inserirPagamento(PagamentoEntity $pagamentoEntity){
            $this->em->persist($pagamentoEntity);
            $this->em->flush();
            return $pagamentoEntity;
    }
    public function obterIdTransacaoPorIdLocacao(LocacaoEntity $locacaoEntity){

        $pagamento =  $this->em->getRepository(PagamentoEntity::class)->findBy([
            'idLocacao' => $locacaoEntity->getId(),
        ]);

        $pag = reset($pagamento);

        return $pag->getIdTransacaoPagamento();
    }
    public function obterValorPorIdLocacao(LocacaoEntity $locacaoEntity){

        $pagamento =  $this->em->getRepository(PagamentoEntity::class)->findBy([
            'idLocacao' => $locacaoEntity->getId(),
        ]);
        $pag = reset($pagamento);
        return $pag->getValor();
    }
}
