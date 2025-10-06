# Electronic signature for EspoCRM

E-Signature extension providing electronic signature capabilities for EspoCRM.

This extension enables the use of an electronic signature canvas field within EspoCRM, allowing users to capture signatures directly in the application. It also supports generating full-page documents that embed the captured signature, which can be printed or saved as PDF using the browser's built-in PDF functionality.

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

## Authors

- [@tmachyshyn](https://github.com/tmachyshyn)
- [@lithiuhm](https://github.com/Lithiuhm)
- [@telecastg](https://github.com/telecastg)
- [@bandtank](https://github.com/bandtank)

## References

- [Extension for EspoCRM v8](https://github.com/Lithiuhm/eSignature-extension-for-Espocrm)
- [Original extension for EspoCRM OLD VERSIONS](https://github.com/EspoCRM-Custom-Modules/eSignature-for-Documents/tree/master)

## License

E-Signature extension is published under MIT license. For more details, see `LICENSE` file.
