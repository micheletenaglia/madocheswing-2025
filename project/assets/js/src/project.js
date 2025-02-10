/**
 * Get data for Whatsapp button.
 * 
 */

// Default value
var whatsappMsg = '';

// Whatsapp message
$(document).on('change', '.js-whatsapp input, .js-whatsapp select, .js-whatsapp textarea', function() {
    // Default URL
    var wTel = $('.js-whatsapp-button').data('tel');
    const inputs = {};
    // Count required inputs
    var requiredInputs = 0; 
    // Handle multiple choices repeating names
    var repeatingNames = [];
    // Count required inputs
    $('.js-whatsapp input, .js-whatsapp select, .js-whatsapp textarea').each(function() {
        // Name
        const inputName = $(this).attr('name');
        const inputType = $(this).attr('type');
        if( 
            $(this).attr('type') == 'hidden'
            || inputType == 'submit'
            || inputType == 'button'
            || repeatingNames.includes(inputName)
        ) {
            return; // Continue doesn't work with each
        }
        if(
            $(this).prop('required')
            || $(this).attr('aria-required') == 'true' // Fix for CF7
            || $(this).hasClass('wpcf7-validates-as-required') // Fix for CF7
            || $(this).closest('.wpcf7-form-control-wrap').find('.wpcf7-validates-as-required').length // Fix for CF7
            || inputType == 'radio' // Fix for CF7
            || inputName == 'gdpr' // Fix for CF7
        ){
            // Increment required inputs count
            requiredInputs++;
            // Push attr name into array
            repeatingNames.push(inputName); 
        }
    });
    // Populate variable
    $('.js-whatsapp input, .js-whatsapp select, .js-whatsapp textarea').each(function() {
        const inputType = $(this).attr('type');
        if( 
            inputType != 'hidden'
            && inputType != 'submit'
            && inputType != 'button'
        ) {
            // Name
            const inputName = $(this).attr('name');
            // Label
            const inputLabel = $('label[for="' + inputName + '"]').html();
            // Value
            var inputValue = $(this).val();
            // Handle required inputs
            var inputRequired = 0;
            if( 
                $(this).prop('required')
                || $(this).attr('aria-required') == 'true' // Fix for CF7
                || inputName == 'gdpr' // Fix for CF7
            ){
                inputRequired = 1;
            }
            // Handle radios and gdpr (Fix for CF7)
            if( $(this).is(':radio') || inputName == 'gdpr' ) {
                inputValue = $('input[name="' + inputName + '"]:checked').val();
            }else if( $(this).is(':checkbox') && inputName != 'gdpr' ) {
                // Temporary array
                var tempValue = [];
                // Pusch checked values into array
                $('input[name="' + inputName + '"]:checked').each(function() {
                    tempValue.push($(this).val()); 
                });
                // Array to string
                inputValue = tempValue.toString();
            }else if( $(this).is('select') ) {
                inputValue = $('input[name="' + inputName + '"]:selected').val();
            }else if( $(this).is('textarea') ) {
                // Nothing
            }
            inputs[inputName] = {
                'label'     :   inputLabel,
                'value'     :   inputValue,
                'required'  :   inputRequired,
            };
        }
    });
    // Count elements in inputs object
    const countInputs = Object.keys(inputs);
    // Validate Whatsapp message
    var dataCheck = 0;
    // Message
    whatsappMsg = 'Ciao, vorrei informazioni sui corsi. Ecco i miei dati:' + '\n';
    // Loop and populate message
    for( const [key, values] of Object.entries(inputs)) {
        if( values.value != '' ) {
            if( key == 'gdpr' ) {
                // Handle GDPR
                if( values.value > 0 ) {
                    whatsappMsg += 'GDPR: Autorizzo il trattamento dei miei dati personali ai sensi dell’art. 13 Dlgs 196 del 30 giugno 2003 e dell’art. 13 GDPR (Regolamento UE 2016/679).' + '\n';
                    whatsappMsg += privacyUrl; // From PHP
                    // Increment check value
                    dataCheck++;
                }
            }else if( Array.isArray(values.value) ) {
                // Handle arrays
                whatsappMsg += values.label + ': ' + values.value.toString() + '\n';
                // Increment check value
                dataCheck++;
            }else{
                whatsappMsg += values.label + ': ' + values.value + '\n';
                if( key != 'notes' ) {
                    // Increment check value of not required values
                    dataCheck++;
                }
            }
        }
    }
    // Encode message
    whatsappMsg = encodeURIComponent(whatsappMsg);
    // Update URL
    newUrl = 'https://wa.me/' + wTel + '/?text=' + whatsappMsg;
    // Update href
    $('.js-whatsapp-button').attr('href',newUrl);
    // Check if all required inputs have been filled in
    // We add 1 because "notes" is not a required input
    if( (dataCheck + 1) == countInputs.length ) {
        $('.js-whatsapp-button').removeClass('disabled');
    }else{
        $('.js-whatsapp-button').addClass('disabled');
    }
});

// Prevent Whatsapp button link if not enough data
$(document).on('click', '.button.disabled', function(event) {
    event.preventDefault();
});

