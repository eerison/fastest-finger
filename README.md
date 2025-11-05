
### Setup
I am assuming you have **docker compose** installed on your machine.

> [!WARNING]  
> Make sure you do not have any service running on port `8000`


Clone the project in your machine.
```bash
git clone https://github.com/eerison/fastest-finger.git
```

#### Prepare Dev and Test environment

Inside the project run the commands bellow e.g `cd fastest-finger`

```bash
docker compose up -d --wait \
&& docker compose exec php composer install \
&& docker compose exec php bin/console doctrine:migrations:migrate --no-interaction \
&& docker compose exec php bin/console --env test doctrine:database:create \
&& docker compose exec php bin/console --env test doctrine:migrations:migrate --no-interaction \
&& docker compose exec php bin/console --env test doctrine:fixtures:load --no-interaction \
&& docker compose exec php bin/phpunit
```


### Test api

new game

```bash
curl -X POST http://localhost:8000/api/games   -H "Content-Type: application/json"   -d '{"playerName": "user-2", "score": 0.7}'

```
get top 10

```bash
curl -s http://localhost:8000/api/games/top-scores | jq .
```
