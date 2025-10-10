{{#if value}}
    <span style='font-size:0.8em;font-style:italic;'>{{{imageSource}}}</span>
{{else}}
    <div class="text-center btn-container">
        <button
            data-action="sign"
            class="btn btn-default"
            type="button"
            title="{{translate 'Click to sign' scope='FieldManager' category='labels'}}"
        >{{translate 'Click to sign' scope='FieldManager' category='labels'}}</button>
    </div>
{{/if}}
