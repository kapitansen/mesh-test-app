## Installation

```
git clone mesh-test-app. 
cd mesh-test-app
npm install 
sail composer install
```

## Starting containers

to start:  ```sail up -d```

start queues: 
```sail artisan queue:work```  

start websockets: 
```sail artisan websockets:serve```

run tests:
```sail artisan test```


