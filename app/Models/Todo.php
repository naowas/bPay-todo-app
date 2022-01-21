<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Todo extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];
    protected $fillable = [
        'title', 'description', 'date', 'time', 'sending_status', 'user_id'
    ];
    protected $casts = [
        'title' => 'string',
        'description' => 'string',
        'date' => 'date',
        'status' => 'integer',
        'user_id' => 'integer',
    ];

    public const EMAIL_NOT_SENT = 0;
    public const EMAIL_SENT = 1;


    public function setTimeAttribute($value): void
    {
        $this->attributes['time'] = Carbon::parse($value)->format('h:i:s');
    }
    public function getTimeAttribute($value): string
    {
       return $this->attributes['time'] = Carbon::parse($value)->isoFormat('LT');
    }
    public function getDateAttribute($value): string
    {
       return $this->attributes['date'] = Carbon::parse($value)->format('Y-m-d');
    }

}
