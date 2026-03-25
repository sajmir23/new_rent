<?php

namespace App\Models\Admin\QueryBuilders;

use App\Enums\UserTypesEnum;
use Illuminate\Database\Eloquent\Builder;

class UsersQueryBuilder extends Builder
{
    public function search(?string $keyword = null, ?int $id = null): UsersQueryBuilder
    {


        $query = $this->orderBy('first_name')->where('user_type',UserTypesEnum::SYSTEM_ADMIN);


        if ($id !== null) {
            return $this->where('id', $id)->where('user_type',UserTypesEnum::SYSTEM_ADMIN)->limit(1);
        }

        if ($keyword === null) {
            return $query->limit(20);
        }

        $query = $query->where(function (Builder $query) use ($keyword) {
            return $query->whereAny(['first_name','last_name','email'], 'LIKE', '%'.$keyword.'%');
        });


        return $query->limit(50);
    }

}
