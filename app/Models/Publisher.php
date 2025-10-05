<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Publisher
 * 
 * @property int $id
 * @property string $nome
 * @property Book $livros 
 */

class Publisher extends Model
{
    protected $table = "editoras";

    protected $fillable = [
        'nome'
    ];

    public function livros(): HasMany
    {
        return $this->hasMany(Book::class, 'editora_id', 'id');
    }

    const CREATED_AT = 'data_criacao';
    const UPDATED_AT = 'data_atualizacao';
}
