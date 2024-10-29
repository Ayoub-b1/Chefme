-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 10 mai 2024 à 18:00
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `chefme`
--

-- --------------------------------------------------------
Use `if0_36955285_chefme`;
--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id_category` int(11) NOT NULL,
  `Category` char(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id_category`, `Category`) VALUES
(18, 'Appetizers'),
(7, 'Breakfast/Brunch'),
(6, 'Desserts'),
(4, 'Main Courses'),
(16, 'Mediterranean'),
(9, 'Pasta/Noodles'),
(10, 'Pizza'),
(2, 'Salads'),
(8, 'Sandwiches/Burgers'),
(17, 'Seafood'),
(5, 'Side Dishes'),
(3, 'Soups'),
(0, 'unknown'),
(15, 'Vegetarian/Vegan');

--
-- Déclencheurs `category`
--
DELIMITER $$
CREATE TRIGGER `update_recipe_category_id` BEFORE DELETE ON `category` FOR EACH ROW BEGIN
    UPDATE recipe
    SET id_category = 0
    WHERE id_category = OLD.id_category;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `comments_id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment_text` text DEFAULT NULL,
  `comment_parent` int(11) DEFAULT NULL,
  `comment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `content_faq`
--

CREATE TABLE `content_faq` (
  `id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `content_faq`
--

INSERT INTO `content_faq` (`id`, `question`, `answer`) VALUES
(1, 'I submit my own recipes to be featured on your website?', 'Absolutely! We love featuring recipes from our community. You can submit your recipe through the &quot;Recipes&quot; page on our website. Please make sure to include all the necessary details and high-quality images if possible.'),
(2, 'How do I save recipes for later?', 'You can save recipes by creating an account on our website and clicking the \"Bookmark\" button located on top of each recipe. This will add the recipe to your saved recipes list for easy access later.'),
(3, 'How can I contact you for further assistance or inquiries?', 'You can reach out to us through the \"Contact Us\" page on our website. We\'re happy to help with any questions or concerns you may have.');

-- --------------------------------------------------------

--
-- Structure de la table `cuisine`
--

