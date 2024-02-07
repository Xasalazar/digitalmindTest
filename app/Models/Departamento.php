<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Departamento
 *
 * @property $id
 * @property $nombre
 * @property $estado
 * @property $usuario_creacion
 * @property $created_at
 * @property $updated_at
 *
 * @property Usuario[] $usuarios
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Departamento extends Model
{
    protected $table = 'departamentos';

    static $rules = [
		'nombre' => 'required',
		'estado' => 'required',
		'usuario_creacion' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre','estado','usuario_creacion'];
    

}
