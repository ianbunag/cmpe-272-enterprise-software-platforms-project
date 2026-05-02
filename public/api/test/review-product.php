<?php
require_once __DIR__ . '/../../../src/index.php';

$seed = "2";

RatingService::submitReview(
    "313a62",
    UserService::getId() . $seed,
    UserService::getDisplayName() . $seed,
    5,
    "I really love how sturdy this desk feels because it does not wobble at all when I type. The assembly was very quick and I would definitely recommend it to anyone who needs a solid workspace."
);
