<?php

namespace App\Models\Admin\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class CitiesQueryBuilder extends Builder
{
    public function search(?string $keyword = null, ?int $id = null): CitiesQueryBuilder
    {

        $query = $this->orderBy('name');


        if ($id !== null) {
            return $this->where('id', $id)->limit(1);
        }

        if ($keyword === null) {
            return $query->limit(50);
        }

        $keywords = keyword_to_array($keyword, '%');


        foreach ($keywords as $keyword) {
            $query = $query->where(function (Builder $query) use ($keyword) {
                return $query->where('name', 'LIKE', $keyword);
            });
        }

        return $query->limit(50);
    }
}
