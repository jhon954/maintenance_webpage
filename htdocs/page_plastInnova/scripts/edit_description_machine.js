function enableEdit(fieldId) {
    var field = document.getElementById(fieldId);
    field.readOnly = false;
    document.getElementById('save_changes_btn').disabled = false;
    document.getElementById('discard_changes_btn').disabled = false;
    //Enable the editing of the state field.
    document.getElementById('state_machine').disabled = false;
    //
    var datasheetUrl = document.getElementById('datasheet_url').getAttribute('href');
    var inputElement = document.getElementById('datasheet_url_input');
    inputElement.setAttribute('value', datasheetUrl);

}
function enableEdit_URL() {
    var datasheetUrl = document.getElementById('datasheet_url').getAttribute('href');
    var inputElement = document.getElementById('datasheet_url_input');
    
    // Create a new text input element
    // var inputElement = document.createElement('input');
    inputElement.setAttribute('type', 'text');
    // inputElement.setAttribute('class', 'form-control');
    // inputElement.setAttribute('id', 'datasheet_url_input');
    // inputElement.setAttribute('name', 'datasheet_url');
    inputElement.setAttribute('value', datasheetUrl);
    // Replace the link with the input text field
    var datasheetSection = document.getElementById('datasheet_section');
    datasheetSection.innerHTML = '<label for="datasheet_url">URL del datasheet:</label>'; // Clean the field
    datasheetSection.appendChild(inputElement);
    // Insert the button next to the input text field
    datasheetSection.insertAdjacentHTML('beforeend', '<button type="button" class="button-edit" onclick="enableEdit()">Editar</button>');            //var datasheetSection = document.getElementById('datasheet_section');

    document.getElementById('save_changes_btn').disabled = false;
    document.getElementById('discard_changes_btn').disabled = false;
    // Enable the editing of the status field
    document.getElementById('state_machine').disabled = false;
}
function discardChanges() {
    // Reload the page
    location.reload();
}