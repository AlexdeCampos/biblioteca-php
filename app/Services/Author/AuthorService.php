<?php

namespace  App\Services\Author;

use App\Models\Author;
use Illuminate\Support\Facades\Validator;

class AuthorService
{

    public function listAuthors()
    {
        $search =  request()->query('search', '');
        $authorList = Author::select('id', 'nome', 'biografia');

        if ($search) {
            $authorList->whereAny(["nome", "biografia"], 'LIKE', "%{$search}%");
        }

        $authorList->orderBy("nome");
        return $authorList->paginate();
    }

    public function getAuthor(Author $author)
    {
        // Buscar vínculo com livros
        return response()->json($author->only("id", "nome", "biografia"), 200);
    }

    public function save(?Author $author = null)
    {
        $author = $author ?? new Author();
        $request = request();

        $rules = [
            'nome' => ['required', 'string', 'unique:autores,nome,' . $author->id],
            'biografia' => ['nullable', 'string', 'max:100']
        ];

        $messages = [
            "nome.required" => "O campo nome é obrigatório",
            "nome.unique" => "Author já cadastrado com o mesmo nome",
            "biografia.max" => "O campo biografia não deve ter mais que 100 caracteres",
        ];

        $validator = Validator::make($request->all(), $rules, $messages, []);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $author->fill($request->only(['nome', 'biografia']));

        $author->save();
        $author->fresh();

        return response()->json($author->only([
            "id",
            "nome",
            "biografia",
        ]), 200);
    }

    public function destroy(Author $author)
    {
        if ($author->livros->count() > 0) {
            return response()->json(
                ["message" => "O autor possui livros vinculados, remova-os antes de prosseguir"],
                422
            );
        }

        //Validar livros vinculados
        $author->delete();
        return response()->json($author->only("id", "nome", "biografia"), 200);
    }
}
