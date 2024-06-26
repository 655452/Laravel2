<?php

namespace App\Livewire;

use App\Models\MenuItem;
use Livewire\Component;

class ShowPage extends Component
{
    public $categories_products = [];
    public $categories = [];
    public $other_products;
    public $restaurant;
    public $menu_item;
    public $menu_id = 0;
    public $variations;
    public $options;
    public $instructions;
    public $quantity=1;
    public $restaurant_id;

    public function addToCartModal($itemID){
        $this->dispatch('CartModal',$itemID);
        $this->dispatch('openFormModalCart');
    }

    public function mount()
    {
        $products = MenuItem::with('categories')->with('media')->with('variations')->with('options')->where(['restaurant_id' => $this->restaurant->id])->get();
        foreach($products as $key=>$product) {
            $product_categories = $product->categories;
            if(!blank($product_categories)) {
                foreach($product_categories as $product_category) {
                    $this->categories[$product_category->id]            = $product_category;
                    $this->categories_products[$product_category->id][$key] = $product;
                    $this->categories_products[$product_category->id][$key]['image'] = $product->image;
                }
            } else {
                $this->other_products[$key] = $product;
                $this->other_products[$key]['image'] = $product->image;
            }
        }
        return view('livewire.show-page');
    }
}
