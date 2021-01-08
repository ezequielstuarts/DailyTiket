<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    public $table = "tikets";
    protected $fillable = ['amount', 'client_id', 'user_id'];

    public function client() {
        return $this->belongsTo("App\Client", "id");
    }
}
