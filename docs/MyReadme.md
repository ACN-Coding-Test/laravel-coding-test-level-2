# Setup Steps
1. Set virtual host as laravel_test in http / you can edit URL on L5_SWAGGER_CONST_HOST=http://laravel_test/api/

2. generate new application key for the first time
- $ php artisan key:generate
    
3. generate new jwt key oauth for the first time
- $ php artisan jwt:secret

4. caching new config 
- $ php artisan config:cache

5. generate l5-swagger 
- $ php artisan l5-swagger:generate