<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Exception;


class CategoryService
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Hàm lấy ra thông tin của tất cả danh mục
     *
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws Exception
     */
    public function getAllCategories(): \Illuminate\Database\Eloquent\Collection
    {
        try {
            Log::info('Fetching all categories');

            $categories = $this->category::withCount('products')
                ->leftJoin('products', 'categories.id', '=', 'products.category_id')
                ->leftJoin('order_details', 'products.id', '=', 'order_details.product_id')
                ->select(
                    'categories.*',
                    DB::raw('COALESCE(SUM(products.price * order_details.quantity), 0) as revenue'),
                    DB::raw('COUNT(products.id) as products_count')
                )
                ->groupBy('categories.id')
                ->get();

            return $categories;
        } catch (Exception $e) {
            Log::error('Failed to fetch categories: ' . $e->getMessage());
            throw new Exception('Failed to fetch categories');
        }
    }

    /**
     * Hàm tạo mới một danh mục
     *
     * @param array $data
     * @return Category
     * @throws ModelNotFoundException
     */
    public function createCategory(array $data): Category
    {
        DB::beginTransaction();
        try {
            Log::info('Creating new category');
            $category = $this->category->create($data);
            DB::commit();
            return $category;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to create category: ' . $e->getMessage());
            throw new Exception('Failed to create category');
        }
    }

    /**
     * Hàm cập nhật thông tin của một danh mục
     *
     * @param int $id
     * @param array $data
     * @return Category
     * @throws ModelNotFoundException
     */
    public function updateCategory(Category $category, array $data): Category
    {
        DB::beginTransaction();
        try {
            Log::info("Updating category with ID: $category->id");
            $category->update($data);
            DB::commit();
            return $category;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to update category: ' . $e->getMessage());
            throw new Exception('Failed to update category');
        }
    }

    /**
     * Hàm xóa một danh mục
     *
     * @param int $id
     * @throws Exception
     * CreatedBy: youngbachhh (30/05/2024)
     */
    public function deleteCategory(Category $category): void
    {
        DB::beginTransaction();
        try {
            Log::info("Deleting category with ID: $category->id");
            $category->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete category: ' . $e->getMessage());
            throw new Exception('Failed to delete category');
        }
    }
}
