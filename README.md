## About Fleet-Management Setup And Solution Idea

**Setup**

After Installing, take a copy for .env.example to .env and fill out the system connection and tenant connection

1 -
```sh
composer install
```

2-
```sh
php artisan migrate
```

3-
```sh
php artisan passport:install
```

4-
```sh
php artisan passport:keys
```

5-
```sh
php artisan passport:client --password
```

* After That, you get your new Passport client to use it in the login

6- To have a dummy data to test, run the seeders:
```sh
php artisan db:seed
```

7- To run unit tests:
```sh
php artisan test
```
***

**Solution Idea**
We want to make a feature of reserving available seats in trips. The trips are between cities and has a cities "stations" in between which could reserved as well. The idea is to asume that all those trips are paths and the in-between stations in the trips are paths as well.

![Trip Example](https://i.ibb.co/wN3WfdZ/Screenshot-from-2021-06-12-21-47-28.png "Trip Example")

Let's asume we have a trip between Cairo and Alexandria as shown in the image. We are defining a number for every path between the in-between cities. The whole trip is from path 1 to path 4. If we want to reserve a trip between Faiyum and Asyut, that mean we will reserve fromn the path 2 to 3 and so on.

The whole idea is we are dealing with the trip as a sequence of ordered paths that has a start point and end point. When reserving a new trip, all we need is to check the new reservation path and compare it with the current reservations. We do this comparison be checking the overlappings. If there are an overlap, that means another person is already taking a seat in some point of the new reservation path.

Every reservation is reserving a seat and every tip has 12 seats. That means if we are having a 12 overlapping, this trip is unavailable for the new needed reservation as all seats is having peole reserved it at some point on the trip.