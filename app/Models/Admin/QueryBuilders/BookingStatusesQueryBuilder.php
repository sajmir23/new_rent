<?php

namespace App\Models\Admin\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;

class BookingStatusesQueryBuilder extends Builder
{
    public function search(?string $keyword = null, ?int $id = null): BookingStatusesQueryBuilder
    {

        $query = $this->orderBy("id");

        if ($id !== null) {
            return $this->where('id', $id)->limit(1);
        }

        if ($keyword === null) {
            return $query->limit(50);
        }

        $keywords = keyword_to_array($keyword, '%');

        foreach ($keywords as $keyword) {
            // Use the correct title field based on the locale
            $query = $query->where(function (Builder $query) use ($keyword) {
                return $query->where('title_en', 'LIKE', $keyword);
            });
        }

        return $query->limit(50);
    }
}
