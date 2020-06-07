<div class="hl-listings">

  <?php foreach ($gallery as $image) { ?>
    <div class="hl-listing-card-wrap">
      <div class="hl-listing-card hl-listing-card-1">
        <div class="hl-listing-card-1__picture">
          <ul class="hl-listing-card-1__tags">
            <li class="hl-listing-card-1__tag-wrap">
              <span class="hl-listing-card-1__tag hl-listing-card-1__tag_green">Featured</span>
            </li>

<!--            <li class="hl-listing-card-1__tag-wrap">-->
<!--              <span class="hl-listing-card-1__tag hl-listing-card-1__tag">Rentals</span>-->
<!--            </li>-->
<!---->
<!--            <li class="hl-listing-card-1__tag-wrap">-->
<!--              <span class="hl-listing-card-1__tag hl-listing-card-1__tag_blue">Rentals</span>-->
<!--            </li>-->

            <li class="hl-listing-card-1__tag-wrap">
              <span class="hl-listing-card-1__tag hl-listing-card-1__tag_red">Rentals</span>
            </li>
          </ul>

          <div class="hl-listing-card-1__location">
            <span class="hl-listing-card-1__icon hl-listing-card-1__location-icon"></span>
            <a class="hl-listing-card-1__location-item" href="#">Shinjuku,</a>
            <a class="hl-listing-card-1__location-item" href="#">Tokyo</a>
          </div>

          <a class="hl-listing-card-1__picture-wrap-img" href="#">
            <picture class="hl-listing-card-1__picture-img-picture">
              <source src="<?php echo  $image['sizes']['medium']; ?>" type="image/png">
              <img
                src="<?php echo  $image['sizes']['medium']; ?>"
                class="hl-listing-card-1__picture-img img-responsive"
                alt="<?php echo $image['alt']; ?>"
              >
            </picture>
          </a>

          <div class="hl-listing-card-1__carousel" style="display: none;">
            <div class="hl-listing-card-1__carousel-item">
              <a class="hl-listing-card-1__carousel-item-inner hl-listing-card-1__picture-wrap-img" href="#">
                <img
                  src="<?php echo  $image['sizes']['medium']; ?>"
                  class="hl-listing-card-1__picture-img img-responsive"
                  title="<?php echo $image['title']; ?>"
                  alt="<?php echo $image['alt']; ?>"
                >
              </a>
            </div>

            <button class="hl-listing-card-1__carousel-nav-left hl-listing-card-1__carousel-nav">

            </button>

            <button class="rhl-listing-card-1__carousel-nav-right hl-listing-card-1__carousel-nav">

            </button>
          </div>
        </div>

        <div class="hl-listing-card-1__body">
          <h4 class="hl-listing-card-1__title">
            <a href="#">
              Boutique Space in Tokyo for Sale
            </a>
          </h4>

          <div class="hl-listing-card-1__price">
            <span class="hl-listing-card-1__price-value">
              ¥ 770,000
            </span>
            <span class="hl-listing-card-1__price-label">
              / month
            </span>
          </div>

          <p class="hl-listing-card-1__description">
            This property is mostly wooded and sits high on a hilltop overlooking the Mohawk River Valley. Located right in the
          </p>

          <ul class="hl-listing-card-1__info">
            <li class="hl-listing-card-1__info-item">
              <span class="hl-listing-card-1__icon hl-listing-card-1__info-icon"></span>
              <span class="hl-listing-card-1__info-value">5</span>
            </li>

            <li class="hl-listing-card-1__info-item">
              <span class="hl-listing-card-1__icon hl-listing-card-1__info-icon"></span>
              <span class="hl-listing-card-1__info-value">6</span>
            </li>

            <li class="hl-listing-card-1__info-item">
              <span class="hl-listing-card-1__icon hl-listing-card-1__info-icon"></span>
              <span class="hl-listing-card-1__info-value">
                190.00 m<sup>2</sup>
              </span>
            </li>

            <li class="hl-listing-card-1__info-item hl-listing-card-1__info-item_full ml-auto">
              <a href="#">
                full info
              </a>
            </li>
          </ul>
        </div>

        <div class="hl-listing-card-1__bottom mt-auto">
          <div class="hl-listing-card-1__bottom-inner">
            <a href="#" class="hl-listing-card-1__agent">
              <img
                src="https://tokyowpresidence.b-cdn.net/wp-content/uploads/2014/05/agent3-1-19-120x120.jpg"
                class="hl-listing-card-1__agent-img img-responsive"
                alt=""
              >
              <span class="hl-listing-card-1__agent-name">Janet Richmond</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>

</div>

//    echo $image['title'];
//    echo $image['url'];
//    echo $image['alt'];
////    url for different sizes
//    echo $image['sizes']['thumbnail'];
//    echo $image['sizes']['medium'];
//    echo $image['sizes']['medium_large'];
//    echo $image['sizes']['large'];