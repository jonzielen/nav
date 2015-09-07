<?php
    function replaceChar($text) {
        $replace = [];
        // $replace[0] = '/\//';
        // $replace[1] = '/\(.*?\)/';

        $replacement = [];
        // $replacement[0] = '-';
        // $replacement[1] = '';

        $text = preg_replace($replace, $replacement, $text);

        if (substr($text, -1) == ' ') {
            return rtrim($text, ' ');
        } else {
            return $text;
        }
    }

    function urlFix($title) {
        $title = replaceChar($title);
        return str_replace(' ', '-', strtolower($title));
    }

    function linkReplace($url, $text) {
        return '<a href="'.urlFix($url).'">'.$text.'</a>';
    }

    $nav = [
        'Things to Do' => [
            'Music' => [
                'Music Calendar',
                'Music Listings'
            ],
            'Film' => [
                'Film Listings',
                'Film Calendar'
            ],
            'Events' => [
                'Annual Events',
                'Events Calendar',
                'Browse Evens by Category'
            ],
            'Attractions' => [
                'Browse Attractions',
                'TV Tapings'
            ],
            'Tours' => [
                'Bus Tours',
                'Itineraries',
                'Browse Tours'
            ],
            'Prefroming Arts' => [
                'Browse Prefroming Arts',
                'Broadway' => [
                    'Broadway Week',
                    'Browse Broadways Shows'
                ],
                'Off Broadway' => [
                    'Off Broadway Week',
                    'Browse Off Broadway Shows'
                ],
                'All Theater'
            ],
            'Museums and Galleries' => [
                'Museums and Galleries Listings',
                'Museums and Galleries Calendar'
            ],
            'Shopping and Fashion' => [
                'Shopping Listings',
                'Shopping and Fashion Calendar'
            ],
            'Dining' => [
                'Dining Listings',
                'Dining Calendar',
                'Restauant Week',
                'Recently Opened Restaurants'
            ],
            'Nightlife' => [
                'Nightlife Listings',
                'Nightlife Calendar',
                'Comedy Week'
            ],
            'Member Deals',
            'Tickets and Passes' => [
                'Attraction Passes',
                'Broadway Listings',
                'Tours and Attractions Listings'
            ],
            'Sports' => [
                'Sports by Category',
                'Sports Listings',
                'Sports Calendar'
            ],
            'Outdoors and Recreation' => [
                'Outdoors and Recreation Listings',
                'Outdoors and Recreation Calendar',
                'Fitness'
            ],
            'Spas and Salons'
        ],
        'Where to Stay' => [
            'Hotels' => [
                'Hotels Search' => [
                    'Hotels by Category',
                    'Hotels by Borough/Neighborhood'
                ],
                'Hotel Collections'
            ],
            'Niche Accommodations'
        ],
        'Visitor Information' => [
            'Guides and Tips' => [
                'Accessibility',
                'Internet Access',
                'Official Info Centers (ONICs)',
                'Transportation',
                'Weather/Climate',
                'Bathrooms',
                'Tipping/Customs',
                'Weddings'
            ],
            'Maps/Guides' => [
                'External/Offline Maps',
                'Official Guides (OVG)'
            ],
            'Services' => [
                'Venue Listings'
            ]
        ],
        'Interests/Lenses' => [
            'NYC History',
            'Neighborhoods & Boroughs' => [
                'Brooklyn' => [
                    'Trip Ideas/Editorial by Borough/Neighborhood',
                    'Hotels by Borough/Neighborhood',
                    'Restaurants by Borough/Neighborhood',
                    'Attractions by Borough/Neighborhood',
                    'Events by Borough/Neighborhood',
                    'Neighborhood Pages'
                ],
                'Queens' => [
                    'Trip Ideas/Editorial by Borough/Neighborhood',
                    'Hotels by Borough/Neighborhood',
                    'Restaurants by Borough/Neighborhood',
                    'Attractions by Borough/Neighborhood',
                    'Events by Borough/Neighborhood',
                    'Neighborhood Pages'
                ],
                'Manhattan' => [
                    'Trip Ideas/Editorial by Borough/Neighborhood',
                    'Hotels by Borough/Neighborhood',
                    'Restaurants by Borough/Neighborhood',
                    'Attractions by Borough/Neighborhood',
                    'Events by Borough/Neighborhood',
                    'Neighborhood Pages'
                ],
                'Staten Island' => [
                    'Trip Ideas/Editorial by Borough/Neighborhood',
                    'Hotels by Borough/Neighborhood',
                    'Restaurants by Borough/Neighborhood',
                    'Attractions by Borough/Neighborhood',
                    'Events by Borough/Neighborhood',
                    'Neighborhood Pages'
                ],
                'The Bronx' => [
                    'Trip Ideas/Editorial by Borough/Neighborhood',
                    'Hotels by Borough/Neighborhood',
                    'Restaurants by Borough/Neighborhood',
                    'Attractions by Borough/Neighborhood',
                    'Events by Borough/Neighborhood',
                    'Neighborhood Pages'
                ],
                'See Your City'
            ],
            'Seasonal' => [
                'Spring' => [
                    'Spring Holidays'
                ],
                'Summer' => [
                    'Summer Holidays'
                ],
                'Fall' => [
                    'Fall Holidays'
                ],
                'Winter' => [
                    'Winter Holidays'
                ],
            ],
            'Miscellaneous',
            'Personal Recommendations' => [
                'Celebrity Interviews',
                'Third-party Roundups'
            ],
            'Itineraries',
            'Videos' => [
                'Video by Category'
            ],
            'Free in NYC',
            'Personalized Categories' => [
                'On a Budget',
                'Best-Sellers',
                'Trending Now',
                'LGBT',
                'Family Friendly',
                'First-time Visitor/NYC 101',
                'Classic NYC',
                'Cultural NYC'
            ]
        ]
    ];

    function loopArray($baseUrl, $navVal) {
        foreach ($navVal as $key => $value) {
            if (is_string($key)) {
                $baseUrl .= $key.'/';
                echo '<li>'.linkReplace($baseUrl.$key, $key).'</li>';
            }

            if (is_numeric($key)) {
                echo '<li>'.linkReplace($baseUrl.$value, $value).'</li>';
            }

            if (is_array($value)) {
                echo '<ul>';
                loopArray($baseUrl, $value);
                echo '</ul>';
                $baseUrl = '';
            }
        }
    }

    function parseNav($nav) {
        echo '<ul>';
        loopArray('', $nav);
        echo '</ul>';
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>test nav</title>
    </head>
    <body>
        <header>
            <nav>
                <?php parseNav($nav); ?>
            </nav>
        </header>

        <script>
            var a = document.getElementsByTagName("A");

            for (var i = 0; i < a.length; i++) {
                a[i].addEventListener("click", function(event, index){
                    event.preventDefault();
                    console.log(this.getAttribute('href'));
                });
            }
        </script>
    </body>
</html>
