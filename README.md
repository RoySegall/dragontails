## Set up backend

You'll need [Rethinkdb](http://rethinkdb.db) up and running:

```bash
rethikndb --http-port 8090
```

Now, let's set up the data

```bash
cd server
composer install

php console.php social:install
```

The last thing is to get the backend up and running:

```bash
php -S localhost:8081
```
