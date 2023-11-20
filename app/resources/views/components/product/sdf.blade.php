// app/Traits/Discountable.php

namespace App\Traits;

trait Discountable
{
    public function calculateDiscountedPrice($originalPrice, $discountPercentage)
    {
        $discountAmount = ($discountPercentage / 100) * $originalPrice;
        $discountedPrice = $originalPrice - $discountAmount;
        
        return $discountedPrice;
    }
}



// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Discountable;

class Product extends Model
{
    use Discountable;

    protected guarded=[];
    public function getDiscountedPriceAttribute()
    {
        return $this->calculateDiscountedPrice($this->original_price, $this->discount_percentage);
    }
}



use App\Models\Product;

// Example usage
$product = new Product();
$originalPrice = 100; // Example original price
$discountPercentage = 20; // Example discount percentage

$discountedPrice = $product->getDiscountedPriceAttribute($originalPrice, $discountPercentage);
