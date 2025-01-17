<?php

namespace App\Models;

use App\Models\Car;
use App\Models\Host;
use App\Models\Tour;
use App\Models\Hotel;
use App\Models\Image;
use App\Models\Restaurant;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = ['description','type'];


    public function host(){
        return $this->belongsTo(Host::class);
    }

    public function reservations(){
        return $this->hasMany(Reservation::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
