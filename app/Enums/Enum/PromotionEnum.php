<?php declare(strict_types=1);

namespace App\Enums\Enum;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class PromotionEnum extends Enum
{
    const DISCOUNTMETHODPRODUCT = 'discountMethodProduct';
    const ORDERRANGEAMOUNT = 'order_amount_range';
    const PRODUCTANDQUANITY = 'product_and_qualnity';
    const EXTREMELYMETHODDISCOUNTPRODUCT = 'product_quanity_promotion';

    const PRODUCTDISCOUNT = 'Product';

    const PRODUCTCATELOGEDISCOUNT = 'ProductCateloge';
}
