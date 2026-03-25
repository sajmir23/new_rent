<?php

namespace App\Models\Company\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class AdditionalServicesQueryBuilder extends Builder
{
    public function search(?string $keyword = null, ?int $id = null): AdditionalServicesQueryBuilder
    {
        // Always restrict to the authenticated user's company
        $companyId = auth()->user()->company_id;

        $query = $this->where('company_id', $companyId)
            ->orderBy('id');

        if ($id !== null) {
            return $query->where('id', $id)->limit(1);
        }

        if ($keyword === null) {
            return $query->limit(50);
        }

        $keywords = keyword_to_array($keyword, '%');

        foreach ($keywords as $keyword) {
            $query->where(function (Builder $q) use ($keyword) {
                $q->where('title_en', 'LIKE', $keyword);
            });
        }

        return $query->limit(50);
    }
}