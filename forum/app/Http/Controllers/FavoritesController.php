<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * FavoritesContoller
 * 
 * Clase que se ocupa de la operaciones para poner favorito en los comentarios.
 */
class FavoritesController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware("auth");
    }

    /**
     * Almacena un nuevo favorito en la bd.
     *
     * @param Reply $reply
     * @return void
     */
    public function store(Reply $reply)
    {
        $reply->favorite();

        return back();
    }
}
