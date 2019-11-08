<?php
namespace medianet\models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model {
    protected $table = 'reservations';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'date_reservation', 'date_debut', 'date_limite', 'user_id', 'document_id'];
    public $timestamps = false;

    public function user(){
		  return $this->belongsTo(User::class);
    }

    public function document(){
      return $this->belongsTo(Document::class);
    }

    public function valide() {
      $now = date("Y-m-d H:i:s");
      $next = $this->date_limite;
      $now = new \DateTime($now);
      $next = new \DateTime($next);
      $now = $now->format("YmdHis");
      $next = $next->format("YmdHis");
      return $now <= $next;
    }
}