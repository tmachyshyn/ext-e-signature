# Electronic signature for EspoCRM

E-Signature extension providing electronic signature capabilities for EspoCRM.

## Developer version

### Configuration and building

For more information, follow the [instructions](https://github.com/espocrm/ext-template?tab=readme-ov-file#configuration).

### Configuring IDE

You need to set the following paths to be ignored in your IDE:

* `build`
* `site/build`
* `site/custom/`
* `site/client/custom/`
* `site/tests/unit/Espo/Modules/ESignature`
* `site/tests/integration/Espo/Modules/ESignature`

### File watcher

You can set up a file watcher in the IDE to automatically copy and transpile files upon saving.

File watcher parameters for PhpStorm:

* Program: `node`
* Arguments: `build --copy-file --file=$FilePathRelativeToProjectRoot$`
* Working Directory: `$ProjectFileDir$`

Note: The File Watcher configuration for PhpStorm is included in this repository.

## License

E-Signature extension is published under MIT license. For more details, see `LICENSE` file.
