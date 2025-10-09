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

class Date implements Helper
{
    private const PATTERN_LIST = [
        '/Electronically signed on (\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})/',
        '/Firmado electrónicamente a (\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})/',
    ];

    public function render(Data $data): Result
    {
        $color = $data->getOption('color');
        $text = $data->getArgumentList()[0] ?? '';

        $dateTime = $this->getDateTimeFromText($text);

        return Result::createSafeString($dateTime);
    }

    private function getDateTimeFromText($text): string
    {
        foreach (self::PATTERN_LIST as $pattern) {
            if (!preg_match($pattern, $text, $matches)) {
                continue;
            }

            return $matches[1];
        }

        return '';
    }
}
