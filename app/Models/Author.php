<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;

/**
 * class Author
 * 
 * @property int $id
 * @property string $nome
 * @property string $biografia
 * @property Book[]|Collection[] $livros
 * 
 */

class Author extends Model
{
    protected $table = "autores";

    protected $fillable = [
        'nome',
        'biografia'
    ];

    public function livros(): HasManyThrough
    {
        return $this->hasManyThrough(
            Book::class,
            BookAuthor::class,
            'autor_id',
            'id',
            'id',
            'livro_id',
        );
    }

    const CREATED_AT = 'data_criacao';
    const UPDATED_AT = 'data_atualizacao';
}
