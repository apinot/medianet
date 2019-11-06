<?php

namespace medianet\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Emprunt extends Model
{
    protected $table = 'emprunts';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'date_emprunt', 'date_limite', 'date_retour', 'user_id', 'document_id'];
    public $timestamps = false;

    public function user(){
		return $this->belongsTo(User::class);
    }

    public function document(){
		return $this->belongsTo(Document::class);
    }

} 
