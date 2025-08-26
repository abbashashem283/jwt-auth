<?php

namespace DevCraft\JwtAuth ;

use DevCraft\JwtAuth\Models\AuthRevoke;
use DevCraft\JwtAuth\Models\EmailVerificationToken;
use DevCraft\JwtAuth\Models\ResetPasswordToken;

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