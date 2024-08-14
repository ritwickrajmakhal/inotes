let table = new DataTable("#myTable");

const editBtns = document.querySelectorAll(".edit");
const alert = document.getElementById("alert");

editBtns.forEach((editBtn) => {
  editBtn.addEventListener("click", () => {
    const parentElement = editBtn.parentElement.parentElement;
    const id = parentElement.id;
    const title = parentElement.children[1].innerHTML;
    const desc = parentElement.children[2].children[0].innerHTML;

    // set the above data to edit modal
    const modalNoteId = document.querySelector("#modalNoteId");
    const modalNoteTitle = document.querySelector("#modalNoteTitle");
    const modalNoteDesc = document.querySelector("#modalNoteDesc");

    modalNoteId.value = id;
    modalNoteTitle.value = title;
    modalNoteDesc.value = desc;
    alert.innerHTML = `<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your note edited.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>`;
  });
});

const deleteBtns = document.querySelectorAll(".delete");

deleteBtns.forEach((deleteBtn) => {
  deleteBtn.addEventListener("click", () => {
    const confirmation = confirm("Are sure to delete this note?");
    if (confirmation) {
      const id = deleteBtn.parentElement.parentElement.id;
      window.location.href = `/delete.php?id=${id}`;
      alert.innerHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your note deleted.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>`;
    }
  });
});

const insertAlert = () => {
    alert.innerHTML = `<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your note created.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>`;
};
