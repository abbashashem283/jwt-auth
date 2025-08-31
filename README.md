1- install the package

2-export jwt-auth package config, also generate token secrets using this command
php artisan jwt-generate --key=JWT_SECRET
php artisan jwt-generate --key=REFRESH_SECRET
php artisan jwt-generate --key=CSRF_SECRET

set the token configurations in config/jwt-auth.php as
 "access" => [
        "secret" => env("JWT_SECRET"),
        "algorithm" => "HS256",
        "ttl" => 60
    ],
    "refresh" => [
        "secret" => env("REFRESH_SECRET"),
        "algorithm" => "HS256",
        "ttl" => 10080
    ],
    "csrf" => [
        "secret" => env("CSRF_SECRET"),
        "algorithm" => "HS256",
        "ttl" => 1440
    ],

3- create password reset and email verification views (email verification has a property $link and password verification has a property $code) for example I created 
auth.email_verification & auth.password_reset and link them to your config/jwt-auth.php as
"mail_service_views" => [
        "emailVerification"=>"auth.email_verification",
        "passwordReset"=>"auth.password_reset"
    ] 


4- run the migrations of the package php artisan migrate

5- install laravel sanctum php artisan install:api

6- modify config/auth.php 

 'defaults' => [
        'guard' => env('AUTH_GUARD', 'api'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

and 

'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'api' => [
            'driver' => 'jwt',
            'provider' => 'users'
        ]
    ],

7- set email mail server settings in .env file as in
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME= "put your email here"
MAIL_PASSWORD="password you got from google"
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="put your email here"
MAIL_FROM_NAME="Jwt Auth"

8-Make sure user model has the following fields (email verified at, email, password) and it must extend Authenticatable and use the HasJwtAuthTokens trait

9- in routes/api.php add sample routes like
Route::prefix("auth")->controller(AuthController::class)->group(
    function () {
        Route::post("/login","login")->name("auth.login");
        Route::post("/logout","logout")->name("auth.logout");
        Route::post("/refresh","refresh")->name("auth.refresh");
        Route::post("/register","register")->name("auth.register");
        Route::post("/password/forgot-password", "forgotPassword")->name("auth.password.forgot");
        Route::post("/password/check-code", "checkPasswordCode")->name("auth.password.code");
        Route::post("/password/reset", "resetPassword")->name("auth.password.reset");
        Route::get("/verify","verify")->name("auth.verify");
        Route::get("/hi", "greet");
        Route::get("/user", "user")->name("auth.user");
    }
