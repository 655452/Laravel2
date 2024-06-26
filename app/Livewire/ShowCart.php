<?php
namespace App\Livewire;

use App\Models\MenuItem;
use App\Models\MenuItemOption;
use App\Models\MenuItemVariation;
use Livewire\Component;

class ShowCart extends Component
{
    public $restaurant, $menuItem, $quantity = 1, $menu_id, $restaurant_id, $variationID, $options = [], $instructions;
    protected $listeners = ['CartModal'];

    public function addItemQty()
    {
        $this->quantity++;
    }

    public function removeItemQty()
    {
        $this->quantity = max(1, $this->quantity - 1);
    }

    public function submit($restaurant_id, $menu_id)
    {

        session()->put('session_cart_restaurant_id', $restaurant_id);
        session()->put('session_cart_restaurant', $this->restaurant->slug);

        $variationArray = $optionArray = [];
        $variationId = $totalPrice = $discount = null;


        if ((int)$this->variationID) {

            $variation = MenuItemVariation::find($this->variationID);
            $this->setVariationData($variation, $variationArray, $variationId, $totalPrice, $discount);
        } else {
            $totalPrice = $this->menuItem->unit_price - $this->menuItem->discount_price;
            $discount = $this->menuItem->discount_price;
        }

        if (!blank($this->options)) {
            $this->setOptionData($optionArray, $totalPrice);
        }

        $instructions = !blank($this->instructions) ? $this->instructions : "";

        $cartItem = [
            'id'              => $menu_id,
            'name'            => $this->menuItem->name,
            'qty'             => $this->quantity,
            'price'           => $totalPrice,
            'delivery_charge' => $this->restaurant->delivery_charge,
            'options'         => $optionArray,
            'variation'       => $variationArray,
            'discount'        => $discount,
            'restaurant_id'   => $this->menuItem->restaurant_id,
            'images'          => $this->menuItem->images,
            'menuItem_id'     => $this->menuItem->id,
            'variationID'     => $variationId,
            'instructions'    => $instructions,
        ];

        $this->dispatch('addCart', $cartItem);
        $this->resetFields();
    }

    public function CartModal($itemID)
    {
        $this->resetFields();
        $this->menuItem = MenuItem::with('variations')->with('options')->where('id', $itemID)->first();
        if (!blank($this->menuItem->variations)) {
            $this->variationID = $this->menuItem->variations->first()->id;
        }
    }

    private function setVariationData($variation, &$variationArray, &$variationId, &$totalPrice, &$discount)
    {
        $variationArray = [
            'id'    => $variation->id,
            'name'  => $variation->name,
            'price' => $variation->price - $variation->discount_price,
        ];

        $variationId = $variation->id;
        $totalPrice  = $variationArray['price'];
        $discount    = $variation->discount_price;
    }

    private function setOptionData(&$optionArray, &$totalPrice)
    {
        $options = MenuItemOption::whereIn('id', $this->options)->get();
        foreach ($options as $option) {
            $optionArray[] = [
                'id' => $option->id,
                'name' => $option->name,
                'price' => $option->price,
            ];
            $totalPrice += $option->price;
        }
    }

    private function resetFields()
    {
        $this->quantity = 1;
        $this->instructions = '';
        $this->variationID = null;
        $this->options = [];
        $this->dispatch('closeFormModalCart');
    }

    public function mount()
    {
        return view('livewire.show-cart');
    }
}
