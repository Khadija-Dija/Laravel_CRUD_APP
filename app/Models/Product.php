<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    //Cela signifie que seules les colonnes suivantes peuvent être massivement affectées
    protected $fillable = ['name', 'description','category','quantity','price','image'];
}
