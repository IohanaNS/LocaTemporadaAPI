<?php


namespace App\Application\Actions\Imovel;


use App\Application\Actions\Action;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\LocaTemporada\Cliente\ClienteOrmService;
use App\Domain\LocaTemporada\Imovel\ImovelComentarioEntity;
use App\Domain\LocaTemporada\Imovel\ImovelComentarioOrmService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;

class NovoImovelComentario extends Action
{
    protected ClienteOrmService $clienteOrmService;
    protected ImovelComentarioOrmService $imovelComentarioOrmService;
    public function __construct(LoggerInterface $logger,ImovelComentarioOrmService $imovelComentarioOrmService,ClienteOrmService $clienteOrmService)
    {
        parent::__construct($logger);
        $this->clienteOrmService = $clienteOrmService;
        $this->imovelComentarioOrmService = $imovelComentarioOrmService;
    }

    protected function action(): Response
    {
        $requestBody = $this->request->getBody()->getContents();
        $dados = json_decode($requestBody,true);
        $token = $dados['token'];
        $cliente= $this->clienteOrmService->obterClientePorToken($token);
        $user = reset($cliente);
        if(!isset($cliente)){
            return $this->respondWithData([
                'msg' => 'Cliente é inválido: ',
            ],404);
        }
        $novoComentario = new ImovelComentarioEntity();
        $novoComentario->setIdCliente($user->getId());
        $novoComentario->setIdImovel($dados['imovelId']);
        $novoComentario->setDataHora(new \DateTime());
        $novoComentario->setTexto($dados['texto']);

        try{
            $novoComentario = $this->imovelComentarioOrmService->inserirComentario($novoComentario);

            $retorno = [
                'msg'=>'Comentario # '.$novoComentario->getId().' inserido',
            ];
        }catch (\Exception $e) {
            $retorno = [
                'msg' => $e->getMessage(),
            ];
        }
        return $this->respondWithData($retorno);
    }
}