CREATE TABLE `cuisine` (
  `id_Cuisine` int(11) NOT NULL,
  `Cuisine` char(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `cuisine`
--

INSERT INTO `cuisine` (`id_Cuisine`, `Cuisine`) VALUES
(2, 'American'),
(4, 'Appetizers'),
(8, 'French'),
(11, 'Greek'),
(6, 'Indian'),
(3, 'Italian'),
(7, 'Japanese'),
(13, 'Korean'),
(9, 'Mediterranean'),
(5, 'Mexican'),
(1, 'Moroccan'),
(14, 'Russian'),
(15, 'test'),
(10, 'Thai'),
(12, 'Vegetarian');

--
-- Déclencheurs `cuisine`
--
DELIMITER $$
CREATE TRIGGER `update_category_id` BEFORE DELETE ON `cuisine` FOR EACH ROW BEGIN
    UPDATE recipe
    SET id_Cuisine = 0
    WHERE id_Cuisine = OLD.id_cuisine;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `dislikes`
--

CREATE TABLE `dislikes` (
  `dislike_id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `dislikes`
--

INSERT INTO `dislikes` (`dislike_id`, `post_id`, `user_id`) VALUES
(36, 9, 21),
(37, 204, 21);

--
-- Déclencheurs `dislikes`
--
DELIMITER $$
CREATE TRIGGER `update_dislike_count_after_delete` AFTER DELETE ON `dislikes` FOR EACH ROW BEGIN
    DECLARE post_count INT;
    
    -- Get the total number of likes for the post_id
    SELECT COUNT(*) INTO post_count FROM dislikes WHERE post_id = OLD.post_id;
    
    -- Update the like_count in the posts table
    UPDATE posts SET dislike_count = post_count WHERE post_id = OLD.post_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_dislike_count_after_insert` AFTER INSERT ON `dislikes` FOR EACH ROW BEGIN
    DECLARE post_count INT;
    
    -- Get the total number of likes for the post_id
    SELECT COUNT(*) INTO post_count FROM dislikes WHERE post_id = NEW.post_id;
    
    -- Update the like_count in the posts table
    UPDATE posts SET dislike_count = post_count WHERE post_id = NEW.post_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `likes`
--

INSERT INTO `likes` (`like_id`, `post_id`, `user_id`) VALUES
(72, 8, 21);

--
-- Déclencheurs `likes`
--
DELIMITER $$
CREATE TRIGGER `update_like_count` AFTER INSERT ON `likes` FOR EACH ROW BEGIN
    DECLARE post_count INT;
    
    -- Get the total number of likes for the post_id
    SELECT COUNT(*) INTO post_count FROM likes WHERE post_id = NEW.post_id;
    
    -- Update the like_count in the posts table
    UPDATE posts SET like_count = post_count WHERE post_id = NEW.post_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_like_count_after_delete` AFTER DELETE ON `likes` FOR EACH ROW BEGIN
    DECLARE post_count INT;
    
    -- Get the total number of likes for the post_id
    SELECT COUNT(*) INTO post_count FROM likes WHERE post_id = OLD.post_id;
    
    -- Update the like_count in the posts table
    UPDATE posts SET like_count = post_count WHERE post_id = OLD.post_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `personal_info`
--

CREATE TABLE `personal_info` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `recipe_count` int(11) DEFAULT 0,
  `Bio` text NOT NULL DEFAULT '',
  `prefered_cuisine` varchar(40) NOT NULL DEFAULT '',
  `allergies` varchar(255) NOT NULL DEFAULT '',
  `facebook` varchar(255) NOT NULL DEFAULT '',
  `number` varchar(50) NOT NULL DEFAULT '',
  `instagram` varchar(255) NOT NULL DEFAULT '',
  `twitter_x` varchar(255) NOT NULL DEFAULT '',
  `active` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `personal_info`
--

INSERT INTO `personal_info` (`id`, `user_id`, `recipe_count`, `Bio`, `prefered_cuisine`, `allergies`, `facebook`, `number`, `instagram`, `twitter_x`, `active`) VALUES
(2, 21, 1, 'usjdvdfvdfvfdvfdvfcsdccsdccdscdscsc', 'Thai', 'vfcsdc', 'vfdv', 'vdfvf', 'vdvdf', 'vfdvccsdcd', '2024-04-29'),
(3, 22, 0, '', '', '', '', '', '', '', '2024-05-08'),
(4, 23, 0, '', '', '', '', '', '', '', '2024-05-08');

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `creator_id` int(11) DEFAULT NULL,
  `post_text` text DEFAULT NULL,
  `post_date` timestamp NULL DEFAULT current_timestamp(),
  `like_count` int(11) NOT NULL DEFAULT 0,
  `dislike_count` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`post_id`, `creator_id`, `post_text`, `post_date`, `like_count`, `dislike_count`) VALUES
(2, 21, '🍵 Green Tea: Nature\'s Elixir! 🍃\n\nSip, sip, hooray! Did you know that green tea is more than just a tasty beverage? 🌱 It\'s packed with antioxidants that can help boost your metabolism, support heart health, and even enhance brain function. 💡 Plus, it\'s a refreshing way to stay hydrated throughout the day. Cheers to good health with a cup of green tea! 🍵✨ #GreenTea #HealthyLiving #WellnessWednesday', '2024-04-29 23:00:00', 0, 0),
(5, 21, '🍽️ Cooking Tip of the Day 🌟 Looking to add extra flavor to your dishes? Try incorporating fresh herbs instead of dried ones whenever possible! 🌿 Herbs like basil, parsley, cilantro, and thyme pack a punch of vibrant flavor that can take your meals to the next level. Not only do they add complexity to your recipes, but they also provide a burst of color and aroma that enhances the overall dining experience. Whether you&amp;amp;amp;#39;re cooking pasta, salads, soups, or grilled meats, fresh herbs are sure to elevate your culinary creations! 🍝🥗🍲 #CookingTips #FreshHerbs #FlavorEnhancers', '2024-05-01 00:00:25', 0, 0),
(6, 21, 'Maintaining a balanced diet is essential for overall health and well-being. Incorporating a variety of fruits, vegetables, lean proteins, and whole grains into your meals can provide essential nutrients and energy to fuel your day. Discover delicious and nutritious recipes, along with tips for making healthy choices, to help you achieve your wellness goals.', '2024-05-01 00:07:35', 1, 0),
(8, 21, 'Eating well doesn&amp;#39;t have to break the bank. With a little creativity and planning, you can enjoy delicious and satisfying meals without overspending. Learn how to shop smart, make the most of pantry staples, and stretch your ingredients to create budget-friendly meals that are both nutritious and flavorful. Whether you&amp;#39;re a college student, a busy parent, or simply looking to save money, these budget-friendly recipes and tips will help you eat well on a budget.', '2024-05-01 00:13:41', 1, 1),
(9, 21, 'test', '2024-05-01 01:45:23', 0, 1),
(204, 21, 'jnjkdnv', '2024-05-10 08:15:55', 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `post_media`
--

CREATE TABLE `post_media` (
  `media_id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `url` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `post_media`
--

INSERT INTO `post_media` (`media_id`, `post_id`, `url`) VALUES
(1, 8, '[{\"type\":\"image\",\"url\":\".\\/uploads\\/blogs\\/66318935e6356_Designer__7_.jpeg\"},{\"type\":\"image\",\"url\":\".\\/uploads\\/blogs\\/66318935e67b5_Designer__6_.jpeg\"},{\"type\":\"image\",\"url\":\".\\/uploads\\/blogs\\/66318935e6a2c_Designer__5_.jpeg\"}]'),
(11, 9, '[{\"type\":\"video\",\"url\":\".\\/uploads\\/blogs\\/66319eb3b2407_Blogs_and_8_more_pages___Personal___Microsoft____Edge_2024_04_30_22_18_54.mp4\"},{\"type\":\"video\",\"url\":\".\\/uploads\\/blogs\\/66319eb3bb219_Blogs_and_8_more_pages___Personal___Microsoft____Edge_2024_04_30_22_19_02.mp4\"}]'),
(25, 204, '[{\"type\":\"image\",\"url\":\".\\/uploads\\/blogs\\/663dd7bb7a779_th__2_.jpeg\"}]');

-- --------------------------------------------------------

--
-- Structure de la table `profile_picture`
--

CREATE TABLE `profile_picture` (
  `id` int(11) NOT NULL,
  `path` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `profile_picture`
--

INSERT INTO `profile_picture` (`id`, `path`) VALUES
(1, 'uploads/pfp/image1.jpeg'),
(2, 'uploads/pfp/image2.jpeg'),
(3, 'uploads/pfp/image3.jpeg'),
(4, 'uploads/pfp/image4.jpeg'),
(5, 'uploads/pfp/image5.jpeg'),
(6, 'uploads/pfp/image6.jpeg'),
(7, 'uploads/pfp/image7.jpeg'),
(8, 'uploads/pfp/image8.jpeg'),
(9, 'uploads/pfp/default.jpeg');

-- --------------------------------------------------------

--
-- Structure de la table `recipe`
--

CREATE TABLE `recipe` (
  `id_recipe` int(11) NOT NULL,
  `title` varchar(70) NOT NULL,
  `description` text NOT NULL,
  `Ingredient` text NOT NULL,
  `Instructions` text NOT NULL,
  `preparation_time` int(11) NOT NULL,
  `cooking_time` int(11) NOT NULL,
  `total_time` int(11) NOT NULL,
  `difficulty_level` enum('easy','medium','hard') NOT NULL,
  `id_category` int(11) NOT NULL,
  `id_cuisine` int(11) NOT NULL,
  `calories` decimal(5,2) NOT NULL,
  `servings` int(11) NOT NULL,
  `id_creator` int(11) NOT NULL,
  `date_added` date NOT NULL DEFAULT current_timestamp(),
  `recipe_img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `recipe`
--

INSERT INTO `recipe` (`id_recipe`, `title`, `description`, `Ingredient`, `Instructions`, `preparation_time`, `cooking_time`, `total_time`, `difficulty_level`, `id_category`, `id_cuisine`, `calories`, `servings`, `id_creator`, `date_added`, `recipe_img`) VALUES
(21, 'Pumpkin Delight Recipe', 'Pumpkin Delight starts with a crunchy pecan crust topped with light and fluffy pumpkin and whipped cream. It&amp;#39;s heavenly!', '[\"1 cup All-Purpose Flour\",\"\\u00bd cup Butter (softened)\",\"\\u00be cup Pecans (chopped)\",\"8 ounces Cream Cheese (softened)\",\"1 cup Powdered Sugar\",\"3 cups Whipped Topping (divided)\",\"2 \\u00bd cups Milk\",\"3 packages Instant Pudding Mix (white chocolate, or vanilla, 3.4 oz size)\",\"15 ounces cans Pumpkin Puree\",\"1 teaspoon Pumpkin Spice\"]', '[\"Mix flour, butter and \\u00bd cup pecans together. Press into a greased 9\\u00d79 pan. Bake for 15 minutes at 350\\u00b0F, then remove and let cool. NOTE: If you are using a 9\\u00d713 pan, or would like a thicker crust, add an additional \\u00bd cup flour, \\u00bc cup butter and \\u00bc cup chopped pecans.\",\"Blend cream cheese and powdered sugar, add 1 cup of the whipped topping, then spread over cooled crust.\",\"Mix milk, pudding mix, canned pumpkin, pumpkin spice and 1 cup whipped topping until smooth. Spread over top of layer 2.\",\"Spread remaining 1 cup of whipped topping and sprinkle pecans.\",\"Let chill for 3 hours or until set. Serve chilled.\"]', 20, 15, 35, 'easy', 6, 2, 361.00, 10, 13, '2024-04-12', 'uploads/recipes/6619657820990_pumkin delight.jpg'),
(22, 'Simple Ground Beef Casserole', 'This ground beef casserole recipe is super easy to throw together and feeds a crowd! It&amp;#39;s comforting and uses simple ingredients.', '[\"1 pound Uncooked Penne\",\"1 tablespoon Olive Oil\",\"1 pound Lean Ground Beef\",\"\\u00bd  Medium Onion (chopped)\",\"1 clove Garlic (minced)\",\"1 \\u00bd cups Marinara Sauce\",\"add  Salt &amp; Pepper\",\"1 \\u00bd cups Cheddar Cheese (shredded)\"]', '[\"Preheat your oven to 400F and move the rack to the middle position. Grease a 9\\u00d713 baking dish (I use Pam spray).\",\"Boil a large, salted pot of water for the penne. Cook it for 10 minutes (it should be slightly underdone so it doesn&#39;t get mushy).\",\"Add the oil, beef, and onion to a skillet. Saut\\u00e9 over medium-high heat, breaking the meat up as you go along, for 10 minutes. Once it gets going, stir in the garlic. Spoon out excess fat if needed.\",\"Stir in the marinara sauce and warm through. Give it a taste and season with salt &amp; pepper as needed.\",\"Drain the pasta and pour it into the baking dish. Pour the beef mixture over top and then toss until it&#39;s combined with the pasta. Top with an even layer of the cheese. If you want it extra cheesy, you can stir in an additional half cup of cheese prior to topping it with the rest of the cheese.\",\"Bake for 10 minutes, uncovered, until the cheese is nicely melted. I then broil it for a few minutes (optional) to brown the cheese up a bit. Serve immediately.\"]', 10, 25, 35, 'easy', 9, 2, 538.00, 6, 13, '2024-04-23', 'uploads/recipes/66282cfdd8ede_th.jpeg'),
(23, 'Garlic Butter Shrimp', 'This easy garlic butter shrimp is succulent shrimp tossed in an easy garlic and lemon sauce. The perfect quick dinner or appetizer!', '[\"4 tablespoons butter\",\"\\u25a21 lb large shrimp I use 16-20 count size, peeled, deveined and tails removed if desired\",\"\\u25a2salt and pepper to taste\",\"1 teaspoon Italian seasoning\",\"2-3 teaspoons minced garlic use more if you love garlic!\",\"the juice of one lemon\",\"1 tablespoon chopped parsley\",\"4 tablespoons butter\",\"\\u25a21 lb large shrimp I use 16-20 count size, peeled, deveined and tails removed if desired\",\"\\u25a2salt and pepper to taste\",\"1 teaspoon Italian seasoning\",\"2-3 teaspoons minced garlic use more if you love garlic!\",\"the juice of one lemon\",\"1 tablespoon chopped parsley\",\"4 tablespoons butter\",\"\\u25a21 lb large shrimp I use 16-20 count size, peeled, deveined and tails removed if desired\",\"\\u25a2salt and pepper to taste\",\"1 teaspoon Italian seasoning\",\"2-3 teaspoons minced garlic use more if you love garlic!\",\"the juice of one lemon\",\"1 tablespoon chopped parsley\",\"4 tablespoons butter\",\"\\u25a21 lb large shrimp I use 16-20 count size, peeled, deveined and tails removed if desired\",\"\\u25a2salt and pepper to taste\",\"1 teaspoon Italian seasoning\",\"2-3 teaspoons minced garlic use more if you love garlic!\",\"the juice of one lemon\",\"1 tablespoon chopped parsley\"]', '[\"Place the butter in a large pan and melt over medium high heat. Add the shrimp and season with salt, pepper and Italian seasoning.\",\"Cook for 3-5 minutes, stirring occasionally, until shrimp are pink and opaque.\",\"Add the garlic and cook for one more minute.\",\"Stir in the lemon juice and parsley, then serve.\",\"Place the butter in a large pan and melt over medium high heat. Add the shrimp and season with salt, pepper and Italian seasoning.\",\"Cook for 3-5 minutes, stirring occasionally, until shrimp are pink and opaque.\",\"Add the garlic and cook for one more minute.\",\"Stir in the lemon juice and parsley, then serve.\",\"Place the butter in a large pan and melt over medium high heat. Add the shrimp and season with salt, pepper and Italian seasoning.\",\"Cook for 3-5 minutes, stirring occasionally, until shrimp are pink and opaque.\",\"Add the garlic and cook for one more minute.\",\"Stir in the lemon juice and parsley, then serve.\",\"Place the butter in a large pan and melt over medium high heat. Add the shrimp and season with salt, pepper and Italian seasoning.\",\"Cook for 3-5 minutes, stirring occasionally, until shrimp are pink and opaque.\",\"Add the garlic and cook for one more minute.\",\"Stir in the lemon juice and parsley, then serve.\"]', 5, 5, 10, 'easy', 18, 4, 215.00, 4, 21, '2024-05-03', 'uploads/recipes/66341bd7d34d3_th.jpeg');

--
-- Déclencheurs `recipe`
--
DELIMITER $$
CREATE TRIGGER `update_recipe_count` AFTER INSERT ON `recipe` FOR EACH ROW BEGIN
    -- Increment the recipe count for the user after each recipe insertion
    UPDATE personal_info SET recipe_count = recipe_count + 1 WHERE id = NEW.id_creator;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` char(30) NOT NULL,
  `lastname` char(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_pic` varchar(80) NOT NULL DEFAULT 'uploads/pfp/default.jpeg',
  `verified` tinyint(4) NOT NULL DEFAULT 0,
  `tokenVefication` int(6) DEFAULT NULL,
  `resetToken` varchar(64) DEFAULT NULL,
  `expiration` datetime NOT NULL,
  `reset_token_expiration` datetime DEFAULT NULL,
  `bookmarked_recipes` text NOT NULL DEFAULT '[]',
  `role` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--


-- Déclencheurs `users`
--
DELIMITER $$
CREATE TRIGGER `add_personal_info` AFTER INSERT ON `users` FOR EACH ROW BEGIN
    INSERT INTO personal_info (user_id) VALUES (NEW.id);
END
$$
DELIMITER ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`),
  ADD UNIQUE KEY `Category` (`Category`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comments_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `comment_parent` (`comment_parent`);

--
-- Index pour la table `content_faq`
--
ALTER TABLE `content_faq`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cuisine`
--
ALTER TABLE `cuisine`
  ADD PRIMARY KEY (`id_Cuisine`),
  ADD UNIQUE KEY `Cuisine` (`Cuisine`);

--
-- Index pour la table `dislikes`
--
ALTER TABLE `dislikes`
  ADD PRIMARY KEY (`dislike_id`),
  ADD KEY `deletecascade_both_posts3` (`post_id`),
  ADD KEY `deletecascade_both_users2` (`user_id`);

--
-- Index pour la table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`),
  ADD KEY `deletecascade_both_posts2` (`post_id`),
  ADD KEY `deletecascade_both_users` (`user_id`);

--
-- Index pour la table `personal_info`
--
ALTER TABLE `personal_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `personal_info_ibfk_1` (`user_id`);

--
-- Index pour la table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `deletecascade` (`creator_id`);

--
-- Index pour la table `post_media`
--
ALTER TABLE `post_media`
  ADD PRIMARY KEY (`media_id`),
  ADD KEY `deletecascade1` (`post_id`);

--
-- Index pour la table `profile_picture`
--
ALTER TABLE `profile_picture`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `recipe`
--
ALTER TABLE `recipe`
  ADD PRIMARY KEY (`id_recipe`),
  ADD KEY `id_category` (`id_category`),
  ADD KEY `id_cuisine` (`id_cuisine`),
  ADD KEY `id_creator` (`id_creator`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `resetToken` (`resetToken`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `comments_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `content_faq`
--
ALTER TABLE `content_faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `cuisine`
--
ALTER TABLE `cuisine`
  MODIFY `id_Cuisine` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `dislikes`
--
ALTER TABLE `dislikes`
  MODIFY `dislike_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT pour la table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT pour la table `personal_info`
--
ALTER TABLE `personal_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- AUTO_INCREMENT pour la table `post_media`
--
ALTER TABLE `post_media`
  MODIFY `media_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `profile_picture`
--
ALTER TABLE `profile_picture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `recipe`
--
ALTER TABLE `recipe`
  MODIFY `id_recipe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`comment_parent`) REFERENCES `comments` (`comments_id`);

--
-- Contraintes pour la table `dislikes`
--
ALTER TABLE `dislikes`
  ADD CONSTRAINT `deletecascade_both_posts3` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `deletecascade_both_users2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dislikes_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`),
  ADD CONSTRAINT `dislikes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `deletecascade_both_posts` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `deletecascade_both_posts2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `deletecascade_both_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_01` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `personal_info`
--
ALTER TABLE `personal_info`
  ADD CONSTRAINT `personal_info_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `deletecascade` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `post_media`
--
ALTER TABLE `post_media`
  ADD CONSTRAINT `deletecascade1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_parent_id` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_media_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`);

--
-- Contraintes pour la table `recipe`
--
ALTER TABLE `recipe`
  ADD CONSTRAINT `recipe_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `category` (`id_category`),
  ADD CONSTRAINT `recipe_ibfk_2` FOREIGN KEY (`id_cuisine`) REFERENCES `cuisine` (`id_Cuisine`),
  ADD CONSTRAINT `recipe_ibfk_3` FOREIGN KEY (`id_creator`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
