const updateModal = document.getElementById('updateModal');
if (updateModal) {
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
}

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
    modalTitle.textContent = name;
})

const updateStudentModal = document.getElementById('updateStudentModal');
if (updateStudentModal) {
    updateStudentModal.addEventListener('show.bs.modal', (e) => {
        // Button that triggered the modal
        const button = e.relatedTarget;
        // Extract info from data-mdb-* attributes
        const id = button.getAttribute('data-id')
        const surName = button.getAttribute('data-sur-name')
        const name = button.getAttribute('data-name')
        const fatherName = button.getAttribute('data-father-name')
        const group = button.getAttribute('data-group-id')
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        const modalBodyInputId = updateStudentModal.querySelector('.modal-body input[name="id"]');
        const modalBodyInputSurName = updateStudentModal.querySelector('.modal-body input[name="surName"]');
        const modalBodyInputName = updateStudentModal.querySelector('.modal-body input[name="name"]');
        const modalBodyInputFatherName = updateStudentModal.querySelector('.modal-body input[name="fatherName"]');
        const modalBodySelect = updateStudentModal.querySelector('.modal-body select');

        modalBodyInputId.value = id;
        modalBodyInputSurName.value = surName;
        modalBodyInputName.value = name;
        modalBodyInputFatherName.value = fatherName;
        modalBodySelect.value = group;
    })
}