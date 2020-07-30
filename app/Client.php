<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['name'];

    public function tikets() {
        return $this->hasMany("App\Tiket", "tiket_id");
    }
}
