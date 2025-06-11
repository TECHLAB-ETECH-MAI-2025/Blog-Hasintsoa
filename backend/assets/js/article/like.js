import jQuery from "jquery";

jQuery(function ($) {
  const $likeButton = $(".like-button");
  $likeButton.on("click", function (e) {
    e.preventDefault();
    e.stopPropagation();
    $.ajax({
      url: `/api/articles/${$(this).data("article-id")}/likes`,
      method: "POST",
      dataType: "json",
      success: function (response) {
        console.log(response);
        const $articleLikeBtn = $(`#article-like-${response.articleId}`);
        $articleLikeBtn.toggleClass("liked", response.liked);
        if (response.liked)
          $articleLikeBtn
            .find(".like-icon")
            .removeClass("fa-regular")
            .addClass("fa-solid");
        else
          $articleLikeBtn
            .find(".like-icon")
            .removeClass("fa-solid")
            .addClass("fa-regular");
        $articleLikeBtn.find("#likes-count").text(response.likesCount);
      },
      error: (err) => {
        console.log(err);
      }
    });
  });
});
