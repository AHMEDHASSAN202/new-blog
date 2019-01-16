-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2019 at 04:41 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `adcms`
--

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `link` text NOT NULL,
  `image` text NOT NULL,
  `start_at` int(11) NOT NULL,
  `end_at` int(11) NOT NULL,
  `page` varchar(20) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `categoryName` varchar(40) NOT NULL,
  `image` varchar(250) DEFAULT NULL,
  `desc` text,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `categoryName`, `image`, `desc`, `status`) VALUES
(20, 0, 'web Design', 'categories/1765f607b219ef74e7b0b229b2a65b9b23245eed.jpg', 'ahmd he fk fjd gg  t', 1),
(28, 0, 'Full stack', 'categories/9684c2a6b6f230a05fdf33b28a05393593f80496.jpg', 'full stack is haskaja ajaa jaaj', 1),
(35, 0, 'Web Developer', 'categories/0e859b038869262842accb5294343ab08e6240dd.jpg', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created` int(11) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `comment`, `created`, `status`) VALUES
(1, 8, 5, 'First Comment', 1533273961, '1'),
(2, 8, 5, 'jhfhgf fkjghf kfgjhg jhfdghf hgjgh ', 1533270131, '1');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(96) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `created` int(11) NOT NULL,
  `reply` text NOT NULL,
  `replied_by` int(11) NOT NULL,
  `replied_at` int(11) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `user_id`, `name`, `email`, `phone`, `subject`, `message`, `created`, `reply`, `replied_by`, `replied_at`, `status`) VALUES
(3, 5, 'ahmed hassan', 'ahmed@gmail.com', '01025369875', 'web', 'fgdgf hjg j jk kfg fkgf kfgf kfg kgjf kfgj fkgjf fgjfk fkgf fkgf hgf jhf njdhf jfh dhfd dhfjd jhfj djhfd djfd jfdgd', 1533273961, 'This First Reply', 5, 1533617186, '1'),
(4, 6, 'mostafa', 'mostafa@gmail.com', '01025369875', 'design', 'hgfj jh jhkjk kj kfgh gfkgf gfkjhgf jdfdjgfd fhdf jdff ksd ksfs kdsjks ksdj ksjds ksds yrer tqrw skjdsf fglf kjfd kdfhf', 1533342340, 'Second Reply 2', 5, 1533617488, '1'),
(6, 6, 'mostafa', 'mostafa@gmail.com', '01025369875', 'design', 'hgfj jh jhkjk kj kfgh gfkgf gfkjhgf jdfdjgfd fhdf jdff ksd ksfs kdsjks ksdj ksjds ksds yrer tqrw skjdsf fglf kjfd kdfhf', 1533342340, 'bla bla bla bla', 5, 1533617516, '1');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `online_users`
--

CREATE TABLE `online_users` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(40) NOT NULL,
  `details` text NOT NULL,
  `image` text NOT NULL,
  `tags` varchar(255) NOT NULL,
  `related_posts` text NOT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `created` varchar(10) DEFAULT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `category_id`, `user_id`, `title`, `details`, `image`, `tags`, `related_posts`, `views`, `created`, `status`) VALUES
(1, 28, 5, 'The New Post', '&lt;p&gt;The New Post The New Post &lt;em&gt;&lt;strong&gt;The New Post&lt;/strong&gt; &lt;/em&gt;The N&lt;strong&gt;ew Post The New Post The New Post The New Post The New Post The New Post The New Post The New Post The New Post The New Post The New Post The New Post The New Post&lt;/strong&gt;&lt;/p&gt;', 'posts/8594942c40525a4bf21b52504beda08811921e82.jpg', 'a:3:{i:0;s:8:\"new post\";i:1;s:10:\"first post\";i:2;s:3:\"bla\";}', 'a:1:{i:0;s:1:\"3\";}', 0, '1530838859', 1),
(2, 28, 5, 'First Pst', '&lt;p&gt;&lt;strong&gt;This is a First Post&lt;/strong&gt;&lt;/p&gt;', 'posts/64c2ba0770f9b7d2ea990f01aa8e871fd1bf531d.jpg', 'a:3:{i:0;s:8:\"new post\";i:1;s:10:\"first post\";i:2;s:3:\"bla\";}', 'a:4:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"4\";i:3;s:1:\"5\";}', 0, '1533270131', 1),
(3, 35, 5, 'Second Post', '&lt;h3&gt;Second &lt;strong&gt;Post and Afte&lt;/strong&gt;r &lt;i&gt;Than First Post&lt;/i&gt;&lt;/h3&gt;', 'posts/f9961937e17e981f795a13ce170b7bbcdad4938b.jpg', 'a:3:{i:0;s:8:\"new post\";i:1;s:10:\"first post\";i:2;s:3:\"bla\";}', 'a:4:{i:0;i:1;i:1;i:4;i:2;i:5;i:3;i:2;}', 0, '1533270966', 1),
(4, 35, 5, 'hghjhgk', '&lt;h2&gt;kjhkjkjfgfhg&lt;strong&gt;h &lt;/strong&gt;&lt;/h2&gt;\r\n&lt;p&gt;jgjhjkkj&lt;/p&gt;', 'posts/be91b86719efb8daa59c5c4c62b4c2b4a8dd7246.jpg', 'a:3:{i:0;s:8:\"new post\";i:1;s:10:\"first post\";i:2;s:3:\"bla\";}', 'a:4:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"5\";i:3;s:1:\"7\";}', 0, '1533273514', 0),
(5, 28, 5, 'fgfhhgjkhk', '&lt;p&gt;gffhgg hkjklk&amp;nbsp; fg h gf kjk lkkl; k&amp;nbsp;&lt;strong&gt; hgjhjh&lt;/strong&gt;&lt;/p&gt;', 'posts/14c3d2cf8ba8ef4d16b23d9845b5f24889551e94.jpg', 'a:3:{i:0;s:8:\"new post\";i:1;s:10:\"first post\";i:2;s:3:\"bla\";}', 'a:4:{i:0;i:1;i:1;i:4;i:2;i:5;i:3;i:2;}', 0, '1533273720', 0),
(6, 35, 5, 'sdgfghf', '&lt;p&gt;gfhgfj&amp;nbsp; kjhkjh fdgfhhgj lk dfgfhgjhlg gtfg&lt;/p&gt;', 'posts/a7022f49fabc7e9eff917cfa039b924db3f5bb20.jpg', 'a:3:{i:0;s:8:\"new post\";i:1;s:10:\"first post\";i:2;s:3:\"bla\";}', 'a:4:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"4\";i:3;s:1:\"5\";}', 0, '1533273765', 0),
(7, 28, 5, 'lfhlkgfhg', '&lt;p&gt;vvvjghk&amp;nbsp; kkj gfh gfjuu&amp;nbsp; lk&amp;nbsp; fgfghg gh&lt;/p&gt;', 'posts/fb836f2de264d56f304df31d804d2381408777a8.jpg', 'a:3:{i:0;s:8:\"new post\";i:1;s:10:\"first post\";i:2;s:3:\"bla\";}', 'a:4:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"4\";i:3;s:1:\"5\";}', 0, '1533273848', 1),
(8, 20, 5, 'Edit Post Too', '&lt;p&gt;&amp;nbsp;,n.,l kj l kj&amp;nbsp;&lt;strong&gt;k kl; ghg&lt;em&gt; hkjhkj ggh dsf f gfhgfh&lt;/em&gt;&lt;span style=&quot;color: #000000;&quot;&gt; my name is ahmed hassan i&#039;m web developer&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;', 'posts/6e2bb27ccaa539c3d9fb4daf535bc10d2328df2d.jpg', 'a:2:{i:0;s:8:\"new post\";i:1;s:10:\"first post\";}', 'a:4:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"4\";i:3;s:1:\"5\";}', 0, '1533273961', 0),
(9, 20, 5, 'second Edit Post', '&lt;p style=&quot;text-align: center;&quot;&gt;hghjhgj jk&amp;nbsp; ffgh kjh dhgfh kjkgh&lt;strong&gt; hghg j&amp;nbsp; f hfg&amp;nbsp; ghhgjjhk j&lt;/strong&gt;&lt;/p&gt;\r\n&lt;p style=&quot;text-align: left;&quot;&gt;&lt;strong&gt;fgfdgf&amp;nbsp; kjhkj kk&amp;nbsp;&lt;em&gt;h kj&lt;/em&gt;&lt;/strong&gt;&lt;/p&gt;', 'posts/ac800da7d0e4a9b25b0262e7dec16f533a2798b6.jpg', 'a:3:{i:0;s:8:\"new post\";i:1;s:10:\"first post\";i:2;s:3:\"bla\";}', 'a:4:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"4\";i:3;s:1:\"5\";}', 0, '1533274086', 1),
(13, 28, 5, 'New Edit Post', '&lt;p&gt;&lt;strong&gt;New Edit Post&lt;/strong&gt;&lt;/p&gt;', 'posts/8d451da2fd31bbcfbc2f94e4165f1aa75015f227.jpg', 'a:3:{i:0;s:8:\"new post\";i:1;s:10:\"first post\";i:2;s:3:\"bla\";}', 'a:4:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"4\";i:3;s:1:\"5\";}', 0, '1533274299', 1),
(14, 28, 5, 'kjfkfdjgf', '&lt;p&gt;hgjh kjjlkjl fghg jh k jk&lt;/p&gt;', 'posts/fdd3ad2e6d4cde52eef150179b46275576b96808.jpg', 'a:4:{i:0;s:5:\"jkjhk\";i:1;s:5:\"jhkjh\";i:2;s:5:\"fhfgh\";i:3;s:4:\"fghg\";}', 'a:3:{i:0;s:1:\"1\";i:1;s:1:\"3\";i:2;s:1:\"8\";}', 0, '1533341296', 1),
(15, 28, 5, 'djfjhgfg', '&lt;p&gt;ghfjn&amp;nbsp; oiupo&lt;strong&gt; loip&amp;nbsp; hygu&lt;em&gt; kjh i rftgf&lt;/em&gt;&lt;/strong&gt;&lt;em&gt;fg&amp;nbsp; jhkj&amp;nbsp;&amp;nbsp;&lt;span style=&quot;background-color: #003366;&quot;&gt; kjklk;lk;&lt;span style=&quot;color: #ffffff;&quot;&gt; hgfj hkhj&lt;strong&gt; jkj&lt;/strong&gt;&lt;/span&gt;&lt;/span&gt;&lt;/em&gt;&lt;span style=&quot;background-color: #003366;&quot;&gt;&lt;span style=&quot;color: #ffffff;&quot;&gt;&lt;strong&gt; jkhjk jlkj&lt;/strong&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;', 'posts/bc7070add84688acc2f6baa62bc840a0a895ef96.jpg', 'a:3:{i:0;s:3:\"dfh\";i:1;s:9:\"gfhfgjghj\";i:2;s:4:\"sfdg\";}', 'a:3:{i:0;s:1:\"3\";i:1;s:1:\"8\";i:2;s:2:\"13\";}', 0, '1533437434', 1),
(16, 35, 5, 'now Post', '&lt;p&gt;hkgfkhg khkljh&amp;nbsp;&lt;strong&gt; hjgjl;hj lfk fgh gf fkjgfk hjmkfjgkf kflgjk&amp;nbsp;&lt;/strong&gt;&lt;/p&gt;', 'posts/9b7aad3af52818e923e6f7a5ef0379b6e9ac4e6a.jpg', 'a:3:{i:0;s:5:\"quets\";i:1;s:6:\"gfhgfj\";i:2;s:4:\"fgfh\";}', 'a:3:{i:0;s:1:\"1\";i:1;s:1:\"3\";i:2;s:1:\"4\";}', 0, '1533520082', 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `key` varchar(100) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`) VALUES
(1, 'site_name', 'New Blog'),
(2, 'site_email', 'blog_blog@gmail.com'),
(3, 'site_status', '1'),
(4, 'site_close_msg', 'Oops! Sorry '),
(5, 'site_logo', 'logo_site.png'),
(6, 'site_copyright', 'ahmedHassan2019');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `users_group_id` int(11) DEFAULT '0',
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(96) NOT NULL,
  `password` varchar(250) NOT NULL,
  `birthday` varchar(100) NOT NULL,
  `gender` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created` varchar(50) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `confirm_id` int(11) NOT NULL,
  `verified` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `users_group_id`, `first_name`, `last_name`, `email`, `password`, `birthday`, `gender`, `status`, `created`, `ip`, `code`, `image`, `confirm_id`, `verified`) VALUES
(5, 31, 'ahmed', 'hassan', 'ahmed@gmail.com', '$2y$10$wR2Ik40LRDIUDFGV2IapHe5SmkRiDuGHixt4NH.vcJIYa8aIV/qtK', '794962800', 1, 1, '1532473967', '127.0.0.1', '15330948765b612bdcceb004c99c99a27768e3e909b51c8e038f855', 'users/cce8790e5045994c5479e5bf814485654ae46b38.jpg', 1, 1),
(6, 0, 'mahmoud', 'ahmed', 'mahmoud@gmail.com', '$2y$10$1WM0q2vKaiVXzxijXpLvmOEOfAWjy0q.UveSyGVomlCltlU8AeXi2', '605228400', 1, 1, '1532552522', '127.0.0.1', '15329235655b5e8ead158a849bb994094b9900a7770df7bf0dd56f7', 'users/f631787a10a3d09740bfc4b7aff2f21c43cbcc3d.jpg', 1, 1),
(8, 10, 'sayed', 'mostafa abooo', 'sayed@gmail.com', '$2y$10$F.hpkeIoOi.QQoWTC17VeeNPkH4ONahy8PBmliQJO8BYeWN3sNKJ2', '920502000', 1, 1, '1532923782', '127.0.0.1', '15329237825b5e8f86148b8f16631c2d87b20385a2764fd99586030', 'users/4bbdeb2bc7eed688908a64a67df19969bc0106f2.jpg', 1, 1),
(9, 0, 'hassan', 'mohamed', 'hassan@gmail.com', '$2y$10$lxwVk8.qgsXNJMBWnj9J9ON3zItkTjArVIlKHWWk1rA7jCEquVtby', '923176800', 1, 1, '1533342267', '127.0.0.1', '15333422675b64f23b02c04d69ea81ba7c568a57ce9fba347a52e64', 'users/ff13d00b15f0d5f465a27f6bc04b1d0602c33cd3.jpg', 1, 1),
(10, 0, 'hassan', 'mostafa', 'hassansss@gmail.com', '$2y$10$wQJxQYdm5AoEkRxYeg62AOu4bg0dhSy/zT/Xz6i0v.cSrSJ88rSJa', '928620000', 1, 1, '1533342297', '127.0.0.1', '15333422975b64f259f369e3dee812575d3f371791ab58aab64a283', 'users/default avatar.png', 1, 1),
(11, 0, 'ghjhgjh', 'fdgfdg', 'hgfhghgf@gmail.com', '$2y$10$bKGDc8JQNH6vUs3ySRk5BeAAQyAPfvDJDMP3A2jzGMWRm23rna2ji', '922831200', 1, 1, '1533342340', '127.0.0.1', '15333423405b64f28477b1770b67110f02c0ed4d7a72b49e77b435b', 'users/default avatar.png', 1, 1),
(12, 10, 'ajfkjdkgf', 'dssfgdkgf', 'hgjhkjh@gmail.com', '$2y$10$0bjRjqPDxNYB4JsZj9u3we8sdPtUWBpD9EPjpK5Ny5Euxvqw7f8te', '925682400', 1, 1, '1533342375', '127.0.0.1', '15333423755b64f2a76521984a09a4b96cb8bfc94544ac8397636f2', 'users/default avatar.png', 1, 1),
(13, 10, 'gfghg', 'hkjh', 'dfdfdghgf@yahoo.com', '$2y$10$86LeiE1dy6HoN9ueH9KL.eIbUaiLm5toruYa8BPdyS7DiclNUJneS', '925768800', 0, 1, '1533342404', '127.0.0.1', '15333424045b64f2c46b387fa5c697333bc11bb33286e9e420d840c', 'users/default avatar.png', 1, 1),
(14, 0, 'hassan', '78oiup', 'poppo@gmail.com', '$2y$10$XRE6JD3gb7YQr9Hr9gVNWuN.G5UYozl6M1T4kl0H0NlRwnFo5u2/O', '923263200', 0, 1, '1533429759', '127.0.0.1', '15334297595b6647ff64d89ba3825f679b59c5b0828041fbbebe185', 'users/ce202c9a7cadb92f385d84d04bb8b93328007e3c.jpg', 1, 1),
(15, 0, 'jfhjfhfjs', 'kfgkjgh', 'hjgkhjfg@gmail.com', '$2y$10$EIKr1paZDHaFeRdz6IRbQOvn.UheEdPsb2B/Rnp.IxUROfsrhbc8u', '579304800', 0, 1, '1533429938', '127.0.0.1', '15334299385b6648b2d5c55d1a79cc346ea6feeb65b87e73e28b1f9', 'users/c32b08cc9894c4f9cb2df03e2a762ac0a17efc0a.jpg', 1, 1),
(16, 15, 'lfhkgjhj', 'dgfyhfg', 'fdfggh@gmail.com', '$2y$10$drFZ6LcOMa40yztBxGRw3e0ZKdRZ7JjVL/YmA2UtLGCIZNIEYwQXy', '957391200', 0, 1, '1533429989', '127.0.0.1', '15334299895b6648e59b07661806240b46ec83d85f7d250bdbc7c2c', 'users/0c34d8d538a43a2ba55a5efd6c46bf1faefbc2ed.jpg', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users_group`
--

