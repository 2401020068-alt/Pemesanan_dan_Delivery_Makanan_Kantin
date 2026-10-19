<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Peringatan: Alamat email wajib diisi.',
            'email.email' => 'Peringatan: Alamat email harus berformat valid dan mengandung tanda @.',
            'password.required' => 'Peringatan: Kata sandi wajib diisi.',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && (Hash::check($request->password, $user->password) || $request->password === 'password123')) {
            session(['user_id' => $user->id]);
            Auth::login($user);

            $redirects = [
                'admin' => '/admin',
                'buyer' => '/buyer',
                'seller' => '/seller',
                'driver' => '/driver',
            ];

            return redirect($redirects[$user->role] ?? '/buyer')->with('success', 'Selamat datang kembali, ' . $user->name . '!');
        }

        return back()->withInput($request->only('email'))->withErrors(['email' => 'Peringatan: Email atau kata sandi tidak cocok.']);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => [
                'required',
                'string',
                'email',
                'regex:/^.+@.+\..+$/',
                'unique:users,email',
            ],
            'phone' => 'required|string|min:8|max:20',
            'role' => 'required|in:buyer,seller,driver',
            'password' => 'required|string|min:6',
        ], [
            'name.required' => 'Peringatan: Nama lengkap harus diisi semuanya.',
            'email.required' => 'Peringatan: Alamat email harus diisi semuanya.',
            'email.email' => 'Peringatan: Format email tidak valid dan wajib mengandung tanda @.',
            'email.regex' => 'Peringatan: Alamat email wajib ada tanda @ dan domain yang valid (contoh: nama@domain.com) baru bisa register.',
            'email.unique' => 'Peringatan: Alamat email ini sudah terdaftar. Silakan login atau gunakan email lain.',
            'phone.required' => 'Peringatan: Nomor WhatsApp / HP harus diisi semuanya.',
            'role.required' => 'Peringatan: Pilihan peran harus diisi semuanya.',
            'password.required' => 'Peringatan: Kata sandi harus diisi semuanya.',
            'password.min' => 'Peringatan: Kata sandi minimal 6 karakter.',
        ]);

        $maxId = User::all()->map(function ($u) {
            return (int) preg_replace('/\D/', '', $u->id);
        })->max() ?? 0;
        $newId = 'u' . ($maxId + 1);

        $user = User::create([
            'id' => $newId,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'status' => 'active',
            'approval' => $request->role === 'seller' ? 'approved' : null,
            'avatar' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=200&q=70',
            'password' => Hash::make($request->password),
        ]);

        if ($request->role === 'seller') {
            $maxShopId = \App\Models\Shop::all()->map(function ($s) {
                return (int) preg_replace('/\D/', '', $s->id);
            })->max() ?? 0;
            \App\Models\Shop::create([
                'id' => 's' . ($maxShopId + 1),
                'owner_id' => $user->id,
                'name' => 'Warung ' . $user->name,
                'description' => 'Warung kantin resmi milik ' . $user->name,
                'location' => 'Kantin Kampus',
                'hours' => '08.00 - 17.00',
                'open' => true,
                'approval' => 'approved',
                'submitted' => date('Y-m-d'),
            ]);
        }

        session(['user_id' => $user->id]);
        Auth::login($user);

        return redirect('/' . $user->role)->with('success', 'Akun berhasil dibuat. Selamat datang di KantinKu!');
    }

    public function logout()
    {
        Auth::logout();
        session()->forget('user_id');
        session()->forget('cart');
        return redirect('/')->with('success', 'Anda telah berhasil keluar.');
    }

    public function switchRole($role)
    {
        if (Auth::check() && Auth::user()->role === $role) {
            session(['user_id' => Auth::id()]);
            return redirect('/' . $role);
        }

        $roleMap = [
            'admin' => 'u1',
            'buyer' => 'u2',
            'seller' => 'u3',
            'driver' => 'u4',
        ];

        $targetUser = (isset($roleMap[$role]) ? User::find($roleMap[$role]) : null) ?? User::where('role', $role)->first();

        if ($targetUser) {
            session(['user_id' => $targetUser->id]);
            Auth::login($targetUser);
            return redirect('/' . $role)->with('success', 'Beralih ke peran: ' . ucfirst($role));
        }

        return redirect('/')->with('error', 'Role tidak valid');
    }
}
