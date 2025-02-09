<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    /**
     * La table associée au modèle.
     *
     * @var string
     */
    protected $table = 'feedback';

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array
     */
    protected $fillable = [
        'proposition_id',
        'user_id',
        'rating',
        'comment',
    ];

    /**
     * Obtient la proposition associée au feedback.
     */
    public function proposition()
    {
        return $this->belongsTo(Proposition::class);
    }

    /**
     * Obtient l'utilisateur qui a donné le feedback.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
