<?php

namespace App\Models\Admin;

use App\Models\Admin\QueryBuilders\BookingStatusesQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingStatus extends Model
{
    use HasFactory;

    protected $table = 'booking_statuses';
    protected $guarded = ['id'];

    // ------------------------------
    // Constants matching DB IDs
    // ------------------------------
    const PENDING   = 1;
    const CONFIRMED = 2;
    const ACTIVE    = 3;
    const COMPLETED = 4;
    const CANCELLED = 5;

    public function newEloquentBuilder($query): BookingStatusesQueryBuilder
    {
        return new BookingStatusesQueryBuilder($query);
    }

    public function getLabelAttribute(): string
    {
        return $this->{"title_en"};
    }
}
