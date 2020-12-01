<?php


namespace App\Application\Actions\Cliente;


use App\Application\Actions\Action;
use App\Domain\LocaTemporada\Cliente\ClienteEntity;
use App\Domain\LocaTemporada\Cliente\ClienteOrmService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class LoginAction extends Action
{
    protected EntityManagerInterface $em;
    protected ClienteOrmService $clienteOrmService;
    public function __construct(LoggerInterface $logger,ClienteOrmService $clienteOrmService)
    {
        parent::__construct($logger);
        $this->clienteOrmService = $clienteOrmService;
    }
    protected function action(): Response
    {
        $requestBody = $this->request->getBody()->getContents();

        $dadosCliente = json_decode($requestBody,true);

        $clienteLogado = new ClienteEntity();

        try{

            $clienteLogado = $this->clienteOrmService->obterPorCpfESenha($dadosCliente['cpf'],$dadosCliente['senha']);
            $clienteLogado[0]->setToken(bin2hex(openssl_random_pseudo_bytes(8)));
            $this->clienteOrmService->editarCliente();

            $cliente = [
                'id'=>$clienteLogado[0]->getId(),
                'nome'=>$clienteLogado[0]->getNome(),
                'cpf'=>$clienteLogado[0]->getCpf(),
                'senha'=>$clienteLogado[0]->getSenha(),
                'token'=>$clienteLogado[0]->getToken(),
            ];
        }catch (\Exception $e) {
            $cliente = [
                'msg' => $e->getMessage(),
            ];
        }
        return $this->respondWithData($cliente);
    }
}