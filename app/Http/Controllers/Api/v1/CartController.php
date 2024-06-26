<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\FrontendController;
use App\Models\MenuItem;
use App\Models\Restaurant;
use App\Models\MenuItemOption;
use App\Traits\ApiResponse;
use App\Models\MenuItemVariation;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends FrontendController
{
    use ApiResponse;

    public function __construct()
    {
        parent::__construct();
        $this->data['site_title'] = 'Frontend';
    }

    public function index()
    {
        $this->data['restaurant'] = Restaurant::find(session('session_cart_restaurant_id'));
        return $this->successresponse(['status'=>200,'data'=> $this->data]);
    }

    private function cartInfo($menuItemId, $variationId = null )
    {
        $product = [];
        $carts = Cart::content()->toArray();
        if(is_array($carts)) {
            foreach($carts as $cart) {
                if ( count($cart['options']['variation']) > 0 ) {
                    if ( isset($product[ $cart['options']['menuItem_id'] ]['single']) ) {
                        $product[ $cart['options']['menuItem_id'] ]['single'] += $cart['qty'];
                    } else {
                        $product[ $cart['options']['menuItem_id'] ]['single'] = $cart['qty'];
                    }
                    if ( isset($product[ $cart['options']['menuItem_id'] ]['variation'][ $cart['options']['variation']['id'] ]) ) {
                        $product[ $cart['options']['menuItem_id'] ]['variation'][ $cart['options']['variation']['id'] ] += $cart['qty'];
                    } else {
                        $product[ $cart['options']['menuItem_id'] ]['variation'][ $cart['options']['variation']['id'] ] = $cart['qty'];
                    }
                } else {
                    if ( isset($product[ $cart['options']['menuItem_id'] ]['single']) ) {
                        $product[ $cart['options']['menuItem_id'] ]['single'] += $cart['qty'];
                    } else {
                        $product[ $cart['options']['menuItem_id'] ]['single'] = $cart['qty'];
                    }
                    $product[ $cart['options']['menuItem_id'] ]['variation'] = [];
                }
            }
        }

        if ( $variationId ) {
            $quantity = isset($product[$menuItemId]['variation'][ $variationId ]) ? $product[$menuItemId]['variation'][ $variationId ] : 0;
        } else {
            $quantity = isset($product[$menuItemId]['single']) ? $product[$menuItemId]['single'] : 0;
        }

        return $quantity;
    }

    public function store( Request $request )
    {
        $requestArray = [
            'menu_id'         => 'required|numeric',
            'variations'      => 'nullable|numeric',
            'options.*'       => 'nullable',
            'instructions'       => 'instructions',
        ];
        $validator    = Validator::make($request->all(), $requestArray);
        if ( !$validator->fails() ) {
            $menu_id = $request->menu_id;
            $menuItem     = MenuItem::findOrfail($menu_id);
            if ( !blank($menuItem) ) {
                if ( session('session_cart_restaurant_id') != $menuItem->restaurant_id ) {
                    Cart::destroy();
                }
                session()->put('session_cart_restaurant_id', $menuItem->restaurant_id);
                $variationArray = [];
                $variationId    = null;
                if ( (int)$request->variationID ) {
                    $variations              = MenuItemVariation::find($request->variationID);
                    $variationArray['id']    = $variations->id;
                    $variationArray['name']  = $variations->name;
                    $variationArray['price'] = $variations->price - $variations->discount_price;
                    $variationId             = $variations->id;
                    $totalPrice              = $variationArray['price'];
                    $discount                = $variations->discount_price;
                } else {
                    $totalPrice = $menuItem->unit_price - $menuItem->discount_price;
                    $discount   = $menuItem->discount_price;
                }
                $instructions= !blank($request->instructions) ? $request->instructions : "";
                $optionArray = [];
                if ( !blank($request->options) ) {
                    $options = MenuItemOption::whereIn('id', $request->options)->get();
                    $i       = 0;
                    foreach ( $options as $option ) {
                        $optionArray[ $i ]['id']    = $option->id;
                        $optionArray[ $i ]['name']  = $option->name;
                        $optionArray[ $i ]['price'] = $option->price;
                        $i++;
                        $totalPrice += $option->price;
                    }
                }
                $cartItem = [
                    'id'      => $menu_id,
                    'name'    => $menuItem->name,
                    'qty'     => 1,
                    'price'   => $totalPrice,
                    'weight'  => 0,
                    'options' => [
                        'options'    => $optionArray,
                        'variation'  => $variationArray,
                        'discount'   => $discount,
                        'restaurant_id'    => $menuItem->restaurant_id,
                        'images'     => $menuItem->images,
                        'menuItem_id' => $menuItem->id,
                        'instructions' => $instructions->id
                    ]
                ];
                Cart::add($cartItem);
            }
        }
        return $this->successresponse(['status'=>200,'message'=>'Added to cart successfully']);
    }

    public function remove($id)
    {
        Cart::remove($id);
        if(blank(Cart::content())) {
            session()->put('session_cart_restaurant_id', 0);
        }
        return $this->successresponse(['status'=>200,'message'=>'Removed successfully']);
    }

    public function quantity( Request $request )
    {
        $validation = [
            'rowId'          => 'required',
            'quantity'       => 'required|numeric',
            'deliveryCharge' => 'required',
        ];
        $validator = Validator::make($request->all(), $validation);
        if ( !$validator->fails() ) {
            $carts = Cart::content()->toArray();
            if ( isset($carts[ $request->rowId ]) ) {
                $menuItemId   = $carts[ $request->rowId ]['options']['menuItem_id'];
                $variationId = (isset($carts[ $request->rowId ]['options']['variation']['id']) ? $carts[ $request->rowId ]['options']['variation']['id'] : null);
                $restaurantId      = $carts[ $request->rowId ]['options']['restaurant_id'];
                $cartQuantity =  $carts[ $request->rowId ]['qty'];
                $menuItem     = MenuItem::find($menuItemId);
                if ( !blank($menuItem) ) {
                        Cart::update($request->rowId, $request->quantity);
                        echo json_encode([
                            'status'     => true,
                            'price'      => currencyFormat(Cart::get($request->rowId)->price * Cart::get($request->rowId)->qty),
                            'totalPrice' => currencyFormat(Cart::totalFloat()),
                            'total'      => currencyFormat(Cart::totalFloat() + $request->deliveryCharge)
                        ]);
                }
            } else {
                echo json_encode([
                    'status'  => false,
                    'message' => 'cart not found.'
                ]);
            }
        } else {
            echo json_encode([
                'status'  => false,
                'message' => 'something wrong'
            ]);
        }
    }
}
