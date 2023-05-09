<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, mixed $batchId)
 */
class JobBatch extends Model
{
    use HasFactory;

    protected $table = 'job_batches';
    protected $guarded = [];

}
