import jQuery from "jquery";

jQuery(function($) {
  $(".rating-star").on("click", function(event) {
    event.preventDefault();
    event.stopPropagation();
    const articleId = $(this).data("article-id")
    const rating = $(this).data("rating")
    console.log(articleId, rating);
    $.ajax({
      url: `/api/articles/${$(this).data("article-id")}/rate`,
      method: "POST",
      data: {rating},
      dataType: "json",
      success: function (response) {
        const { rates } = response;
        const $starsRatings = $(`#article-range-${articleId}`).find(".rating-star")
        $starsRatings.removeClass("fa-solid rated fa-regular")
        for (let i = 1; i <= 5; i++) {
          if (i <= rates) {
            $starsRatings.eq(i-1).removeClass("fa-regular").addClass("fa-solid rated")
          } else {
            $starsRatings.eq(i-1).removeClass("fa-solid rated").addClass("fa-regular")
          }
        }
      },
      error: function (response) {}
    });
  })
})