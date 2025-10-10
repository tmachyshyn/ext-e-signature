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

class AfterInstall
{
    private const CUSTOM_FILE = 'custom/Espo/Custom/Resources/metadata/fields/eSignature.json';

    public function run($container)
    {
        $this->container = $container;

        /** @var FileManager $fileManager */
        $fileManager = $container->get('fileManager');

       $this->fixUninstallationIssue($fileManager);
    }

    private function fixUninstallationIssue(FileManager $fileManager): void
    {
        if (!$fileManager->exists(self::CUSTOM_FILE)) {
            return;
        }

        $fileManager->removeFile(self::CUSTOM_FILE);
    }
}
