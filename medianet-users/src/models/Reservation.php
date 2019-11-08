<?php
namespace medianet\models;

class Reservation extends Model {
    protected $table = 'emprunts';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'date_reservation', 'date_debut', 'date_limite', 'user_id', 'document_id'];
    public $timestamps = false;

    public function user(){
		return $this->belongsTo(User::class);
    }

    public function document(){
		return $this->belongsTo(Document::class);
}