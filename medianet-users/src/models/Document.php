<?php
namespace medianet\models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use SoftDeletes;
    protected $table = 'documents';
    protected $primaryKey = 'id';
    protected $fillable = ['nom', 'resumer', 'genre','disponible','documentable_type','documentable_id'];
    public $timestamps = true;
    
    public function documentable() {
        return $this->morphTo();
    }
    
    public function emprunt(){
        return $this->hasMany(Emprunt::class);
    }

    public function reservation() {
        return $this->hasMany(Reservation::class);
    }

    public function type() {
        $res = explode('\\',$this->documentable_type);
        return $res[count($res)-1];
    }

    public function peutEtreReserver() {
        if($this->disponible === 0) return false;
        $reservation = $this->reservation()->whereNull('emprunt_id')->whereDate('date_limite', '>=', date('Y-m-d H:i:s'))->first();
        if($reservation != null) return false;
        return true;
    }
}