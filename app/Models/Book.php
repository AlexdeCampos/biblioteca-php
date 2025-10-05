<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * class Book
 * @property int $id
 * @property string $nome
 * @property string $sinopse
 * @property date $data_lancamento
 * @property Publisher|Collection $editora
 * @property Author[]|Collection[] $autores
 */

class Book extends Model
{
    protected $table = "livros";

    protected $fillable = [
        "nome",
        "sinopse",
        "data_lancamento",
        "editora_id"
    ];

    public function editora(): HasOne
    {
        return $this->hasOne(Publisher::class, 'id', 'editora_id');
    }

    public function autores(): HasManyThrough
    {
        return $this->hasManyThrough(
            Author::class,
            BookAuthor::class,
            'livro_id',
            'id',
            'id',
            'autor_id'
        );
    }

    const CREATED_AT = 'data_criacao';
    const UPDATED_AT = 'data_atualizacao';
}
