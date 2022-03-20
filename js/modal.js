const updateModal = document.getElementById('updateModal');
updateModal.addEventListener('show.bs.modal', (e) => {
    // Button that triggered the modal
    const button = e.relatedTarget;
    // Extract info from data-mdb-* attributes
    const id = button.getAttribute('data-id')
    const name = button.getAttribute('data-name')
    const isadmin = button.getAttribute('data-isadmin') == 1 ? true : false
    // If necessary, you could initiate an AJAX request here
    // and then do the updating in a callback.
    //
    // Update the modal's content.
    const modalBodyInputId = updateModal.querySelector('.modal-body input[name="id"]');
    const modalBodyInputLogin = updateModal.querySelector('.modal-body input[name="login"]');
    const modalBodyInputAdmin = updateModal.querySelector('.modal-body input[name="admin"]');

    modalBodyInputId.value = id;
    modalBodyInputLogin.value = name;
    modalBodyInputAdmin.checked = isadmin;
})

const deleteModal = document.getElementById('deleteModal');
deleteModal.addEventListener('show.bs.modal', (e) => {
    // Button that triggered the modal
    const button = e.relatedTarget;
    // Extract info from data-mdb-* attributes
    const id = button.getAttribute('data-id')
    const name = button.getAttribute('data-name')
    // If necessary, you could initiate an AJAX request here
    // and then do the updating in a callback.
    //
    // Update the modal's content.
    const modalBodyInputId = deleteModal.querySelector('.modal-body input[name="id"]');
    const modalTitle = deleteModal.querySelector('.modal-title');
    modalBodyInputId.value = id;
    modalTitle.textContent = "Удаление пользователя " + name;
})