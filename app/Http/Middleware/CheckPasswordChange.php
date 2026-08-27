<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class CheckPasswordChange
{


    public function handle(
        Request $request,
        Closure $next
    ): Response
    {


        $user = auth()->user();



        if(
            $user &&
            $user->must_change_password
        ){

            if(
                !$request->routeIs('orangtua.password.edit')
                &&
                !$request->routeIs('orangtua.password.update')
            ){

                return redirect()
                    ->route('orangtua.password.edit');

            }

        }



        return $next($request);

    }


}