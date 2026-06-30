<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;

#[Fillable(['pkcliente', 'username', 'password_hash', 'intentos_fallidos', 'bloqueado', 'activo', 'fecultactualizacion'])]
#[Hidden(['password_hash'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Conectamos con la tabla exacta de la base de datos del profesor
    protected $table = 'usuarios_homebanking';
    protected $primaryKey = 'pkusuario';

    /**
     * Retorna el password_hash para la autenticación de Laravel.
     */
    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}