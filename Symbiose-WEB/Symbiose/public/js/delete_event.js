//TODO Make sure this always works whats causing bugs

const events = document.getElementById('events');

if (events) {
    events.addEventListener('click', e => {
            const id = e.target.getAttribute('data-id');
            if (id !== null) {
                fetch('/event/delete/${id}', {
                    method: 'DELETE'
                }).then(res => window.location.reload());
            }
        /*
        if (e.target.className === "btn btn-danger delete-event"){
            if (confirm('Are you sure?')){
                const id = e.target.getAttribute('data-id');

                alert(id);
            }
        }*/
    });
}

