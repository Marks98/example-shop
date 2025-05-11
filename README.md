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

