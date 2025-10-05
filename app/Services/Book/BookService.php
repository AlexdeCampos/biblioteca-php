<?php

namespace  App\Services\Book;

use App\Models\Book;
use App\Models\BookAuthor;
use App\Models\Publisher;
use Illuminate\Support\Facades\Validator;

class BookService
{

    public function listBooks()
    {
        $search =  request()->query('search', '');
        $authorList = Book::select(
            'id',
            'nome',
            'sinopse',
            'data_lancamento',
            'editora_id'
        )
            ->with('editora:id,nome')
            ->with('autores:autores.id,autores.nome');

        if ($search) {
            $authorList->whereAny(["nome", "biografia"], 'LIKE', "%{$search}%");
        }

        $authorList->orderBy("nome");
        return $authorList->paginate();
    }

    public function getBook(Book $book)
    {

        $data = $book->only(
            "id",
            "nome",
            "sinopse",
            "data_lancamento"
        );

        $data["editora"] = $book->editora->only(['id', 'nome']);
        $data["autores"] = $book->autores;

        return response()->json($data, 200);
    }

    public function save(?Book $book = null)
    {

        $book = $book ?? new Book();
        $request = request();


        $rules = [
            'nome' => ['required', 'string', 'unique:livros,nome,' . $book->id],
            'sinopse' => ['nullable', 'string', 'max:100'],
            'data_lancamento' => ['required', 'date_format:Y-m-d', 'date'],
            'editora' => ['required', 'int'],
            'autores.*' => ['nullable', 'exists:autores,id']
        ];

        $messages = [
            "nome.required" => "O campo nome é obrigatório",
            "nome.unique" => "Livro já cadastrado com o mesmo nome",
            "sinopse.max" => "O campo sinopse não deve ter mais que 100 caracteres",
            "data_lancamento.required" => "O campo data_lancamento é obrigatório",
            "data_lancamento.date" => "Campo data_lancamento inválido",
            "autores.*.exists" => "Autor com id :input não encontrado"
        ];

        $validator = Validator::make($request->all(), $rules, $messages, []);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $book->fill($request->only([
            'nome',
            'sinopse',
            'data_lancamento'
        ]));

        $publisher = Publisher::find(request('editora'));

        if (!$publisher) {
            return response()->json(["message" => "Editora não encontrada"], 404);
        }

        $book->editora_id = $publisher->id;

        $authors = $request->get("autores", []);
        if ($book->id && count($authors) > 0) {
            $bookAuthors = BookAuthor::select('autor_id')->get()->toArray();

            foreach ($bookAuthors as $author) {
                $key = array_search($author["autor_id"], $authors);

                if ($key !== false) {
                    unset($authors[$key]);
                }
            }
        }

        $book->save();

        if ($authors) {
            $bookAuthors = array_map(function ($author) use ($book) {
                return [
                    "autor_id" => $author,
                    "livro_id" => $book->id
                ];
            }, $authors);
            BookAuthor::insert($bookAuthors);
        }

        $book->fresh();

        return response()->json(
            Book::whereId($book->id)
                ->with('editora:id,nome')
                ->with('autores:autores.id,autores.nome')
                ->get(),
            200
        );
    }

    public function destroy(Book $book)
    {
        BookAuthor::where('livro_id', $book->id)->delete();

        $book->delete();
        return response()->json($book->only("id", "nome", "biografia"), 200);
    }
}
