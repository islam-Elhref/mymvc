-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2021 at 10:47 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mymvc`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `client_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(40) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `email` varchar(40) NOT NULL,
  `address` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`client_id`, `name`, `phone`, `email`, `address`) VALUES
(2, 'احمد محمود', '01157874628', 'ahmedmohamed@yahoo.com', 'مطاي البلد'),
(9, 'محمود محروس', '01157874622', 'mahmoud@yahoo.com', 'مطاي شارع الحمام'),
(11, 'خالد علي', '01651651561', 'kaled@yahoo.com', 'مطاي');

-- --------------------------------------------------------

--
-- Table structure for table `expenses_categories`
--

CREATE TABLE `expenses_categories` (
  `expense_category_id` tinyint(3) UNSIGNED NOT NULL,
  `expense_name` varchar(30) NOT NULL,
  `fixed_payment` decimal(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `expenses_daily_list`
--

CREATE TABLE `expenses_daily_list` (
  `expense_id` int(11) NOT NULL,
  `expense_category_id` tinyint(3) UNSIGNED NOT NULL,
  `payment` decimal(7,2) NOT NULL,
  `created` datetime NOT NULL,
  `emp_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notification_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(30) NOT NULL,
  `content` varchar(255) NOT NULL,
  `type` tinyint(2) UNSIGNED NOT NULL,
  `created` date NOT NULL DEFAULT current_timestamp(),
  `user_id` int(10) UNSIGNED NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `object` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notification_id`, `title`, `content`, `type`, `created`, `user_id`, `url`, `name`, `object`) VALUES
(76, 'notif_usersgroups_title', 'notif_usersgroups_content_add', 0, '2021-11-22', 44, '/usersgroups/edit/38', 'qqq', NULL),
(77, 'notif_usersgroups_title', 'notif_usersgroups_content_edit', 1, '2021-11-22', 44, '/usersgroups/edit/38', 'dddd', 'a:5:{s:8:\"group_id\";s:2:\"38\";s:10:\"group_name\";s:3:\"qqq\";i:87;s:16:\"الموردين\";i:93;s:14:\"العملاء\";i:94;s:27:\"عرض المستخدمين\";}'),
(78, 'notif_usersgroups_title', 'notif_usersgroups_content_delete', 2, '2021-11-22', 44, '', 'dddd', 'a:7:{s:8:\"group_id\";s:2:\"38\";s:10:\"group_name\";s:4:\"dddd\";i:87;s:16:\"الموردين\";i:93;s:14:\"العملاء\";i:94;s:27:\"عرض المستخدمين\";i:95;s:23:\"اضافة مستخدم\";i:96;s:23:\"تعديل مستخدم\";}'),
(79, 'notif_user_title', 'notif_user_content_add', 0, '2021-11-22', 44, '/users/edit/61', 'mohamed8', NULL),
(80, 'notif_user_title', 'notif_user_content_edit', 1, '2021-11-22', 44, '/users/edit/61', 'mohamed9', 'O:23:\"MYMVC\\MODELS\\UsersModel\":10:{s:10:\"\0*\0user_id\";s:2:\"61\";s:11:\"\0*\0username\";s:8:\"mohamed8\";s:8:\"\0*\0email\";s:18:\"mohamed8@yahoo.com\";s:8:\"\0*\0phone\";s:11:\"01050566637\";s:11:\"\0*\0group_id\";s:2:\"31\";s:20:\"\0*\0subscription_date\";s:10:\"2021-11-22\";s:13:\"\0*\0last_login\";N;s:13:\"\0*\0group_name\";s:8:\"ادمن\";s:10:\"\0*\0profile\";N;s:11:\"statue_name\";s:48:\"غير مفعل يرجي تسجيل الدخول\";}'),
(81, 'notif_user_title', 'notif_user_content_edit', 1, '2021-11-22', 44, '/users/edit/61', 'mohamed9', 'O:23:\"MYMVC\\MODELS\\UsersModel\":10:{s:10:\"\0*\0user_id\";s:2:\"61\";s:11:\"\0*\0username\";s:8:\"mohamed9\";s:8:\"\0*\0email\";s:18:\"mohamed8@yahoo.com\";s:8:\"\0*\0phone\";s:11:\"01050566637\";s:11:\"\0*\0group_id\";s:2:\"31\";s:20:\"\0*\0subscription_date\";s:10:\"2021-11-22\";s:13:\"\0*\0last_login\";N;s:13:\"\0*\0group_name\";s:8:\"ادمن\";s:10:\"\0*\0profile\";N;s:11:\"statue_name\";s:10:\"محظور\";}'),
(82, 'notif_user_title', 'notif_user_content_delete', 2, '2021-11-22', 44, '/users/edit/61', 'mohamed9', 'O:23:\"MYMVC\\MODELS\\UsersModel\":10:{s:10:\"\0*\0user_id\";s:2:\"61\";s:11:\"\0*\0username\";s:8:\"mohamed9\";s:8:\"\0*\0email\";s:18:\"mohamed8@yahoo.com\";s:8:\"\0*\0phone\";s:11:\"01050566637\";s:11:\"\0*\0group_id\";s:2:\"31\";s:20:\"\0*\0subscription_date\";s:10:\"2021-11-22\";s:13:\"\0*\0last_login\";N;s:13:\"\0*\0group_name\";s:8:\"ادمن\";s:10:\"\0*\0profile\";N;s:11:\"statue_name\";s:10:\"محظور\";}');

-- --------------------------------------------------------

--
-- Table structure for table `privilege_control`
--

CREATE TABLE `privilege_control` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `group_id` tinyint(1) UNSIGNED NOT NULL,
  `privilege_id` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `privilege_control`
--

INSERT INTO `privilege_control` (`id`, `group_id`, `privilege_id`) VALUES
(27, 31, 87),
(28, 31, 93),
(29, 31, 94),
(30, 31, 95),
(31, 31, 96),
(32, 31, 97),
(33, 31, 98),
(34, 31, 99),
(35, 31, 100),
(36, 31, 101),
(37, 31, 102),
(38, 31, 103),
(39, 31, 104),
(40, 31, 105),
(41, 32, 94),
(42, 32, 98),
(43, 32, 102),
(44, 31, 106),
(45, 31, 108),
(46, 31, 109),
(47, 31, 110),
(48, 31, 112),
(49, 31, 113),
(50, 31, 114),
(51, 31, 115),
(52, 31, 116),
(53, 31, 117),
(54, 31, 118),
(55, 31, 119),
(56, 31, 120),
(57, 31, 121),
(58, 31, 122),
(59, 31, 123),
(60, 31, 124),
(61, 31, 125),
(62, 31, 126),
(63, 31, 127),
(64, 31, 128),
(65, 31, 129),
(66, 31, 130),
(67, 31, 131),
(68, 31, 132),
(69, 31, 133),
(70, 31, 134),
(71, 31, 135),
(73, 31, 137),
(74, 31, 138),
(75, 31, 139),
(77, 31, 141),
(78, 31, 142);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(10) UNSIGNED NOT NULL,
  `category_id` tinyint(3) UNSIGNED NOT NULL,
  `product_name` varchar(40) NOT NULL,
  `BuyPrice` decimal(7,2) NOT NULL,
  `barcode` char(20) DEFAULT NULL,
  `unit` tinyint(1) NOT NULL,
  `SellPrice` decimal(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `product_name`, `BuyPrice`, `barcode`, `unit`, `SellPrice`) VALUES
(3, 22, 'زيت شعر فاتيكا', '50.00', NULL, 1, '70.00'),
(4, 22, 'زيت شعر حرير', '100.00', NULL, 1, '110.00'),
(10, 24, 'حنفيه بلاستيك حجم صغير', '35.00', NULL, 1, '45.00'),
(12, 22, 'زيت دابر فاتيكا', '100.00', NULL, 2, '150.00'),
(29, 22, 'جلبه حديد', '50.00', NULL, 1, '600.00');

-- --------------------------------------------------------

--
-- Table structure for table `products_categories`
--

CREATE TABLE `products_categories` (
  `category_id` tinyint(3) UNSIGNED NOT NULL,
  `category_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products_categories`
--

INSERT INTO `products_categories` (`category_id`, `category_name`) VALUES
(24, 'حنفيات'),
(22, 'زيوت');

-- --------------------------------------------------------

--
-- Table structure for table `purchases_bills`
--

CREATE TABLE `purchases_bills` (
  `bill_id` int(10) UNSIGNED NOT NULL,
  `supplier_id` int(10) UNSIGNED NOT NULL,
  `payment_type` tinyint(1) UNSIGNED NOT NULL COMMENT '(1 = بالتقسيط ) (2 = كاش)',
  `payment_status` tinyint(1) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `purchases_bills`
--

INSERT INTO `purchases_bills` (`bill_id`, `supplier_id`, `payment_type`, `payment_status`, `user_id`, `created`) VALUES
(49, 36, 2, 0, 42, '2021-11-21');

-- --------------------------------------------------------

--
-- Table structure for table `purchases_orders`
--

CREATE TABLE `purchases_orders` (
  `order_id` int(10) UNSIGNED NOT NULL,
  `purchases_bill_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `order_quantity` smallint(5) UNSIGNED NOT NULL,
  `order_price` decimal(8,2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `purchases_orders`
--

INSERT INTO `purchases_orders` (`order_id`, `purchases_bill_id`, `product_id`, `order_quantity`, `order_price`) VALUES
(62, 49, 3, 500, '25000.00'),
(63, 49, 4, 500, '50000.00'),
(64, 49, 12, 500, '50000.00'),
(65, 49, 29, 60, '3000.00');

-- --------------------------------------------------------

--
-- Table structure for table `purchases_receipt`
--

CREATE TABLE `purchases_receipt` (
  `receipt_id` int(10) UNSIGNED NOT NULL,
  `bill_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `receipt_price` decimal(8,2) UNSIGNED NOT NULL,
  `reciept_literal_price` varchar(50) NOT NULL,
  `reciept_type` tinyint(1) UNSIGNED NOT NULL,
  `bank_name` varchar(50) DEFAULT NULL,
  `bank_account_number` varchar(50) DEFAULT NULL,
  `check_number` varchar(15) DEFAULT NULL,
  `transferedto` varchar(30) DEFAULT NULL,
  `date_of_receipt` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `purchases_receipt`
--

INSERT INTO `purchases_receipt` (`receipt_id`, `bill_id`, `user_id`, `receipt_price`, `reciept_literal_price`, `reciept_type`, `bank_name`, `bank_account_number`, `check_number`, `transferedto`, `date_of_receipt`) VALUES
(27, 49, 44, '5000.00', 'خمسائة الاف ', 1, NULL, NULL, NULL, NULL, '2021-11-16'),
(28, 49, 44, '100000.00', 'مائه الف', 1, NULL, NULL, NULL, NULL, '2021-11-16');

-- --------------------------------------------------------

--
-- Table structure for table `sales_bills`
--

CREATE TABLE `sales_bills` (
  `bill_id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `payment_type` tinyint(1) UNSIGNED NOT NULL,
  `payment_status` tinyint(1) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sales_bills`
--

INSERT INTO `sales_bills` (`bill_id`, `client_id`, `payment_type`, `payment_status`, `user_id`, `created`) VALUES
(6, 2, 2, 0, 44, '2021-11-16'),
(7, 2, 2, 0, 44, '2021-11-16'),
(8, 2, 2, 0, 44, '2021-11-16'),
(9, 2, 1, 0, 44, '2021-11-16');

-- --------------------------------------------------------

--
-- Table structure for table `sales_orders`
--

CREATE TABLE `sales_orders` (
  `order_id` int(10) UNSIGNED NOT NULL,
  `sales_bill_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `order_quantity` smallint(5) UNSIGNED NOT NULL,
  `order_price` decimal(8,2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sales_orders`
--

INSERT INTO `sales_orders` (`order_id`, `sales_bill_id`, `product_id`, `order_quantity`, `order_price`) VALUES
(17, 6, 3, 20, '1000.00'),
(18, 6, 4, 20, '2000.00'),
(19, 6, 12, 20, '2000.00'),
(20, 7, 4, 300, '30000.00'),
(21, 8, 3, 30, '1500.00'),
(22, 8, 4, 100, '10000.00'),
(23, 9, 3, 100, '5000.00'),
(24, 9, 4, 50, '5000.00');

-- --------------------------------------------------------

--
-- Table structure for table `sales_receipt`
--

CREATE TABLE `sales_receipt` (
  `receipt_id` int(10) UNSIGNED NOT NULL,
  `bill_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `receipt_price` decimal(8,2) UNSIGNED NOT NULL,
  `reciept_literal_price` varchar(50) NOT NULL,
  `reciept_type` tinyint(1) UNSIGNED NOT NULL,
  `bank_name` varchar(50) DEFAULT NULL,
  `bank_account_number` varchar(50) DEFAULT NULL,
  `check_number` varchar(15) DEFAULT NULL,
  `transferedto` varchar(30) DEFAULT NULL,
  `date_of_receipt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sales_receipt`
--

INSERT INTO `sales_receipt` (`receipt_id`, `bill_id`, `user_id`, `receipt_price`, `reciept_literal_price`, `reciept_type`, `bank_name`, `bank_account_number`, `check_number`, `transferedto`, `date_of_receipt`) VALUES
(8, 6, 44, '2000.00', 'الفان', 1, NULL, NULL, NULL, NULL, '2021-11-15 22:00:00'),
(9, 6, 44, '1000.00', 'الف جنيه', 1, NULL, NULL, NULL, NULL, '2021-11-15 22:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `suppliers_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(40) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `email` varchar(40) NOT NULL,
  `address` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`suppliers_id`, `name`, `phone`, `email`, `address`) VALUES
(33, 'مصنع برفاناتك عندنا', '01050566637', 'ealhref2@yahoo.com', 'مطاي البلد'),
(35, 'المصنع الدولي بالقاهره', '01157462584', 'garethbale@yahoo.com', 'المركز الطبي بمطاي شارع الحمام'),
(36, 'مصنع الزيوت بالمنيب', '01115748525', 'oil@yahoo.com', 'المنيب');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` char(60) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `group_id` tinyint(1) UNSIGNED NOT NULL,
  `subscription_date` date NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `phone`, `group_id`, `subscription_date`, `last_login`, `status`) VALUES
(42, 'mohamed', '$2y$10$LPMTufjCpcr8GkmggANAmuTOMfEXVmM6cECpR4MshufwWWnelRtOe', 'mohamed@yahoo.com', '0168591376', 31, '2021-10-19', '2021-11-21 06:54:09', 1),
(44, 'ealhref', '$2y$10$Mn2qqNeOJvMdm0DJQN5sIOITbicFUvQ6EB.ogrRfoPRHltkLQnHx2', 'ealhref@yahoo.com', '01157874628', 31, '2021-10-19', '2021-11-22 04:11:50', 1),
(56, 'islam1', '$2y$10$AGB0Oyu2cyJtI9hpexkkfu5x/4sh62nYFQWSbwKILfsarEHqlcw6u', 'islam1@yahoo.com', '01050566637', 31, '2021-10-27', '2021-10-27 04:43:58', 1),
(57, 'mohamed2', '$2y$10$TejCS7Ls6cpr0bqQBzgzhODxKxR9InRFs6nJBzckIYrpS8.RTs2UW', 'mohamed2@yahoo.com', '01050566637', 31, '2021-10-27', '2021-11-07 06:15:55', 1),
(58, 'khaled', '$2y$10$Lm0IEut2Kg8zaSry8/Ts8uz0pG4qdayDwZ1R9yH1DLVHnsJmIlmvG', 'mohaned@yahoo.com', '01111111111', 31, '2021-11-17', '2021-11-17 01:11:23', 1),
(59, 'mahmoud', '$2y$10$qzy62j9TaoitdGn70zXle.uHYD.51SyYqq.gt5LiMf2SotbSvfoie', 'mahmoud@yahoo.com', '01050566637', 31, '2021-11-22', NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users_group`
--

CREATE TABLE `users_group` (
  `group_id` tinyint(1) UNSIGNED NOT NULL,
  `group_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_group`
--

INSERT INTO `users_group` (`group_id`, `group_name`) VALUES
(31, 'ادمن'),
(32, 'مشاهد');

-- --------------------------------------------------------

--
-- Table structure for table `users_privilege`
--

CREATE TABLE `users_privilege` (
  `privilege_id` tinyint(3) UNSIGNED NOT NULL,
  `privilege_name` varchar(30) NOT NULL,
  `privilege_url` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_privilege`
--

INSERT INTO `users_privilege` (`privilege_id`, `privilege_name`, `privilege_url`) VALUES
(87, 'الموردين', '/suppliers/default'),
(93, 'العملاء', '/clients/default'),
(94, 'عرض المستخدمين', '/users/default'),
(95, 'اضافة مستخدم', '/users/add'),
(96, 'تعديل مستخدم', '/users/edit'),
(97, 'حذف مستخدم', '/users/delete'),
(98, 'عرض الصلاحيات', '/privileges/default'),
(99, 'اضافة صلاحيه', '/privileges/add'),
(100, 'تعديل صلاحيه', '/privileges/edit'),
(101, 'حذف صلاحيه', '/privileges/delete'),
(102, 'عرض مجموعات المستخدمين', '/usersgroups/default'),
(103, 'اضافة مجموعة مستخدمين', '/usersgroups/add'),
(104, 'تعديل مجموعة المستخدمين', '/usersgroups/edit'),
(105, 'حذف مجموعة المستخدمين', '/usersgroups/delete'),
(106, 'حظر مستخدم', '/users/permit'),
(108, 'اضافة مورد', '/suppliers/add'),
(109, 'تعديل مورد', '/suppliers/edit'),
(110, 'حذف مورد', '/suppliers/delete'),
(112, 'اضافة عميل جديد', '/clients/add'),
(113, 'حذف عميل', '/clients/delete'),
(114, 'تعديل عميل', '/clients/edit'),
(115, 'عرض اقسام المنتجات', '/productscategory/default'),
(116, 'اضافة قسم منتجات جديد', '/productscategory/add'),
(117, 'تعديل قسم منتجات', '/productscategory/edit'),
(118, 'حذف قسم منتجات', '/productscategory/delete'),
(119, 'المنتجات', '/products/default'),
(120, 'اضافة منتج جداد', '/products/add'),
(121, 'تعديل منتج', '/products/edit'),
(122, 'حذف منتج', '/products/delete'),
(123, 'عرض فواتير المشتريات', '/purchases/default'),
(124, 'اضافة فاتوره مشتريات جديده', '/purchases/add'),
(125, 'تعديل فاتوره مشتريات', '/purchases/edit'),
(126, 'حذف فاتوره مشتريات', '/purchases/delete'),
(127, 'اضافة منتج في الفاتوره ', '/products/getproduct'),
(128, 'المبيعات', '/sales/default'),
(129, 'اضافة فاتورة مبيعات جديده', '/sales/add'),
(130, 'تعديل فاتوره مبيعات', '/sales/edit'),
(131, 'حذف فاتوره مبيعات', '/sales/delete'),
(132, 'طباعة فاتوره شراء', '/purchases/print'),
(133, 'طباعة فاتورة بيع', '/sales/print'),
(134, 'ايصالات المشتريات', '/receiptspurchases/default'),
(135, 'اضافة ايصال مشتريات', '/receiptspurchases/add'),
(137, 'حذف ايصال مشتريات', '/receiptspurchases/delete'),
(138, 'ايصال مبيعات', '/receiptssales/default'),
(139, 'اضافة ايصال مبيعات', '/receiptssales/add'),
(141, 'حذف ايصال مبيعات', '/receiptssales/delete'),
(142, 'التنبيهات المحذوفه والمعدله', '/notification/show');

-- --------------------------------------------------------

--
-- Table structure for table `users_profile`
--

CREATE TABLE `users_profile` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `firstname` varchar(10) NOT NULL,
  `lastname` varchar(10) NOT NULL,
  `address` varchar(50) DEFAULT NULL,
  `image` char(30) NOT NULL,
  `dob` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_profile`
--

INSERT INTO `users_profile` (`user_id`, `firstname`, `lastname`, `address`, `image`, `dob`) VALUES
(42, 'اسلام', 'علي', 'مطاي البلد', '729923_٢٠٢٠٠٥١٤_٠١٠٨٢٩.jpg', '2021-10-19'),
(44, 'خالد', 'علي عباس', 'مطاي البلد', 'zmiwzwfmntblzwi0mzizmwe2nm.jpg', '1996-09-01'),
(56, 'اسلام', 'محمود', 'المركز الطبي بمطاي شارع الحمام', 'owu2mzyxnwjjyja4n2rmzdiyzt.jpg', '2021-10-27'),
(57, 'اسماء', 'محمد', 'المركز الطبي بمطاي شارع الحمام', 'ntmzmjdiyzkxndawywzmntq2yt.jpg', '2021-10-27'),
(58, 'خالد', 'ابراهيم', 'مطاي الفوريقه', 'nmqwzmfmmmeynjk4zwy0mwyxzj.jpg', '2021-11-11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `expenses_categories`
--
ALTER TABLE `expenses_categories`
  ADD PRIMARY KEY (`expense_category_id`),
  ADD UNIQUE KEY `expense_name` (`expense_name`);

--
-- Indexes for table `expenses_daily_list`
--
ALTER TABLE `expenses_daily_list`
  ADD PRIMARY KEY (`expense_id`),
  ADD KEY `expense_category_id` (`expense_category_id`),
  ADD KEY `emp_id` (`emp_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `privilege_control`
--
ALTER TABLE `privilege_control`
  ADD PRIMARY KEY (`id`),
  ADD KEY `privilege_id` (`group_id`),
  ADD KEY `privilege_id_2` (`privilege_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `product_name` (`product_name`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `products_categories`
--
ALTER TABLE `products_categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `purchases_bills`
--
ALTER TABLE `purchases_bills`
  ADD PRIMARY KEY (`bill_id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `purchases_orders`
--
ALTER TABLE `purchases_orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `purchases_orders_ibfk_1` (`purchases_bill_id`);

--
-- Indexes for table `purchases_receipt`
--
ALTER TABLE `purchases_receipt`
  ADD PRIMARY KEY (`receipt_id`),
  ADD KEY `bill_id` (`bill_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `sales_bills`
--
ALTER TABLE `sales_bills`
  ADD PRIMARY KEY (`bill_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `sales_orders`
--
ALTER TABLE `sales_orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `sales_orders_ibfk_1` (`sales_bill_id`);

--
-- Indexes for table `sales_receipt`
--
ALTER TABLE `sales_receipt`
  ADD PRIMARY KEY (`receipt_id`),
  ADD KEY `bill_id` (`bill_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`suppliers_id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `privilege` (`group_id`);

--
-- Indexes for table `users_group`
--
ALTER TABLE `users_group`
  ADD PRIMARY KEY (`group_id`),
  ADD UNIQUE KEY `group_name` (`group_name`);

--
-- Indexes for table `users_privilege`
--
ALTER TABLE `users_privilege`
  ADD PRIMARY KEY (`privilege_id`),
  ADD UNIQUE KEY `url_privilege` (`privilege_url`),
  ADD UNIQUE KEY `privilege_name` (`privilege_name`);

--
-- Indexes for table `users_profile`
--
ALTER TABLE `users_profile`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `client_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notification_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `privilege_control`
--
ALTER TABLE `privilege_control`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `products_categories`
--
ALTER TABLE `products_categories`
  MODIFY `category_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `purchases_bills`
--
ALTER TABLE `purchases_bills`
  MODIFY `bill_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `purchases_orders`
--
ALTER TABLE `purchases_orders`
  MODIFY `order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `purchases_receipt`
--
ALTER TABLE `purchases_receipt`
  MODIFY `receipt_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `sales_bills`
--
ALTER TABLE `sales_bills`
  MODIFY `bill_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sales_orders`
--
ALTER TABLE `sales_orders`
  MODIFY `order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `sales_receipt`
--
ALTER TABLE `sales_receipt`
  MODIFY `receipt_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `suppliers_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `users_group`
--
ALTER TABLE `users_group`
  MODIFY `group_id` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `users_privilege`
--
ALTER TABLE `users_privilege`
  MODIFY `privilege_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `expenses_daily_list`
--
ALTER TABLE `expenses_daily_list`
  ADD CONSTRAINT `expenses_daily_list_ibfk_1` FOREIGN KEY (`expense_category_id`) REFERENCES `expenses_categories` (`expense_category_id`),
  ADD CONSTRAINT `expenses_daily_list_ibfk_2` FOREIGN KEY (`emp_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `privilege_control`
--
ALTER TABLE `privilege_control`
  ADD CONSTRAINT `privilege_control_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `users_group` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `privilege_control_ibfk_2` FOREIGN KEY (`privilege_id`) REFERENCES `users_privilege` (`privilege_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `products_categories` (`category_id`);

--
-- Constraints for table `purchases_bills`
--
ALTER TABLE `purchases_bills`
  ADD CONSTRAINT `purchases_bills_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`suppliers_id`),
  ADD CONSTRAINT `purchases_bills_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `purchases_orders`
--
ALTER TABLE `purchases_orders`
  ADD CONSTRAINT `purchases_orders_ibfk_1` FOREIGN KEY (`purchases_bill_id`) REFERENCES `purchases_bills` (`bill_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchases_orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `purchases_receipt`
--
ALTER TABLE `purchases_receipt`
  ADD CONSTRAINT `purchases_receipt_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `purchases_bills` (`bill_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchases_receipt_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `sales_bills`
--
ALTER TABLE `sales_bills`
  ADD CONSTRAINT `sales_bills_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`),
  ADD CONSTRAINT `sales_bills_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `sales_orders`
--
ALTER TABLE `sales_orders`
  ADD CONSTRAINT `sales_orders_ibfk_1` FOREIGN KEY (`sales_bill_id`) REFERENCES `sales_bills` (`bill_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sales_orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `sales_receipt`
--
ALTER TABLE `sales_receipt`
  ADD CONSTRAINT `sales_receipt_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `sales_bills` (`bill_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sales_receipt_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `users_group` (`group_id`);

--
-- Constraints for table `users_profile`
--
ALTER TABLE `users_profile`
  ADD CONSTRAINT `users_profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
