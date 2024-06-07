<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    // Utiliza el trait HasFactory para generar datos de prueba
    protected $fillable = [];

    /**
     * Get the user that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supplier()
    {
        // Define la relación de pertenencia con la clase Supplier
        return $this->belongsTo(Supplier::class);
    }
}
