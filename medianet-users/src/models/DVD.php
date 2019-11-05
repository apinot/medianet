<?php


namespace medianet\models;
use Illuminate\Database\Eloquent\Model;

class DVD extends Model
{

    protected $table = 'dvds';
    protected $primaryKey = 'id';
    protected $fillable = ['acteurs', 'duree'];
    public $timestamps = true;

    public function document() {
        $this->morphOne(Document::class);
    }
}