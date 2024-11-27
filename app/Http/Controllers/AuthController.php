<?php 
namespace App\Http\Controllers;

use App\DTOs\AuthorDTO;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}

    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:authors,email',
            'password' => 'required|min:8',
        ]);

        //dd($validated);
        $authorDTO = AuthorDTO::fromRequest($validated);
        //dd(vars: "Hii");
        $result = $this->authService->register($authorDTO);

        return response()->json($result, 201);
    }
}
