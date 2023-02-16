document.addEventListener('DOMContentLoaded', () => {
    // Get the receiver identifier field.
    let receiverIdentifierField = document.getElementById('nyzo-plugin-setting-receiver-id');

    if (receiverIdentifierField != null) {
        // Add a listener to update validation on user input.
        receiverIdentifierField.addEventListener('input', () => {
            validateReceiverIdentifierField();
        });

        // Perform initial validation.
        validateReceiverIdentifierField();
    }
});

function isValidPublicIdentifier(identifierString) {
    let valid = false;
    if (typeof identifierString === 'string') {
        identifierString = identifierString.trim();
        let identifier = decode(identifierString);
        valid = identifier != null && typeof identifier.getIdentifier() !== 'undefined';
    }

    return valid;
}

function validateReceiverIdentifierField() {
    let field = document.getElementById('nyzo-plugin-setting-receiver-id');
    if (field != null) {
        let value = field.value;
        if (isValidPublicIdentifier(value)) {
            field.style.backgroundColor = '#efe';
        } else {
            field.style.backgroundColor = '#fee';
        }
    }
}