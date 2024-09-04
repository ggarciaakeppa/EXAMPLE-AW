<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Noticias extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'noticias';

    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'contenido',
        'status',
        'user_id',
    ];
}