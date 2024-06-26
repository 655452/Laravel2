<?php


namespace App\Http\Services;


use App\Models\Category;
use Illuminate\Http\Request;
use App\Enums\CategoryStatus;

class CategoryService
{
    public function allCategories($request)
    {
        $q = trim($request->id);
       
        if ($q) {
            $this->data['tables'] = Category::where('status',CategoryStatus::ACTIVE)->where('name', 'like', '%' . $q . '%')->orWhere('description', 'like', '%' . $q . '%')->descending()->get();
        } else {
            $this->data['tables'] = Category::where('status',CategoryStatus::ACTIVE)->descending()->get();
        }
        return $this->data['tables'];
    }

    public function show($id)
    {
        
        return Category::find($id);
       
    }

    public function store(Request $request)
    {
        $category              = new Category;
        $category->name        = $request->name;
        $category->description = $request->description;
        $category->parent_id   = 0;
        $category->depth       = 0;
        $category->left        = 0;
        $category->right       = 0;
        $category->status      = $request->status;
        $category->save();

        return $category;
    }

    public function media($category)
    {
        if (!blank(request()->input('image'))) {
            $category->addMediaFromRequest('image')->toMediaCollection('categories');
        }
    }

    public function update(Request $request, $category) : void
    {
        $category->name        = $request->name;
        $category->description = $request->description;
        $category->parent_id   = 0;
        $category->depth       = 0;
        $category->left        = 0;
        $category->right       = 0;
        $category->save();
    }
    public function updateMedia($category)
    {
        if (!blank(request()->input('image'))) {
            $category->media()->delete();
            $category->addMediaFromRequest('image')->toMediaCollection('categories');
        }
    }
    public function delete($table)
    {
        $table->delete();
    }

}
