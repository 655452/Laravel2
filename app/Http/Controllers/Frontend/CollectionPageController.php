<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\MenuItemRating;
use App\Models\Category;
use App\Enums\RatingStatus;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class CollectionPageController extends Controller
{
    public function show(Request $request)
    {
        // Get all available categories to display in the filter
        $categories = Category::all();
        
        // Get the selected category ID from the request (if any)
        $selectedCategory = $request->input('category_id');

        // Define the specific menu items to display
        // Define the specific menu items to display
            $specificMenuItems = [
                'Mini Grazing Box Hamper',
                'Date & Walnut cake',
                'Wheat Strawberry Tart',
                'Miniature tartlets (Min 4 pc)',
                'Rakhi',
                'Demo1',
                'Demo2',
                'Demo3',
                '24 Gift Cards',
                '6 Luggage Tags',
                'Diary',
                'Book Labels',
                '30 Envelopes',
                'Book Marks',
                'Dyslexia',
                'IMO - International Mathematics Olympiad',
                'IPM Institute for Promotion of Mathematics (IPM)',
                'Math Foundation Class',
                'Dysgraphia'
            ];
            


        try {
            // Start the query to fetch menu items along with their restaurant
            $query = MenuItem::with('media', 'categories', 'restaurant') // Include restaurant relation
                ->whereIn('name', $specificMenuItems) // Filter by specific menu item names
                ->whereHas('categories', function($query) use ($selectedCategory) {
                    // Apply category filter if selected
                    if ($selectedCategory) {
                        $query->where('categories.id', $selectedCategory);
                    }
                });

            // Get the filtered menu items
            $menuItems = $query->get();

            // Fetch ratings and reviews for each menu item
            $menuItemRatings = MenuItemRating::whereIn('menu_item_id', $menuItems->pluck('id'))
                ->where('status', RatingStatus::ACTIVE)
                ->get()
                ->groupBy('menu_item_id');

            // Attach ratings and restaurant name to menu items
            foreach ($menuItems as $menuItem) {
                $menuItem->ratings = $menuItemRatings->get($menuItem->id, collect());
                $menuItem->average_rating = $menuItem->ratings->avg('rating');
                $menuItem->total_reviews = $menuItem->ratings->count();
                
                // Attach restaurant name to the menu item
                $menuItem->restaurant_name = $menuItem->restaurant->name ?? 'Unknown';
            }

            Log::info('Retrieved menu items for the collection page', ['menuItems' => $menuItems]);

            // Pass menuItems, categories, and selectedCategory to the view
            return view('frontend.collection', [
                'menuItems' => $menuItems,
                'categories' => $categories,
                'selectedCategory' => $selectedCategory,
            ]);
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the query
            Log::error('Error fetching menu items for the collection page', ['error' => $e->getMessage()]);

            return view('frontend.collection', [
                'error' => 'An error occurred while fetching the menu items. Please try again later.',
            ]);
        }
    }
}
