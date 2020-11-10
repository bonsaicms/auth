<?php

namespace BonsaiCms;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable;

interface AuthenticatableContract extends Authenticatable, Authorizable, CanResetPassword
{
    //
}
