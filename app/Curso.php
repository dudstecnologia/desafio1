<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'curso';

    protected $primaryKey = 'id_curso';

    public $timestamps = false;

    public function professor() {
        return $this->hasOne(Professor::class, 'id_professor');
    }
}
