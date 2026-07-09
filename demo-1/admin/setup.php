<?php
// One-time setup: creates the database/tables and seeds them with the content
// that used to be hardcoded in index.html. Safe to re-run (CREATE ... IF NOT
// EXISTS + seed only when a table is empty).

// Only needed for local XAMPP, where the "spcinemas" database doesn't exist yet.
// On live/shared hosting the database is normally pre-created via the control panel
// (cPanel etc.) and the site's DB user usually lacks CREATE DATABASE privileges, so
// this is best-effort: if it fails, we just proceed straight to Dbconfig.php's
// connection, which should already point at an existing database.
try {
    $bootstrap = new PDO('mysql:host=127.0.0.1:3307', 'root', '');
    $bootstrap->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $bootstrap->exec("CREATE DATABASE IF NOT EXISTS spcinemas CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
} catch (PDOException $e) {
    // Ignore — expected on live hosting (see comment above).
}

require __DIR__ . '/Dbconfig.php'; // $connect (from Dbconfig.php) should now be able to select the database

$connect->exec("
CREATE TABLE IF NOT EXISTS banner_slides (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    link_url VARCHAR(255) NOT NULL DEFAULT '#',
    image VARCHAR(255) NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    status ENUM('enabled','disabled') NOT NULL DEFAULT 'enabled',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)");

$connect->exec("
CREATE TABLE IF NOT EXISTS team_members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    role VARCHAR(150) NOT NULL,
    bio TEXT NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    status ENUM('enabled','disabled') NOT NULL DEFAULT 'enabled',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)");

$connect->exec("
CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    category ENUM('branding','people','nature') NOT NULL,
    image VARCHAR(255) NOT NULL,
    link_url VARCHAR(255) NOT NULL DEFAULT '#',
    credits TEXT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    status ENUM('enabled','disabled') NOT NULL DEFAULT 'enabled',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)");

// Add the "synopsis" column to a projects table created before this field existed.
$has_synopsis_column = (int)$connect->query("
    SELECT COUNT(*) FROM information_schema.COLUMNS
    WHERE TABLE_SCHEMA = 'spcinemas' AND TABLE_NAME = 'projects' AND COLUMN_NAME = 'synopsis'
")->fetchColumn();
if ($has_synopsis_column === 0) {
    $connect->exec("ALTER TABLE projects ADD COLUMN synopsis TEXT NULL AFTER credits");
}

// Add the "mobile_image" column to a banner_slides table created before this field existed.
$has_mobile_image_column = (int)$connect->query("
    SELECT COUNT(*) FROM information_schema.COLUMNS
    WHERE TABLE_SCHEMA = 'spcinemas' AND TABLE_NAME = 'banner_slides' AND COLUMN_NAME = 'mobile_image'
")->fetchColumn();
if ($has_mobile_image_column === 0) {
    $connect->exec("ALTER TABLE banner_slides ADD COLUMN mobile_image VARCHAR(255) NULL AFTER image");
}

$connect->exec("
CREATE TABLE IF NOT EXISTS project_videos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    youtube_url VARCHAR(500) NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
)");

$connect->exec("
CREATE TABLE IF NOT EXISTS project_reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    publication VARCHAR(150) NOT NULL,
    review_url VARCHAR(500) NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
)");

echo "<p>Tables ready.</p>";

// --- Seed banner_slides (only if empty) ---
if ((int)$connect->query("SELECT COUNT(*) FROM banner_slides")->fetchColumn() === 0) {
    $banners = [
        ['Diesel', 'People', '#s', 'diesel.jpg'],
        ['The Village', 'Creative', '#', 'the-village.jpg'],
        ['Good Night', 'Nature', '#', 'good-night.jpg'],
        ['Payum<br> Puli', 'Branding', '#', 'payum-puli.jpg'],
        ['Vezham', 'People', '#', 'vezham.jpg'],
        ['Maara', 'Nature', '#', 'maara.jpg'],
        ['K-13', 'Nature', '#', 'k-13.jpg'],
        ['Baaram', 'Creative', '#', 'baaram.jpg'],
        ['Commercial', 'Creative', '#', 'kalyan-jewellers.jpg'],
    ];
    $stmt = $connect->prepare("INSERT INTO banner_slides (title, category, link_url, image, sort_order) VALUES (?, ?, ?, ?, ?)");
    foreach ($banners as $i => $b) {
        $stmt->execute([$b[0], $b[1], $b[2], $b[3], $i + 1]);
    }
    echo "<p>Seeded " . count($banners) . " banner slides.</p>";
}

// --- Seed team_members (only if empty) ---
if ((int)$connect->query("SELECT COUNT(*) FROM team_members")->fetchColumn() === 0) {
    $team = [
        ['SANKAR S.P', 'Managing Director', 'Sankar is a seasoned film professional with a deep understanding of the Movie Production Business. A product of the MGR Government Film and Television Institute, Chennai, Sankar started his career working for Aalayam and then shifted to acclaimed Director Mr. Manirathnam’s Production House Madras Talkies.He subsequently joined popular Television Production house Radaan Mediaworks (I) Ltd. run by actress Ms.RadhikaaSarathkumar to understand the nuances of the medium.Again he entered the world of cinema through Mirchi Movies (A Times Group Company) as Executive Producer and then with PVP Cinema, a leading name in the film industry in South India. Sankar has gone on to work on films like Irandam Ulagam, Naan Ee, Thozha/Oopiri etc. for PVP Cinema.'],
        ['KISHORE.S', 'Co - Producer', 'After his graduation in physics and an MBA in Marketing, Kishore went on to start his career in the FMCG space, before making a successful transition to the Media & Entertainment space. He has worked with prominent players in the field like Real Image Media Technologies and PVP Cinema over the last several years. With Real Image he has helped in developing the market for digital cinema in South India, playing a key role in making the Qube brand a success. At PVP Cinema he has gone on to handle distribution and marketing of their films like Irandam Ulagam, Naan Ee, Thozha/Oopiri, Kshanam etc and in the process he has built up an envious rapport in the trade which includes relationships with prominent producers, distributors, exhibitors in addition to creative personnel. Today Kishore is an independent distribution and marketing consultant for films.'],
        ['NAREN', 'Creative Producer', 'An MBA in MediaManagement (specialized in movie Marketing & event management) & B.E (Mechanical Engineering), Naren is a proactive, multi skilled marketing professional, offering a track record of over 5 years of rich experience in production, marketing and distribution of movies in Tamil & Telugu. He has planned and executed the media planning & global release of 15 movies in Tamil, Telugu and Hindi. He played a key role in marketing and operations of KBFC’s (Kerala Blasters Football Club) debut season at ISL and 100 years of Cinema Celebrations event.'],
        ['UDAYKUMAR.T', 'External Advisor', 'A Sound Engineer by profession working currently at Knack Studios. He started his career at Four Frames Mix Studio ( owned by Director Mr.Priyadarshan) and the brain behind sound designing/mixing of acclaimed films like Visaaranai, Vada Chennai and commercial movies like Kabali, VIP, Viswasam to name a few. Many movies are made on the editing Table but movies do get developed at the mixing stage too like including filling logical loopholes thanks to Uday’s expertise on commercial sensibilities.'],
        ['SETHUMADHAVAN.N', 'External Advisor', 'To sure calm much most long me mean. Able rent long in do we. Uncommonly no it announcing melancholy an in. Mirth learn it he given. Secure shy favour length all twenty denote. He felicity no an at packages answered opinions juvenile.'],
    ];
    $stmt = $connect->prepare("INSERT INTO team_members (name, role, bio, sort_order) VALUES (?, ?, ?, ?)");
    foreach ($team as $i => $t) {
        $stmt->execute([$t[0], $t[1], $t[2], $i + 1]);
    }
    echo "<p>Seeded " . count($team) . " team members.</p>";
}

// --- Seed projects (only if empty) ---
if ((int)$connect->query("SELECT COUNT(*) FROM projects")->fetchColumn() === 0) {
    $projects = [
        ['DIESEL', 'branding', 'films/s-diesel.jpg', '#s', "SP Cinemas Production"],
        ['GOOD NIGHT', 'branding', 'films/s-good-night.jpg', '#', "SP Cinemas"],
        ['PAAYUM OLI NEE YENAKKU', 'branding', 'films/s-payum-puli.jpg', '#', "SP Cinemas Worldwide Distribution"],
        ['VEZHAM', 'branding', 'films/s-vezham.jpg', '#', "SP Cinemas Worldwide Distribution"],
        ['OH MANA PENNE(Tamil)', 'branding', 'films/s-oh-manapenne.jpg', '#', "People"],
        ['MAARA', 'branding', 'films/s-maara.jpg', '#', "SP Cinemas Production"],
        ['BAARAM', 'branding', 'films/s-baaram.jpg', '#', "SP Cinemas Distribution"],
        ['K-13', 'branding', 'films/s-k13.jpg', '#', "SP Cinemas Production\nSP Cinemas Distribution"],
        ['PRODUCTION NO 8', 'people', 'web-series/s_series-prime.jpg', '#', null],
        ['PRODUCTION NO 7', 'people', 'web-series/s-applause.jpg', '#', null],
        ['THE VILLAGE', 'people', 'web-series/s-web-village.jpg', '#', null],
        ['KALYAN JEWELLERS', 'nature', 'web-series/s-kalyan-jewellers.jpg', '#', "SP Cinemas Production"],
    ];
    $stmt = $connect->prepare("INSERT INTO projects (title, category, image, link_url, credits, sort_order) VALUES (?, ?, ?, ?, ?, ?)");
    foreach ($projects as $i => $p) {
        $stmt->execute([$p[0], $p[1], $p[2], $p[3], $p[4], $i + 1]);
    }
    echo "<p>Seeded " . count($projects) . " projects.</p>";
}

// --- Seed project popup content: synopsis + videos + reviews (only if project_videos is empty) ---
// Migrated from the existing popups on spcinemas/index.html (matched by project title).
if ((int)$connect->query("SELECT COUNT(*) FROM project_videos")->fetchColumn() === 0) {
    $popup_content = [
        'DIESEL' => [
            'synopsis' => "The handsome hero Harish Kalyan who has won many hearts for his Rom-Coms and intense love stories will be now appearing as an action hero in his new bi-lingual film Diesel The film belongs to the genre of Love Action Drama directed by Shanmugam Muthusamy (GV Prakash starrer Adangathey fame). Athulya Ravi plays the female lead role and Vinay essays an important character. Dibu Ninan Thomas musical score is going to be one of the main highlights of this film. The film is a North Chennai-based gangster script in which Harish Kalyan is donning a full-fledged action hero for the first time in his filmography and will be seen in a rugged look.Currently in Post Production. Releasing Soon.",
            'videos' => [
                ['Diesel Glimpse', 'http://www.youtube.com/embed/SCRBECuHr34'],
                ['Diesel Song', 'http://www.youtube.com/embed/V8D5P04kZ_M'],
            ],
            'reviews' => [
                ['Wikipedia', 'https://en.wikipedia.org/wiki/Diesel_(2022_film)'],
            ],
        ],
        'GOOD NIGHT' => [
            'synopsis' => "Good Night is a 2023 Indian Tamil-language romantic comedy film written and directed by Vinayak Chandrasekaran. The film stars K. Manikandan and Meetha Raghunath in the lead roles with Ramesh Thilak, Raichal Rabecca, Balaji Sakthivel and Bagavathi Perumal portraying supporting roles",
            'videos' => [
                ['Trailer', 'http://www.youtube.com/embed/eLPePlnFoho'],
            ],
            'reviews' => [
                ['Wikipedia', 'https://en-m-wikipedia-org.translate.goog/wiki/Good_Night_(2023_film)?_x_tr_sl=en&_x_tr_tl=ta&_x_tr_hl=ta&_x_tr_pto=tc'],
                ['Times of India', 'https://timesofindia.indiatimes.com/entertainment/tamil/movie-reviews/good-night/movie-review/100151118.cms?from=mdr'],
                ['The Hindu', 'https://www.thehindu.com/entertainment/movies/good-night-movie-review-a-spectacular-manikandan-in-a-lovely-slice-of-life-drama/article66837671.ece'],
                ['Film Companion', 'https://www.filmcompanion.in/reviews/tamil-review/good-night-movie-review-manikandan-is-both-adorable-and-heart-rending-in-this-delightful-romcom-tamil-movie'],
            ],
        ],
        'PAAYUM OLI NEE YENAKKU' => [
            'synopsis' => "A man suffering with Nyctalopia tries to solve the mystery behind his uncle's death and uncover a sinister political conspiracy.",
            'videos' => [
                ['Official Teaser', 'http://www.youtube.com/embed/JomxZONGkPM'],
            ],
            'reviews' => [
                ['Wikipedia', 'https://en.wikipedia.org/wiki/Paayum_Oli_Nee_Yenakku'],
                ['OnlyKollywood', 'https://www.onlykollywood.com/paayum-oli-nee-yenakku-movie-review/'],
                ['News18', 'https://www.news18.com/movies/tamil-film-payum-oli-nee-enaku-wins-hearts-recommended-to-all-age-groups-8164525.html'],
            ],
        ],
        'VEZHAM' => [
            'synopsis' => "On the Nilgiris hills in the month of October 2014, series of murders occur which are very similar in nature. They are all brutal, iron rods used as a weapon to smash the head/face region of the victims and a X mark carved on the arms of each of them. The story revolves around whether Ashok is able to find the psycho killer and how he himself his pushed into a web of lies changing his entire life making him into a whole new person.",
            'videos' => [
                ['Official Trailer', 'http://www.youtube.com/embed/1qa_eqdROHE'],
            ],
            'reviews' => [
                ['Wikipedia', 'https://en.wikipedia.org/wiki/Vezham'],
                ['Times of India', 'http://timesofindia.indiatimes.com/entertainment/tamil/movie-reviews/vezham/movie-review/92440075.cms'],
                ['Cinema Express', 'http://www.cinemaexpress.com/tamil/review/2022/jun/24/vezham-movie-review-a-middling-thriller-with-a-pensive-ending-32312.html'],
                ['Behindwoods', 'http://www.behindwoods.com/tamil-movies/vezham/vezham-review.html'],
                ['24 News Daily', 'http://24newsdaily.com/vezham-tamil-movie-review/'],
            ],
        ],
        'OH MANA PENNE(Tamil)' => [
            'synopsis' => "A COMEDY DRAMA DIRECTED BY KAARTHIKK FEATURING HARISH KALYAN AND PRIYA BHAVANI SHANKAR IN THE LEAD ROLES. THE FILM REVOLVES AROUND A BOY AND A GIRL WHO MEET DURING A MATCH-MAKING AND HOW THEIR ASPIRATIONS BRING THEM TOGETHER FORMS THE REST OF THE STORY",
            'videos' => [
                ['Official Trailer', 'http://www.youtube.com/embed/1qa_eqdROHE'],
            ],
            'reviews' => [
                ['Wikipedia', 'https://en.wikipedia.org/wiki/Oh_Manapenne!'],
                ['The Indian Express', 'http://indianexpress.com/article/entertainment/movie-review/oh-manapenne-movie-review-this-remake-reminds-us-why-we-loved-pelli-choopulu-7585420/'],
                ['The Hindu', 'http://www.thehindu.com/entertainment/movies/oh-manapenne-review-harish-kalyan-priya-bhavani-shankar/article37125233.ece'],
                ['The New Indian Express', 'http://www.newindianexpress.com/entertainment/review/2021/oct/23/oh-manapenne-review-a-decent-remake-thatmisses-a-few-beats-2374560.html'],
                ['Times of India', 'http://timesofindia.indiatimes.com/web-series/reviews/tamil/oh-manapenne/ottmoviereview/87019422.cms'],
            ],
        ],
        'MAARA' => [
            'synopsis' => "Maara is an action drama starring Madhavan, Shraddha Srinath & others. Directed by Dhilip, the movie is official remake of Malayalam Superhit film Charlie. The movie was released as Amazon Prime Original and was critically acclaimed.",
            'videos' => [],
            'reviews' => [
                ['Wikipedia', 'http://en.m.wikipedia.org/wiki/Maara'],
                ['Times of India', 'http://timesofindia.indiatimes.com/entertainment/tamil/movie-reviews/maara/movie-review/80159468.cms'],
                ['Hindustan Times', 'http://www.hindustantimes.com/regional-movies/maara-movie-review-r-madhavan-stars-in-a-rare-remake-that-almost-eclipses-the-original/story-NNlnGO1wo9f8MH5hzjF7TL.html'],
                ['India Today', 'http://www.indiatoday.in/movies/reviews/story/maara-movie-review-madhavan-and-shraddha-srinath-dazzle-in-this-decent-remake-1756986-2021-01-08'],
                ['Behindwoods', 'http://www.behindwoods.com/tamil-movies/maara/maara-review.html'],
                ['IndiaGlitz', 'http://www.indiaglitz.com/maara-review-telugu-movie-23043'],
            ],
        ],
        'BAARAM' => [
            'synopsis' => "Karuppasamy, a widowed night watchman, lives with his sister and three nephews at a town in Tamil Nadu. One morning after returning from his shift, he breaks his hip in an accident. While his nephews want him to be treated in town, his son takes him to his ancestral village, to be healed by a traditional healer. Eight days later, Karuppasamy dies. His mysterious death gets one of his nephew Veera, an activist, suspicious and he starts to Investigate.",
            'videos' => [
                ['Official Trailer', 'http://www.youtube.com/embed/15JE_fxLHyY'],
            ],
            'reviews' => [
                ['Wikipedia', 'http://en.m.wikipedia.org/wiki/Baaram'],
                ['Times of India', 'http://timesofindia.indiatimes.com/entertainment/tamil/movie-reviews/baaram/movie-review/74177321.cms'],
                ['Hindustan Times', 'http://www.hindustantimes.com/regional-movies/baaram-movie-review-priya-krishnaswamy-s-film-is-a-shocking-take-on-parricide/story-sHhmgrSgNglX8POm2FB29J.html'],
                ['The Indian Express', 'http://indianexpress.com/article/entertainment/movie-review/baaram-movie-review-rating-6279893/'],
                ['IMDb', 'http://m.imdb.com/title/tt9277762/'],
            ],
        ],
        'K-13' => [
            'synopsis' => "Partying out with his friends on a night, a young man bumps in to a beautiful young woman. Both instantly like each other and flirts. As they set for their one night stand an unexpected incident occurs and soon life is not the same for both of them. K 13 is an edge of seat thriller starring Arulnithi & Shraddha Srinath in unique roles and its directed by Barath Neelakantan.",
            'videos' => [
                ['Official Trailer', 'http://www.youtube.com/embed/-uc0YFYYeCw'],
            ],
            'reviews' => [
                ['Wikipedia', 'http://en.m.wikipedia.org/wiki/K-13_(film)'],
                ['Times of India', 'http://timesofindia.indiatimes.com/entertainment/tamil/movie-details/k-13/movieshow/68461471.cms'],
                ['Hindustan Times', 'http://www.hindustantimes.com/regional-movies/k13-movie-review-shraddha-srinath-arulnithi-starrer-is-a-meta-thriller-with-solid-surprises/story-lsdlBhPXEXxiMdf5SsjADI.html'],
                ['Filmibeat', 'http://www.filmibeat.com/tamil/reviews/2019/k-13-movie-review-this-arulnithi-shraddha-srinath-starrer-punch-285576.html'],
                ['Behindwoods', 'http://www.behindwoods.com/tamil-movies/k13/k13-review.html'],
                ['Deccan Chronicle', 'http://www.deccanchronicle.com/entertainment/movie-reviews/040519/k-13-movie-review-captivating-thriller.html'],
                ['Movie Crow', 'http://www.moviecrow.com/News/23041/k13-movie-review'],
                ['IMDb', 'http://m.imdb.com/title/tt10275440/'],
            ],
        ],
        'PRODUCTION NO 8' => [
            'synopsis' => "An urban new age love story currently in development. Hitting floors soon.",
            'videos' => [],
            'reviews' => [],
        ],
        'PRODUCTION NO 7' => [
            'synopsis' => "A rooted Tamil web series line produced for Applause Entertainment.",
            'videos' => [],
            'reviews' => [],
        ],
        'THE VILLAGE' => [
            'synopsis' => "The absolute powerhouses of talent, Arya, in India's first show based on the graphic novel, The Village. Coming soon in Prime Video.\nDirected by Milind Rau,\nLine Production : SP Cinemas\nProduction Company : Studio Shakthi",
            'videos' => [],
            'reviews' => [],
        ],
        'KALYAN JEWELLERS' => [
            'synopsis' => "SP Cinemas produced a series of ads for KALYAN JEWELLERS in Tamil, Telugu & Kannanda celebrating the customs and traditions of the respective states featuring Regina Cassendra, was conceived and directed by Kaarthikk Sundar & Aruna Rakhee",
            'videos' => [
                ['Kalyan Muhurat Bride: The graceful Tamizh Manamagal', 'http://www.youtube.com/embed/KCf5jaUulw4'],
                ['Kalyan Jewellers Muhurat Bride: The stunning Telugu Vadhuvu', 'http://www.youtube.com/embed/MT3Jub-evqg'],
                ['Varamahalakshmi Vratam, bring home prosperity (Telugu)', 'http://www.youtube.com/embed/w0iBNL8B_6M'],
            ],
            'reviews' => [],
        ],
    ];

    $update_synopsis = $connect->prepare("UPDATE projects SET synopsis = ? WHERE title = ?");
    $insert_video = $connect->prepare("INSERT INTO project_videos (project_id, title, youtube_url, sort_order) VALUES (?, ?, ?, ?)");
    $insert_review = $connect->prepare("INSERT INTO project_reviews (project_id, publication, review_url, sort_order) VALUES (?, ?, ?, ?)");
    $find_project = $connect->prepare("SELECT id FROM projects WHERE title = ?");

    $seeded_count = 0;
    foreach ($popup_content as $title => $content) {
        $find_project->execute([$title]);
        $project_id = $find_project->fetchColumn();
        if (!$project_id) {
            continue; // no matching project row (shouldn't happen given the seed data above)
        }

        $update_synopsis->execute([$content['synopsis'], $title]);

        foreach ($content['videos'] as $i => $v) {
            $insert_video->execute([$project_id, $v[0], $v[1], $i + 1]);
        }
        foreach ($content['reviews'] as $i => $r) {
            $insert_review->execute([$project_id, $r[0], $r[1], $i + 1]);
        }
        $seeded_count++;
    }
    echo "<p>Seeded popup content (synopsis/videos/reviews) for $seeded_count projects.</p>";
}

echo "<p><strong>Setup complete.</strong> You can now <a href='login.php'>log in</a>.</p>";
