<?php


namespace App\Http\Services;


use App\Models\MenuItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Enums\MenuItemStatus;

class MenuItemService
{
    public function allMenuItems($request)
    {
        $q = trim($request->id);
        if ($q) {
            $this->data['menuItems'] = MenuItem::owner()->with('categories')->where('status', MenuItemStatus::ACTIVE)->where('name', 'like', '%' . $q . '%')->orWhere('description', 'like', '%' . $q . '%')->descending()->get();
        } else {
            $this->data['menuItems'] = MenuItem::owner()->with('categories')->where('status', MenuItemStatus::ACTIVE)->descending()->get();
        }

        return $this->data['menuItems'];
    }
    public function show($id){
        return MenuItem::find($id);
    }


    public function store(Request $request)
    {
        $menuItem              = new MenuItem;
        $menuItem->restaurant_id  = $request->get('restaurant_id');
        $menuItem->name           = $request->get('name');
        $menuItem->description    = $request->get('description');
        $menuItem->unit_price     = $request->get('unit_price');
        $menuItem->discount_price = $request->get('discount_price');
        $menuItem->status         = $request->get('status');
        $menuItem->save();
        $menuItem->categories()->sync($request->get('categories'));

        return $menuItem;
    }

    public function media($menuItem)
    {
        if (!blank(request()->input('document'))) {
            foreach (request()->input('document') as $file) {
                $menuItem->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('menu-items');
            }
        }
    }

    public function update(Request $request, $menuItem) : void
    {
        $menuItem->restaurant_id  = $request->get('restaurant_id');
        $menuItem->name           = $request->get('name');
        $menuItem->description    = $request->get('description');
        $menuItem->unit_price     = $request->get('unit_price');
        $menuItem->discount_price = $request->get('discount_price');
        $menuItem->status         = $request->get('status');
        $menuItem->save();
        $menuItem->categories()->sync($request->get('categories'));
    }

    public function updateMedia($menuItem)
    {
        if (!blank(request()->input('document'))) {
            $menuItem->media()->delete();
            foreach (request()->input('document') as $file) {
                $menuItem->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('menu-items');
            }
        }
    }

    public function delete($menuItem)
    {
        $menuItem->delete();
    }

}
