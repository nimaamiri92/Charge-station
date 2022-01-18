## About Project

Base on the test assessment, I create system to calculate price of charging.

## About Structure

- `app`
    - `Controllers`
        - `ChargeStationController` to get request, there is no logic in there just get input params and send output to
          resource class
    - `ValueObjects`
        - `ChargeStationValueObject` this class has responsibility to get inputs and parse it, also some simple
          operation
    - `Services`
        - `ChargeStationService` the main logic of application is there(domain layer)
    - `resource`
        - `RateCalculatorResource` for representation layer use this resource class
    - `Request`
        - `RateCalculatorRequest` this class set input requirements
    - `tests`
        - `feature` test the api work perfectly
        - `unit` test our functionality in domain layer

## Install Application
- For running application you need Docker installed on your system, and follow instructions;
  ```bash
    docker-compose build --no-cache
    docker-compose up -d
    docker-compose exec php composer install
  ```
  after run docker container we have our service at `localhost:8080`

# API Document
-----------------
- You can send data in `POST` to the following URL:
```
http://localhost:8000/rate
```
- Body:
```
{
    "rate": {
        "energy": 0.3,
        "time": 2,
        "transaction": 1
    },
    "cdr": {
        "meterStart": 1204307,
        "timestampStart": "2021-04-05T10:04:00Z",
        "meterStop": 1215230,
        "timestampStop": "2021-04-05T11:27:00Z"
    }
}
```

- Response:
```
{
    "overall": 7.04,
    "components": {
        "energy": 3.277,
        "time": 2.767,
        "transaction": 1
    }
}
```

## Running Tests

For running tests simply run below command:
```bash
    docker-compose exec php php ./vendor/bin/phpunit tests
```

## About better Api Design :
base one my knowledge and below references:
 - [json.org](https://www.json.org/json-en.html)
 - [Google JSON Style Guide](https://google.github.io/styleguide/jsoncstyleguide.xml)
 
I suggest:
- Use `GET` instead of `POST`, because we are retreating data
- Use meaningful words,instead of `cdr` or `overall`,`components`
- If station has rate and usage why we should send it to another api for calculation, I think in concept of microservice it's better
to get rate from another service and get usage form another one.
- the Api result should be wrap with `data` keyword, and in case of error should has `errors` keyword
- (optional) In my opinion it's better to define keys as `snake_case`, because most developer use `camelCase` in their code,it helps us find out request data from our local variables. 
this rule exist for response too
- In the response we need specify the unit of our currency, it's better instead of show a number show object that contain number and price unit
- set `apiVersion` in our api response
- we can also add request `status code` in our response
