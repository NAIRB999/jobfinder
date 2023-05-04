<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    // protected $fillable=['title','company','tag','website','location','description','email'];
    // public $timestamps=false;

    public function scopeFilter($query,array $filters){
        if($filters['tag'] ?? false){
            $query->where('tag','like','%'.request('tag').'%');
        }
        if($filters['search'] ?? false){
            $query->where('title','like','%'.request('search').'%')
            ->orwhere('tag','like','%'.request('search').'%')
            ->orwhere('description','like','%'.request('search').'%')
            ->orwhere('company','like','%'.request('search').'%');
        }
    }
    // relationship to user
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
