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

use Espo\Core\Utils\File\Manager as FileManager;

class BeforeUninstall
{
    private const ORIGINAL_FILE = 'custom/Espo/Modules/ESignature/Resources/metadata/fields/eSignature.json';

    private const CUSTOM_PATH = 'custom/Espo/Custom/Resources/metadata/fields/';

    public function run($container)
    {
        $this->container = $container;

        /** @var FileManager $fileManager */
        $fileManager = $container->get('fileManager');

       $this->fixUninstallationIssue($fileManager);
    }

    private function fixUninstallationIssue(FileManager $fileManager): void
    {
        if (!$fileManager->exists(self::ORIGINAL_FILE)) {
            return;
        }

        $fileManager->copy(self::ORIGINAL_FILE, self::CUSTOM_PATH, false, null, true);
    }
}
