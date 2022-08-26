<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\GoogleAccount;
use App\Models\GoogleEvent;
use App\Models\User;
use App\Services\Google;
use DB;

class GoogleAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // dd(auth()->user()->googleAccounts);
        // return redirect($google->createAuthUrl());
        return view('accounts', [
            'accounts' => auth()->user()->googleAccounts,
        ]);
    }

    public function store(Request $request, Google $google)
    {
        if (! $request->has('code')) {
            return redirect($google->createAuthUrl());
        }
        // dd($request->get('code'));
        $google->authenticate($request->get('code'));

        $account = $google->service('Oauth2');
        $userInfo = $account->userinfo->get();
        
        auth()->user()->googleAccounts()->updateOrCreate(
            [
                'google_id' => $userInfo->id,
            ],
            [
                'name' =>$userInfo->email,
                'token' => $google->getAccessToken(),
            ]
        );
        // dd(auth()->user()->googleAccounts());
        auth()->user()->googleAccounts;
        // return redirect()->route('google.index');
        return redirect()->route('studentCal');
    }

    public function getToken(Google $google){
        $userID     = Auth::user()->id;
        $googleCal  = GoogleAccount::where('user_id', '=', $userID)->first();
        $token      = $googleCal->token['access_token'];
        $getCalID   = $google->connectUsing($googleCal->token)->service('Calendar');
    }

    public function destroy(GoogleAccount $googleAccount, Google $google)
    {
        $googleAccount->delete();
        $google->revokeToken($googleAccount->token);
        return redirect()->back();
    }

    public function getGoogleEvents(){
        $events = auth()->user()->googleevents()
            ->orderBy('started_at', 'desc')
            ->get();
    }
}