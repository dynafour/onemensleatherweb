<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    protected $table = 'comments'; // Nama tabel

    protected $primaryKey = 'id_comment'; // Primary key

    protected $fillable = ['email','name','subject','description','created_at','updated_at'];

}
