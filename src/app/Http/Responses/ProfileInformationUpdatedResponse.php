<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\ProfileInformationUpdatedResponse as Contract;

class ProfileInformationUpdatedResponse implements Contract
{
    public function toResponse($request)
    {
        return redirect('/'); 
    }
}
