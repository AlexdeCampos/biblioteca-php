<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\User\UserService;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return $this->userService->listUsers();
    }

    public function show(User $user)
    {
        return $this->userService->getUser($user);
    }

    public function save(?User $user = null)
    {
        return $this->userService->saveUser($user);
    }

    public function destroy(User $user)
    {
        return $this->userService->destroy($user);
    }
}
