<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    protected $table = 'aluno';

    protected $primaryKey = 'id_aluno';

    public $timestamps = false;

    public function curso() {
        return $this->hasOne(Curso::class, 'id_curso');
    }
}
