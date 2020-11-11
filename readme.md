# REST Api Laravel
is a projetct can understand with it the concepts of laravel api with **[JWT-auth](https://jwt-auth.readthedocs.io/en/develop/)**




## How to use

- Clone the repository with __git clone__
- Copy __.env.example__ file to __.env__ and edit database credentials there
- npm __install__
- Run __composer install__
- Run __php artisan key:generate__
- Run __composer require tymon/jwt-auth__
- Run __php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"__
- Run __php artisan jwt:secret__
- Run __php artisan migrate --seed__ (it has some seeded data for your testing)

---