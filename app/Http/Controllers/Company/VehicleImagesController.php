<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Traits\ConvertsToWebp;

class VehicleImagesController extends Controller
{
    use ConvertsToWebp;

    /**
     * Store a new vehicle image in storage.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png,gif,webp,bmp,tif,tiff',
        ]);

        $companyName = auth()->user()->company->name ?? 'company';
        $companyFolder = Str::slug($companyName);

        $path = $this->convertAndStoreWebp(
            $request->file('file'),
            "vehicles/{$companyFolder}",
            'public',
            80
        );

        return response()->json([
            'path' => $path,
            'id'   => basename($path)
        ]);
    }

}
