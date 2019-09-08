<?php

namespace App\Http\Controllers;

use App\User;
use App\Activity;
use Illuminate\Http\Request;

/**
 * ProfilesController
 * 
 * Realiza operaciones sobre el perfil del usuario.
 */
class ProfilesController extends Controller
{
    /**
     * Muestra el perfil y actividad del usuario.
     *
     * @param User $user
     * @return void
     */
    public function show(User $user)
    {
        return view('profiles.show', [
            'profileUser' => $user,
            'activities' => Activity::feed($user)
        ]);
    }
}
