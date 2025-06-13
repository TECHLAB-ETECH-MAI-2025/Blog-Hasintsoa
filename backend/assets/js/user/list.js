import jQuery from "jquery";
import "datatables.net";
import "datatables.net-bs5";
import "datatables.net-responsive-bs5";
import { dataTableOptions } from "../main.js";

jQuery(function ($) {
  $("#users-table").DataTable({
    ...dataTableOptions,
    ajax: { url: "/app/users/data-table", type: "POST" },
    columns: [
      { data: "id", searchable: false },
      { data: "fullName" },
      { data: "email" },
      { data: "roles", orderable: false, searchable: false },
      { data: "isVerified", searchable: false },
      { data: "createdAt", searchable: false },
      { data: "actions", orderable: false, searchable: false }
    ]
  });
});
