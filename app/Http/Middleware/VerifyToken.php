<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class VerifyToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->route('token');
        $checkrecord = DB::table('tokens')->where('token', $token)->where('type', 'reset_password')->exists();
        $record = DB::table('tokens')->where('token', $token)->where('type', 'reset_password')->first();
        $expire = Carbon::parse($record->expires_at);
        if (!$checkrecord) {
            return redirect('/')->with('warning', 'Token Tidak Valid');
        }
        if ($expire->isPast()) {
            return back()->with('warning', 'Token Sudah Tidak Berlaku');
        }
        return $next($request);
    }
}
