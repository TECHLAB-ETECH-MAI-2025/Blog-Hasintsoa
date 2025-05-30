import jQuery from "jquery";
import { Toast } from "bootstrap";

jQuery(function ($) {
  const $deviseForm = $("#devise-form");
  $deviseForm.on("submit", function (event) {
    event.preventDefault();
    event.stopPropagation();
  const $submitBtn = $deviseForm.find('button[type="submit"]');
    const originalBtnText = $submitBtn.html();
    $submitBtn.html("Calcul en cours...").prop("disabled", true);
    $.ajax({
      method: "POST",
      url: $deviseForm.attr("action"),
      data: $deviseForm.serialize(),
      dataType: "json",
      success: function (response) {
        console.log(response)
        const {
          conversionAmountValue,
          conversionFromCurrency,
          conversionToCurrency,
          convertedAmount,
          originalValues: {
            fromCurrency,
            toCurrency,
            fxRateWithAdditionalFee
          },
          reverseAmount
        } = response
        
        $('#results-row')
          .removeClass('d-none')
          .html(`<div class="fs-4">
            <span class="fw-bold">${conversionAmountValue}</span>
            <span class="fw-bold">${conversionToCurrency}</span>
            =
            <span class="fw-bold">${convertedAmount}</span>
            <span class="fw-bold">${conversionFromCurrency}</span>
          </div>
          <div class="fs-6">
            <div>1 ${fromCurrency} = ${fxRateWithAdditionalFee} ${toCurrency} </div>
            <div>1 ${toCurrency} = ${reverseAmount} ${fromCurrency}</div>
          </div>`)
        $(".invalid-feedback").remove();
        $(".form-control").removeClass("is-invalid");
      },
      error: (err) => {
        const {
          status,
          responseJSON: { error }
        } = err;
        if (status === 400) {
          $(".form-control").removeClass("is-invalid");
          $(".invalid-feedback").remove();
          if (error.amount)
            showValidationMessage("#amount-row", error.amount, "#devise_conversion_form_amount");
          if (error.exchangedate)
            showValidationMessage("#exchangedate-row", error.exchangedate, "#devise_conversion_form_exchangedate");
          if (error.fee)
            showValidationMessage("#fee-row", error.fee, "#devise_conversion_form_fee");
        } else {
          showAlert("danger", "Une erreur est survenue lors du calcul du taux de change");
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
  
  const $selectFrom = $('#devise_conversion_form_fromCurr');
  const $selectTo = $('#devise_conversion_form_toCurr');
  const $errorMessage = $('#select-error-message');
  const $submitButton = $('button[type="submit"]');
  const $swapBtn = $('#swap-btn')

  /**
   * Fonction pour valider les sélections et afficher/masquer le message d'erreur
   * si fromCurr et toCurr sont égales
   */
  function validateSelections() {
    const valFrom = $selectFrom.val();
    const valTo = $selectTo.val();

    if (valFrom && valTo && valFrom === valTo) {
      $errorMessage.removeClass('d-none');
      $submitButton.prop("disabled", true);
    } else {
      $errorMessage.addClass('d-none');
      $submitButton.prop("disabled", false);
    }
  }

  /**
   * Fonction pour échanger les valeurs des deux selects
   */
  $swapBtn.on('click', function swapSelectValues(event) {
    const currentValFrom = $selectFrom.val();
    const currentValTo = $selectTo.val();
    $selectFrom.val(currentValTo);
    $selectTo.val(currentValFrom);
  })

  $selectFrom.on('change', validateSelections);
  $selectTo.on('change', validateSelections);

  validateSelections();
});
