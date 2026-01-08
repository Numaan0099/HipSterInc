<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    use HasFactory;

    protected $table = 'imports';

    protected $primaryKey = 'import_id';

    public $incrementing = true;

    protected $fillable = [
        'type',
        'total_rows',
        'processed_rows',
        'failed_rows',
        'status',
    ];

    protected $casts = [
        'total_rows' => 'integer',
        'processed_rows' => 'integer',
        'failed_rows' => 'integer',
    ];
}