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
    const PENDINGCONFIRM = 0;

    const CONFIRM = 1;

    const UNPAID = 'unpaid';

    const PAID = 'paid';

    const SHIPPINGBEGIN = 'pending';

    const PAYTYPE = 2;
    
    const GHTKCOMPANY = 'GHTK';

    const GHTKCODE = 'CODE_GHTK_CODE';




    const ORDER_PENDING_PAYMENT = 0;
    const ORDER_WAIT_DELI = 1;
    const ORDER_ALREADY_DELIVERY = 2;
    const ORDER_CLOSE = 4;

    // const GHTKCODE = 'CODE_GHTK_CODE';
 
}
