## WhoIs Rest API

This is a simple example of the usage of **io-developer/php-whois** which is a PHP library used to perform WHOIS lookups. WHOIS is a protocol that provides information about domain names, such as the registrant details, registration dates, and the domain's status. This library simplifies querying WHOIS data programmatically using PHP. Implemented on a **Laravel** instance and hosted by a **Nginx** instance.

#### Usage

After downloading the repository you must run the docker compose file in the root directory
```docker
docker-compose up --build -d
```
It should spin up a laravel container hosted by another nginx container accessible at http://localhost:8000

#### Examples of calling the API endpoint for the WhoIs service:

The source code of the controller that handles this endpoint is located in: **src/app/Http/Controllers/WhoisController.php**

**1. Existing domain:**
http://localhost:8000/v1/api/whois?domain=example.com

```json
{
"domain": "example.com",
"whois": {
"parserType": "commonFlat",
"domainName": "example.com",
"whoisServer": "",
"nameServers": [],
"creationDate": 694224000,
"expirationDate": "",
"updatedDate": "",
"states": [],
"owner": "Internet Assigned Numbers Authority",
"registrar": "",
"dnssec": ""
}
}
```

**2. Not allowed domain:**
*Only **.com** domains are considered valid.*
http://localhost:8000/v1/api/whois?domain=example.net

```json
{
"error": "Invalid domain or not a .com domain"
}
```

**3. Invalid domain:**
*Domain name missing.*
http://localhost:8000/v1/api/whois?domain=example

```json
{
"error": "Invalid domain or not a .com domain"
}
```

**4. Not found domain:**
http://localhost:8000/v1/api/whois?domain=aegaegeagrearg.com
*The domain is not found*
```json
{
"error": "WHOIS data not found"
}
```

#### Running Unit Tests
The source code that implements these tests is located in **src/tests/Feature/WhoisTest.php**
```cli
docker exec -it <image name> php artisan test
ex.:
docker exec -it whois_api-main-php-1 php artisan test
```
Expected results:
```cli
   PASS  Tests\Feature\WhoisTest
  ✓ valid domain
  ✓ invalid domain
  ✓ non com domain
  ✓ not found domain

  Tests:    4 passed (4 assertions)
  Duration: 2.13s
```

#### Ending

```
docker-compose down
```