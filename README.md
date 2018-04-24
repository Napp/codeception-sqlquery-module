Napp SQL Query Codeception module
===

Find N+1 or similar design bugs in your Laravel application.


## Install with Composer

```bash
    {
        "require-dev": {
            "napp/codeception-sqlquery": "1.*"
        }
    }
```

## Example suite configuration

```yaml
    modules:
        enabled:
            - Laravel5
            - Db:
                dsn: "mysql:host=localhost;dbname=testdb"
            - Database:
                depends: [Db, Laravel5]
                connection: my_database
```

## Usage

```php
public function _before()
{
    // start by enabling the listener
    $this->tester->enableSqlQueryListener();
}

public function test_my_api_endpoint()
{
    $this->tester->sendGET('api/my_endpoint');
    $this->tester->seeResponseCodeIs(200);
    $this->tester->seeResponseIsJson();

    // then test sql query count
    $this->tester->assertSqlQueriesLessThanOrEqual(2);
    $this->tester->assertSqlExecutionTimeLessThan(4);
    
    // dump the sql queries for debugging
    //$this->tester->debugSqlQueries();
} 
    
```




    