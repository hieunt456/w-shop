# WOLF SHOP
## I. Installation
### 1. Clone project
```
git clone git@github.com:LLL-ASIA/cb-instagram-sales-list.git
cd wolf-shop
cp .env.example .env
```

### 2. Set up environment configs
If you want to use ports other than 80 and 3306 for your application and database, please set `APP_PORT` and `DB_PORT` in your `.env` file before building the Docker container.
```
APP_PORT=
DB_PORT=
```

### 3. Build Docker containers
```
docker compose up -d
```

### 4. Install dependencies
```
docker compose exec app composer install
```

### 5. Initialize other things
Generate the app key
```
docker compose exec app php artisan key:generate
```
Create the database
```
docker compose exec app php artisan migrate
```
Create user's seed data
```
docker compose exec app php artisan db:seed
```

## II. Features
### 1. Update items
Execute the following command to update the items in the database. The application will update the sellIn and quality value of the items.
```
docker compose exec app php artisan items:update
```
Execute the following command to update the items daily at 00:00 UTC.
```
docker compose exec app php artisan schedule:work
```
- The daily update time can be changed in the `config/wolfshop.php` file.

### 2. Import items
Execute the following command to import items. If the item is already in the database, the application will update the item's sellIn and quality value.
```
docker compose exec app php artisan items:import
```
- If the items from the API do not have the sellIn value, the application will set the default sellIn value to 30 days for normal items.
- If the items from the API do not have the quality value, the application will set the default quality value to 50 for normal items.
- The legendary item's sellIn value is always 0 and its quality value is always 80.
- The normal item's default values can be changed in the `config/wolfshop.php` file.

### 3. Upload item's image url
Set the Cloudinary cloud url in the `.env` file.
```
CLOUDINARY_URL=
```
Use the Postman APIs from [here](https://www.postman.com/prophetqn/workspace/wolfshop/collection/14908894-11d4178d-93c9-4650-856f-0f5363bd9378?action=share&creator=14908894) or import the Json from [here](WolfShop.postman_collection.json) to get all items and upload the item's image url.
Use the following credentials to authenticate and get the token before using the APIs:
```
| Email             | Password |
|-------------------|----------|
| admin@example.com | password |
```
## III. Test
```
docker compose exec app php artisan test
```
