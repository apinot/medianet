<?php

namespace medianet\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nom', 'prenom', 'email', 'adresse', 'mdp', 'adhesion', 'demande_adhesion', 'telephone'];
    public $timestamps = true;

    public function emprunts(){
		  return $this->hasMany(Emprunt::class);
    }

    public function reservations (){
        return $this->hasMany(reservations::class);
  }

} 
