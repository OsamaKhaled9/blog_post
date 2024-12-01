<?php 
namespace App\Http\Controllers;

use App\DTOs\AuthorDTO;
use App\Repositories\AuthorRepository;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService, private AuthorRepository $authorRepository) {}

    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:authors,email',
            'password' => 'required|min:8',
        ]);

        $authorDTO = AuthorDTO::fromRequest($validated);
        $result = $this->authService->register($authorDTO);

        return response()->json($result, 201);
    }

    public function verifyEmail(Request $request)
    {
        // Retrieve the token from the URL
        $token = $request->query('token');

        // Find the author by the token
        $author = $this->authorRepository->findByToken($token);

        if (!$author) {
            return response()->json(['message' => 'Invalid token'], 400);
        }

        // Check if the email is already verified
        if ($author->is_verified) {
            return response()->json(['message' => 'Email already verified'], 200);
        }

        // Update the author record
        $author->is_verified = true;
        $author->verification_token = null; // Clear the token after verification
        $author->save();

        return response()->json([
            'message' => 'Email verified successfully',
            'author' => $author
        ], 200);
    }
}
