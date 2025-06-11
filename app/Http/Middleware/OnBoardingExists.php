<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Projects;
use Illuminate\Support\Facades\Auth;

class OnBoardingExists
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
        $projects = Projects::all()->where("user_id", Auth::id());
        if(count($projects) > 0){
            return redirect("/dashboard");
        }else{
            return $next($request);
        }
    }
}
