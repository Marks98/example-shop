## Požadavky na spuštění
- **PHP verze 8.0**
- Libovolný funkční Databázový server

## Jak spustit

- pomocí 'Composer install' nainstalujeme veškeré závislosti Laravel Frameworku
- frontend se již kompilovat nemusí, je přes CDN
- v souboru .env se musí nastavit přístupy na vlastní databázi:

Výchozí hodnota v .env:
- DB_CONNECTION=mysql
- DB_HOST=127.0.0.1
- DB-PORT=3306
- DB_DATABASE=shop
- DB_USERNAME=root
- DB_PASSWORD=

- Po nastavení databáze, stačí již zavolat příkaz "php artisan migrate:fresh --seed"

## Popis, co příkaz migrate spustí
- Příkaz spustí migrace vytvořené v adresáři "database/migrations/"
- Poté, co proběhnou migrace (vytvoří se nové tabulky v nastavené databázi) se zavolá seeder
- Seeder nastavený v adresáři "database/seeders" naplní tabulku **products** daty


## Popis projektu

- **"app/Http/Controllers/Api/ProductsController" - Controller pro správu API, výpis, editace, ukládání API
- **"app/Http/Models" - Laravel Modely, komunikační vrstva s databází (Tabulkami Products a Product_Histories)
- **"database/migrations"** - Migrace dvou tabulek (Products a Product_Histories), po spuštění příkazu **migrate** vytvoří nové tabulky
- **"database/seeders"** - Po zavolání příkazu **migrate** s příznamek *--seed* naplní nově vytvořené tabulky produkty, které se prodávají v e-shopu
- **"resources/views** - Frontend část webu, .Vue, tailwind načítán přes CDN
- **"routes"** - Nadefinované routy webu a api, web má pouze jednu routu na homepage
- **".env"** - Konfigurační soubor laravelu, stačí nastavit pouze Databázi
- **"openapi.yaml"** - OpenAPI specifikace
