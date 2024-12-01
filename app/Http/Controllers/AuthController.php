<?php 
namespace App\Http\Controllers;

use App\DTOs\AuthorDTO;
use App\Repositories\AuthorRepository;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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

    public function login(Request $request)
{
    // Validate the login request
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Create an AuthorDTO specifically for login
    $authorDTO = AuthorDTO::fromLoginRequest($credentials);

    // Use the repository to find the verified author
    $author = $this->authorRepository->findVerifiedByEmail($authorDTO->getEmail());

    if (!$author) {
        return response()->json(['message' => 'Account not verified or does not exist'], 403);
    }

    // Verify the password
    if (!\Hash::check($authorDTO->getPassword(), $author->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    // Generate a Sanctum token
    $token = $author->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Login successful',
        'token' => $token,
        'author' => [
            'id' => $author->id,
            'first_name' => $author->first_name,
            'last_name' => $author->last_name,
            'email' => $author->email,
        ],
    ], 200);
}

}
