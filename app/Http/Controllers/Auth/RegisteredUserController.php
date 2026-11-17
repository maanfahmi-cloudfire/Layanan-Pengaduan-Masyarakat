<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $kecamatanList = [
            'Blangkejeren',
            'Kutapanjang',
            'Rikit Gaib',
            'Terangun',
            'Pining',
            'Blangpegayon',
            'Puteri Betung',
            'Dabun Gelang',
            'Blangjerango',
            'Teripe Jaya',
            'Pantan Cuaca',
        ];

        return view('auth.register', compact('kecamatanList'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:20', 'regex:/^[0-9+\s\-()]+$/'],
            'kecamatan' => ['required', 'string', 'max:100'],
            'desa' => ['required', 'string', 'max:100'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar dalam sistem.',
            'phone.required' => 'Nomor HP/WhatsApp aktif wajib diisi.',
            'phone.regex' => 'Format nomor HP tidak valid.',
            'kecamatan.required' => 'Silakan pilih kecamatan domisili.',
            'desa.required' => 'Nama desa/kampung wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'kecamatan' => $request->kecamatan,
            'desa' => $request->desa,
            'password' => Hash::make($request->password),
            'role' => 'masyarakat',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Selamat datang! Akun Anda berhasil didaftarkan.');
    }
}
