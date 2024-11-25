<?php declare(strict_types=1);

namespace App\Enums\Enum;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class StatusReponse extends Enum
{
    const SUCCESS = 'success';

    const ERROR = 'error';

    const WARNING = 'warning';
    
}
