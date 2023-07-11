let tblClients;

document.addEventListener("DOMContentLoaded", function () {
  //Load data with datatables plugin
  tblClients = $("#tblClients").DataTable({
    ajax: {
      url: base_url + "clients/list",
      dataSrc: "",
    },
    columns: [{ data: "identity_type" }, { data: "client_identity" }, { data: "name" }, { data: "phone" }, { data: "email" }, { data: "address" }, { data: "actions" }],
    language: {
      url: base_url + "assets/js/spanish.json",
    },
    dom,
    buttons,
    responsive: true,
    order: [[0, "asc"]],
  });
});
