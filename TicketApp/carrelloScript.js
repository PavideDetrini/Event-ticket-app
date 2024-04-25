document.addEventListener('DOMContentLoaded', function() {
    // Ottieni riferimenti agli elementi DOM
    var acquistaCheckbox = document.querySelectorAll('.checkbox-cart');
    var submitBtn = document.querySelector('.submitBtn');
    acquistaCheckbox.forEach(function(checkbox) {
        checkbox.addEventListener('change', function(ev) {
            console.log(ev);
            var checkbox = document.querySelectorAll('.checkbox-cart:checked');
            if (checkbox.length > 0) {
                    submitBtn.style.display = 'block';
            } else {
                submitBtn.style.display = 'none';
            }
        })
    });
});

document.getElementById('myForm').addEventListener('submit', function(event) {
    // Otteniamo tutti gli input checkbox
    const checkboxes = document.querySelectorAll('.checkbox-cart');

    checkboxes.forEach(function(checkbox) {
        // Troviamo l'input number corrispondente
        const eventID = checkbox.id.split('_')[1]; // Estrarre l'ID evento
        const numberInput = document.getElementById('number_' + eventID);

        if (!checkbox.checked) {
            // Se la checkbox non è selezionata, rimuoviamo l'input number dal form
            numberInput.removeAttribute('name');
        }
    });

    // Inviamo il form normalmente
});

document.addEventListener('DOMContentLoaded', function() {
    // Get all the buttons with the class 'check_true'
    var buttons = document.querySelectorAll('.check_true');

    buttons.forEach(function(button) {
        button.addEventListener('click', function() {
            // Extract the unique identifier from the button's id
            var eventoId = button.id.split('_')[1];

            // Find the corresponding checkbox using the unique identifier
            var checkbox = document.getElementById('checkbox_' + eventoId);

            // Check the checkbox
            if (checkbox.checked) {
                checkbox.checked = false;
            }else
                checkbox.checked = true;
            var event = new Event('change', { bubbles: true });
            checkbox.dispatchEvent(event);
    });
    });
});
    document.addEventListener('DOMContentLoaded', (event) => {
    const buttons = document.querySelectorAll('.elimina-cart');
    buttons.forEach(button => {
    button.addEventListener('click', function() {
    const eventoId = this.getAttribute('data-evento');
    const container = document.getElementById('checkbox_' + eventoId).closest('.container-cart');
    container.remove();
    //ajax delete from carrello where
    xhttp = new XMLHttpRequest();
    xhttp.open("POST", "ajaxAcquisto.php?Evento=" + eventoId, true);
    xhttp.send();
});
});
});


