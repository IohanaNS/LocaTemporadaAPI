<?php


namespace App\Application\Actions\Locacao;


use App\Application\Actions\Action;
use App\Domain\LocaTemporada\Cliente\ClienteEntity;
use App\Domain\LocaTemporada\Cliente\ClienteOrmService;
use App\Domain\LocaTemporada\Imovel\ImovelEntity;
use App\Domain\LocaTemporada\Imovel\ImovelOrmService;
use App\Domain\LocaTemporada\Locacao\LocacaoOrmService;
use App\Domain\LocaTemporada\Pagamento\PagamentoOrmService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

//busca locacoes pelo id do imovel
class BuscaLocacoesComParametro extends Action
{
    protected EntityManagerInterface $em;
    protected LocacaoOrmService $locacaoOrmService;
    protected ClienteOrmService $clienteOrmService;
    protected PagamentoOrmService $pagamentoOrmService;

    public function __construct(LoggerInterface $logger,LocacaoOrmService $locacaoOrmService,
    ClienteOrmService $clienteOrmService,PagamentoOrmService $pagamentoOrmService)
    {
        parent::__construct($logger);
        $this->locacaoOrmService = $locacaoOrmService;
        $this->clienteOrmService = $clienteOrmService;
        $this->pagamentoOrmService = $pagamentoOrmService;
    }

    protected function action(): Response
    {
        // Obter filtros via QueryString
        $filtros =$this->request->getQueryParams();
        $token = reset($filtros);
        $cliente= $this->clienteOrmService->obterClientePorToken($token);

        if(!isset($cliente)){
            return $this->respondWithData([
                'msg' => 'Cliente é inválido: ',
            ],404);
        }


            $locacoes = $this->locacaoOrmService->obterTodasLocaoes($filtros);
            if (!$locacoes) {
                return $this->respondWithData([
                    'msg' => 'Locacoes não existem ',
                ], 404);
            }


        $dadosLocacoes= [];
        foreach ($locacoes as $locacao) {

            $id = $this->pagamentoOrmService->obterIdTransacaoPorIdLocacao($locacao);
            $valor = $this->pagamentoOrmService->obterValorPorIdLocacao($locacao);
            $dadosLocacoes[] = [
                'id'=>$locacao->getId(),
                'imovelId'=>$locacao->getIdImovel(),
                'idCliente'=>$locacao->getIdCliente(),
                'dataInicio'=>$locacao->getDataInicio()->format('d-m-Y'),
                'dataFim'=>$locacao->getDataFim()->format('d-m-Y'),
                'idTransacao'=>$id,
                'valor'=>$valor,
            ];
        }

        // Retonar dados ao usuário
        return $this->respondWithData($dadosLocacoes);
    }
}

