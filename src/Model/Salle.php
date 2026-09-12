<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Salle extends Model
{
    protected $table = 'salle';

    protected $perPage = 5;

    protected $fillable = ['nom', 'batiment', 'capacite', 'type', 'active'];

    protected $casts = ['active' => 'boolean'];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
