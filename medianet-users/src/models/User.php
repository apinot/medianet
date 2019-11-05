<?php

namespace medianet\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = ['nom', 'prenom', 'email', 'adresse', 'mdp', 'adhesion'];
    public $timestamps = true;
} 