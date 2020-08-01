<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public $table = "clients";
    protected $fillable = ['name'];

    public function tikets() {
        return $this->hasMany(Tiket::class, "client_id");
    }
}
