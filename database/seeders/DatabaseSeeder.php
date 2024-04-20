<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Car;
use App\Models\Cbrand;
use App\Models\City;
use App\Models\Client;
use App\Models\Cmodel;
use App\Models\Cuisine;
use App\Models\Host;
use App\Models\Image;
use App\Models\Offer;
use App\Models\Restaurant;
use App\Models\Table;
use App\Models\User;
use App\Models\Room;
use App\Models\Roomtype;
use App\Models\Hotel;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $citiesData = [
            [
                'name' => 'Tangier',
            ],
            
            [
                'name' => 'Rabat',
            ],
        ];

        foreach ($citiesData as $cityData) {
            City::create($cityData);
        }

        $cbrandsData = [
            [
                'name' => 'Brand 1',
            ],
            
            [
                'name' => 'Brand 2',
            ],
        ];

        foreach ($cbrandsData as $cbrandData) {
            Cbrand::create($cbrandData);
        }


        $cmodelsData = [
            [
                'name' => 'Modèle 1',
                'cbrand_id' => 1, 
            ],
            
            [
                'name' => 'Modèle 2',
                'cbrand_id' => 2,
            ],
            [
                'name' => 'Modèle 3',
                'cbrand_id' => 2,
            ],
        ];

        foreach ($cmodelsData as $cmodelData) {
            Cmodel::create($cmodelData);
        }

        $carsData = [
            [
                'price_per_day' => 550.00,
                'production_date' => '2022-01-01',
                'fuel' => 'Essence',
                'nbr_places' => 2+2,
                'description' => 'Une voiture luxueuse et fiable.',
                'cmodel_id' => 1,
                'city_id' => 1,
            ],
            [
                'price_per_day' => 460.00,
                'production_date' => '2021-05-15',
                'fuel' => 'Diesel',
                'nbr_places' => 4,
                'description' => 'Une voiture luxueuse et spacieuse.',
                'cmodel_id' => 2,
                'city_id' => 2,
            ],
            [
                'price_per_day' => 200.00,
                'production_date' => '2008-10-10',
                'fuel' => 'Diesel',
                'nbr_places' => 4,
                'description' => 'Une voiture économique et fiable.',
                'cmodel_id' => 3,
                'city_id' => 1,
            ],
        ];

        foreach ($carsData as $carData) {
            Car::create($carData);
        }

        $usersData = [
            [
                'CIN' => 'CD123456',
                'first_name' => 'Youssra',
                'last_name' => 'Benmimoun',
                'email' => 'youssra.benmimou@gmail.com',
                'password' => '123',
                'type' => 'user',
                'address' => 'bit',
                'telephone' => '0123456789',
                'city' => 'Tanger',
                'country' => 'Maroc',
                'birth_date' => '1998-08-11'
            ],
            
            [
                'CIN' => 'CD654321',
                'first_name' => 'Aida',
                'last_name' => 'Benmimoun',
                'email' => 'aida.benmimou@gmail.com',
                'password' => '123',
                'type' => 'user',
                'address' => 'bit',
                'telephone' => '0123456789',
                'city' => 'Tanger',
                'country' => 'Maroc',
                'birth_date' => '2000-06-06'
            ],
            
        ];

        foreach ($usersData as $userData) {
            User::create($userData);
        }

        $hostsData = [
            [
                'user_id' => 1
            ]
            
        ];

        foreach ($hostsData as $hostData) {
            Host::create($hostData);
        }

        $clientsData = [
            [
                'user_id' => 2
            ]
            
        ];

        foreach ($clientsData as $clientData) {
            Client::create($clientData);
        }

        $cuisinesData = [
            [
                'name' => 'marocaine',
            ],
            [
                'name' => 'italienne',
            ],
            [
                'name' => 'chinoise',
            ],
            [
                'name' => 'mexicaine',
            ]
            
        ];

        foreach ($cuisinesData as $cuisineData) {
            Cuisine::create($cuisineData);
        }

        $restaurantsData = [
            [
                'name' => 'Pallermo',
                'description' => '............................',
                'nbr_tables' => 16,
                'cuisine_id' => 2,
                'city_id' => 1
            ],
            [
                'name' => 'Chihuahua',
                'description' => '............................',
                'nbr_tables' => 18,
                'cuisine_id' => 4,
                'city_id' => 1
            ],
            [
                'name' => 'Dar Naji',
                'description' => '............................',
                'nbr_tables' => 20,
                'cuisine_id' => 1,
                'city_id' => 2
            ],
            [
                'name' => 'Dar Tazi',
                'description' => '............................',
                'nbr_tables' => 24,
                'cuisine_id' => 1,
                'city_id' => 2
            ],
            
            
        ];

        foreach ($restaurantsData as $restaurantData) {
            Restaurant::create($restaurantData);
        }
        
        $offersData = [
            [
                'description' => "description",
                'type' => 'car',
                'host_id' => 1,
                'car_id' => 1
            ],
            
            [
                'description' => "description",
                'type' => 'car',
                'host_id' => 1,
                'car_id' => 2
            ],
            [
                'description' => "description",
                'type' => 'car',
                'host_id' => 1,
                'car_id' => 3
            ],
            [
                'description' => "description restaurant 1",
                'type' => 'restaurant',
                'host_id' => 1,
                'restaurant_id' => 1
            ],
            
            [
                'description' => "description restaurant 2",
                'type' => 'restaurant',
                'host_id' => 1,
                'restaurant_id' => 2
            ],
            [
                'description' => "description restaurant3",
                'type' => 'restaurant',
                'host_id' => 1,
                'restaurant_id' => 3
            ],
            
            [
                'description' => "description",
                'type' => 'restaurant',
                'host_id' => 1,
                'restaurant_id' => 4
            ],
            [
                'description' => "description",
                'type' => 'hotel',
                'host_id' => 1,
                'hotel_id' => 1
            ],            [
                'description' => "description",
                'type' => 'hotel',
                'host_id' => 1,
                'hotel_id' => 2
            ],
            
        ];

        foreach ($offersData as $offerData) {
            Offer::create($offerData);
        }

        
        $imagesData = [
            [
                'url' => '/assets/polestar-1.jpg',
                'offer_id' => 1,
            ],
            [
                'url' => '/assets/polestar-1-1.jpg',
                'offer_id' => 1,
            ],
            [
                'url' => '/assets/car2.jpg',
                'offer_id' => 2,
            ],
            [
                'url' => '/assets/mercedes-2005.jpg',
                'offer_id' => 3,
            ]
            
        ];

        foreach ($imagesData as $imageData) {
            Image::create($imageData);
        }

        

        

        $tablesData = [
            [
                'type' => 'table à 4',
                'restaurant_id' => 1
            ],
            
            [
                'type' => 'table à 2',
                'restaurant_id' => 1
            ],
            
            [
                'type' => 'table à 4',
                'restaurant_id' => 1
            ],
            
            [
                'type' => 'table à 2',
                'restaurant_id' => 2
            ],    
        ];

        foreach ($tablesData as $tableData) {
            Table::create($tableData);
        }

        $hotels = [
            [
                'name' => 'Hilton Tanger City Center Hotel & Residences',
                'address' => ' Tanger City Center Place du Maghreb, 90000 Tangier, Morocco',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'nbr_stars' => 5,
                'latitude' => 51.5074, 
                'longitude' => -0.1278, 
                'city_id' => 1,
            ],
            [
                'name' => 'Royal Tulip City Center',
                'address' => ' Tanger City Center Place du Maghreb, 90000 Tangier, Morocco ',
                'description' => 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'nbr_stars' => 5,
                'latitude' => 40.7128,
                'longitude' => -74.0060,
                'city_id' => 2, 
            ],
           
        ];

       
        foreach ($hotels as $hotelData) {
            Hotel::insert($hotelData);
        }

        $roomtypes=[
            ['name' =>'suite'],
            ['name' => 'familly room']
        ];

        foreach($roomtypes as $roomtypeData){
            RoomType::insert($roomtypeData);
        }

        $room=[
            ['nbr_beds' => 3, 'price_per_night' => '140.00', 'description'=> 'suite', 'hotel_id'=>1, 'roomtype_id'=>1],
            ['nbr_beds' => 1, 'price_per_night' => '70.00', 'description'=> 'familly', 'hotel_id'=>2, 'roomtype_id'=>2],

                      
        ];
        foreach($room as $roomData){
            Room::insert($roomData);
        }
    }
}
