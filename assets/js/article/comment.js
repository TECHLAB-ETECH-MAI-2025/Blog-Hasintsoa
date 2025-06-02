import jQuery from "jquery";
import { Toast } from "bootstrap";

jQuery(function ($) {
  const $commentForm = $("#comment-form");
  const $commentsList = $("#comments-list");
  const $commentsCount = $("#comments-count");
  $commentForm.on("submit", function (event) {
    event.preventDefault();
    event.stopPropagation();
    const $submitBtn = $commentForm.find('button[type="submit"]');
    const originalBtnText = $submitBtn.html();
    $submitBtn.html("Envoi en cours...").prop("disabled", true);
    $.ajax({
      method: "POST",
      url: $commentForm.attr("action"),
      data: $commentForm.serialize(),
      dataType: "json",
      success: function (response) {
        if ($("#empty-text")) {
          $("#empty-text").hide();
        }
        $commentsList.append(response.commentHtml);
        $commentsCount.text(response.commentsCount);
        $commentForm[0].reset();
        showAlert("success", "Votre commentaire a été publié avec succès !");
        $(".invalid-feedback").remove();
        $(".form-control").removeClass("is-invalid");
      },
      error: (err) => {
        const {
          status,
          responseJSON: { error }
        } = err;
        if (status === 400) {
          $(".invalid-feedback").remove();
          showAlert("danger", "Veuillez remplir le formulaire correctement !");
          if (error.content)
            showValidationMessage("#content-row", error.content, "#comment_form_content");
        } else {
          showAlert("danger", "Une erreur est survenue lors de l'envoi du commentaire !");
        }
      },
      complete: () => {
        $submitBtn.html(originalBtnText).prop("disabled", false);
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
