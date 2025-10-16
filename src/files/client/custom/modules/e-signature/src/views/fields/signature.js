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

/** @preserve
jSignature v2 "${buildDate}" "${commitID}"
Copyright (c) 2012 Willow Systems Corp http://willow-systems.com
Copyright (c) 2010 Brinley Ang http://www.unbolt.net
MIT License <http://www.opensource.org/licenses/mit-license.php>
*/

/** @module e-signature:views/fields/signature */

import BaseFieldView from 'views/fields/base';

class SignatureFieldView extends BaseFieldView {
    inlineEditDisabled = true

    // custom templates
    detailTemplate = 'e-signature:fields/signature/detail'
    editTemplate = 'e-signature:fields/signature/edit'
    listTemplate = 'e-signature:fields/signature/list'

    // custom properties
    blankCanvassCode = ''

    init() {
        super.init();

        // signature fields can not be edited manually, force detail mode
        this.setMode('detail');

        this.listenToOnce(this, 'after:render', this.initInlineEsignatureEdit, this);

        this.listenToOnce(this, 'after:render', () => {
            if (!this.model.isNew()) {
                return;
            }

            this.disableButton();
        }, this);
    }

    data() {
        const data = super.data();

        data.imageSource = this.getValueForDisplay();

        // signature fields can not be edited manually, force detail mode
        if (this.mode !== "detail") {
            this.setMode("detail");
        }

        return data;
    }

    setup() {
        super.setup();

        this.events['click [data-action="sign"]'] = function (e) {
            this.inlineEsignatureEdit();
        };
    }

    // custom function equivalent to "initInlineEdit" at base.js
    initInlineEsignatureEdit() {
        let cell = this.getCellElement();
        let $cell = $(cell);

        if ($cell.length === 0 || typeof(this.model.get(this.name))=== 'undefined') {
            this.listenToOnce(this, 'after:render', this.initInlineEsignatureEdit, this);

            return;
        }

        // if the signature field already has a value do not add
        // the inline edit link and set the field as readonly
        if(this.model.get(this.name)) {
            this.readOnly = true;

            return;
        }
    }

    disableButton() {
        $(this.el).find('[data-action="sign"]')
            .attr('disabled', 'disabled')
            .attr('title', this.translate('recordMustBeSaved', 'messages', 'FieldManager'));
    }

    showButton() {
        let cell = this.getCellElement();

        $(cell).find('.btn-container').removeClass('hidden');
    }

    hideButton() {
        let cell = this.getCellElement();

        $(cell).find('.btn-container').addClass('hidden');
    }

    /**
     * Custom function equivalent to "inlineEdit" at base.js
     */
    inlineEsignatureEdit() {
        // add css class esignature to the field element
        this.$el.addClass('eSignature');

        // initialize jSignature plug-in to display canvas input
        let $sigDiv = this.$el.jSignature({
            'UndoButton': true,
            'color': 'rgb(5, 1, 135)',
            'SignHere': true
        });

        // get the blank canvass code value to compare against a filled canvas
        this.blankCanvassCode = $sigDiv.jSignature('getData');

        // add the inline action links ("Update" and "Cancel")

        this.addInlineEditLinks(); // function inherited from base.js

        this.hideButton();
    }

    inlineEditClose() { // substitutes same function at base.js
        this.trigger('inline-edit-off');

        this.$el.removeClass('eSignature');

        this._isInlineEditMode = false;

        // remove the inline edit links after re-rendering
        this.once('after:render', this.removeInlineEditLinks, this);

        // re-renders the entity in detail mode
        this.reRender(true);
    }

    /**
     * Substitutes same function at base.js
     */
    inlineEditSave() {
        // convert the canvas drawing to image code
        let imageCode = this.$el.jSignature('getData');

        // compare the contents of the current vs blank canvass to make sure there's a signature to be saved
        if(this.blankCanvassCode[1] === imageCode) {
            alert("No signature was entered");
            this.inlineEditClose();

            return;
        }

        // register the signature time stamp
        let d = new Date();
        let timestamp = this.eSignatureISODateString(d);

        // prepare the signature drawing to be stored in the database integrating the timestamp
        let imageSource = '<img src="' + this.$el.jSignature('getData') + '"/>' +
            '<div style=margin-top:-0.5em;font-size:1em;font-style:italic;>' +
                this.translate('signedOn', 'messages', 'FieldManager') + ' ' + timestamp +
            '</div > ';

        Espo.Ui.notify(this.translate('Saving...'), 'success');

        let self = this;
        let model = this.model;
        let prev = this.initialAttributes;
        let data = model.attributes;

        // store the image code as the field value
        data[this.name] = imageSource;

        // persist the model with the updated field value
        this.model.save(data, {
            success: function () {
                self.trigger('after:save');
                model.trigger('after:save');

                Espo.Ui.notify(self.translate('Saved'), 'success');
            },
            error: function () {
                Espo.Ui.notify(self.translate('Error'), 'success');

                // undo all field value changes
                model.set(prev, { silent: true });

                // re-render with the original values
                self.render();
            },
            patch: true
        });

        // set field as readonly
        this.readOnly = true;

        this.inlineEditClose();
    }

    eSignatureISODateString(d) {
        return d.getFullYear() + '-' + this.pad(d.getMonth() + 1) + '-' +
            this.pad(d.getDate()) + ' ' + this.pad(d.getHours()) + ':' +
            this.pad(d.getMinutes()) + ':' + this.pad(d.getSeconds());
    }

    pad(n) {
        return n < 10 ? '0' + n : n;
    }
}

export default SignatureFieldView;
