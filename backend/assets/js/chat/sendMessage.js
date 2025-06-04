import jQuery from "jquery";
import { Toast } from "bootstrap";

jQuery(function ($) {
  const $messageForm = $("#message-form");
  const $messagesContainer = $("#messages-container");
  $messageForm.on("submit", (event) => {
    event.preventDefault();
    event.stopPropagation();
    const $submitBtn = $messageForm.find('button[type="submit"]');
    $submitBtn.prop("disabled", true);
    $.ajax({
      method: "POST",
      url: $messageForm.attr("action"),
      data: $messageForm.serialize(),
      dataType: "json",
      success: function (response) {
        if ($("#empty-text")) {
          $("#empty-text").hide();
        }
        $messagesContainer.append(response.messageHtml)
        $messageForm[0].reset();
        $(".invalid-feedback").remove();
        $(".form-control").removeClass("is-invalid");
      },
      error: (err) => {
        const {
          status,
          responseJSON: { error }
        } = err;
        if (status === 400) {
          console.log(error)
          $(".invalid-feedback").remove();
          if (error.content)
            showValidationMessage("#content-row", error.content, "#message_form_content");
        } else {
          showAlert("danger", "Une erreur est survenue lors de l'envoi du message !");
        }
      },
      complete: () => {
        $submitBtn.prop("disabled", false);
      }
    });
  });

  const showAlert = (type, message) => {
    const $alert =
      $(`<div class="toast show align-items-center text-white bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true" style="z-index: 999">
        <div class="d-flex">
            <div class="toast-body">
                ${message}
            </div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>`);
    $(".toast-container").append($alert);
    setTimeout(() => {
      new Toast($alert).hide();
    }, 5000);
  };

  const showValidationMessage = (rowId, message, inputId) => {
    const $authRow = $(rowId);
    const $authorErr = $(`<div class="invalid-feedback">${message}</div>`);
    $authRow.append($authorErr);
    $authRow.find(inputId).addClass("is-invalid");
  };
});
