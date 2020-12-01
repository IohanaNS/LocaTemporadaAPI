<?php


namespace App\Application\Actions\Imovel;


use App\Application\Actions\Action;
use App\Domain\LocaTemporada\Cliente\ClienteOrmService;
use App\Domain\LocaTemporada\Imovel\ImovelEntity;
use App\Domain\LocaTemporada\Imovel\ImovelOrmService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class NovoImovelAction extends Action
{
    protected EntityManagerInterface $em;
    protected ImovelOrmService $imovelOrmService;
    protected ClienteOrmService $clienteOrmService;
    public function __construct(LoggerInterface $logger,ImovelOrmService $imovelOrmService,ClienteOrmService $clienteOrmService)
    {
        parent::__construct($logger);
        $this->imovelOrmService = $imovelOrmService;
        $this->clienteOrmService = $clienteOrmService;
    }
    protected function action(): Response
    {
        $requestBody = $this->request->getBody()->getContents();

        $dadosImovel = json_decode($requestBody,true);
        $token = $dadosImovel['token'];
        $cliente= $this->clienteOrmService->obterClientePorToken($token);
        if(!isset($cliente)){
            return $this->respondWithData([
                'msg' => 'Cliente é inválido: ',
            ],404);
        }


        $novoImovel = new ImovelEntity();
        $novoImovel->setNome($dadosImovel['nome']);
        $novoImovel->setDescricao($dadosImovel['descricao']);
        $novoImovel->setFoto($dadosImovel['foto']);
        $novoImovel->setLocal($dadosImovel['local']);
        $novoImovel->setValorDiaria($dadosImovel['valorDiaria']);



        try{
            $novoImovel = $this->imovelOrmService->inserirImovel($novoImovel);

            $retorno = [
                'msg'=>'Imovel #'.$novoImovel->getId().'inserido',
            ];
        }catch (\Exception $e) {
            $retorno = [
                'msg' => $e->getMessage(),
            ];
        }
        return $this->respondWithData($retorno);
    }
}