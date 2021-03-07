<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\LogEvent;
use App\LogEventFail;
use Carbon\Carbon;
use App\User;
use Session;

use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = '/backoffice';

    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function login(\Illuminate\Http\Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        // This section is the only change
        if ($this->guard()->validate($this->credentials($request))) {
            $user = $this->guard()->getLastAttempted();

            // Make sure the user is active
            if ($user->is_active && $this->attemptLogin($request)) {
                // Send the normal successful login response
                return $this->sendLoginResponse($request);
            } else {
                // Increment the failed login attempts and redirect back to the
                // login form with an error message.
                $this->incrementLoginAttempts($request);

                $ipv4 = $request->server->get('REMOTE_ADDR');
                LogEventFail::NewLoginEvent($request->email, $ipv4);

                return redirect()
                    ->back()
                    ->withInput($request->only($this->username(), 'remember'))
                    ->withErrors(['active' => 'You must be active to login.']);
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        $user->update([
            'last_login' => Carbon::now()->toDateTimeString()
        ]);
        $ipv4 = $request->server->get('REMOTE_ADDR');
        LogEvent::NewLoginEvent($user, $ipv4);

        Session::put('locale', $user->lang);

        flash('Signed in successfully.')->success();

        // dd(auth()->user()->role_id);
                if ( $user->roles->first() ) {// do your magic here
                    return redirect()->route('backoffice.index');
                }
        
            return redirect('/backoffice');
            

            
    }


    public function logout(Request $request)
    {
        $user = auth()->user();
        $ipv4 = $request->server->get('REMOTE_ADDR');
        LogEvent::NewLogoutEvent($user, $ipv4);
        $this->guard()->logout();
        $request->session()->invalidate();

        flash('Signed out successfully.')->success();
        return $this->loggedOut($request) ?: redirect('/');
        //return $this->loggedOut($request) ?: redirect('/login');
    }
}
