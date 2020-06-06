<?php

//gallery of the post
foreach ($gallery as $image) {
    echo $image['title'];
    echo $image['url'];
    echo $image['alt'];
//    url for different sizes
    echo $image['sizes']['thumbnail'];
    echo $image['sizes']['medium'];
    echo $image['sizes']['medium_large'];
    echo $image['sizes']['large'];

}

