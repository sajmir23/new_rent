<?php

namespace App\Models\Admin\QueryBuilders;

use App\Enums\UserTypesEnum;
use Illuminate\Database\Eloquent\Builder;

class CompaniesQueryBuilder extends Builder
{
    public function search(?string $keyword = null, ?int $id = null): CompaniesQueryBuilder
    {


        $query = $this->orderBy('name');


        if ($id !== null) {
            return $this->where('id', $id)->limit(1);
        }

        if ($keyword === null) {
            return $query->limit(20);
        }

        $query = $query->where(function (Builder $query) use ($keyword) {
            return $query->whereAny(['name','email'], 'LIKE', '%'.$keyword.'%');
        });


        return $query->limit(50);
    }

}
