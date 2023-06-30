let tblUsers;

document.addEventListener("DOMContentLoaded", function () {
  //Load data with datatables plugin
  tblUsers = $("#tblUsers").DataTable({
    ajax: {
      url: base_url + "users/listInactives",
      dataSrc: "",
    },
    columns: [
      { data: "completeName" },
      { data: "email" },
      { data: "phone" },
      { data: "address" },
      { data: "rol" },
      { data: "actions" },
    ],
    language: {
      url: base_url + "assets/js/spanish.json",
    },
    dom,
    buttons,
    responsive: true,
    order: [[0, "asc"]],
  });
});

//Reactivate Users function
function reactivateUser(idUser) {
  const url = base_url + "users/reactivate/" + idUser;
  restoreRecords(url, tblUsers);
}
