<?php
/************************************************************************
 * This file is part of E-Signature extension for EspoCRM.
 *
 * Copyright (C) 2025 Taras Machyshyn
 * Copyright (C) 2024 Lithiuhm
 * Copyright (C) 2020 Omar A Gonsenheim
 * Website: https://github.com/tmachyshyn/ext-e-signature
 *
 * Licensed under the MIT License.
 * See the LICENSE file for license information.
 ************************************************************************/

namespace Espo\Modules\ESignature\Classes\TemplateHelpers;

use Espo\Core\Htmlizer\Helper;
use Espo\Core\Htmlizer\Helper\Data;
use Espo\Core\Htmlizer\Helper\Result;

class Sign implements Helper
{
    public function render(Data $data): Result
    {
        $color = $data->getOption('color');
        $text = $data->getArgumentList()[0] ?? '';

        // Extract base64-encoded PNG image from the input text
        $pattern = '/data:image\/png;base64,[A-Za-z0-9+\/=]+/';

        $data = preg_match($pattern, $text, $matches)
            ? $matches[0]
            : '';

        return Result::createSafeString($data);
    }
}
