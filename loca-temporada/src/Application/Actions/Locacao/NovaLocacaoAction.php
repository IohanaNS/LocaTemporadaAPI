<?php


namespace App\Application\Actions\Locacao;


use App\Application\Actions\Action;
use App\Domain\LocaTemporada\Cliente\ClienteOrmService;
use App\Domain\LocaTemporada\Locacao\LocacaoEntity;
use App\Domain\LocaTemporada\Locacao\LocacaoOrmService;
use App\Domain\LocaTemporada\Pagamento\PagamentoEntity;
use App\Domain\LocaTemporada\Pagamento\PagamentoOrmService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;

class NovaLocacaoAction extends Action
{
    protected EntityManagerInterface $em;
    protected LocacaoOrmService $locacaoOrmService;
    protected ClienteOrmService $clienteOrmService;
    protected PagamentoOrmService $pagamentoOrmService;
    public function __construct(LoggerInterface $logger,LocacaoOrmService $locacaoOrmService,
                                ClienteOrmService $clienteOrmService,
                                PagamentoOrmService  $pagamentoOrmService)
    {
        parent::__construct($logger);
        $this->locacaoOrmService = $locacaoOrmService;
        $this->clienteOrmService = $clienteOrmService;
        $this->pagamentoOrmService = $pagamentoOrmService;
    }
    protected function action(): Response
    {
        $requestBody = $this->request->getBody()->getContents();
        $dados = json_decode($requestBody,true);
        $tokenCliente = $this->clienteOrmService->obterTodosClientes($dados);
        $pagamento = $this->pagamentoOrmService->obterPagamentoPorIdTransacao($dados['idTransacaoPagamento']);

            if(!isset($tokenCliente[0])){
                $resultado = [
                    'msg'=>'Cliente inválido'
                ];
            }elseif (!isset($pagamento)){
                $resultado = [
                    'msg'=>'Pagamento inválido'
                ];
            }
            else{
                $locacao = new LocacaoEntity();
                $locacao->setIdImovel($dados['imovelId']);
                $locacao->setDataInicio(new \DateTime($dados['dataInicio']));
                $locacao->setDataFim(new \DateTime($dados['dataFim']));
                $locacao->setIdCliente($dados['idCliente']);
                $locacao->setIdSituacaoLocacao(0);

                $locacaoUpdate = $this->locacaoOrmService->inserirLocacao($locacao);

                $pagASerInserido = new PagamentoEntity();
                $pagASerInserido->setIdLocacao($locacaoUpdate->getId());
                $pagASerInserido->setIdTipoPagamento(1);
                $pagASerInserido->setIdTransacaoPagamento($dados['idTransacaoPagamento']);
                $pagASerInserido->setValor(floatval($pagamento['valor']));

                $pagASerInserido = $this->pagamentoOrmService->inserirPagamento($pagASerInserido);


                if(!isset($locacaoUpdate)){
                    $resultado = [
                        'msg'=>'A data inserida é inválida',
                    ];
                }elseif (!isset($pagASerInserido)) {
                    $resultado = [
                        'msg' => 'Pagamento é inválido',
                    ];

                }
                 else {
                    $resultado = [
                        'msg1' => 'LOCACAO INSERIDA COM SUCESSO, ID LOC: ' . $locacaoUpdate->getId(),
                        'msg2' => 'PAGAMENTO INSERIDO COM SUCESSO, ID PAG: ' . $pagASerInserido->getId(),
                    ];
                }
            }
        return $this->respondWithData($resultado);
    }

}