// Wait for the DOM to fully load before attaching event listeners
document.addEventListener('DOMContentLoaded', function () {
    // Select all input and select fields
    const fields = document.querySelectorAll('input, select, radio');

    fields.forEach(field => {
        // Add an event listener for when the field changes (input or select)
        field.addEventListener('input', function() {
            // Remove the error message related to this field when the user interacts
            const errorElement = field.parentElement.querySelector('.error-message');
            if (errorElement) {
                errorElement.remove();
            }
        });
    });

    const radioButtons = document.querySelectorAll('input[type="radio"]');

    const radioButtonsQuestions = document.querySelectorAll('input[type="radio"]');

    radioButtons.forEach(radio => {
        // Add event listener for changes (when a radio button is clicked)
        radio.addEventListener('change', function() {
            // Remove error message when the user selects an option
            const errorElement = radio.closest('.form-group').querySelector('.error-message');
            if (errorElement) {
                errorElement.remove();
            }
        });
    });

    radioButtonsQuestions.forEach(radio => {
        // Add event listener for changes (when a radio button is clicked)
        radio.addEventListener('change', function() {
            // Remove error message when the user selects an option
            const errorElement = radio.closest('.error-row').querySelector('.error-message');
            if (errorElement) {
                errorElement.remove();
            }
        });
    });
});