<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Blog;

class Commt extends Model
{
    use HasFactory;
  protected $fillable = [
        'blog_id','name','email','message','status','ip','user_agent',
    ];
  
    public function blog() {
        return $this->belongsTo(Blog::class);
    }

    // Simple scope to retrieve only approved comments
    public function scopeApproved($q) {
        return $q->where('status', 'approved');
    }
}
