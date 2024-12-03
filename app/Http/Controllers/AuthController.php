<?php 
namespace App\Http\Controllers;

use App\DTOs\AuthorDTO;
use App\DTOs\UserDTO;
use App\Repositories\AuthorRepository;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService, private AuthorRepository $authorRepository,private UserRepository $userRepository) {}

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            //'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:authors,email',
            'password' => 'required|min:8',
        ]);

        $userDTO = UserDTO::fromRegisterRequest($validated);
        $result = $this->authService->register($userDTO);

        return response()->json($result, 201);
    }

    public function verifyEmail(Request $request)
    {
        // Retrieve the email from the URL
        $email = $request->email;

        // Find the author by the email address
        $user = $this->userRepository->findByEmail($email);
       // dd($user);

        if (!$user) {
            return response()->json(['message' => 'Invalid token'], 400);
        }

        // Check if the email is already verified
        if ($user->email_verified_at ) {
            return response()->json(['message' => 'Email already verified'], 200);
        }

        // Update the author record
        //dd($user->email_verified_at);
        $user->email_verified_at = now();
        //$author->verification_token = null; // Clear the token after verification
        $user->save();

        return response()->json([
            'message' => 'Email verified successfully',
            'user' => $user
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
