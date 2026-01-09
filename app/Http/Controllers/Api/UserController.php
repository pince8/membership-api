<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request): JsonResponse
    {
        Log::info('Kullanıcılar listelendi');

        $filters = $request->only(['first_name', 'email', 'phone', 'firm_id', 'firm_name']);
        $users = $this->userService->getUsers($filters);

        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        Log::info('Yeni kullanıcı oluşturma isteği', ['email' => $request->email]);

        $result = $this->userService->createUser($request->validated());

        if (isset($result['error'])) {
            Log::warning('Kullanıcı oluşturma hatası', ['error' => $result['error']]);
            return response()->json([
                'success' => false,
                'message' => $result['error']
            ], 422);
        }

        Log::info('Kullanıcı oluşturuldu', ['id' => $result->id]);

        return response()->json([
            'success' => true,
            'message' => 'Kullanıcı başarıyla oluşturuldu',
            'data' => $result
        ], 201);
    }

    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        Log::info('Kullanıcı güncelleme isteği', ['id' => $id]);

        $result = $this->userService->updateUser($id, $request->validated());

        if (isset($result['error'])) {
            Log::warning('Kullanıcı güncelleme hatası', ['error' => $result['error']]);
            return response()->json([
                'success' => false,
                'message' => $result['error']
            ], 422);
        }

        Log::info('Kullanıcı güncellendi', ['id' => $id]);

        return response()->json([
            'success' => true,
            'message' => 'Kullanıcı başarıyla güncellendi',
            'data' => $result
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        Log::info('Kullanıcı silme isteği', ['id' => $id]);

        $result = $this->userService->deleteUser($id);

        if (is_array($result) && isset($result['error'])) {
            Log::warning('Kullanıcı silme hatası', ['error' => $result['error']]);
            return response()->json([
                'success' => false,
                'message' => $result['error']
            ], 404);
        }

        Log::info('Kullanıcı silindi', ['id' => $id]);

        return response()->json([
            'success' => true,
            'message' => 'Kullanıcı başarıyla silindi'
        ]);
    }

    public function show(int $id): JsonResponse
    {
        Log::info('Kullanıcı detay isteği', ['id' => $id]);

        $user = $this->userService->getUserById($id);

        if (!$user) {
            Log::warning('Kullanıcı bulunamadı', ['id' => $id]);
            return response()->json([
                'success' => false,
                'message' => 'Kullanıcı bulunamadı'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }
}
