# Electronic signature for EspoCRM

E-Signature extension providing electronic signature capabilities for EspoCRM.

This extension enables the use of an electronic signature canvas field within EspoCRM, allowing users to capture signatures directly in the application. It also supports generating full-page documents that embed the captured signature, which can be printed or saved as PDF using the browser's built-in PDF functionality.

## How to use

### 1. Install the extension

Follow the standard EspoCRM extension installation process to add the E-Signature extension to your instance.

![installation](docs/images/installation.png?raw=true)

### 2. Add the signature field

In the EspoCRM Administration panel, customize the desired entity (e.g., Contact, Opportunity, Document) and add the "Signature" field to the layout using the Layout Manager.

![configuration](docs/images/configuration-1.png?raw=true)
![configuration](docs/images/configuration-2.png?raw=true)
![configuration](docs/images/configuration-3.png?raw=true)
![configuration](docs/images/configuration-4.png?raw=true)
![configuration](docs/images/configuration-5.png?raw=true)
![configuration](docs/images/configuration-6.png?raw=true)
![configuration](docs/images/configuration-7.png?raw=true)
![configuration](docs/images/configuration-8.png?raw=true)
![configuration](docs/images/configuration-9.png?raw=true)

### 3. Capture a signature

When viewing or editing a record with the signature field, users can draw their signature directly in the provided canvas area.

![capture](docs/images/capture-1.png?raw=true)

### 4. Save and view signatures

After saving the record, the captured signature will be stored and displayed within the record details.

![capture](docs/images/capture-2.png?raw=true)

### 5. Generate documents with embedded signatures

Use the extension's document generation feature to create a full-page document that includes the captured signature. You can print or save this document as a PDF using your browser's print functionality.

Available Placeholders:

```
<p><img src="{{eSignatureSign c<FIELD_NAME>}}"></p>

<p>{{eSignatureDate c<FIELD_NAME>}}</p>
```

![document](docs/images/document-1.png?raw=true)
![document](docs/images/document-2.png?raw=true)
![document](docs/images/document-3.png?raw=true)
![document](docs/images/document-4.png?raw=true)

## Migration from v1 to v2

> Before you begin
> - Backup your database and files.
> - Confirm your EspoCRM version to pick the correct migration path.

### Option 1. For EspoCRM v8.4.0 - v9.1.9

1\. Install the [latest version](https://github.com/tmachyshyn/ext-e-signature/releases) of **E-Signature** via `Administration` > `Extensions`, along with the existing v1.0.3.

![document](docs/images/administration-extensions.png?raw=true)

2\. In `Administration` > `Entity Manager` > `<YOUR_ENTITY_NAME>`, remove the old field of type **eSignature** created by v1.

![document](docs/images/administration-entity-manager-your_entity_name-fields-remove-esignature.png?raw=true)

3\. Create a new field of type **E-Signature** using the **same field name** as the removed one.

![document](docs/images/administration-entity-manager-document-fields-e-signature.png?raw=true)

4\. If you use **PDF Templates**, open the template Code View and replace the old placeholder:

```
<img src="{{img_data ESIGNATUREGFILEDNAME}}">
```

with the new placeholders:

```
<p><img src="{{eSignatureSign c<FIELD_NAME>}}"></p>

<p>{{eSignatureDate c<FIELD_NAME>}}</p>
```

5\. Verify signatures display correctly and test PDF generation.

### Option 2. EspoCRM v9.2.0+

Note: v1 (1.0.3) is not compatible with EspoCRM >= v9.2.0, so migrate data to a new field name.

1\. Install the [latest version](https://github.com/tmachyshyn/ext-e-signature/releases) of **E-Signature** via `Administration` > `Extensions`, along with the existing v1.0.3.

![document](docs/images/administration-extensions.png?raw=true)

2\. In `Administration` > `Entity Manager` > `<YOUR_ENTITY_NAME>`, create a new field of type **E-Signature** with a different name than the old field.

![document](docs/images/administration-entity-manager-document-fields-new-e-signature.png?raw=true)

3\. Add a formula in `Administration` > `Entity Manager` > `<YOUR_ENTITY_NAME>` > `Formula` > `Before Save Custom Script`:

```
c<NewSignatureFieldName> = c<OldSignatureFieldName>;
// c<OldSignatureFieldName> = null;  // Optional: clear the original value if it's no longer required
```

4\. In the List view for your entity, select the records to migrate (use filters or “Select All”), open the `Actions` dropdown and run `Recalculate Formula`.

![document](docs/images/your_entity_name-actions-recalculate-formula.png?raw=true)

5\. Once confirmed, remove the old **eSignature** field from `Entity Manager` and `Layout Manager`.
6\. Uninstall the E-Signature extension `1.0.3`.

## Developer version

### Configuration and building

For more information, follow the [instructions](https://github.com/espocrm/ext-template?tab=readme-ov-file#configuration).

### Recommended config

> **Note:** Since the jSignature library requires jQuery out-of-the-box, it is recommended to keep `isDeveloperMode` set to `false`. This ensures proper loading of dependencies and stable operation of the extension.

Create `config.php` in the root directory of the repository:

```
<?php

return [
    'useCache' => false,
    'isDeveloperMode' => false,
];
```

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
