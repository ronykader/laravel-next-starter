<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\v1\FamilyResource;
use App\Services\v1\AuthService;
use App\Services\v1\UserService;
use App\Traits\v1\ApiResponse;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use ApiResponse;

    /**
     * @param UserService $userService
     * @param ResponseFactory $responseFactory
     * @param AuthService $authService
     */
    public function __construct(
        private readonly UserService     $userService,
        private readonly ResponseFactory $responseFactory,
        private readonly AuthService     $authService
    )
    {
    }

    /**
     * @param RegisterUserRequest $request
     * @return array
     */
    public function register(RegisterUserRequest $request): array
    {
        try {
            $user = $this->userService->create($request->validated());
            $data = [
                'user' => $user,
                'access_token' => $user->createToken('rest-api-user-token')->plainTextToken, // Optional
                'token_type' => 'Bearer',
            ];
            return $this->success($data, 'User registered successfully.', 201);
        } catch (ValidationException $exception) {
            return $this->error($exception->getMessage(), $exception->errors(), 422);
        } catch (\Exception $exception) {
            return $this->error('Something went wrong. Please try again later.', [$e->getMessage()], 500);
        }
    }

    /**
     * @param LoginUserRequest $request
     * @return array
     */
    public function login(LoginUserRequest $request): array
    {
        try {
            $data = $this->authService->login($request->validated());
            return $this->success($data, 'User logged in successfully', 200);
        } catch (ValidationException $e) {
            return $this->error($e->getMessage(), $e->errors(), 422);
        } catch (\Exception $e) {
            return $this->error('Something went wrong. Please try again later.', [$e->getMessage()], 500);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            $this->authService->logout($request->user());
            return $this->responseFactory->json([
                'success' => true,
                'message' => 'User logged out successfully',
            ], 200);
        } catch (\Exception $exception) {
            return $this->responseFactory->json([
                'success' => false,
                'message' => 'An error occurred during logout.',
                'error' => $exception->getMessage(),
            ]);
        }
    }

    public function users(): JsonResponse
    {
        try {
            $response = $this->userService->all();
            return $this->responseFactory->json([
                'success' => true,
                'message' => 'User fetch successfully',
                'data' => $response
            ], 200);
        } catch (\Exception $exception) {
            return $this->responseFactory->json([
                'success' => false,
                'message' => 'An error occurred during retrieve users.',
                'error' => $exception->getMessage(),
            ]);
        }
    }
    public function userDetails(Request $request): array
    {
        try {
            $user = $request->user();
            return $this->success(FamilyResource::make($user), 'User retrieved successfully.',200);
        } catch (\Exception $e) {
            return $this->error('Something went wrong. Please try again later', [$e->getMessage()], 500);
        }
    }


}