/**
 * Example of CF7 HTML markup
 * 
<div class="js-whatsapp grid-1">
    <div class="col-span-1-2 grid-1-2">
        <div class="">
            <label for="f_name" class="required-input">Nome</label>
            [text* f_name autocomplete:given-name placeholder "Nome"]
        </div>
        <div class="">
            <label for="l_name" class="required-input">Cognome</label>
            [text* l_name autocomplete:family-name placeholder "Cognome"]
        </div>
        <div class="">
            <label for="phone" class="required-input">Telefono</label>
            [text* phone autocomplete:tel placeholder "Telefono"]
        </div>
        <div>
            <label for="email" class="required-input">Email</label>
            [email* email autocomplete:email placeholder "Email"]
        </div>
    </div>
    <div class="col-span-1-2 grid-1-2-4">
        <div>
            <label for="dance_classes[]" class="required-input">Corsi</label>
            [checkbox* dance_classes use_label_element data:dance_classes]
        </div>
        <div>
            <label for="bundle" class="required-input">Pacchetto</label>
            [radio bundle use_label_element default:1 "Trimestrale" "Mensile" "Lezione di prova"]
        </div>
        <div>
            <label for="roles[]" class="required-input">Ruolo</label>
            [checkbox* roles use_label_element "Solo" "Follower" "Leader"]
        </div>
        <div>
            <label for="sex" class="required-input">Sesso</label>
            [radio sex use_label_element default:1 "Donna" "Uomo" "Altro"]
        </div>
    </div>
    <div class="col-span-1-2">
        <label for="notes">Note</label>
        [textarea notes x2 placeholder "Aggiungi una nota"]
    </div>
    <div class="flex justify-between">
        <div>
            <label for="gdpr" style="display: none;">GDPR</label>
            [acceptance gdpr] Autorizzo il trattamento dei miei dati personali ai sensi dell’art. 13 Dlgs 196 del 30 giugno 2003 e dell’art. 13 GDPR (Regolamento UE 2016/679). <a href="http://localhost:8888/mcs/privacy-policy/" target="_blank" rel="noopener">Informativa privacy</a> [/acceptance]
        </div>
        <div>
            <a class="button js-whatsapp-button w-full disabled" target="_blank" rel="noopener" data-tel="393514150480" href="https:wa.me/393514150480">Whatsapp</a>
            [submit class:w-full "Invia email"]
        </div>
    </div>
</div>
*/

// Backup of Whatsapp message
/*
$(document).on('change', '.js-whatsapp input, .js-whatsapp select, .js-whatsapp textarea', function() {
    // Default URL
    var wTel = $('.js-whatsapp-button').data('tel');
    // Inputs
    var inputs = {
        'f_name' : {
            'value' :   $('.js-whatsapp [name="f_name"]').val(),
            'label' :   $('label[for="f_name"]').html(),
        },
        'l_name' : {
            'value' :   $('.js-whatsapp [name="l_name"]').val(),
            'label' :   $('label[for="l_name"]').html(),
        },
        'phone' : {
            'value' :   $('.js-whatsapp [name="phone"]').val(),
            'label' :   $('label[for="phone"]').html(),
        },
        'email' : {
            'value' :   $('.js-whatsapp [name="email"]').val(),
            'label' :   $('label[for="email"]').html(),
        },
        'bundle' : {
            'value' :   $('.js-whatsapp [name="bundle"]:checked').val(),
            'label' :   $('label[for="bundle"]').html(),
        },
        'roles' : {
            'value' :   [],
            'label' :   $('label[for="roles[]"]').html(),
        },
        'dance_classes' : {
            'value' :   [],
            'label' :   $('label[for="dance_classes[]"]').html(),
        },
        'sex' : {
            'value' :   $('.js-whatsapp [name="sex"]:checked').val(),
            'label' :   $('label[for="sex"]').html(),
        },
        'notes' : {
            'value' :   $('.js-whatsapp [name="notes"]').val(),
            'label' :   $('label[for="notes"]').html(),
        },
        'gdpr' : {
            'value' :   $('.js-whatsapp [name="gdpr"]:checked').val(),
            'label' :   $('label[for="gdpr"]').html(),
        }
    };
    // Handle multiple choices
    $('.js-whatsapp [name="dance_classes[]"]:checked').each(function() {
        inputs.dance_classes.value.push($(this).val()); 
    });
    $('.js-whatsapp [name="roles[]"]:checked').each(function() {
        inputs.roles.value.push($(this).val()); 
    });
    // Count elements in inputs object
    const countInputs = Object.keys(inputs);
    // Validate Whatsapp message
    var dataCheck = 0;
    // Message
    whatsappMsg = 'Ciao, vorrei informazioni sui corsi. Ecco i miei dati:' + '\n';
    // Loop and populate message
    for( const [key, values] of Object.entries(inputs)) {
        if( values.value != '' ) {
            if( key == 'gdpr' ) {
                // Handle GDPR
                if( values.value > 0 ) {
                    whatsappMsg += 'GDPR: Autorizzo il trattamento dei miei dati personali ai sensi dell’art. 13 Dlgs 196 del 30 giugno 2003 e dell’art. 13 GDPR (Regolamento UE 2016/679).' + '\n';
                    whatsappMsg += 'http://localhost:8888/mcs/privacy-policy/'; // !!! Fare con PHP
                    // Increment check value
                    dataCheck++;
                }
            }else if( Array.isArray(values.value) ) {
                // Handle arrays
                whatsappMsg += values.label + ': ' + values.value.toString() + '\n';
                // Increment check value
                dataCheck++;
            }else{
                whatsappMsg += values.label + ': ' + values.value + '\n';
                if( key != 'notes' ) {
                    // Increment check value of not required values
                    dataCheck++;
                }
            }
        }
    }
    // Encode message
    whatsappMsg = encodeURIComponent(whatsappMsg);
    // Update URL
    newUrl = 'https://wa.me/' + wTel + '/?text=' + whatsappMsg;
    // Update href
    $('.js-whatsapp-button').attr('href',newUrl);
    // Check if all required inputs have been filled in
    // We add 1 because "notes" is not a required input
    if( (dataCheck + 1) == countInputs.length ) {
        $('.js-whatsapp-button').removeClass('disabled');
    }else{
        $('.js-whatsapp-button').addClass('disabled');
    }
});
*/