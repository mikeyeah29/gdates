<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use App\Lib\Roles\RoleChecker;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;

/**
 * Class CheckUserRole
 * @package App\Http\Middleware
 */
class CheckUserRole
{
    /**
     * @var RoleChecker
     */
    protected $roleChecker;

    public function __construct(RoleChecker $roleChecker)
    {
        $this->roleChecker = $roleChecker;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string $role
     * @return mixed
     * @throws AuthorizationException
     */
    public function handle($request, Closure $next, $role)
    {
        /** @var User $user */
        $user = ($request->expectsJson() ? auth('api')->user() : Auth::user());

        if ( ! $this->roleChecker->check($user, $role)) {

            if (!$request->expectsJson()) {
                return back();
                // throw new AuthorizationException('You do not have permission to view this page');
            }else{
                // json respone
                return response()->json(['error' => 'Cant do that'], 403);
            }

        }

        return $next($request);
    }
}