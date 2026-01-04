<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'user_id',
        'status',
        'total_rows',
        'successful_rows',
        'failed_rows',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
