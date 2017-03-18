<?php

namespace App\Http\Middleware;

use Closure;

class MaxUploadFileSizeMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Check if upload has exceeded max size limit
        
        if (! ($request->isMethod('POST') or $request->isMethod('PUT'))) {
            return $next($request); 
        }
        // Get the max upload size (in Mb, so convert it to bytes)
        $maxUploadSize = 1024 * 1024 * ini_get('post_max_size');
        $contentSize = 0;
        if (isset($_SERVER['HTTP_CONTENT_LENGTH']))
        {
            $contentSize = $_SERVER['HTTP_CONTENT_LENGTH'];
        } 
        elseif (isset($_SERVER['CONTENT_LENGTH']))
        {
            $contentSize = $_SERVER['CONTENT_LENGTH'];
        }
        // If content exceeds max size, throw an exception
        if ($contentSize > $maxUploadSize)
        {
            throw new \Exception('Max File Size exceeded');
        }

        return $next($request);
    }
}
