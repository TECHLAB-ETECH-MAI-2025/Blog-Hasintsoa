import jQuery from "jquery";
import "datatables.net";
import "datatables.net-bs5";
import "datatables.net-responsive-bs5";

jQuery(function ($) {
  $("#categories-table").DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    ajax: {
      url: "/api/categories/data-table",
      type: "POST"
    },
    columns: [
      { data: "id", searchable: false },
      { data: "title" },
      { data: "createdAt", searchable: false },
      { data: "actions", orderable: false, searchable: false }
    ],
    language: {
      url: "/dataTable/i18n/fr-FR.json"
    },
    order: [[0, "desc"]]
  });
});
