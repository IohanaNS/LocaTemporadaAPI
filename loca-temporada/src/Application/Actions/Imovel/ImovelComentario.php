<?php


namespace App\Application\Actions\Imovel;


use App\Application\Actions\Action;
use App\Domain\LocaTemporada\Imovel\ImovelComentarioOrmService ;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class ImovelComentario extends Action
{
    protected EntityManagerInterface $em;
    protected ImovelComentarioOrmService $imovelComentarioOrmService;
    public function __construct(LoggerInterface $logger,ImovelComentarioOrmService $imovelComentarioOrmService)
    {
        parent::__construct($logger);
        $this->imovelComentarioOrmService = $imovelComentarioOrmService;
    }

    protected function action(): Response
    {
        // Obter filtros via QueryString
        $filtros = $this->request->getQueryParams();

        // Obter comentarios
        $comentarios = $this->imovelComentarioOrmService->obterTodosComentarios($filtros);

        if (!$comentarios) {
            return $this->respondWithData([
                'msg' => 'comentarios não existem',
            ], 404);
        }
        $dadosComentatios= [];
        foreach ($comentarios as $comentario) {
            $dadosComentatios[] = [
                'id'=>$comentario->getId(),
                'imovelId'=>$comentario->getIdImovel(),
                'idCliente'=>$comentario->getIdCliente(),
                'data'=>$comentario->getDataHora()->format('d-m-Y'),
                'texto'=>$comentario->getTexto()
            ];
        }

        // Retonar dados ao usuário
        return $this->respondWithData($dadosComentatios);
    }
}