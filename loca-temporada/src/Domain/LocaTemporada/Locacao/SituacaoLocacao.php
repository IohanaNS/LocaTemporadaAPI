<?php
namespace App\Domain\LocaTemporada\Locacao;

class SituacaoLocacao
{
    const ATIVA = 1;
    const CANCELADA = 2;
    const REALIZADA = 3;

    /**
     * @return array
     */
    public static function lista()
    {
        return [
            self::ATIVA     => 'Ativa',
            self::CANCELADA => 'Cancelada',
            self::REALIZADA => 'Realizada',
        ];
    }

    /**
     * @param int $id
     *
     * @return string
     */
    public static function texto(int $id)
    {
        return self::lista()[$id];
    }
}
