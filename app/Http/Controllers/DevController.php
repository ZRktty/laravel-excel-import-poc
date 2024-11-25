<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Rinvex\Categories\Models\Category;

class DevController extends Controller
{
    public function createACategory()
    {

        $attributes = [
            'name' => 'Electronics',
            'slug' => 'electronics',
            'description' => 'Electronics Category',
            'icon' => 'fa fa-laptop',
            'color' => '#000000',
            'parent_id' => null,
        ];
        $category = app('rinvex.categories.category')->fill($attributes);
        $category->save(); // Saved as root

        return response()->json($category);
    }

    public function getAllCategories()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    public function appendToCategory()
    {
        $category = Category::find(1);
        $category->children()->create([
            'name' => 'Mobile Phones',
            'slug' => 'mobile-phones',
            'description' => 'Mobile Phones Category'
        ]);

        return response()->json($category);
    }

    public function createFromTree()
    {
        $newCategoryTree = app('rinvex.categories.category')->create([
            'name' => [
                'en' => 'Headphones',
            ],

            'children' => [
                [
                    'name' => 'Over-ear headphones',

                    'children' => [
                        ['name' => 'Wireless'],
                    ],
                ],
            ],
        ]);

        $rootCategory = Category::find(1);
        // #2 Using parent category
        $rootCategory->appendNode($newCategoryTree);

        return response()->json($rootCategory);

    }

    public function getAncestors($id)
    {
        $result = app('rinvex.categories.category')->ancestorsOf($id);
        return response()->json($result);
    }

    public function tree()
    {
        $tree = Category::get()->toTree();
        return response()->json($tree);
    }

    public function attachCategoryToProduct($productId, $categoryId)
    {
        $product = Product::find($productId);
        $category = Category::find($categoryId);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        // Single category id
        $product->attachCategories($category->id);
        return response()->json($product);
    }


}
