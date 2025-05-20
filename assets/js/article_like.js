import jQuery from "jquery";

jQuery(function ($) {
  const $likeButton = $(".like-button")
  $likeButton.on("click", function (e) {
    e.preventDefault();
    e.stopPropagation();
    $.ajax({
      url: `/api/articles/${$(this).data("article-id")}/like`,
      method: "POST",
      dataType: "json",
      success: function (response) {
        const $articleLikeBtn = $(`#article-like-${response.articleId}`)
        $articleLikeBtn.toggleClass("liked", response.liked)
        $articleLikeBtn.find("#likes-count").text(response.likesCount)
      }
    });
  });
});
