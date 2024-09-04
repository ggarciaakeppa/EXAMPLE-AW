<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class IngresoAutoModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ingreso_auto';

    protected $fillable = [
        'placas',
        'conductor',
    ];
}