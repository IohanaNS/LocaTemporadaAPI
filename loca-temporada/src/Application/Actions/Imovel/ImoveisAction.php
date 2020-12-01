<?php


namespace App\Application\Actions\Imovel;


use App\Application\Actions\Action;
use App\Domain\LocaTemporada\Imovel\ImovelOrmService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class ImoveisAction extends Action
{

    protected EntityManagerInterface $em;
    protected ImovelOrmService $imovelOrmService;
    public function __construct(LoggerInterface $logger,ImovelOrmService $imovelOrmService)
    {
        parent::__construct($logger);
        $this->imovelOrmService = $imovelOrmService;
    }

    protected function action(): Response
    {
        // Obter filtros via QueryString
        $filtros = $this->request->getQueryParams();

        // Obter imoveis
        $imoveis = $this->imovelOrmService->obterTodosImoveis($filtros);

        // Preparar dados dos imoveis para retornar ao usuário
        $dadosImoveis = [];
        foreach ($imoveis as $imovel) {
            $dadosImoveis[] = [
                'id'=>$imovel->getId(),
                'nome'=>$imovel->getNome(),
                'local'=>$imovel->getLocal(),
                'descricao'=>$imovel->getDescricao(),
                'valorDiaria'=>$imovel->getValorDiaria(),
                'foto'=>$imovel->getFoto()
            ];
        }

        // Retonar dados ao usuário
        return $this->respondWithData($dadosImoveis);
    }
}