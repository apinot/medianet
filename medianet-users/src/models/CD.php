<?php
namespace medianet\models;



use Illuminate\Database\Eloquent\Model;

class CD extends Model
{
    protected $table = 'cds';
    protected $primaryKey = 'id';
    protected $fillable = ['artiste', 'maison_disque'];
    public $timestamps = true;

    public function document() {
        $this->morphOne(Document::class);
    }
}