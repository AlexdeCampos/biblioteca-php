<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * class BookAuthor
 * @property int $id
 * @property Book|Collection $livro
 * @property Author|Collection $autor
 */

class BookAuthor extends Model
{
    protected $table = "livros_autores";

    protected $fillable = [
        'autor_id',
        'livro_id'
    ];

    const CREATED_AT = 'data_criacao';
    const UPDATED_AT = 'data_atualizacao';
}
