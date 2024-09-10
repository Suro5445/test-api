<?php

namespace App\Services;

use App\Models\Advert;
use Illuminate\Pagination\LengthAwarePaginator;

class AdvertService
{
    /**
     * Get a paginated list of adverts with sorting.
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAdverts(array $filters): LengthAwarePaginator
    {
        $query = Advert::query();

        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'asc';

        $validSortByFields = ['price', 'created_at'];
        $validSortDirections = ['asc', 'desc'];

        if (in_array($sortBy, $validSortByFields) && in_array($sortDirection, $validSortDirections)) {
            $query->orderBy($sortBy, $sortDirection);
        }

        return $query->paginate(10);
    }

    /**
     * Get a specific advert.
     *
     * @param int $id
     * @return Advert
     */
    public function getAdvertById($id): Advert
    {
        return Advert::findOrFail($id);
    }

    /**
     * Create a new advert.
     *
     * @param array $data
     * @return Advert
     */
    public function createAdvert(array $data): Advert
    {
        $advert = new Advert();
        $advert->fill($data);
        $advert->save();

        return $advert;
    }
}

