<?php


namespace App\Application\Actions\Locacao;


use App\Application\Actions\Action;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\LocaTemporada\Cliente\ClienteOrmService;
use App\Domain\LocaTemporada\Locacao\LocacaoOrmService;
use App\Domain\LocaTemporada\Pagamento\PagamentoOrmService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;

class CancelaLocacaoAction extends Action
{
    protected ClienteOrmService $clienteOrmService;
    protected LocacaoOrmService $locacaoOrmService;
    protected PagamentoOrmService $pagamentoOrmService;

    public function __construct(LoggerInterface $logger,ClienteOrmService $clienteOrmService,
LocacaoOrmService $locacaoOrmService,PagamentoOrmService $pagamentoOrmService)
    {
        parent::__construct($logger);
        $this->pagamentoOrmService = $pagamentoOrmService;
        $this->locacaoOrmService = $locacaoOrmService;
        $this->clienteOrmService = $clienteOrmService;
    }

    protected function action(): Response
    {
        $requestBody = $this->request->getBody()->getContents();
        $dados = json_decode($requestBody,true);
        $tokenCliente = $this->clienteOrmService->obterTodosClientes($dados);
        $pagamento = $this->pagamentoOrmService->obterPagamentoPorIdTransacao($dados['idTransacaoPagamento']);
        $locacao = $this->locacaoOrmService->obterLocacaoPorId($dados['idLocacao']);
        $resultado = [];
        if(!isset($tokenCliente[0])){
            $resultado = [
                'msg'=>'Cliente inválido'
            ];
        }elseif (!isset($pagamento)){
            $resultado = [
                'msg'=>'Pagamento inválido'
            ];
        }elseif (!isset($locacao)){
            $resultado = [
                'msg'=>'Locacao inválida'
            ];
        }else{
            $pode = $this->locacaoOrmService->podeCancelar($locacao);
            if($pode){
                $locacao->setIdSituacaoLocacao(2);
                $locacao = $this->locacaoOrmService->editarLocacao($locacao);
                    $resultado=['msg'=>'Cancelado com sucesso!: '
                        .$locacao->getId()];
            }else{
                    $resultado=['msg'=>'Não é possível cancelar, pois, é necessário que a distancia
                    entre o cancelamento e a data de inicio seja pelo menos 30 dias: '.$locacao->getDataInicio()->format('Y-m-d')];
            }
            return $this->respondWithData($resultado);
        }
    }
}