<div class="hl-listing-card hl-listing-card-1 hl-listing-card-1_hover">
    <div class="hl-listing-card-1__picture">
        <ul class="hl-listing-card-1__tags">
            <li class="hl-listing-card-1__tag-wrap">
                <a href="#" class="hl-listing-card-1__tag hl-listing-card-1__tag_green">Featured</a>
            </li>

            <li class="hl-listing-card-1__tag-wrap">
                <a href="#" class="hl-listing-card-1__tag hl-listing-card-1__tag_red">Rentals</a>
            </li>
        </ul>

        <div class="hl-listing-card-1__location">
            <span class="hl-listing-card-1__icon hl-listing-card-1__location-icon"></span>
            <a class="hl-listing-card-1__location-item" href="#">Shinjuku,</a>
            <a class="hl-listing-card-1__location-item" href="#">Tokyo</a>
        </div>

        <!--    <a class="hl-listing-card-1__picture-wrap-img" href="#">-->
        <!--      <picture class="hl-listing-card-1__picture-img-picture">-->
        <!--        <source src=" --><?php //echo $gallery[0]['sizes']['medium'] ?><!--" type="image/png">-->
        <!--        <img-->
        <!--          src="http://builder.local/wp-content/uploads/2020/05/birds-14.png"-->
        <!--          class="hl-listing-card-1__picture-img hl-img-responsive"-->
        <!--          alt=""-->
        <!--        >-->
        <!--      </picture>-->
        <!--    </a>-->

        <div class="hl-listing-card__carousel hl-listing-card-1__carousel">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php foreach ($gallery as $image) { ?>
                        <div class="swiper-slide hl-listing-card-1__carousel-item">
                            <a class="hl-listing-card-1__carousel-item-inner hl-listing-card-1__picture-wrap-img" href="#">
                                <img
                                        src="<?php echo  $image['sizes']['medium']; ?>"
                                        class="hl-listing-card-1__picture-img hl-img-responsive"
                                        title="<?php echo $image['title']; ?>"
                                        alt="<?php echo $image['alt']; ?>"
                                >
                            </a>
                        </div>
                    <?php } ?>
                </div>

                <button class="hl-listing-card__carousel-nav_prev hl-listing-card-1__carousel-nav hl-listing-card__carousel-nav">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6 1.41-1.41z"></path>
                        <path fill="none" d="M0 0h24v24H0V0z"></path>
                    </svg>
                </button>

                <button class="hl-listing-card__carousel-nav_next hl-listing-card-1__carousel-nav hl-listing-card__carousel-nav">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"></path>
                        <path fill="none" d="M0 0h24v24H0V0z"></path>
                    </svg>
                </button>
            </div>
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
        </ul>
    </div>

    <div class="hl-listing-card-1__bottom mt-auto">
        <div class="hl-listing-card-1__bottom-inner">
            <a href="#" class="hl-listing-card-1__agent">
                <img
                        src="https://tokyowpresidence.b-cdn.net/wp-content/uploads/2014/05/agent3-1-19-120x120.jpg"
                        class="hl-listing-card-1__agent-img hl-img-responsive"
                        alt=""
                >
                <span class="hl-listing-card-1__agent-name">Janet Richmond</span>
            </a>
        </div>
    </div>
</div>

