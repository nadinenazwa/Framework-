<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Role;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Validasi email dan password
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Ambil user dan relasi role (utamakan role dengan pivot status=1, jika tidak ada ambil role pertama)
        $user = User::with('roles')->where('email', $request->email)->first();

        // Cek keberadaan user dan verifikasi password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
        }

        // Tentukan role aktif (status=1 jika ada, jika tidak ada pakai role pertama)
        $activeRole = $user->roles->firstWhere(function ($r) {
            return isset($r->pivot) && isset($r->pivot->status) && (int) $r->pivot->status === 1;
        }) ?? $user->roles->first();

        if (!$activeRole) {
            return back()->withErrors(['email' => 'Akun tidak memiliki role aktif. Hubungi admin.'])->withInput();
        }

        // Login user menggunakan Laravel Auth
        Auth::login($user);

        // Simpan 5 variabel session kustom
    $role = $activeRole;
        session([
            'user_id' => $user->iduser,
            'user_name' => $user->nama,
            'user_email' => $user->email,
            'user_role' => $role ? $role->idrole : null,
            'user_role_name' => $role ? $role->nama_role : null,
            'user_status' => $role ? $role->pivot->status : null,
        ]);

        // Lakukan redirect menggunakan switch case berdasarkan userRole (ID Role)
        $userRole = $role ? (string) $role->idrole : null;

        // Tentukan target route name berdasarkan role
        $targetRouteName = match ($userRole) {
            '1' => 'admin.dashboard',
            '2' => 'dokter.dashboard',
            '3' => 'perawat.dashboard',
            '4' => 'resepsionis.dashboard',
            '5' => 'pemilik.dashboard',
            default => null
        };

        // Log keputusan redirect untuk debugging
        Log::info('Login redirect decision', [
            'user_id' => $user->iduser ?? null,
            'email' => $user->email ?? null,
            'detected_role_id' => $userRole,
            'detected_role_name' => $role->nama_role ?? null,
            'pivot_status' => $role->pivot->status ?? null,
            'target_route' => $targetRouteName,
        ]);

        switch ($userRole) {
            case '1':
                return redirect()->route('admin.dashboard');
            case '2':
                return redirect()->route('dokter.dashboard');
            case '3':
                return redirect()->route('perawat.dashboard');
            case '4':
                return redirect()->route('resepsionis.dashboard');
            case '5':
                return redirect()->route('pemilik.dashboard');
            default:
                // Jika role tidak dikenali, arahkan kembali ke login dengan pesan
                return redirect()->route('login')->withErrors(['email' => 'Role tidak dikenali. Hubungi admin.']);
        }
    }

    /**
     * Log the current user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        // Clear custom sessions
        session()->forget(['user_id', 'user_name', 'user_email', 'user_role', 'user_role_name', 'user_status']);

        // Logout using Auth
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
