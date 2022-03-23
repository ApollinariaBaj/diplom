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
    const button = e.relatedTarget;
    const id = button.getAttribute('data-id')
    const name = button.getAttribute('data-name')
    const modalBodyInputId = deleteModal.querySelector('.modal-body input[name="id"]');
    const modalTitle = deleteModal.querySelector('.modal-title');
    modalBodyInputId.value = id;
    modalTitle.textContent = name;
})

const updateStudentModal = document.getElementById('updateStudentModal');
if (updateStudentModal) {
    updateStudentModal.addEventListener('show.bs.modal', (e) => {
        const button = e.relatedTarget;
        const id = button.getAttribute('data-id')
        const surName = button.getAttribute('data-sur-name')
        const name = button.getAttribute('data-name')
        const fatherName = button.getAttribute('data-father-name')
        const group = button.getAttribute('data-group-id')
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

const updateGroupModal = document.getElementById('updateGroupModal');
if (updateGroupModal) {
    updateGroupModal.addEventListener('show.bs.modal', (e) => {
        const button = e.relatedTarget;
        const id = button.getAttribute('data-id')
        const name = button.getAttribute('data-name')
        const type = button.getAttribute('data-type')
        const course = button.getAttribute('data-course')
        const modalBodyInputId = updateGroupModal.querySelector('.modal-body input[name="id"]');
        const modalBodyInputName = updateGroupModal.querySelector('.modal-body input[name="name"]');
        const modalBodyInputCourse = updateGroupModal.querySelector('.modal-body input[name="course"]');
        const modalBodySelect = updateGroupModal.querySelector('.modal-body select');

        modalBodyInputId.value = id;
        modalBodyInputName.value = name;
        modalBodyInputCourse.value = course;
        modalBodySelect.value = type;
    })
}

const updateSubjectModal = document.getElementById('updateSubjectModal');
if (updateSubjectModal) {
    updateSubjectModal.addEventListener('show.bs.modal', (e) => {
        const button = e.relatedTarget;
        const id = button.getAttribute('data-id')
        const name = button.getAttribute('data-name')
        const teachers = button.getAttribute('data-teachers')

        const modalBodyInputId = updateSubjectModal.querySelector('.modal-body input[name="id"]');
        const modalBodyInputName = updateSubjectModal.querySelector('.modal-body input[name="name"]');

        modalBodyInputId.value = id;
        modalBodyInputName.value = name;

        $('#teachers2').selectpicker('val', teachers.split(",")).change();
        $('#teachers2').selectpicker('refresh')
    })
}