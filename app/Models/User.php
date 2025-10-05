<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 *
 *  @property int $id
 *  @property string $nome
 *  @property string $email
 *  @property string $senha
 */


class User extends Model
{
    protected $table = 'usuarios';

    protected $fillable = [
        'nome',
        'email'
    ];

    protected $hidden = [
        'senha'
    ];

    const CREATED_AT = 'data_criacao';
    const UPDATED_AT = 'data_atualizacao';
}
