<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    public $tabel = "tokens";
    public $primarykey = "id";

    protected $fillable = [
        'title',
        'description',
        'email',
    ];
}
