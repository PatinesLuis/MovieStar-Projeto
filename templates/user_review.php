<?php print_r($review);?>

<div class="col-md-12">
                <div class="row">
                    <div class="col-md-1">
                        <div class="profile-image-container review-image" style="background-image: url('<?= $BASE_URL?>/img/users/<?= $review->user->image ?>')"></div>
                    </div>
                    <div class="col-md-9 author-details-container">
                        <h4 class="author-name">
                            <a href="<?= $BASE_URL?>profile.php?=<?=$review->user->id?>"><?=$review->user->name?></a>
                        </h4>
                        <p><i class="fas fa-star"></i><?=$review->rating?></p>
                    </div>
                    <div class="col-md-12">
                        <p class="comment-title">Comentario:</p>
                        <p><?=$review->review?></p>
                    </div>
                </div>
              </div>