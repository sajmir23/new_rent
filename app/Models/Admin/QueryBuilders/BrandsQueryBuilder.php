<?php

namespace App\Models\Admin\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class BrandsQueryBuilder extends Builder
{
    public function search(?string $keyword = null, ?int $id = null): BrandsQueryBuilder
    {

        $query = $this->orderBy('title');


        if ($id !== null) {
            return $this->where('id', $id)->limit(1);
        }

        if ($keyword === null) {
            return $query->limit(50);
        }

        $keywords = keyword_to_array($keyword, '%');


        foreach ($keywords as $keyword) {
            $query = $query->where(function (Builder $query) use ($keyword) {
                return $query->where('title', 'LIKE', $keyword);
            });
        }

        return $query->limit(50);
    }
}
