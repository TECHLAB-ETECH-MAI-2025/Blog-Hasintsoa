import jQuery from "jquery";
import "datatables.net";
import "datatables.net-bs5";
import "datatables.net-responsive-bs5";

jQuery(function ($) {
  $("#articles-table").DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    ajax: {
      url: "/api/articles",
      type: "POST"
    },
    columns: [
      { data: "id", searchable: false },
      { data: "title" },
      { data: "categories", searchable: false },
      { data: "commentsCount", searchable: false },
      { data: "likesCount", searchable: false },
      { data: "createdAt", searchable: false },
      { data: "actions", orderable: false, searchable: false }
    ],
    language: {
      url: "/dataTable/i18n/fr-FR.json"
    },
    order: [[0, "desc"]]
  });
});
