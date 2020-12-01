<?php


namespace App\Application\Actions\Imovel;


use App\Application\Actions\Action;
use App\Domain\LocaTemporada\Imovel\ImovelComentarioEntity;
use App\Domain\LocaTemporada\Imovel\ImovelComentarioOrmService;
use App\Domain\LocaTemporada\Imovel\ImovelOrmService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class ImoveisPelaData extends Action
{

    protected EntityManagerInterface $em;
    protected ImovelOrmService $imovelOrmService;
    protected ImovelComentarioOrmService $imovelComentarioOrmService;
    public function __construct(LoggerInterface $logger,ImovelOrmService $imovelOrmService,
                                ImovelComentarioOrmService $imovelComentarioOrmService)
    {
        parent::__construct($logger);
        $this->imovelOrmService = $imovelOrmService;
        $this->imovelComentarioOrmService = $imovelComentarioOrmService;
    }
    protected function action(): Response
    {
        $dataInicio = $this->resolveArg('dataInicio');
        $dataFim = $this->resolveArg('dataFim');
        $imoveis = $this->imovelOrmService->obterImovelPelaData($dataInicio,$dataFim);
        $imovel = reset($imoveis);
        $comentarios = $this->imovelComentarioOrmService->obterComentarioPorImovelId($imovel->getId());

        if (!$imoveis) {
            return $this->respondWithData([
                'msg' => 'Imovel não existe',
            ], 404);
        }

        $dadosImoveis = [];
        foreach ($comentarios as $comentario){
            $coms =[
                'id'=> $comentario->getId(),
                'idImovel'=>$comentario->getIdImovel(),
                'idCliente'=>$comentario->getIdCliente(),
                'dataHora'=>$comentario->getDataHora(),
                'texto'=>$comentario->getTexto(),
            ];
            $coms2[] = $coms;
        }
        $imovel = reset($imoveis);
        $dadosImoveis[] = [
            'id' => $imovel->getId(),
            'nome' => $imovel->getNome(),
            'local' => $imovel->getLocal(),
            'descricao' => $imovel->getDescricao(),
            'valor_diaria' => $imovel->getValorDiaria(),
            'foto' => $imovel->getFoto(),
            'comentarios'=>$coms2
        ];
//        $dados[] = $dadosImoveis;
//        $dados[] = $coms;
        return $this->respondWithData($dadosImoveis);
    }
}