<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Events\UserRegistration;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // luu vao bang user
        $user = User::create([
            'name' => $request['name'],
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        // luu vao bang student
        Student::create([
            'STU_USER_ID' => $user->id, //  STU_USER_ID là khóa ngoại trong bảng student
            'STU_UNI_ID' => $request->stu_uni_id,
            'STU_UNI_NAME' => $request->university,
            'STU_DOB' => $request->dob,
            'STU_GENDER' => $request->gender,
            // Thêm các trường khác nếu có
        ]);


        event(new Registered($user));

        Auth::login($user);

        event(new UserRegistration($user->name));

        return redirect(route('dashboard', absolute: false));
    }
}
