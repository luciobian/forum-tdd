<?php

namespace App;

use App\RecordsActivity;
use Illuminate\Database\Eloquent\Model;


/**
 * Modelo Favorite.
 * 
 * Contiene operaciones y relaciones sobre favoritos.
 */
class Favorite extends Model
{

    use RecordsActivity;

    protected $guarded = [];

    /**
     * Relación polimórfica.
     *
     * @return void
     */
    public function favorited()
    {
        return $this->morphTo();
    }
}
