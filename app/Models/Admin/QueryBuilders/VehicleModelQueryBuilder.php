<?php

namespace App\Models\Admin\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class VehicleModelQueryBuilder extends Builder
{
    public function search(?string $keyword = null, ?int $id = null): VehicleModelQueryBuilder
    {
        $query = $this->join('brands', 'brands.id', '=', 'vehicle_models.brand_id')
            ->select('vehicle_models.*') // important to avoid selecting all brand fields
            ->orderBy('brands.title');

    if ($id !== null) {
        return $query->where('vehicle_models.id', $id)->limit(1);
    }

    if ($keyword === null) {
        return $query->limit(50);
    }

    $keywords = keyword_to_array($keyword, '%');

    foreach ($keywords as $keyword) {
        $query = $query->where(function (Builder $query) use ($keyword) {
            return $query->where('vehicle_models.title', 'LIKE', $keyword);
        });
    }

    return $query->limit(50);
    }

}
