<?php

namespace App\Services\Publisher;

use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Support\Facades\Validator;

class PublisherService
{
    public function listPubishers()
    {
        $search =  request()->query('search', '');
        $publisherList = Publisher::select('id', 'nome');

        if ($search) {
            $publisherList->whereAny(["nome",], 'LIKE', "%{$search}%");
        }

        $publisherList->orderBy("nome");
        return $publisherList->paginate();
    }

    public function getPublisher(Publisher $publisher)
    {
        // Buscar vínculo com livros
        return response()->json($publisher->only("id", "nome"), 200);
    }

    public function save(?Publisher $publisher = null)
    {
        $publisher = $publisher ?? new Publisher();
        $request = request();

        $rules = [
            'nome' => ['required', 'string', 'unique:autores,nome,' . $publisher->id],
        ];

        $messages = [
            "nome.required" => "O campo nome é obrigatório",
            "nome.unique" => "Author já cadastrado com o mesmo nome",
        ];

        $validator = Validator::make($request->all(), $rules, $messages, []);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $publisher->fill($request->only(['nome']));

        $publisher->save();
        $publisher->fresh();

        return response()->json($publisher->only([
            "id",
            "nome",
        ]), 200);
    }

    public function destroy(Publisher $publisher)
    {
        if ($publisher->livros->count() > 0) {
            return response()->json(
                ["message" => "A editora possui livros vinculados, remova-os antes de prosseguir"],
                422
            );
        }

        $publisher->delete();
        return response()->json($publisher->only("id", "nome"), 200);
    }
}
