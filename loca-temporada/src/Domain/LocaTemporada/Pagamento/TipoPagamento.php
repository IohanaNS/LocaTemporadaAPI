<?php
namespace App\Domain\LocaTemporada\Pagamento;

class TipoPagamento
{
    const LOCACAO = 1;
    const CANCELAMENTO = 2;

    /**
     * @return array
     */
    public static function lista()
    {
        return [
            self::LOCACAO      => 'Locação',
            self::CANCELAMENTO => 'Cancelamento',
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
