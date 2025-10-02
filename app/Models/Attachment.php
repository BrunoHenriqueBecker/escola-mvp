<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model {
    protected $fillable=['activity_id','original_name','path','size','mime'];
    public function activity(){ return $this->belongsTo(Activity::class); }
}