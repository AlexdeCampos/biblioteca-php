<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserService
{
    public function listUsers()
    {
        $search =  request()->query('search', '');
        $userList = User::select('id', 'nome', 'email');

        if ($search) {
            $userList->whereAny(["nome", "email"], 'LIKE', "%{$search}%");
        }

        $userList->orderBy("nome");

        // Por padrão o Laravel tras 15 itens por página
        //
        //Ex caso seja necessário alterar a quantidade
        // return $userList->paginate(10);

        //O simplePaginate é uma alternativa com menos dados na paginação
        // return $userList->simplePaginate();

        return $userList->paginate();
    }

    public function getUser(User $user)
    {
        $data = $user->only("id", "email", "nome");
        return response()->json($data, 200);
    }

    public function saveUser(?User $user = null)
    {
        $user = $user ?? new User();
        $request = request();

        $rules = [
            'nome' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:usuarios,email,' . $user->id],
            'senha' => ['required', 'string']
        ];

        $messages = [
            "nome.required" => "O campo nome é obrigatório",
            "email.required" => "O campo email é obrigatório",
            "email.email" => "Email inválido",
            "email.unique" => "Email já cadastrado para outro usuário",
            "senha.required" => "O campo senha é obrigatório",
        ];

        $validator = Validator::make($request->all(), $rules, $messages, []);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $user->fill($request->only(['nome', 'email']));
        $user->senha = $request->get('senha');

        $user->save();
        $user->fresh();

        return response()->json($user->only([
            "id",
            "email",
            "nome",
        ]), 200);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json($user->only("id", "nome", "email"), 200);
    }
}
