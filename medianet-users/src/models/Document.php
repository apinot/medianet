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
        $reservation = $this->reservation()->whereNull('emprunt_id')->whereDate('date', '<=', date('Y-m-d H:i:s'));
        $emprunt = $this->emprunt()->whereNull('date_retour');
        
        //On peut reserver si le document est disponible, si il n'est pas reservé et si il n'est pas retirer 
        return $this->disponible || $reservation == null || (!$this->disponible && $reservation != null);
    }
}