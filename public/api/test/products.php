<?php
header('Content-Type: application/json');
$data = json_encode([
    [
        'id' => '1',
        'name' => 'Europe Tour',
        'price' => '$2,499',
        'description' => 'Explore Paris, Rome, and London in one unforgettable journey.',
        'imageUrl' => 'https://images.unsplash.com/photo-1467269204594-9661b134dd2b',
        'url' => 'https://mulugetagirmay.com/hw/product.php?name=Europe%20Tour'
    ],
    [
        'id' => '2',
        'name' => 'Family Vacation',
        'price' => '$1,599',
        'description' => 'Fun for the whole family.',
        'imageUrl' => 'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429',
        'url' => 'https://mulugetagirmay.com/hw/product.php?name=Family%20Vacation'
    ],
    [
        'id' => 'a',
        'name' => 'Competitive Coaching',
        'price' => '$120/session, $600/month',
        'description' => 'Competitive archery demands more than good form — it requires mental toughness, tactical preparation, and the ability to perform under pressure. Our competitive coaching program is designed for archers targeting podium finishes at local, regional, state, and national tournaments.
        
Our head coach analyzes your shot cycle through video review, identifies the specific technical and mental barriers limiting your score, and builds a training plan to break through them. Athletes in this program train at competition distances with simulated tournament conditions to build the pressure tolerance that wins.',
        'imageUrl' => 'https://fastly.picsum.photos/id/516/800/420.jpg?hmac=FpZ2PHASX6lfO1BTXLV6QXoHqBFVszX8vgckK85XkHw',
        'url' => 'http://brandonr.xyz/product_competitive.php'
    ],
    [
        'id' => 'b',
        'name' => 'Compound Bows',
        'price' => '$300 – $1,800',
        'description' => 'The compound bow uses a system of cams and cables to provide a mechanical advantage, dramatically reducing the holding weight at full draw — a feature called "let-off." This lets you hold at full draw longer for a more precise aim without muscular fatigue.

We stock compound bows for target archery, 3D shooting, and hunting applications. Adjustable draw length and draw weight settings mean most compound bows can grow with an archer for years. Our technicians will set up your bow to your exact specifications before you leave the shop.',
        'imageUrl' => 'https://fastly.picsum.photos/id/699/800/420.jpg?hmac=67-MdDGF6NkUu3lNHpI3s1P2eJv9qnozOaN6qwGKKAk',
        'url' => 'http://brandonr.xyz/product_compound.php'
    ],
    [
        'id' => '1a',
        'name' => 'Blue Java (Hawaii)',
        'price' => '$4.99 per lb',
        'description' => 'Creamy vanilla ice cream flavor with a smooth, sweet finish',
        'imageUrl' => 'https://cdn.cmpe-272.ianbunag.dev/banana-buoy/products/blue-java.webp',
        'url' => 'https://cmpe-272.ianbunag.dev/banana-buoy/products/1'
    ],
    [
        'id' => '2b',
        'name' => 'Burro (Mexico)',
        'price' => '$4.49 per lb',
        'description' => 'Tangy lemon flavor when unripe, sweet when ripe',
        'imageUrl' => 'https://cdn.cmpe-272.ianbunag.dev/banana-buoy/products/burro.webp',
        'url' => 'https://cmpe-272.ianbunag.dev/banana-buoy/products/6'
    ]
], JSON_PRETTY_PRINT);

echo $data;