CREATE TABLE `users_group` (
  `id` int(11) NOT NULL,
  `permission` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_group`
--

INSERT INTO `users_group` (`id`, `permission`) VALUES
(0, 'users'),
(10, 'Publisher'),
(15, 'Editor'),
(31, 'administrator'),
(32, 'bla');

-- --------------------------------------------------------

--
-- Table structure for table `users_group_permissions`
--

CREATE TABLE `users_group_permissions` (
  `id` int(11) NOT NULL,
  `users_group_id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_group_permissions`
--

INSERT INTO `users_group_permissions` (`id`, `users_group_id`, `name`, `url`) VALUES
(47, 15, 'userPage', 'http://www.blog.test/admin/users'),
(48, 15, 'addUser', 'http://www.blog.test/admin/users/add'),
(49, 15, 'deleteUser', 'http://www.blog.test/admin/users/delete/:id'),
(50, 15, 'rolesPage', 'http://www.blog.test/admin/roles'),
(51, 15, 'addRoles', 'http://www.blog.test/admin/roles/save/0'),
(52, 15, 'deleteRoles', 'http://www.blog.test/admin/roles/delete/:id'),
(53, 15, 'categoriesPage', 'http://www.blog.test/admin/categories'),
(54, 15, 'adCategories', 'http://www.blog.test/admin/categories/save'),
(55, 15, 'deleteCategories', 'http://www.blog.test/admin/categories/delete/:id'),
(56, 15, 'postsPage', 'http://www.blog.test/admin/posts'),
(57, 15, 'editPosts', 'http://www.blog.test/admin/posts/save/:id'),
(58, 15, 'deletePosts', 'http://www.blog.test/admin/posts/delete/:id'),
(59, 15, 'adsPage', 'http://www.blog.test/admin/ads'),
(60, 15, 'editAds', 'http://www.blog.test/admin/ads/save/:id'),
(61, 15, 'deleteAds', 'http://www.blog.test/admin/ads/delete/:id'),
(62, 15, 'settingsPage', 'http://www.blog.test/admin/settings'),
(242, 10, 'postsPage', 'http://www.blog.test/admin/posts'),
(243, 10, 'addPosts', 'http://www.blog.test/admin/posts/save/0'),
(244, 10, 'editPosts', 'http://www.blog.test/admin/posts/save/:id'),
(245, 10, 'deletePosts', 'http://www.blog.test/admin/posts/delete/:id'),
(246, 10, 'settingsPage', 'http://www.blog.test/admin/settings'),
(1238, 31, 'userPage', 'http://www.blog.test/admin/users'),
(1239, 31, 'userGet', 'http://www.blog.test/admin/users/get'),
(1240, 31, 'userModal', 'http://www.blog.test/admin/users/modal/:id'),
(1241, 31, 'adminsGet', 'http://www.blog.test/admin/admins/get'),
(1242, 31, 'userSearch', 'http://www.blog.test/admin/search/users'),
(1243, 31, 'userPagination', 'http://www.blog.test/admin/pagination/:text'),
(1244, 31, 'addUser', 'http://www.blog.test/admin/users/add'),
(1245, 31, 'editUser', 'http://www.blog.test/admin/users/edit/:id'),
(1246, 31, 'deleteUser', 'http://www.blog.test/admin/users/delete/:id'),
(1247, 31, 'viewUser', 'http://www.blog.test/admin/users/view/:id'),
(1248, 31, 'rolesPage', 'http://www.blog.test/admin/roles'),
(1249, 31, 'addRoles', 'http://www.blog.test/admin/roles/save/0'),
(1250, 31, 'editRoles', 'http://www.blog.test/admin/roles/save/:id'),
(1251, 31, 'deleteRoles', 'http://www.blog.test/admin/roles/delete/:id'),
(1252, 31, 'viewRoles', 'http://www.blog.test/admin/roles/get/:id'),
(1253, 31, 'categoriesPage', 'http://www.blog.test/admin/categories'),
(1254, 31, 'addCategories', 'http://www.blog.test/admin/categories/save'),
(1255, 31, 'editCategories', 'http://www.blog.test/admin/categories/edit/:id'),
(1256, 31, 'deleteCategories', 'http://www.blog.test/admin/categories/delete/:id'),
(1257, 31, 'postsPage', 'http://www.blog.test/admin/posts'),
(1258, 31, 'postsSearch', 'http://www.blog.test/admin/search/posts'),
(1259, 31, 'postsLoad', 'http://www.blog.test/admin/posts/load/:text/:id'),
(1260, 31, 'addPosts', 'http://www.blog.test/admin/posts/add'),
(1261, 31, 'editPosts', 'http://www.blog.test/admin/posts/edit/:id'),
(1262, 31, 'deletePosts', 'http://www.blog.test/admin/posts/delete/:id'),
(1263, 31, 'messagesPage', 'http://www.blog.test/admin/messages'),
(1264, 31, 'replyMessages', 'http://www.blog.test/admin/messages/reply/:id'),
(1265, 31, 'deleteMessages', 'http://www.blog.test/admin/messages/delete/:id'),
(1266, 31, 'viewMessages', 'http://www.blog.test/admin/messages/view/:id'),
(1267, 31, 'settingsPage', 'http://www.blog.test/admin/settings'),
(1268, 31, 'editSettings', 'http://www.blog.test/admin/settings/save'),
(1269, 32, 'userPage', 'http://www.blog.test/admin/users'),
(1270, 32, 'userGet', 'http://www.blog.test/admin/users/get'),
(1271, 32, 'userModal', 'http://www.blog.test/admin/users/modal/:id'),
(1272, 32, 'adminsGet', 'http://www.blog.test/admin/admins/get'),
(1273, 32, 'userSearch', 'http://www.blog.test/admin/search/users'),
(1274, 32, 'userPagination', 'http://www.blog.test/admin/pagination/:text'),
(1275, 32, 'viewUser', 'http://www.blog.test/admin/users/view/:id'),
(1276, 32, 'rolesPage', 'http://www.blog.test/admin/roles'),
(1277, 32, 'deleteRoles', 'http://www.blog.test/admin/roles/delete/:id'),
(1278, 32, 'categoriesPage', 'http://www.blog.test/admin/categories'),
(1279, 32, 'addCategories', 'http://www.blog.test/admin/categories/save'),
(1280, 32, 'postsPage', 'http://www.blog.test/admin/posts'),
(1281, 32, 'addPosts', 'http://www.blog.test/admin/posts/add'),
(1282, 32, 'editPosts', 'http://www.blog.test/admin/posts/edit/:id'),
(1283, 32, 'settingsPage', 'http://www.blog.test/admin/settings'),
(1284, 32, 'editSettings', 'http://www.blog.test/admin/settings/save');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_comments` (`user_id`),
  ADD KEY `comments_post` (`post_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `online_users`
--
ALTER TABLE `online_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_ID` (`category_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `UsersGroups` (`users_group_id`);

--
-- Indexes for table `users_group`
--
ALTER TABLE `users_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_group_permissions`
--
ALTER TABLE `users_group_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Permission_Roles` (`users_group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_users`
--
ALTER TABLE `online_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users_group`
--
ALTER TABLE `users_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users_group_permissions`
--
ALTER TABLE `users_group_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1285;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_comments` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `category_ID` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `UsersGroups` FOREIGN KEY (`users_group_id`) REFERENCES `users_group` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `users_group_permissions`
--
ALTER TABLE `users_group_permissions`
  ADD CONSTRAINT `Permission_Roles` FOREIGN KEY (`users_group_id`) REFERENCES `users_group` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
