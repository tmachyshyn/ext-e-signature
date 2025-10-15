<?php
/************************************************************************
 * This file is part of E-Signature extension for EspoCRM.
 *
 * Copyright (C) 2025 Taras Machyshyn
 * Website: https://github.com/tmachyshyn/ext-e-signature
 *
 * Licensed under the MIT License.
 * See the LICENSE file for license information.
 ************************************************************************/

use Espo\Core\Utils\Metadata;

class BeforeUninstall
{
    private const CUSTOM_PATH = 'custom/Espo/Custom/Resources/metadata/fields/eSignature.json';

    public function run($container)
    {
        $this->container = $container;

        /** @var Metadata $metadata */
        $metadata = $container->get('metadata');

       $this->fixUninstallationIssue($metadata);
    }

    private function fixUninstallationIssue(Metadata $metadata): void
    {
        if (file_exists(self::CUSTOM_PATH)) {
            return;
        }

        $metadata->saveCustom('fields', 'eSignature', [
            'params' => [],
            'notCreatable' => false,
            'filter' => false,
            'fieldDefs' => [
                'type' => 'text'
            ],
            'view' => 'views/fields/text'
        ]);
    }
}
