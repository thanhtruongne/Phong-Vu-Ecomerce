<?php declare(strict_types=1);

namespace App\Enums\Enum;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class OrderEnum extends Enum
{
    const PENDINGCONFIRM = 'unconfirmed';

    const CONFIRM = 'confirmed';

    const UNPAID = 'unpaid';

    const PAID = 'paid';

    const SHIPPINGBEGIN = 'pending';
    
    
 
}
