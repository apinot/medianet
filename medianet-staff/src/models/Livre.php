<?php


namespace medianet\models;


use Illuminate\Database\Eloquent\Model;

class Livre extends Model
{
    protected $table = 'livres';
    protected $primaryKey = 'id';
    protected $fillable = ['auteur', 'edition'];
    public $timestamps = false;

    public function document() {
        return $this->morphOne(Document::class, 'documentable');
    }
}