<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Import;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Maatwebsite\Excel\Concerns\{
    ToModel,
    WithChunkReading,
    WithValidation,
    WithHeadingRow,
};
use Illuminate\Contracts\Queue\ShouldQueue;

class ProductsImport implements ToModel, WithChunkReading, WithValidation, WithHeadingRow, ShouldQueue
{
    protected $importId;
    public function __construct(int $importId)
    {
        $this->importId = $importId;

        Import::where('import_id', $this->importId)
            ->update(['status' => 'processing']);
    }
    public function __destruct()
    {
        Import::where('import_id', $this->importId)
            ->update(['status' => 'completed']);
    }


    public function model(array $row)
    {
        $imagePath = 'default.png';

        $providedImage = $row['product_image'] ?? null;

        if ($providedImage && filter_var($providedImage, FILTER_VALIDATE_URL)) {
            $imagePath = $providedImage;
        }

        Import::where('import_id', $this->importId)->increment('processed_rows');

        return new Product([
            'product_name'        => $row['product_name'] ?? null,
            'product_description' => $row['product_description'] ?? null,
            'product_price'       => $row['product_price'] ?? 0,
            'product_image'       => $imagePath,
            'product_category'    => $row['product_category'] ?? 'Uncategorized',
            'product_stock'       => $row['product_stock'] ?? 0,
        ]);
    }

    public function rules(): array
    {
        return [
            'product_name'        => 'required|string|max:255',
            'product_price'       => 'required|numeric|min:0',
            'product_category'    => 'required|string|max:255',
            'product_stock'       => 'required|integer|min:0',
            'product_description' => 'nullable|string',
            'product_image' => 'nullable|string|max:255',
        ];
    }

    public function onFailure(...$failures)
    {
        Import::where('import_id', $this->importId)
            ->increment('failed_rows', count($failures));
    }


    public function headingRow(): int
    {
        return 1;
    }


    public function chunkSize(): int
    {
        return 1000;
    }

    public function customValidationMessages(): array
    {
        return [
            'product_name.required'    => 'Product name is required.',
            'product_price.numeric'    => 'Price must be a valid number.',
            'product_stock.integer'    => 'Stock must be a whole number.',
            'product_image.url'        => 'Image must be a valid URL if provided.',
        ];
    }
}
