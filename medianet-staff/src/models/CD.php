<?php
namespace medianet\models;



use Illuminate\Database\Eloquent\Model;

class CD extends Model
{
    protected $table = 'cds';
    protected $primaryKey = 'id';
    protected $fillable = ['artsist', 'maison_disque'];
    public $timestamps = false;

    public function document() {
        $this->morphOne(Document::class);
    }
}