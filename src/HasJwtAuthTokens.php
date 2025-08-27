<?php

namespace Magico\JwtAuth ;

use Magico\JwtAuth\Models\AuthRevoke;
use Magico\JwtAuth\Models\EmailVerificationToken;
use Magico\JwtAuth\Models\ResetPasswordToken;

trait HasJwtAuthTokens{
     public function authRevoke(){
        return $this->hasOne(AuthRevoke::class);
    }

    public function emailVerificationToken(){
        return $this->hasOne(EmailVerificationToken::class);
    }

    public function resetPasswordToken(){
        return $this->hasOne(ResetPasswordToken::class);
    }
}