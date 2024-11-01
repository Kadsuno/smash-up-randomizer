-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Nov 01, 2024 at 04:15 PM
-- Server version: 10.4.34-MariaDB-1:10.4.34+maria~ubu2004-log
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db`
--

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `phone` varchar(191) NOT NULL,
  `subject` varchar(191) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `phone`, `subject`, `message`, `created_at`, `updated_at`) VALUES
(1, 'MIke', 'mike.rauch@proton.me', '1112223334', 'Test', 'Test', '2024-02-03 01:45:38', '2024-02-03 01:45:38'),
(2, 'Mike', 'mike.rauch@proton.me', '1112223334', 'Test', 'Test', '2024-02-03 01:49:34', '2024-02-03 01:49:34'),
(3, 'Mike', 'mike.rauch@proton.me', '1112223334', 'Test', 'Test', '2024-02-03 01:51:49', '2024-02-03 01:51:49'),
(4, 'Mike Rauch', 'mike.rauch@proton.me', '1112223334', 'Test', 'Test', '2024-02-05 18:45:41', '2024-02-05 18:45:41'),
(5, 'Mike Rauch', 'mike.rauch@proton.me', '1627582278', 'Problem', 'test', '2024-02-06 18:35:13', '2024-02-06 18:35:13');

-- --------------------------------------------------------

--
-- Table structure for table `decks`
--

DROP TABLE IF EXISTS `decks`;
CREATE TABLE IF NOT EXISTS `decks` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) NOT NULL DEFAULT '',
  `image` varchar(191) NOT NULL DEFAULT '',
  `teaser` text NOT NULL DEFAULT '',
  `description` text NOT NULL DEFAULT '',
  `synergy` text NOT NULL DEFAULT '',
  `tips` text NOT NULL DEFAULT '',
  `cardsTeaser` text NOT NULL DEFAULT '',
  `actions` text NOT NULL DEFAULT '',
  `characters` text NOT NULL DEFAULT '',
  `bases` text NOT NULL DEFAULT '',
  `suggestionTeaser` text NOT NULL DEFAULT '',
  `mechanics` text NOT NULL DEFAULT '',
  `expansion` varchar(191) NOT NULL DEFAULT '',
  `effects` varchar(191) NOT NULL DEFAULT '',
  `playstyle` varchar(191) NOT NULL DEFAULT '',
  `actionTeaser` text NOT NULL DEFAULT '',
  `actionList` text NOT NULL DEFAULT '',
  `clarifications` text NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `decks`
--

INSERT INTO `decks` (`id`, `created_at`, `updated_at`, `name`, `image`, `teaser`, `description`, `synergy`, `tips`, `cardsTeaser`, `actions`, `characters`, `bases`, `suggestionTeaser`, `mechanics`, `expansion`, `effects`, `playstyle`, `actionTeaser`, `actionList`, `clarifications`) VALUES
(1, NULL, NULL, 'ALIENS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(2, NULL, NULL, 'ANANSI TALES', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3, NULL, NULL, 'ANCIENT EGYPTIANS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(4, NULL, NULL, 'AVENGERS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(5, NULL, NULL, 'BEAR CAVALRY', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(6, NULL, NULL, 'BEAUTY AND THE BEAST', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(7, NULL, NULL, 'CLERICS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(8, NULL, NULL, 'COWBOYS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(9, NULL, NULL, 'CYBORG APES', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(10, NULL, NULL, 'DRAGONS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(11, NULL, NULL, 'DWARVES', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(12, NULL, NULL, 'ELDER THINGS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(13, NULL, NULL, 'FAIRIES', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(14, NULL, NULL, 'FROZEN', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(15, NULL, NULL, 'GEEKS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(16, NULL, NULL, 'GOBLINS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(17, NULL, NULL, 'GRANNIES', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(18, NULL, NULL, 'GRIMMS\' FAIRY TALES', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(19, NULL, NULL, 'IGNOBLES', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(20, NULL, NULL, 'INNSMOUTH', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(21, NULL, NULL, 'ITTY CRITTERS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(22, NULL, NULL, 'KITTY CATS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(23, NULL, NULL, 'KNIGHTS OF THE ROUND TABLE', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(24, NULL, NULL, 'KREE', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(25, NULL, NULL, 'MAD SCIENTISTS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(26, NULL, NULL, 'MAGES', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(27, NULL, NULL, 'MAGICAL GIRLS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(28, NULL, NULL, 'MERMAIDS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(29, NULL, NULL, 'MINIONS OF CTHULHU', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(30, NULL, NULL, 'MISKATONIC UNIVERSITY', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(31, NULL, NULL, 'MUSKETEERS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(32, NULL, NULL, 'MYTHIC GREEKS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(33, NULL, NULL, 'MYTHIC HORSES', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(34, NULL, NULL, 'PENGUINS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(35, NULL, NULL, 'PIRATES', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(36, NULL, NULL, 'POLYNESIAN VOYAGERS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(37, NULL, NULL, 'ROCK STARS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(38, NULL, NULL, 'RUSSIAN FAIRY TALES', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(39, NULL, NULL, 'S.H.I.E.L.D.', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(40, NULL, NULL, 'SHARKS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(41, NULL, NULL, 'SHEEP', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(42, NULL, NULL, 'SINISTER SIX', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(43, NULL, NULL, 'SPIDER-VERSE', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(44, NULL, NULL, 'STAR ROAMERS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(45, NULL, NULL, 'STEAMPUNKS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(46, NULL, NULL, 'SUPERHEROES', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(47, NULL, NULL, 'TEDDY BEARS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(48, NULL, NULL, 'THE LION KING', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(49, NULL, NULL, 'TIME TRAVELERS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(50, NULL, NULL, 'TORNADOS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(51, NULL, NULL, 'TRICKSTERS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(52, NULL, NULL, 'VAMPIRES', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(53, NULL, NULL, 'VIGILANTES', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(54, NULL, NULL, 'VIKINGS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(55, NULL, NULL, 'WIZARDS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(56, NULL, NULL, 'WORLD CHAMPS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(57, NULL, NULL, 'WRECK-IT RALPH', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(60, NULL, NULL, 'ANCIENT INCAS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(61, NULL, '2024-10-18 22:46:13', 'ALADDIN', 'https://smash-up-randomizer.ddev.site/images/factions/aladdin.png', '<p><i>The Aladdin deck can get the cards you need, whether from your own deck and discard pile, or from other players. Some cards give other kinds of help: extra plays from Jasmine, strength from Palace Guard, and movement from Carpet. But the card that helps the most is Genie, which can fetch three Wishes of phenomenal cosmic power!</i></p>', '<p><strong>Aladdin</strong> is one of the 8 factions from the Smash Up: Disney Edition set.</p><p>They focus on finding the Genie and making use of the Wish cards, three powerful one-time-use actions, as well as discarding actions for benefits.</p><p>Their complexity rating is: Medium-High.</p><p><i>Other factions from the same set: </i>Beauty and the Beast, Big Hero 6, Frozen, Mulan, The Lion King, The Nightmare Before Christmas, Wreck-It Ralph.</p>', '<ul><li>Beauty and the Beast</li><li>The Nightmare Before Christmas</li></ul>', '<ul><li>Be wise but bold in using your precious Wish cards. They can help you break and win bases, but don’t be afraid to use one to fill out a weak hand if needed.</li><li>Several cards require discarding an action to work. Wish cards are great for that since Genie can fetch them back.</li><li>A Friend Like Me and other cards can help restock your hand.</li></ul>', 'Aladdin has the usual 10 characters and 10 actions. The total character base power (not counting any abilities) is unusually low at only 27 or an average of 2.7 per character compared to the usual 30 and 3.', '<ul><li>2x <strong>A Friend Like Me</strong> - Reveal the top four cards of your deck. Draw all actions and shuffle the rest into your deck.</li><li>1x <strong>Cave of Wonders</strong> - Place an action from your discard pile into your hand.</li><li>1x <strong>Jafar</strong> - Each other player discards an action from their hand or reveals their hand to show it has no actions. You may play one of the discarded actions or an action from your hand as an extra action.&nbsp;</li><li>1x <strong>Magic Carpet Ride</strong> - Search your deck, hand, and/or discard pile for Carpet, shuffle your deck if you searched it, and play Carpet as an extra character.</li><li>1x <strong>Street Rat</strong> - Play an action from another player’s discard pile as an extra action.</li><li>1x <strong>The Lamp</strong> - Search your deck and/or discard pile for Genie, reveal it and draw it. Shuffle your deck if you searched it. Place this card on the bottom of your deck.&nbsp;</li><li>3x <strong>Wish</strong> - If you have Genie in play, choose one effect and place this card into the box:<ul><li>Play two extra non-Wish cards.</li><li>Give a character +5 power until the end of the turn.</li><li>Draw four cards.</li></ul></li></ul>', '<ul><li>1x <strong>Aladdin</strong> - power 5 - Search your deck and/or discard pile for The Lamp, reveal it, and draw it. Shuffle your deck if you searched it. Talent: Reveal cards from your deck until you reveal an action. Draw it and shuffle the rest into your deck.</li><li>1x <strong>Jasmine</strong> - power 4 - Talent: Discard an action to play an extra action.</li><li>1x <strong>Abu</strong> - power 3 - Place an action from your discard pile on top of your deck.</li><li>1x <strong>Genie</strong> - power 3 - Talent: Search your deck and/or discard pile for a copy of Wish, reveal it, and place it into your hand. Shuffle your deck if you searched it.</li><li>1x <strong>Rajah</strong> - power 3 - Talent: Discard an action to give this character +2 power until the end of the turn. Special: Before this base scores, you may use this character’s talent.</li><li>1x <strong>Carpet</strong> - power 1 - Talent: Move this character and up to two of your other characters here to another base.</li><li>4x <strong>Palace Guard</strong> - power 2 - Talent: Discard an action to place a +1 power counter on each of your Palace Guards here.</li></ul>', '<ul><li>Agrabah Bazaar</li><li>Sultan’s Palace</li></ul>', 'To help beginner players, the Smash Up: Disney Edition set gave a few tips and tricks to play this faction, as well as partner recommendations within the set.', '<p>You have three powerful actions, the Wishes, that give you a choice between three interesting options. But in order to use them, you must have Genie in play, and on use, those actions go back to the box, making them one-time-use cards. To help you set up that play, you have The Lamp that allows you to retrieve the Genie, as well as several ways to get to The Lamp, such as Aladdin that give it on play and whose talent help you sift your deck, or Abu and Cave of Wonders that allow you to retrieve discarded actions. The Wishes themselved can easily be fetched once Genie is in play.</p><p>As a secondary mechanic is that the \"palace\" characters (Jasmine, Rajah and the Palace Guards) require discarding actions to use their talents. Wishes are great for that purpose because you can retrieve them later with Genie. You can also use A Friend Like Me and Aladdin to help you fill your hand with actions to discard.</p>', 'Smash Up: Disney Edition', '<ul><li>Draw</li><li>Empower</li><li>Play</li><li>Recover</li></ul>', '<ul><li>Support</li><li>Snowball</li></ul>', 'Among their actions, there are:', '<ul><li>0 character modifiers</li><li>0 base modifiers</li><li>10 standard actions (3 that affect one or more characters, <strong>in bold</strong>): A Friend Like Me (2x), Cave of Wonders, Jafar, Magic Carpet Ride, Street Rat, The Lamp, <strong>Wish (3x)</strong>,</li><li>3 actions that directly increase a character\'s power: Wish (3x)</li></ul>', '<p>Here are the official clarifications as they appear in the Smash Up: Disney Edition rulebook:</p><ul><li><strong>A Friend Like Me, Aladdin:</strong> Even if there is nothing to shuffle into the deck, shuffle it anyway.</li><li><strong>Aladdin:</strong> If your deck is empty before you reveal any cards, shuffle your discard pile to make a new deck. If your deck runs out before you find an action, stop revealing and continue with the rest of the instructions.</li><li><strong>Carpet:</strong> All the characters must start on the same base and must be moved to the same base.</li><li><strong>Jafar:</strong> Each player does what the card says in turn order, starting with the current player unless the card says otherwise.</li><li>;<strong>Jafar, Street Rat:</strong> If the action you play is a modifier, you control it until it leaves play, at which point it goes to its owner’s discard pile.</li><li><strong>Palace Guard, Jasmine, Rajah:</strong> Discarding a card for one of these cards does not count toward any other card’s prerequisites; a separate card must be discarded for each one. But even one discarded card triggers all cards that trigger from a discard (e.g. Be Our Guest, Enchanted Castle).</li><li><strong>Palace Guard:</strong> If there are multiple copies of a card in play at the same time, their abilities work for each of them, (e.g. all Sugar Rush Racers can move from one base modifier play; each Sergeant Calhouns can give +1 power, even if at the same base).</li><li><strong>Rajah:</strong> You may use its talent before its base scores even if it was used earlier that same turn.</li><li><strong>Wish:</strong> If Genie is not in play or not controlled by you when you play Wish, it has no effect and you just discard it. For placing it in the box, see “The box”.</li></ul>'),
(62, NULL, NULL, 'ASTROKNIGHTS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(63, NULL, NULL, 'BIG HERO 6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(64, NULL, NULL, 'CHANGERBOTS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(65, NULL, NULL, 'DINOSAURS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(66, NULL, NULL, 'DISCO DANCERS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(67, NULL, NULL, 'ELVES', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(68, NULL, NULL, 'EXPLORERS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(69, NULL, NULL, 'GHOSTS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(70, NULL, NULL, 'GIANT ANTS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(71, NULL, NULL, 'HALFLINGS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(72, NULL, NULL, 'HYDRA', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(73, NULL, NULL, 'KAIJU', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(74, NULL, NULL, 'KILLER PLANTS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(75, NULL, NULL, 'KUNG FU FIGHTERS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(76, NULL, NULL, 'LUCHADORS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(77, NULL, NULL, 'MASTERS OF EVIL', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(78, NULL, NULL, 'MEGA TROOPERS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(79, NULL, NULL, 'MOUNTIES', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(80, NULL, NULL, 'MULAN', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(81, NULL, NULL, 'NINJAS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(82, NULL, NULL, 'ORCS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(83, NULL, NULL, 'PRINCESSES', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(84, NULL, NULL, 'ROBOTS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(85, NULL, NULL, 'SAMURAI', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(86, NULL, NULL, 'SHAPESHIFTERS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(87, NULL, NULL, 'SKELETONS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(88, NULL, NULL, 'SMASH UP ALL STARS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(89, NULL, NULL, 'SUMO WRESTLERS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(90, NULL, NULL, 'SUPER SPIES', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(91, NULL, NULL, 'THE NIGHTMARE BEFORE CHRISTMAS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(92, NULL, NULL, 'THIEVES', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(93, NULL, NULL, 'TRUCKERS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(94, NULL, NULL, 'ULTIMATES', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(95, NULL, NULL, 'WARRIORS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(96, NULL, NULL, 'WEREWOLVES', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(97, NULL, NULL, 'ZOMBIES', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_01_28_194353_create_decks_table', 1),
(6, '2023_11_10_182756_create_contacts_table', 1),
(7, '2024_02_04_155611_create_jobs_table', 2),
(8, '2016_06_01_000001_create_oauth_auth_codes_table', 3),
(9, '2016_06_01_000002_create_oauth_access_tokens_table', 3),
(10, '2016_06_01_000003_create_oauth_refresh_tokens_table', 3),
(11, '2016_06_01_000004_create_oauth_clients_table', 3),
(12, '2016_06_01_000005_create_oauth_personal_access_clients_table', 3),
(13, '2024_06_08_003101_add_new_column_to_decks', 4),
(14, '2024_07_13_014154_add_new_column_to_decks_table', 5),
(15, '2024_07_13_014155_add_new_column_to_decks_table', 6),
(16, '2024_10_18_194646_remove_unused_fields_from_decks_table', 7),
(17, '2024_10_19_003108_add_default_values_for_decks_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
CREATE TABLE IF NOT EXISTS `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
CREATE TABLE IF NOT EXISTS `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
CREATE TABLE IF NOT EXISTS `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `provider` varchar(191) DEFAULT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
CREATE TABLE IF NOT EXISTS `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
CREATE TABLE IF NOT EXISTS `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Mike Rauch', 'mike.rauch@proton.me', NULL, '$2y$10$ZRavKlZmXgVPNU01NAr6gOf6pYbf1qAysLXb1wOI5xRDJv.Yws5S2', 'Ri4GhnAwn5turbpnCwDbvcccmlvSHKjtWsJ8fqV1lLhWhIbEOZUGiZazLL0p', '2024-02-03 01:38:50', '2024-02-03 01:38:50');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
