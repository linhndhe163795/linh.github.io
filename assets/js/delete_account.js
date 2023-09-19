function DeleteAccount(id) {
    var confirmDelete = confirm('Do you want to remove this account id = ' + id);
    if (confirmDelete) {
        document.getElementById("deleteId").value = id;
        document.getElementById("delete").submit();

    }
}
