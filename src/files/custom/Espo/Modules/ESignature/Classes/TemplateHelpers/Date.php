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

use Espo\Core\Utils\Metadata;
use Espo\Core\Htmlizer\Helper;
use Espo\Core\Htmlizer\Helper\Data;
use Espo\Core\Htmlizer\Helper\Result;
use Espo\Core\Utils\Language\LanguageFactory;

class Date implements Helper
{
    private const LABEL_NAME = 'signedAt';

    private const LABEL_CATEGORY = 'messages';

    private const LABEL_SCOPE = 'FieldManager';

    public function __construct(
        private Metadata $metadata,
        private LanguageFactory $languageFactory
    ) {}

    public function render(Data $data): Result
    {
        $color = $data->getOption('color');
        $text = $data->getArgumentList()[0] ?? '';

        $dateTime = $this->getDateTimeFromText($text);

        return Result::createSafeString($dateTime);
    }

    private function getDateTimeFromText($text): string
    {
        $labelList = $this->getLabelList();

        foreach ($labelList as $label) {
            $pattern = '/' . $label . ' (\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})/';

            if (!preg_match($pattern, $text, $matches)) {
                continue;
            }

            return $matches[1];
        }

        return '';
    }

    private function getLabelList(): array
    {
        $languageList = $this->metadata->get(['app', 'language', 'list']) ?? [];

        foreach ($languageList as $i18n) {
            $label = $this->languageFactory
                ->create($i18n)
                ->translate(self::LABEL_NAME, self::LABEL_CATEGORY, self::LABEL_SCOPE);

            $labelList[] = trim($label);
        }

        return array_unique($labelList);
    }
}
