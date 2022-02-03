## Installation

```
git clone https://github.com/kapitansen/mesh-test-app 
cd mesh-test-app
cp .env.example .env
composer install --ignore-platform-reqs
npm install
```

## Configuring a bash alias for sail

https://laravel.com/docs/8.x/sail#configuring-a-bash-alias

## Starting containers

to start:  ```sail up -d```

run migrations:
```sail artisan migrate:fresh```

start queues: 
```sail artisan queue:work```  

start websockets: 
```sail artisan websockets:serve```

open http://0.0.0.0/

## Testing

run tests:
```sail artisan test```


