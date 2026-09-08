-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 07, 2026 at 08:49 PM
-- Server version: 10.11.18-MariaDB-cll-lve
-- PHP Version: 8.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spcinemas`
--

-- --------------------------------------------------------

--
-- Table structure for table `banner_slides`
--

CREATE TABLE `banner_slides` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `link_url` varchar(255) NOT NULL DEFAULT '#',
  `image` varchar(255) NOT NULL,
  `mobile_image` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `status` enum('enabled','disabled') NOT NULL DEFAULT 'enabled',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banner_slides`
--

INSERT INTO `banner_slides` (`id`, `title`, `category`, `link_url`, `image`, `mobile_image`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(1, '', '  ', '#s', 'diesel.jpg', '500x750_Diesel_237539_d3921aa4-fa5a-4e37-84b6-fdbd23867cfe.jpg', 5, 'enabled', '2026-07-08 10:45:54', '2026-09-07 14:36:58'),
(2, '', ' ', '#', 'the-village.jpg', 'MV5BNDY3NzlkNzgtZTJmMi00ODE5LWIwZjItNTY4NzNlMzA3NmFlXkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg', 6, 'enabled', '2026-07-08 10:45:54', '2026-09-07 14:58:29'),
(3, '', ' ', '#', 'good-night.jpg', 'MV5BMTI2NTFhZjUtMjM1Mi00ZGU0LWI3MTQtNjU0MzYzNGFhODYwXkEyXkFqcGc@._V1_.jpg', 7, 'enabled', '2026-07-08 10:45:54', '2026-09-07 14:58:29'),
(4, '', '', '#', 'payumoli.jpg', 'py00.png', 4, 'enabled', '2026-07-08 10:45:54', '2026-09-07 14:57:06'),
(5, '', ' ', '#', 'vezham.jpg', 'images.jpg', 8, 'enabled', '2026-07-08 10:45:54', '2026-09-07 14:58:31'),
(6, '', ' ', '#', 'maara.jpg', '7d070df4f308b112b87f4d6679c3da45605de9842e3ad5c559e10ded6d53ef6b-317856970.jpg', 9, 'enabled', '2026-07-08 10:45:54', '2026-09-07 14:58:32'),
(7, '', ' ', '#', 'k-13.jpg', 'k-13.jpg', 10, 'enabled', '2026-07-08 10:45:54', '2026-09-07 14:58:34'),
(8, '', ' ', '#', 'baaram.jpg', 'MV5BNjA1YWE2YTAtMjdhYi00YmI5LWIzNzYtY2E5MWFlOWVkMzIxXkEyXkFqcGc@._V1_.jpg', 11, 'enabled', '2026-07-08 10:45:54', '2026-09-07 14:58:36'),
(9, '', ' ', '#', 'kalyan-jewellers.jpg', 'e0e74d53-924c-4a48-ad35-03024dcbaa28_rw_1200.jpg', 12, 'enabled', '2026-07-08 10:45:54', '2026-09-07 14:58:37'),
(11, '', ' ', '#', '100-2.jpg', 'MV5BNzViYjkyYTItOGU4Zi00MDVjLWFmZDAtNmEyZTQ4YmJmOGFkXkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg', 2, 'enabled', '2026-07-25 08:41:27', '2026-09-07 14:33:53'),
(12, '', '', '#', 'sp-con.jpg', 'con01.jpg', 1, 'enabled', '2026-09-07 14:27:40', '2026-09-07 14:33:53'),
(13, '', '', '#', 'with-love.jpg', '1111.jpg', 3, 'enabled', '2026-09-07 14:33:05', '2026-09-07 14:33:49');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` enum('branding','people','nature') NOT NULL,
  `image` varchar(255) NOT NULL,
  `link_url` varchar(255) NOT NULL DEFAULT '#',
  `credits` text DEFAULT NULL,
  `synopsis` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `status` enum('enabled','disabled') NOT NULL DEFAULT 'enabled',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `title`, `category`, `image`, `link_url`, `credits`, `synopsis`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'DIESEL', 'branding', 'films/s-diesel.jpg', '#s', 'Production & Kerala Theatrical Distribution', 'Set along the coast of Tamil Nadu, the film follows Vasu, whose community has been affected by an unregulated diesel and crude oil mafia. Raised by a mentor figure who fights for justice on behalf of local fishermen, Vasu gets pulled into a dangerous scheme to reclaim what has been taken from them. As rival factions and adulterated oil trades complicate matters, an uneasy alliance turns into a fight for survival.', 5, 'enabled', '2026-07-08 10:45:55', '2026-09-04 05:08:28'),
(2, 'Good Night', 'branding', 'gn.jpg', '#', 'Pan India Theatrical distribution except Tamilnadu & Karnataka', 'Mohan, a mild-mannered IT employee, struggles with a severe snoring problem that threatens his relationships and self-confidence. When he meets Anu, a warm and understanding woman, the two begin to grow close even as his condition creates awkward and painful situations. The film follows Mohan\'s journey toward addressing his problem while navigating family expectations and new love.', 6, 'enabled', '2026-07-08 10:45:55', '2026-09-07 14:01:46'),
(3, 'Paayum Oli Nee Yenakku', 'branding', 'po-1.jpg', '#', 'Worldwide Theatrical & Non-Theatrical Distribution', 'Aravind, an entrepreneur who runs a data-security firm, lives with partial low-light blindness stemming from a childhood accident. When tragedy strikes his family, he sets out to uncover the people responsible, relying largely on sound and instinct due to his impairment. His investigation soon uncovers a wider conspiracy that puts both his life and his budding romance at risk.', 7, 'enabled', '2026-07-08 10:45:55', '2026-09-07 11:10:36'),
(4, 'Vezham', 'branding', 'films/s-vezham.jpg', '#', 'Worldwide Theatrical Distribution', 'Years after surviving a brutal attack in the Nilgiri hills that claimed the life of someone close to him, Ashok remains haunted by the trauma. Driven to find the person responsible using only fragments of memory and a voice as a clue, he returns to the hills to reopen the case. His search draws him into a web of secrets tied to the original attack.', 8, 'enabled', '2026-07-08 10:45:55', '2026-09-04 05:40:57'),
(5, 'Oh Manapenne!', 'branding', 'omp.jpg', '#', 'Production', 'Karthik, a carefree and directionless engineering graduate, is set up on an arranged-marriage meeting with Shruthi, an ambitious young woman with a gold medal and plans to study abroad. A twist of fate leaves the two stuck together, and they end up bonding over their very different outlooks on life. What begins as a chance encounter turns into a partnership that challenges both of their assumptions about love and ambition.', 9, 'enabled', '2026-07-08 10:45:55', '2026-09-07 14:03:53'),
(6, 'Maara', 'branding', 'films/s-maara.jpg', '#', 'Production', 'When architect Paaru moves to a small coastal town for a restoration project, she discovers the walls of the village are covered in illustrations of a fairy tale she heard as a child. Determined to find the artist behind the paintings, she begins searching for a mysterious man named Maara. Her journey leads her through the intertwined stories of several people whose lives Maara has touched.', 10, 'enabled', '2026-07-08 10:45:55', '2026-09-04 05:45:18'),
(7, 'Baaram', 'branding', 'films/s-baaram.jpg', '#', 'Pan India Theatrical Distribution', 'Karuppasamy, a watchman, lives with his sister and her family in a small Tamil Nadu town. After a hit-and-run accident leaves him badly injured, his family is divided over how best to care for him, and eight days later he dies under circumstances that raise questions. The film follows the family and community as they grapple with grief, suspicion, and old traditions surrounding how the elderly are cared for.', 11, 'enabled', '2026-07-08 10:45:55', '2026-09-04 05:48:59'),
(8, 'K13', 'branding', 'k-13.jpg', '#', 'Production & Worldwide Distribution', 'Aspiring filmmaker Madhiazhagan wakes up in an apartment to find the woman he spent the previous night with lying dead beside him. With circumstances stacked against him and few options for proving his innocence, he must piece together the events of the night to figure out what really happened. The story unfolds largely within a single location as the mystery surrounding the death deepens.', 12, 'enabled', '2026-07-08 10:45:55', '2026-09-07 14:14:05'),
(9, 'PRODUCTION NO 8', 'people', 'web-series/s_series-prime.jpg', '#', NULL, 'An urban new age love story currently in development. Hitting floors soon.', 13, 'disabled', '2026-07-08 10:45:55', '2026-07-25 08:44:43'),
(10, 'PRODUCTION', 'people', 'web-series/s-applause.jpg', '#', '   ', 'A rooted Tamil web series line produced for Applause Entertainment.', 17, 'enabled', '2026-07-08 10:45:55', '2026-09-07 14:46:06'),
(11, 'THE VILLAGE', 'people', 'web-series/s-web-village.jpg', '#', 'Line Production', 'In the desolate hinterlands of Tamil Nadu, a stranded urbanite enlists the help of three locals to find his missing family believed to have been abducted by nefarious beings of a cursed village. Meanwhile, a maniacal heir to a pharma empire sends a group of mercenaries to the same village to retrieve something long forgotten. Will they come out of this terror-stricken night alive?', 14, 'enabled', '2026-07-08 10:45:55', '2026-09-07 14:46:06'),
(12, 'KALYAN JEWELLERS', 'nature', 'web-series/s-kalyan-jewellers.jpg', '#', 'Production', 'SP Cinemas produced a series of ads for KALYAN JEWELLERS in Tamil, Telugu & Kannanda celebrating the customs and traditions of the respective states featuring Regina Cassendra, was conceived and directed by Kaarthikk Sundar & Aruna Rakhee', 18, 'enabled', '2026-07-08 10:45:55', '2026-09-07 02:10:01'),
(15, 'Boonie Bears: The Hidden Protector', 'branding', 'boni.jpg', '#', 'North India Theatrical Distribution', 'Forest friends Briar, Bramble and their companion Vick encounter the legendary Year Monster, Nian, who grants them mysterious elemental powers. The gift upends their dynamic, as Briar struggles with no longer being the strongest of the trio. Transported into the magical realm of Eve City, the group must master their new abilities to stop a growing threat that endangers both the human and immortal worlds.', 2, 'enabled', '2026-07-25 06:56:08', '2026-09-07 13:51:03'),
(16, 'With Love', 'branding', 'sp-project-img.jpg', '#', 'North India Theatrical Distribution', 'Sathya reluctantly agrees to a blind date arranged by his sister and meets Monisha, an influencer, only to discover the two once attended the same school. As they swap stories of forgotten school-day crushes, they hatch a plan to track down their old flames. Their search for the past ends up drawing them closer to each other in the present.', 4, 'enabled', '2026-07-25 08:16:31', '2026-09-08 03:27:01'),
(17, 'Nooru Saami', 'branding', '100-1-820254468.jpg', '#', 'North India Theatrical Distribution', 'Selvi, a young widow in a conservative rural village, devotes herself to raising her two sons after the loss of her husband, enduring hardship and social stigma along the way. Years later, she is encouraged to consider remarriage, a suggestion her elder son fiercely resists. The resulting rift tests the family\'s bonds as each member confronts long-held ideas about sacrifice, tradition, and happiness.', 3, 'enabled', '2026-07-25 08:18:36', '2026-09-07 10:53:30'),
(18, 'Con City', 'branding', 'con--1.jpg', '#', 'North India Theatrical Distribution', 'A married couple running a small mess in a town near Mangalore turn to petty cons and schemes to survive mounting financial troubles, teaming up with a mother-son duo who dream of hitting it big. As they navigate loan sharks and small-time frauds, their partnership evolves into an unlikely found family. The film blends comedy with the tension of staying one step ahead of getting caught.', 1, 'enabled', '2026-07-25 08:20:12', '2026-09-08 03:33:52'),
(19, 'ORU VADAKKAN VEERAGATHA', 'branding', 'images (1).jpg', '#', 'Pan India Theatrical Distribution except Kerala', 'Chandu, an orphan, is looked after by his uncle. But his cousin Aromal is jealous of him as he is very quick in learning. The two boys grow up to be rivals, which trigger an unexpected turn of events', 15, 'enabled', '2026-09-04 06:19:49', '2026-09-07 14:46:06'),
(20, 'ORU ANWESHANATHINTE THUDAKKAM', 'branding', 'mal.jpg', '#', 'Pan India Theatrical Distribution except Kerala', 'In Kerala, an investigating journalist disappears without notice. Media and public stunned. Investigation uncovers shocking, unexpected mysteries. Suspenseful plot follows the case\'s twists and revelations.', 16, 'enabled', '2026-09-04 06:22:24', '2026-09-07 14:46:06');

-- --------------------------------------------------------

--
-- Table structure for table `project_reviews`
--

CREATE TABLE `project_reviews` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `publication` varchar(150) NOT NULL,
  `review_url` varchar(500) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_reviews`
--

INSERT INTO `project_reviews` (`id`, `project_id`, `publication`, `review_url`, `logo`, `sort_order`) VALUES
(177, 4, 'Wikipedia', 'https://en.wikipedia.org/wiki/Vezham', NULL, 1),
(178, 4, 'Times of India', 'http://timesofindia.indiatimes.com/entertainment/tamil/movie-reviews/vezham/movie-review/92440075.cms', NULL, 2),
(179, 4, 'Cinema Express', 'http://www.cinemaexpress.com/tamil/review/2022/jun/24/vezham-movie-review-a-middling-thriller-with-a-pensive-ending-32312.html', NULL, 3),
(180, 4, 'Behindwoods', 'http://www.behindwoods.com/tamil-movies/vezham/vezham-review.html', NULL, 4),
(181, 4, '24 News Daily', 'http://24newsdaily.com/vezham-tamil-movie-review/', NULL, 5),
(182, 4, 'indiaherald', 'https://www.indiaherald.com/Breaking/Read/994518105/Vezham-Tamil-Movie-Review-A-Dull-and-Boring-Revenge-Drama', NULL, 6),
(190, 6, 'Wikipedia', 'http://en.m.wikipedia.org/wiki/Maara', NULL, 1),
(191, 6, 'Times of India', 'http://timesofindia.indiatimes.com/entertainment/tamil/movie-reviews/maara/movie-review/80159468.cms', NULL, 2),
(192, 6, 'Hindustan Times', 'http://www.hindustantimes.com/regional-movies/maara-movie-review-r-madhavan-stars-in-a-rare-remake-that-almost-eclipses-the-original/story-NNlnGO1wo9f8MH5hzjF7TL.html', NULL, 3),
(193, 6, 'India Today', 'http://www.indiatoday.in/movies/reviews/story/maara-movie-review-madhavan-and-shraddha-srinath-dazzle-in-this-decent-remake-1756986-2021-01-08', NULL, 4),
(194, 6, 'Behindwoods', 'http://www.behindwoods.com/tamil-movies/maara/maara-review.html', NULL, 5),
(195, 6, 'IndiaGlitz', 'http://www.indiaglitz.com/maara-review-telugu-movie-23043', NULL, 6),
(196, 6, 'Gulf News', 'https://gulfnews.com/amp/entertainment/south-indian/maara-film-review-r-madhavan-led-movie-is-visually-striking-but-flawed-1.76374944', NULL, 7),
(197, 7, 'Wikipedia', 'http://en.m.wikipedia.org/wiki/Baaram', NULL, 1),
(198, 7, 'Times of India', 'http://timesofindia.indiatimes.com/entertainment/tamil/movie-reviews/baaram/movie-review/74177321.cms', NULL, 2),
(199, 7, 'Hindustan Times', 'http://www.hindustantimes.com/regional-movies/baaram-movie-review-priya-krishnaswamy-s-film-is-a-shocking-take-on-parricide/story-sHhmgrSgNglX8POm2FB29J.html', NULL, 3),
(200, 7, 'The Indian Express', 'http://indianexpress.com/article/entertainment/movie-review/baaram-movie-review-rating-6279893/', NULL, 4),
(201, 7, 'IMDb', 'http://m.imdb.com/title/tt9277762/', NULL, 5),
(230, 1, 'Wikipedia', 'https://en.wikipedia.org/wiki/Diesel_(2025_film)', NULL, 1),
(231, 1, 'Hollywoodreporterindia', 'https://www.hollywoodreporterindia.com/reviews/theatrical/diesel-movie-review-harish-kalyan-anchors-a-lost-lazy-film', NULL, 2),
(232, 1, 'indiaherald', 'https://www.indiaherald.com/Breaking/Read/994855248/Diesel-Tamil-Movie-Review-Fires-Up-The-Engine-But-Runs-Out-Of-Fuel-Midway', NULL, 3),
(233, 1, 'Hollywoodreporterindia', 'https://www.hollywoodreporterindia.com/reviews/theatrical/diesel-movie-review-harish-kalyan-anchors-a-lost-lazy-film', NULL, 4),
(234, 1, 'Indiaherald', 'https://www.indiaherald.com/Breaking/Read/994855248/Diesel-Tamil-Movie-Review-Fires-Up-The-Engine-But-Runs-Out-Of-Fuel-Midway', NULL, 5),
(235, 19, 'Wikipedia', 'https://en.wikipedia.org/wiki/Oru_Vadakkan_Veeragatha', NULL, 1),
(236, 19, 'drummersdiaries', 'https://drummersdiaries.blogspot.com/2023/12/oru-vadakkan-veeragadha.html', NULL, 2),
(241, 11, 'Wikipedia', 'https://en.wikipedia.org/wiki/The_Village_(2023_TV_series)', NULL, 1),
(242, 11, 'Newindianexpress', 'https://www.newindianexpress.com/entertainment/review/2023/Nov/24/the-village-series-review-lifeless-storytelling-digs-the-grave-for-this-gory-and-germane-tale-2635862.html', NULL, 2),
(258, 17, 'Wikipedia', 'https://en.wikipedia.org/wiki/Nooru_Saami', NULL, 1),
(259, 17, 'indian Community', 'https://indian.community/nooru-saami-movie-review/ https://sudhir-srinivasan.com/2026/06/19/nooru-sami-movie-review-the-woman-in-the-mirror/', NULL, 2),
(260, 17, 'Sudhir Srinivasan', 'https://sudhir-srinivasan.com/2026/06/19/nooru-sami-movie-review-the-woman-in-the-mirror/', NULL, 3),
(261, 3, 'Wikipedia', 'https://en.wikipedia.org/wiki/Paayum_Oli_Nee_Yenakku', NULL, 1),
(262, 3, 'OnlyKollywood', 'https://www.onlykollywood.com/paayum-oli-nee-yenakku-movie-review/', NULL, 2),
(263, 3, 'News18', 'https://www.news18.com/movies/tamil-film-payum-oli-nee-enaku-wins-hearts-recommended-to-all-age-groups-8164525.html', NULL, 3),
(264, 3, 'thesouthfirst', 'https://thesouthfirst.com/entertainment/paayum-oli-nee-yenakku-review-a-crisp-thriller-that-keeps-your-attention-span-in-mind/', NULL, 4),
(265, 15, 'Wikipedia', 'https://en.wikipedia.org/wiki/Boonie_Bears:_The_Hidden_Protector', NULL, 1),
(266, 15, 'Firstshowz', 'https://www.firstshowz.com/2026/06/boonie-bears-the-hidden-protector-movie-review-and-rating.html', NULL, 2),
(267, 15, 'Global Newsmakers', 'https://globalnewsmakers.in/boonie-bears-the-hidden-protector-review-2026/', NULL, 3),
(268, 2, 'Wikipedia', 'https://en.wikipedia.org/wiki/Good_Night_(2023_film)', NULL, 1),
(269, 2, 'Times of India', 'https://timesofindia.indiatimes.com/entertainment/tamil/movie-reviews/good-night/movie-review/100151118.cms?from=mdr', NULL, 2),
(270, 2, 'The Hindu', 'https://www.thehindu.com/entertainment/movies/good-night-movie-review-a-spectacular-manikandan-in-a-lovely-slice-of-life-drama/article66837671.ece', NULL, 3),
(271, 2, 'Film Companion', 'https://www.filmcompanion.in/reviews/tamil-review/good-night-movie-review-manikandan-is-both-adorable-and-heart-rending-in-this-delightful-romcom-tamil-movie', NULL, 4),
(272, 2, '123telugu', 'https://www.123telugu.com/reviews/good-night-tamil-movie-review.html', NULL, 5),
(273, 5, 'Wikipedia', 'https://en.wikipedia.org/wiki/Oh_Manapenne!', NULL, 1),
(274, 5, 'The Indian Express', 'http://indianexpress.com/article/entertainment/movie-review/oh-manapenne-movie-review-this-remake-reminds-us-why-we-loved-pelli-choopulu-7585420/', NULL, 2),
(275, 5, 'The Hindu', 'http://www.thehindu.com/entertainment/movies/oh-manapenne-review-harish-kalyan-priya-bhavani-shankar/article37125233.ece', NULL, 3),
(276, 5, 'The New Indian Express', 'http://www.newindianexpress.com/entertainment/review/2021/oct/23/oh-manapenne-review-a-decent-remake-thatmisses-a-few-beats-2374560.html', NULL, 4),
(277, 5, 'Times of India', 'http://timesofindia.indiatimes.com/web-series/reviews/tamil/oh-manapenne/ottmoviereview/87019422.cms', NULL, 5),
(278, 5, 'Behindwoods', 'https://www.behindwoods.com/tamil-movies/oh-manapenne/oh-manapenne-review.html', NULL, 6),
(279, 5, 'IndiaGlitz', 'https://www.indiaglitz.com/oh-manapenne-review-tamil-movie-24260', NULL, 7),
(280, 8, 'Wikipedia', 'http://en.m.wikipedia.org/wiki/K-13_(film)', NULL, 1),
(281, 8, 'Times of India', 'http://timesofindia.indiatimes.com/entertainment/tamil/movie-details/k-13/movieshow/68461471.cms', NULL, 2),
(282, 8, 'Hindustan Times', 'http://www.hindustantimes.com/regional-movies/k13-movie-review-shraddha-srinath-arulnithi-starrer-is-a-meta-thriller-with-solid-surprises/story-lsdlBhPXEXxiMdf5SsjADI.html', NULL, 3),
(283, 8, 'Filmibeat', 'http://www.filmibeat.com/tamil/reviews/2019/k-13-movie-review-this-arulnithi-shraddha-srinath-starrer-punch-285576.html', NULL, 4),
(284, 8, 'Behindwoods', 'http://www.behindwoods.com/tamil-movies/k13/k13-review.html', NULL, 5),
(285, 8, 'Deccan Chronicle', 'http://www.deccanchronicle.com/entertainment/movie-reviews/040519/k-13-movie-review-captivating-thriller.html', NULL, 6),
(286, 8, 'Movie Crow', 'http://www.moviecrow.com/News/23041/k13-movie-review', NULL, 7),
(287, 8, 'IMDb', 'http://m.imdb.com/title/tt10275440/', NULL, 8),
(288, 8, 'Behindwoods', 'https://www.behindwoods.com/tamil-movies/k13/k13-review.html', NULL, 9),
(289, 20, 'Wikipedia', 'https://en.wikipedia.org/wiki/Oru_Anweshanathinte_Thudakkam', NULL, 1),
(290, 20, 'Times of India', 'https://timesofindia.indiatimes.com/entertainment/malayalam/movie-reviews/oru-anweshanathinte-thudakkam/movie-review/115088262.cms', NULL, 2),
(294, 16, 'Wikipedia', 'https://en.wikipedia.org/wiki/With_Love_(2026_film)', NULL, 1),
(295, 16, 'venkatarangan', 'https://venkatarangan.com/blog/2026/02/with-love-2026-tamil-film-review/', NULL, 2),
(296, 16, 'Hollywoodreporterindia', 'https://www.hollywoodreporterindia.com/reviews/theatrical/with-love-movie-review-an-orkut-era-rom-com-told-with-reels-era-freshness', NULL, 3),
(297, 18, 'Wikipedia', 'https://en.wikipedia.org/wiki/Con_City', NULL, 1),
(298, 18, 'Tamil Guardian', 'https://www.tamilguardian.com/content/con-city-thieves-and-scorpions', NULL, 2),
(299, 18, 'Hollywood Reporter India', 'https://www.hollywoodreporterindia.com/reviews/theatrical/con-city-movie-review-arjun-das-anna-ben-film-has-amusing-stretches-in-an-otherwise-listless-con-com', NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `project_videos`
--

CREATE TABLE `project_videos` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `youtube_url` varchar(500) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_videos`
--

INSERT INTO `project_videos` (`id`, `project_id`, `title`, `youtube_url`, `sort_order`) VALUES
(57, 4, 'Trailer', 'https://www.youtube.com/watch?v=DAuJDUP3UC8', 1),
(59, 6, 'Trailer', 'https://www.youtube.com/watch?v=Lv5KUKKwQEw', 1),
(60, 7, 'Trailer', 'https://www.youtube.com/watch?v=15JE_fxLHyY', 1),
(69, 1, 'Trailer', 'https://www.youtube.com/watch?v=pxzHn_T1Vvs', 1),
(70, 19, 'Trailer', 'https://www.youtube.com/watch?v=4KRkDEJDjeg', 1),
(73, 11, 'Trailer', 'https://www.youtube.com/watch?v=Ei2DpC_E-kA', 1),
(74, 12, 'Kalyan Muhurat Bride: The graceful Tamizh Manamagal', 'http://www.youtube.com/embed/KCf5jaUulw4', 1),
(75, 12, 'Kalyan Jewellers Muhurat Bride: The stunning Telugu Vadhuvu', 'http://www.youtube.com/embed/MT3Jub-evqg', 2),
(76, 12, 'Varamahalakshmi Vratam, bring home prosperity (Telugu)', 'http://www.youtube.com/embed/w0iBNL8B_6M', 3),
(82, 17, 'Trailer', 'https://www.youtube.com/watch?v=3EGuYn0_VXc', 1),
(83, 3, 'Trailer', 'https://www.youtube.com/watch?v=JomxZONGkPM', 1),
(84, 15, 'Trailer', 'https://www.youtube.com/watch?v=x0BYKOnumbo', 1),
(85, 2, 'Trailer', 'https://www.youtube.com/watch?v=eLPePlnFoho', 1),
(86, 5, 'Trailer', 'https://www.youtube.com/watch?v=G0E7UgF5csk', 1),
(87, 8, 'Trailer', 'https://www.youtube.com/watch?v=6iRDz_ZY7Dk', 1),
(88, 20, 'Trailer', 'https://www.youtube.com/watch?v=pGiHSN9Jqr4', 1),
(90, 16, 'Trailer', 'https://www.youtube.com/watch?v=je1xB5ColOQ', 1),
(91, 18, 'Trailer', 'https://www.youtube.com/watch?v=wT2VV6bq6hU', 1);

-- --------------------------------------------------------

--
-- Table structure for table `publication_logos`
--

CREATE TABLE `publication_logos` (
  `publication` varchar(150) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `role` varchar(150) NOT NULL,
  `bio` text NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `status` enum('enabled','disabled') NOT NULL DEFAULT 'enabled',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`id`, `name`, `role`, `bio`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'SANKAR S.P', 'Managing Director', 'Sankar is a seasoned film professional with a deep understanding of the Movie Production Business. A product of the MGR Government Film and Television Institute, Chennai, Sankar started his career working for Aalayam and then shifted to acclaimed Director Mr. Manirathnam’s Production House Madras Talkies.He subsequently joined popular Television Production house Radaan Mediaworks (I) Ltd. run by actress Ms.RadhikaaSarathkumar to understand the nuances of the medium.Again he entered the world of cinema through Mirchi Movies (A Times Group Company) as Executive Producer and then with PVP Cinema, a leading name in the film industry in South India. Sankar has gone on to work on films like Irandam Ulagam, Naan Ee, Thozha/Oopiri etc. for PVP Cinema.', 2, 'enabled', '2026-07-08 10:45:54', '2026-07-08 12:22:32'),
(2, 'KISHORE.S', 'Producer', 'After his graduation in physics and an MBA in Marketing, Kishore went on to start his career in the FMCG space, before making a successful transition to the Media & Entertainment space. He has worked with prominent players in the field like Real Image Media Technologies and PVP Cinema over the last several years. With Real Image he has helped in developing the market for digital cinema in South India, playing a key role in making the Qube brand a success. At PVP Cinema he has gone on to handle distribution and marketing of their films like Irandam Ulagam, Naan Ee, Thozha/Oopiri, Kshanam etc and in the process he has built up an envious rapport in the trade which includes relationships with prominent producers, distributors, exhibitors in addition to creative personnel. Today Kishore is an independent distribution and marketing consultant for films.', 3, 'enabled', '2026-07-08 10:45:54', '2026-07-09 06:34:04'),
(3, 'NAREN', 'Creative Producer', 'An MBA in MediaManagement (specialized in movie Marketing & event management) & B.E (Mechanical Engineering), Naren is a proactive, multi skilled marketing professional, offering a track record of over 5 years of rich experience in production, marketing and distribution of movies in Tamil & Telugu. He has planned and executed the media planning & global release of 15 movies in Tamil, Telugu and Hindi. He played a key role in marketing and operations of KBFC’s (Kerala Blasters Football Club) debut season at ISL and 100 years of Cinema Celebrations event.', 4, 'disabled', '2026-07-08 10:45:54', '2026-08-24 16:46:54'),
(4, 'UDAYKUMAR.T', 'External Advisor', 'A Sound Engineer by profession working currently at Knack Studios. He started his career at Four Frames Mix Studio ( owned by Director Mr.Priyadarshan) and the brain behind sound designing/mixing of acclaimed films like Visaaranai, Vada Chennai and commercial movies like Kabali, VIP, Viswasam to name a few. Many movies are made on the editing Table but movies do get developed at the mixing stage too like including filling logical loopholes thanks to Uday’s expertise on commercial sensibilities.', 5, 'enabled', '2026-07-08 10:45:54', '2026-07-08 12:22:32'),
(5, 'SETHUMADHAVAN.N', 'External Advisor', 'A pharmacist by qualification, Sethumadhavan went on to do his MBA from XLRI-Jamshedpur. Sethu quit a successful corporate career to get into cinema by choice. He started off initially as a film journalist and critic for several publications and ran a couple of popular film websites. As a distributor he has released several indie and regional language films in multiple territories across India. His work as a producer has involved a variety of films in both Hindi and several Indian regional languages. After a long innings as the COO of DAR Media/DAR Motion Pictures (makers of films like The Lunchbox, D-Day, Ugly, Haunted, Mickey Virus, Bucket List etc.), Sethu is now setting up multiple projects, including films and original series in Hindi and regional languages.', 6, 'enabled', '2026-07-08 10:45:55', '2026-09-07 01:35:52'),
(7, 'Siva', 'Developer', 'HIHicadslbbvcla', 7, 'disabled', '2026-07-08 12:48:49', '2026-07-22 11:51:15'),
(8, 'Karthikeyan P', 'CREATIVE', ' ', 8, 'enabled', '2026-07-22 11:53:11', '2026-07-22 11:53:11'),
(9, 'Sadhanashree Sowrirajan', 'CREATIVE', ' ', 9, 'disabled', '2026-07-22 11:53:28', '2026-07-25 08:21:42'),
(10, 'ABIRAME SARAVANAN', 'EXECUTIVE', ' ', 10, 'disabled', '2026-07-22 11:54:11', '2026-07-25 08:21:52'),
(11, 'THIYAGARAJAN', 'FINANCE', ' ', 11, 'enabled', '2026-07-22 11:54:23', '2026-08-24 16:46:37'),
(12, 'VINOTH KESAVAN', 'FINANCE', ' ', 12, 'disabled', '2026-07-22 11:54:37', '2026-07-25 08:21:59'),
(13, 'KARTHIK', 'FINANCE', ' ', 13, 'disabled', '2026-07-22 11:55:09', '2026-07-25 08:22:00'),
(14, 'JAI GANESH', 'PRODUCTION', ' ', 14, 'enabled', '2026-07-22 11:55:21', '2026-07-22 11:55:21'),
(15, 'HARSHATH', 'PRODUCTION', ' ', 15, 'disabled', '2026-07-22 11:55:32', '2026-08-24 16:46:23'),
(16, 'DEEPAK', 'PRODUCTION', ' ', 16, 'disabled', '2026-07-22 11:55:49', '2026-08-24 16:46:21'),
(17, 'AJITH KUMAR', 'PRODUCTION', ' ', 17, 'disabled', '2026-07-22 11:56:02', '2026-08-24 16:46:19'),
(18, 'SHANKAR GANESH', 'PRODUCTION', ' ', 18, 'disabled', '2026-07-22 11:56:18', '2026-08-24 16:46:16'),
(19, 'Sethumadhavan', ' Marketing', 'A pharmacist by qualification, Sethumadhavan went on to do his MBA from XLRI-Jamshedpur. Sethu quit a successful corporate career to get into cinema by choice. He started off initially as a film journalist and critic for several publications and ran a couple of popular film websites. As a distributor he has released several indie and regional language films in multiple territories across India. His work as a producer has involved a variety of films in both Hindi and several Indian regional languages. After a long innings as the COO of DAR Media/DAR Motion Pictures (makers of films like The Lunchbox, D-Day, Ugly, Haunted, Mickey Virus, Bucket List etc.), Sethu is now setting up multiple projects, including films and original series in Hindi and regional languages.', 19, 'disabled', '2026-09-07 01:35:03', '2026-09-07 01:35:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banner_slides`
--
ALTER TABLE `banner_slides`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_reviews`
--
ALTER TABLE `project_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `project_videos`
--
ALTER TABLE `project_videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `publication_logos`
--
ALTER TABLE `publication_logos`
  ADD PRIMARY KEY (`publication`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banner_slides`
--
ALTER TABLE `banner_slides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `project_reviews`
--
ALTER TABLE `project_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=300;

--
-- AUTO_INCREMENT for table `project_videos`
--
ALTER TABLE `project_videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `team_members`
--
ALTER TABLE `team_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `project_reviews`
--
ALTER TABLE `project_reviews`
  ADD CONSTRAINT `project_reviews_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_videos`
--
ALTER TABLE `project_videos`
  ADD CONSTRAINT `project_videos_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
