<?php

namespace App\Imports;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Row;


class ProductsImport implements  WithUpserts,SkipsEmptyRows, OnEachRow, WithHeadingRow, WithChunkReading, ShouldQueue
{
    use Importable;

    static $columns = \App\Imports\ProductsImportColumns::class;

    /**
     * @return string|array
     */
    public function uniqueBy()
    {
        return 'product_id';
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row = $row->toArray();
        echo '<pre>RowIndex: ' . $rowIndex . '</pre>';
        //echo '<pre>' . var_dump($row) . '</pre>';

        try {
            if (self::to_save($row)) {
                $this->saveProduct($row, self::is_active($row));
            }

        } catch (\Exception $e) {
            echo($e->getMessage());
        } catch (\Throwable $e) {
            echo($e->getMessage());
        }
    }


    public function handleBrand($row, $product): void
    {
        if (array_key_exists(self::$columns::BRAND->value, $row) && isset($row[self::$columns::BRAND->value])) {
            /**
             * @var Brand $brand The product's brand.
             */
            $brand = Brand::firstOrNew([
                'name' => $row[self::$columns::BRAND->value]
            ], [
                'name' => $row[self::$columns::BRAND->value]
            ]);

            if (!$brand->exists) {
                $brand->save();
            }

            // Connect brand to product.
            $product->brand()->associate($brand);
        }
    }


    private function saveProduct($row, $is_active = null): Product
    {
        $product = Product::firstOrNew([
            'product_id' => $row[self::$columns::PRODUCT_ID->value]
        ]);

        if (array_key_exists(self::$columns::PRODUCT_NAME->value, $row) && $row[self::$columns::PRODUCT_NAME->value]) {
            $product->name = $row[self::$columns::PRODUCT_NAME->value];
        }

        if (array_key_exists(self::$columns::PACKAGING->value, $row)) {
            $product->packaging = $row[self::$columns::PACKAGING->value];
        }
        if (array_key_exists(self::$columns::DESCRIPTION->value, $row)) {
            $product->description = nl2br(mb_convert_encoding($row[self::$columns::DESCRIPTION->value], 'UTF-8'));
        }
        if (array_key_exists(self::$columns::EAN->value, $row) && is_numeric($row[self::$columns::EAN->value])) {
            $product->ean = $row[self::$columns::EAN->value];
        }
        if (array_key_exists(self::$columns::PRODUCT_NUMBER->value, $row)) {
            $product->product_number = $row[self::$columns::PRODUCT_NUMBER->value];
        }
        if (array_key_exists(self::$columns::PRICE->value, $row)) {
            $product->price = $row[self::$columns::PRICE->value];
        }

        $product->on_sale = (array_key_exists(self::$columns::ON_SALE->value, $row) && strtolower($row[self::$columns::ON_SALE->value]) === 'y');
        $product->is_active = ($is_active) ? 1 : 0;

        $this->handleBrand($row, $product);

        $product->save();
        return $product;

    }


    public static function to_save(array $row): bool
    {
        return (strtolower($row[self::$columns::COMMAND->value]) === 'y' || strtolower($row[self::$columns::COMMAND->value]) === 'i');
    }

    public static function is_active(array $row): bool
    {
        return (strtolower($row[self::$columns::COMMAND->value]) === 'y');
    }


}
