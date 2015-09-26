<?php

namespace Jackweinbender\LaravelJsonapi;

use Closure;
use Input;

class JsonApiRequestValidation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $type)
    {
      if(!Input::has('data') || Input::get('data') == []){
        return response('No Data Sent', 400);
      }
      if(!Input::has('data.type')){
        return response('No Type Specified', 400);
      }
      if(Input::get('data.type') != $type){
        return response('Wrong Type Specified', 400);
      }
      if(!Input::has('data.attributes')){
        return response('No Attributes sent', 400);
      }

        return $next($request);
    }
}
