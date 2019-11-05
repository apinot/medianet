<?php
namespace medianet\models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use SoftDeletes;
    protected $table = 'documents';
    protected $primaryKey = 'id';
    protected $fillable = ['nom', 'resumer', 'genre','disponible'];
    public $timestamps = true;

    public function documentable() {
        return $this->morphTo();
    }

    public function emprunt(){
		return $this->belongsTo(Emprunt::class);
    }
}