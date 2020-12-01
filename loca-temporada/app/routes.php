<?php
declare(strict_types=1);

use App\Application\Actions\Cliente\LoginAction;
use App\Application\Actions\Imovel\ImoveisAction;
use App\Application\Actions\Imovel\ImoveisPelaData;
use App\Application\Actions\Imovel\ImoveisPelaDesc;
use App\Application\Actions\Imovel\ImoveisPelaFaixa;
use App\Application\Actions\Imovel\ImoveisPeloNome;
use App\Application\Actions\Imovel\ImovelComentario;
use App\Application\Actions\Imovel\NovoImovelAction;
use App\Application\Actions\Imovel\NovoImovelComentario;
use App\Application\Actions\Locacao\BuscaLocacoesComParametro;
use App\Application\Actions\Locacao\CancelaLocacaoAction;
use App\Application\Actions\Locacao\NovaLocacaoAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    ////////////////////Rotas Imovel////////////////////////////

    $app->get('/imoveis',ImoveisAction::class); //ok
    $app->post('/imoveis/novo',NovoImovelAction::class); //ok
    $app->get('/imoveis/nome={nome}',ImoveisPeloNome::class); //ok
    $app->get('/imoveis/desc={descricao}',ImoveisPelaDesc::class); //ok
    $app->get('/imoveis/faixa={faixa}',ImoveisPelaFaixa::class); //ok
    $app->get('/imoveis/dataIni={dataInicio}&dataFim={dataFim}',ImoveisPelaData::class); //ok
    //////////////////////////////////////////////////////////////////////////
    ///////////////////Rotas de Locacoes///////////////////////////////////

    $app->get('/locacoes/imovelId={imovelId}',BuscaLocacoesComParametro::class); //ok
    $app->post('/locacoes/novo',NovaLocacaoAction::class);//ok
    $app->get('/locacoes/token={token}',BuscaLocacoesComParametro::class);//ok
    $app->put('/locacoes/locacao/cancelar',CancelaLocacaoAction::class);//ok
    //////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////comentarios//////////////////////////////////////////////////

    $app->get('/comentarios/imovelId={imovelId}',ImovelComentario::class); //ok
    $app->post('/comentarios/novo',NovoImovelComentario::class);//ok
    ////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////cliente////////////////////////////////////////////////

    $app->post('/cliente/login',LoginAction::class); //ok
    ////////////////////////////////////////////////////////////////////////////////////////
};
