<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Link extends Model
{
    use HasFactory,SoftDeletes;
    protected $hidden = ['password','remember_token'];
    protected $fillable = ['code','url','user_id','expires_at'];
    protected $appends = ['short_url'];
    protected $casts = ['expires_at'=>'datetime'];

    protected function shortUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => url('/' . $this->code)
        );
    }
    
    public function incrementClicks(){
        $this->increment('clicks');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
