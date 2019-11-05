<?php


namespace medianet\models;


use Illuminate\Database\Eloquent\Model;

class Livre extends Model
{
    protected $table = 'livres';
    protected $primaryKey = 'id';
    protected $fillable = ['auteur', 'edition'];
    public $timestamps = true;

    public function document() {
        $this->morphOne(Document::class);
    }
}