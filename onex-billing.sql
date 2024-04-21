-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20230808.7aa9c4a3ab
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2024 at 12:35 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onex-billing`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(160) NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Addidas', NULL, 1, '2024-04-21 09:17:24', '2024-04-21 09:17:24', NULL),
(2, 'Khadim', NULL, 1, '2024-04-21 09:17:31', '2024-04-21 09:17:31', NULL),
(3, 'Bata', NULL, 1, '2024-04-21 09:17:36', '2024-04-21 09:17:36', NULL),
(4, 'Ajanta', NULL, 1, '2024-04-21 09:17:41', '2024-04-21 09:17:41', NULL),
(5, 'Millage', NULL, 1, '2024-04-21 09:17:49', '2024-04-21 09:17:49', NULL),
(6, 'Puma', NULL, 1, '2024-04-21 09:17:54', '2024-04-21 09:17:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `company_categories`
--

CREATE TABLE `company_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(160) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `short_code` varchar(100) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company_categories`
--

INSERT INTO `company_categories` (`id`, `name`, `description`, `short_code`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Private Limited', NULL, 'Pvt. Ltd.', 1, '2024-04-19 23:52:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `company_information`
--

CREATE TABLE `company_information` (
  `id` int(11) NOT NULL,
  `company_name` varchar(200) NOT NULL,
  `company_type` tinyint(4) NOT NULL,
  `brand_name` varchar(160) NOT NULL,
  `gst_no` varchar(60) DEFAULT NULL,
  `vat_no` varchar(60) DEFAULT NULL,
  `cin_no` varchar(60) DEFAULT NULL,
  `tan_no` varchar(60) DEFAULT NULL,
  `pan_no` varchar(60) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `contact_email` varchar(160) DEFAULT NULL,
  `whatsapp_number` varchar(20) DEFAULT NULL,
  `website_url` text DEFAULT NULL,
  `full_address` text DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `pincode` varchar(60) DEFAULT NULL,
  `land_mark` varchar(200) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company_information`
--

INSERT INTO `company_information` (`id`, `company_name`, `company_type`, `brand_name`, `gst_no`, `vat_no`, `cin_no`, `tan_no`, `pan_no`, `contact_number`, `contact_email`, `whatsapp_number`, `website_url`, `full_address`, `state`, `city`, `pincode`, `land_mark`, `country`, `created_at`, `updated_at`) VALUES
(4, 'Hello User', 1, 'HESR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IND', '2024-04-20 05:57:26', '2024-04-20 05:57:26');

-- --------------------------------------------------------

--
-- Table structure for table `crm_settings`
--

CREATE TABLE `crm_settings` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `list_per_page` int(11) NOT NULL DEFAULT 25,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `crm_settings`
--

INSERT INTO `crm_settings` (`id`, `name`, `list_per_page`, `created_at`, `updated_at`) VALUES
(1, 'ONEX BILLING', 50, '2023-08-12 01:20:19', '2023-08-11 21:50:11');

-- --------------------------------------------------------

--
-- Table structure for table `product_bundle_free`
--

CREATE TABLE `product_bundle_free` (
  `id` int(11) NOT NULL,
  `variant_id` int(11) NOT NULL,
  `child_product_id` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1=bundle, 2=free',
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `id` int(11) NOT NULL,
  `name` varchar(160) NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `menu_visibility` tinyint(2) NOT NULL DEFAULT 0,
  `primary_visibility` tinyint(2) NOT NULL DEFAULT 1,
  `display_order` tinyint(4) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`id`, `name`, `description`, `status`, `menu_visibility`, `primary_visibility`, `display_order`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'Shoes', NULL, 1, 0, 0, NULL, '2024-04-21 09:18:59', '2024-04-21 09:18:59', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `variant_product_id` int(11) NOT NULL,
  `image` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `product_master`
--

CREATE TABLE `product_master` (
  `id` int(11) NOT NULL,
  `name` varchar(160) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `image` varchar(150) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_master`
--

INSERT INTO `product_master` (`id`, `name`, `category_id`, `subcategory_id`, `description`, `image`, `status`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'Gents Shoes', 1, 1, NULL, 'product_image__1713691491.png', 1, '2024-04-21 09:24:52', '2024-04-21 09:24:52', NULL, NULL, NULL, NULL),
(2, 'Ladies Shoes', 1, 2, NULL, 'product_image__1713691548.png', 1, '2024-04-21 09:25:48', '2024-04-21 09:25:48', NULL, NULL, NULL, NULL),
(3, 'School Shoes', 1, 7, NULL, 'product_image__1713691585.png', 1, '2024-04-21 09:26:25', '2024-04-21 09:26:25', NULL, NULL, NULL, NULL),
(4, 'Regular Used', 1, 6, NULL, 'product_image__1713691625.png', 1, '2024-04-21 09:27:06', '2024-04-21 09:27:06', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_meta_fields`
--

CREATE TABLE `product_meta_fields` (
  `id` int(11) NOT NULL,
  `variant_product_id` int(11) NOT NULL,
  `field_key` varchar(150) NOT NULL,
  `field_name` varchar(150) DEFAULT NULL,
  `field_value` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `product_subcategory`
--

CREATE TABLE `product_subcategory` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(160) NOT NULL,
  `description` text DEFAULT NULL,
  `primary_visibility` tinyint(4) NOT NULL DEFAULT 1,
  `display_order` tinyint(4) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_subcategory`
--

INSERT INTO `product_subcategory` (`id`, `category_id`, `name`, `description`, `primary_visibility`, `display_order`, `status`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 1, 'Gent Shoes', NULL, 1, NULL, 1, '2024-04-21 09:19:25', '2024-04-21 09:19:25', NULL, NULL, NULL, NULL),
(2, 1, 'Girls Shoes', NULL, 1, NULL, 1, '2024-04-21 09:19:38', '2024-04-21 09:19:38', NULL, NULL, NULL, NULL),
(3, 1, 'Kid Shoes', NULL, 1, NULL, 1, '2024-04-21 09:19:47', '2024-04-21 09:19:47', NULL, NULL, NULL, NULL),
(4, 1, 'Mid Age Shoes', NULL, 1, NULL, 1, '2024-04-21 09:20:08', '2024-04-21 09:20:08', NULL, NULL, NULL, NULL),
(5, 1, 'Aged Shoes', NULL, 1, NULL, 1, '2024-04-21 09:20:20', '2024-04-21 09:20:20', NULL, NULL, NULL, NULL),
(6, 1, 'Regular Used', NULL, 1, NULL, 1, '2024-04-21 09:20:42', '2024-04-21 09:20:42', NULL, NULL, NULL, NULL),
(7, 1, 'School Shoes', NULL, 1, NULL, 1, '2024-04-21 09:20:51', '2024-04-21 09:20:51', NULL, NULL, NULL, NULL),
(8, 1, 'Office Shoes', NULL, 1, NULL, 1, '2024-04-21 09:21:00', '2024-04-21 09:21:00', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(150) NOT NULL,
  `sku` varchar(60) NOT NULL,
  `barcode_no` varchar(100) DEFAULT NULL,
  `short_description` mediumtext DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `offer_text` mediumtext DEFAULT NULL,
  `unit_id` tinyint(4) NOT NULL DEFAULT 0,
  `price` decimal(8,2) NOT NULL DEFAULT 0.00,
  `old_price` decimal(8,2) NOT NULL DEFAULT 0.00,
  `percentage_discount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `flat_discount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `hsn_code` varchar(50) DEFAULT NULL,
  `gst_rate` decimal(4,2) NOT NULL DEFAULT 0.00,
  `image` varchar(150) DEFAULT NULL,
  `is_bundle_product` tinyint(4) NOT NULL DEFAULT 0,
  `have_free_product` tinyint(4) NOT NULL DEFAULT 0,
  `rating_count` decimal(4,2) NOT NULL DEFAULT 0.00,
  `view_count` int(11) NOT NULL DEFAULT 0,
  `available_stock` decimal(8,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `brand_id`, `name`, `sku`, `barcode_no`, `short_description`, `description`, `offer_text`, `unit_id`, `price`, `old_price`, `percentage_discount`, `flat_discount`, `hsn_code`, `gst_rate`, `image`, `is_bundle_product`, `have_free_product`, `rating_count`, `view_count`, `available_stock`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 'Bata Official Men Star', 'BATA-OFFICIAL-MEN-STAR', 'PU0000000958', NULL, NULL, NULL, 3, 0.00, 0.00, 0.00, 0.00, NULL, 0.00, NULL, 0, 0, 0.00, 0, 0.00, 1, '2024-04-21 09:30:03', '2024-04-21 09:30:03'),
(2, 3, 2, 'School Shoes For Boys', 'KHDM-SCLBOY', 'PU0000000710', NULL, NULL, NULL, 3, 0.00, 0.00, 0.00, 0.00, NULL, 0.00, NULL, 0, 0, 0.00, 0, 0.00, 1, '2024-04-21 09:31:32', '2024-04-21 09:31:32');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(160) NOT NULL,
  `key_name` varchar(60) NOT NULL,
  `display_order` tinyint(4) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=active, 0=inactive',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `key_name`, `display_order`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'super-admin', 0, NULL, 1, '2024-04-15 12:18:09', NULL),
(2, 'Admin', 'admin', 0, NULL, 1, '2024-04-15 12:18:48', NULL),
(3, 'User', 'user', 0, NULL, 1, '2024-04-15 12:21:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `status_master`
--

CREATE TABLE `status_master` (
  `id` int(11) NOT NULL,
  `name` varchar(160) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `status_master`
--

INSERT INTO `status_master` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Active', 1, '2024-04-15 12:26:01', NULL),
(2, 'Inactive', 1, '2024-04-15 12:26:01', NULL),
(3, 'Deleted', 1, '2024-04-15 12:26:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stock_in`
--

CREATE TABLE `stock_in` (
  `id` int(11) NOT NULL,
  `transaction_id` varchar(60) NOT NULL,
  `batch_no` varchar(160) DEFAULT NULL,
  `challan_no` varchar(100) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_quantity` decimal(8,2) NOT NULL DEFAULT 1.00,
  `unit_id` tinyint(4) NOT NULL,
  `unit_price` decimal(8,2) NOT NULL DEFAULT 1.00,
  `unit_total` decimal(8,2) NOT NULL DEFAULT 0.00,
  `stock_received_date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stock_in`
--

INSERT INTO `stock_in` (`id`, `transaction_id`, `batch_no`, `challan_no`, `user_id`, `product_id`, `product_quantity`, `unit_id`, `unit_price`, `unit_total`, `stock_received_date`, `status`, `created_at`, `updated_at`) VALUES
(5, 'e1ee154b5a4bcf0ac2a24adf2b2f3c19', NULL, 'CH-000001100', 18, 3, 25.00, 58, 980.00, 24500.00, '2023-10-08 00:00:00', 1, '2023-08-10 16:13:34', '2023-08-10 16:13:34');

-- --------------------------------------------------------

--
-- Table structure for table `stock_out`
--

CREATE TABLE `stock_out` (
  `id` int(11) NOT NULL,
  `transaction_id` varchar(60) NOT NULL,
  `batch_no` varchar(160) DEFAULT NULL,
  `challan_no` varchar(100) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_quantity` decimal(8,2) NOT NULL DEFAULT 1.00,
  `unit_id` tinyint(4) NOT NULL,
  `unit_price` decimal(8,2) NOT NULL DEFAULT 1.00,
  `unit_total` decimal(8,2) NOT NULL DEFAULT 0.00,
  `stock_issued_date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stock_out`
--

INSERT INTO `stock_out` (`id`, `transaction_id`, `batch_no`, `challan_no`, `user_id`, `product_id`, `product_quantity`, `unit_id`, `unit_price`, `unit_total`, `stock_issued_date`, `status`, `created_at`, `updated_at`) VALUES
(3, '5d11db8e01d4681c816cfed979a7fbb2', NULL, 'INV-0000010', 19, 3, 10.00, 58, 1230.00, 12300.00, '2023-10-08 00:00:00', 1, '2023-08-10 16:14:53', '2023-08-10 16:14:53');

-- --------------------------------------------------------

--
-- Table structure for table `theme_settings`
--

CREATE TABLE `theme_settings` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `nav_class` mediumtext DEFAULT NULL,
  `aside_class` mediumtext DEFAULT NULL,
  `brand_class` mediumtext DEFAULT NULL,
  `bg_class` varchar(30) DEFAULT NULL,
  `css_style` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `theme_settings`
--

INSERT INTO `theme_settings` (`id`, `name`, `nav_class`, `aside_class`, `brand_class`, `bg_class`, `css_style`, `status`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Onex Dark', 'main-header navbar navbar-expand navbar-white navbar-light dropdown-legacy', 'main-sidebar main-sidebar-custom sidebar-dark-primary elevation-4', NULL, 'bg-dark', NULL, 1, 0, '2023-08-11 23:43:23', NULL),
(2, 'Onex Light', NULL, 'main-sidebar main-sidebar-custom sidebar-light-primary elevation-4', 'brand-link bg-primary', NULL, NULL, 1, 0, '2023-08-11 23:44:13', NULL),
(3, 'Onex Blue', 'main-header navbar navbar-expand dropdown-legacy navbar-light bg-primary', 'main-sidebar main-sidebar-custom sidebar-light-primary elevation-4', 'brand-link bg-primary', NULL, 'nav.main-header.navbar.navbar-expand.dropdown-legacy.navbar-light.bg-primary .nav-link {\n            color: #fff;\n        }', 1, 0, '2023-08-11 23:45:29', NULL),
(4, 'Onex Black', 'main-header navbar navbar-expand dropdown-legacy navbar-light bg-dark', 'main-sidebar main-sidebar-custom elevation-4 sidebar-dark-primary', 'brand-link bg-dark', 'bg-dark', 'nav.main-header.navbar.navbar-expand.dropdown-legacy.navbar-light.bg-dark .nav-link {\n            color: #fff;\n        }', 1, 0, '2023-08-11 23:46:20', NULL),
(5, 'Onex Navy', 'main-header navbar navbar-expand dropdown-legacy navbar-light', 'main-sidebar main-sidebar-custom elevation-4 sidebar-light-navy', 'brand-link bg-navy', 'bg-navy', NULL, 1, 0, '2023-08-12 01:44:15', NULL),
(6, 'Onex Dark Navy', 'main-header navbar navbar-expand dropdown-legacy navbar-dark bg-navy', 'main-sidebar main-sidebar-custom elevation-4 sidebar-dark-primary bg-navy', 'brand-link bg-navy', 'bg-navy', NULL, 1, 1, '2023-08-12 01:44:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `unit_master`
--

CREATE TABLE `unit_master` (
  `id` int(11) NOT NULL,
  `name` varchar(160) NOT NULL,
  `short_name` varchar(60) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `child_unit_value` decimal(10,0) DEFAULT NULL,
  `child_unit_id` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `unit_master`
--

INSERT INTO `unit_master` (`id`, `name`, `short_name`, `description`, `child_unit_value`, `child_unit_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Box', 'Box', NULL, 12, 6, 1, '2024-04-21 08:23:08', '2024-04-21 08:54:58', NULL),
(2, 'Carton', 'Carton', NULL, 25, 1, 1, '2024-04-21 08:25:18', '2024-04-21 08:55:19', NULL),
(3, 'Piece', 'Piece', NULL, NULL, NULL, 1, '2024-04-21 08:25:29', '2024-04-21 08:25:29', NULL),
(6, 'Packet', 'Pack', NULL, 12, 3, 1, '2024-04-21 08:48:40', '2024-04-21 08:48:40', NULL),
(7, 'sdfsdf', 'dsfsd', 'sdfsdf', 232, 2, 3, '2024-04-21 09:16:55', '2024-04-21 09:17:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `hash_id` varchar(160) NOT NULL,
  `unique_id` varchar(160) NOT NULL,
  `login_id` varchar(60) DEFAULT NULL,
  `first_name` varchar(160) NOT NULL,
  `middle_name` varchar(160) DEFAULT NULL,
  `last_name` varchar(160) NOT NULL,
  `user_name` varchar(60) DEFAULT NULL,
  `email_id` varchar(160) NOT NULL,
  `password` varchar(150) DEFAULT NULL,
  `phone_number` varchar(30) DEFAULT NULL,
  `whatsapp_number` varchar(30) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `is_crm_access` tinyint(4) NOT NULL DEFAULT 0,
  `agent_id` int(11) DEFAULT NULL,
  `user_category` int(11) NOT NULL DEFAULT 1,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Active, 0=Inactive, 3=Deleted',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `hash_id`, `unique_id`, `login_id`, `first_name`, `middle_name`, `last_name`, `user_name`, `email_id`, `password`, `phone_number`, `whatsapp_number`, `gender`, `is_crm_access`, `agent_id`, `user_category`, `status`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'ff077922-75f9-4920-83ad-9ac8212b2f39', '5X00000625', NULL, 'Onex', NULL, 'DevTeam', 'onexdev', 'onex.devteam@onexcrm.com', '$2y$10$ZX7c69oJutyvGHUcmNp3GOHMvjaFV8xOs52Cg3wyEuQ19CigZFFfK', '9836395513', '9836395513', 'Male', 1, NULL, 1, 1, '2023-08-11 23:14:53', '2024-04-15 16:18:03', NULL, NULL, NULL, NULL),
(40, '42e47d78-384b-4778-ad00-57f44152de6a', '2100000903', 'Q9CAN0', 'Super', NULL, 'Admin', 'iamsuperadmin', 'superadmin@yopmail.com', '$2y$10$QGP2SIO31/XPIqBqix5CTuIIFGLEXxK23hV4SLITKjLRK1VQXyOrG', '1232123212', '1232123212', NULL, 1, NULL, 1, 1, '2024-04-15 07:52:42', '2024-04-15 07:52:42', NULL, NULL, NULL, NULL),
(41, '15a9c52b-de55-498a-a437-6a7cdc517070', '8600000248', '5RRY3I', 'Admin', NULL, 'Admin', 'iamadmin', 'admin@yopmail.com', '$2y$10$ek61jfUG6YL5eljei/XSKeX2NkTphQ2cd4WmTPX4DFIS6X9e/ResO', '7812321234', '7812321234', NULL, 1, NULL, 1, 1, '2024-04-15 07:53:38', '2024-04-15 07:53:38', NULL, NULL, NULL, NULL),
(42, 'f19c8e4b-79df-4fac-958e-1cf8a53e2d4c', '8900000945', 'QQBVTP', 'User', NULL, 'User', 'iamuser1', 'user1@yopmail.com', '$2y$10$2FmhMgGc2DKZlfWGeHQ.p.SXB0UbKT371AOxRBHGiSNF2rr3jlV2S', '7812190123', '7812190123', NULL, 1, NULL, 1, 1, '2024-04-15 07:54:22', '2024-04-15 16:13:22', NULL, NULL, NULL, NULL),
(43, '6d760d52-bc0c-4589-9b6f-1ebf110879a3', '2500001039', '7JBEQW', 'User', NULL, 'Two', NULL, 'user2@yopmail.com', NULL, '8909123212', NULL, NULL, 0, NULL, 1, 1, '2024-04-15 07:54:59', '2024-04-15 07:54:59', NULL, NULL, NULL, NULL),
(44, '1262ada8-3d9c-4cb5-8f1c-5ce0c5fc84d9', '2300000983', 'S6DS5Q', 'User', NULL, 'Three', NULL, 'user3@yopmail.com', NULL, '7812901212', '7812901212', NULL, 0, NULL, 1, 1, '2024-04-15 07:55:31', '2024-04-15 16:57:35', NULL, NULL, NULL, NULL),
(45, '1853a64c-977c-4d60-8076-19a047f2e7a8', '8800000408', NULL, 'Vendor', NULL, 'One', NULL, 'vendor1@yopmail.com', NULL, '7712112901', '7712112901', NULL, 0, NULL, 2, 1, '2024-04-15 17:30:25', '2024-04-15 17:30:25', NULL, NULL, NULL, NULL),
(46, 'd877df33-9c74-4816-a874-9e064e813eae', '2700000904', NULL, 'Vendor', NULL, 'Two', NULL, 'vendor2@yopmail.com', NULL, '8899108101', '8899108101', NULL, 0, NULL, 2, 1, '2024-04-15 17:31:59', '2024-04-15 17:37:41', NULL, NULL, NULL, NULL),
(47, '59b62dbd-6caf-40a8-93ef-0eafea470b50', '1800000841', NULL, 'Vendorx', NULL, 'Three', NULL, 'vendor3x@yopmail.com', NULL, '9911001122', '9911001121', NULL, 0, NULL, 2, 1, '2024-04-15 17:33:35', '2024-04-15 17:52:23', NULL, NULL, NULL, NULL),
(48, 'f8e8c67d-484d-4d15-80ed-87e937c99b06', '1800000630', NULL, 'Supplier', NULL, 'One', NULL, 'supplier1@yopmail.com', NULL, '7777111123', NULL, NULL, 0, NULL, 2, 3, '2024-04-15 17:38:32', '2024-04-15 17:53:16', NULL, NULL, NULL, NULL),
(49, '96e5d350-1a2c-4624-bf83-cda2fe607fce', '7600000937', NULL, 'Customer', NULL, 'One', NULL, 'customer1@yopmail.com', NULL, '6616616612', '6616616612', NULL, 0, NULL, 5, 1, '2024-04-15 18:17:45', '2024-04-15 18:17:45', NULL, NULL, NULL, NULL),
(50, 'd5af9772-eb55-4f11-8cc9-3ae5a32e4cf9', '6500000442', NULL, 'Customer', NULL, 'Two', NULL, 'customer2@yopmail.com', NULL, '8891120912', '8891120912', NULL, 0, NULL, 5, 1, '2024-04-15 18:18:20', '2024-04-15 18:19:22', NULL, NULL, NULL, NULL),
(51, '39ba207c-b90c-442e-977e-31e60bc18c73', '2500000948', NULL, 'Customer', NULL, 'Three', NULL, 'customer3@yopmail.com', NULL, '7788998878', NULL, NULL, 0, NULL, 5, 1, '2024-04-15 18:18:54', '2024-04-15 18:18:54', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_profile`
--

CREATE TABLE `users_profile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `image` varchar(150) DEFAULT NULL,
  `full_address` text DEFAULT NULL,
  `geo_address` text DEFAULT NULL,
  `longitude` varchar(150) DEFAULT NULL,
  `latitude` varchar(150) DEFAULT NULL,
  `city` varchar(150) DEFAULT NULL,
  `pincode` varchar(30) DEFAULT NULL,
  `state` varchar(150) DEFAULT NULL,
  `country` varchar(150) DEFAULT NULL,
  `land_mark` text DEFAULT NULL,
  `gst_no` varchar(160) DEFAULT NULL,
  `vat_no` varchar(160) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_profile`
--

INSERT INTO `users_profile` (`id`, `user_id`, `image`, `full_address`, `geo_address`, `longitude`, `latitude`, `city`, `pincode`, `state`, `country`, `land_mark`, `gst_no`, `vat_no`, `created_at`, `updated_at`) VALUES
(2, 16, 'profile_image__1691995748.png', 'Subhas Pally, Kamrabad Main Rd, Rajpur Sonarpur, Kolkata, West Bengal, India', 'Kamrabad Main Road, Kolkata, WB, India, 700150, 22.4594755, 88.43140129999999', '88.43140129999999', '22.4594755', 'Kolkata', '700150', 'WB', 'IND', 'Jagarani Sangha Club', NULL, NULL, '2023-08-14 06:39:49', '2023-08-14 06:49:08'),
(3, 1, NULL, 'Subhas Pally, Kamrabad Main Rd, Subhas Pally, Kolkata, West Bengal, India', 'Kamrabad Main Road, Kolkata, WB, India, 700150, 22.4594755, 88.43140129999999', '88.43140129999999', '22.4594755', 'Kolkata', '700150', 'WB', 'IND', 'Jagarani Sangha Club', NULL, NULL, '2023-08-14 10:47:05', '2023-10-01 14:25:03'),
(4, 32, NULL, 'Sonagachi, Sovabazar, Baghbazar, Kolkata, West Bengal, India', 'Kolkata, WB, India, 700005, 22.6018973, 88.3656398', '88.3656398', '22.6018973', 'Kolkata', '700005', 'WB', 'India', 'aaaa', NULL, NULL, '2023-10-01 11:09:28', '2023-10-01 11:09:28'),
(5, 32, NULL, 'Sonagachi, Sovabazar, Baghbazar, Kolkata, West Bengal, India', 'Kolkata, WB, India, 700005, 22.6018973, 88.3656398', '88.3656398', '22.6018973', 'Kolkata', '700005', 'WB', 'IND', 'aaaa', NULL, NULL, '2023-10-01 11:10:09', '2023-10-01 11:10:09'),
(6, 31, NULL, 'Sobha, Cotton Street, Raja Katra, Bara Bazar, Jorasanko, Kolkata, West Bengal, India', 'P-35, Cotton Street Road, Burrabazar, Cotton Street, Kolkata, WB, India, 700007, 22.5812047, 88.3551421', '88.3551421', '22.5812047', 'Kolkata', '700007', 'WB', 'India', NULL, NULL, NULL, '2023-10-01 11:11:29', '2023-10-01 11:11:29'),
(7, 34, NULL, 'New Delhi Railway Station Parcel Office, Ajmeri Gate, New Delhi, Delhi, India', 'New Delhi, DL, India, 110002, 28.644512, 77.2215346', '77.2215346', '28.644512', 'New Delhi', '110002', 'DL', 'IND', NULL, NULL, NULL, '2023-10-01 13:14:40', '2023-10-01 13:32:28'),
(8, 35, NULL, 'Netaji Subhash Chandra Bose International Airport (CCU), Jessore Road, Dum Dum, Kolkata, West Bengal, India', 'Jessore Road, Kolkata, WB, India, 700052, 22.653564, 88.4450847', '88.4450847', '22.653564', 'Kolkata', '700052', 'WB', 'IND', NULL, NULL, NULL, '2023-10-01 13:15:41', '2023-10-01 13:32:17'),
(9, 36, NULL, 'DFDFDF, Avenue Colonel Teyssier, Albi, France', '60, Avenue Colonel Teyssier, Albi, Occitanie, France, 81000, 43.9240185, 2.1546571', '2.1546571', '43.9240185', 'Albi', '81000', 'Occitanie', 'IND', NULL, NULL, NULL, '2023-10-01 13:28:21', '2023-10-01 13:31:16'),
(10, 33, NULL, 'dssfsdf', NULL, NULL, NULL, 'dfsdfsdf', '2332423', 'sdfsdfs', 'IND', NULL, NULL, NULL, '2023-10-01 13:36:00', '2023-10-01 13:36:00'),
(11, 44, 'profile_image__1713196648.png', 'Kolkata', NULL, NULL, NULL, 'Kolkata', '700150', 'WB', 'IND', 'JSC', NULL, NULL, '2024-04-15 15:57:29', '2024-04-15 15:57:29'),
(12, 47, NULL, 'Kolkata', NULL, NULL, NULL, 'kolkata', '700140', 'WB', 'IND', 'JSC', 'GSTN0001XXXXXXXX00', 'VAT11111XXXXXX00', '2024-04-15 17:33:36', '2024-04-15 17:52:23'),
(13, 48, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IND', NULL, 'GST4512314234123', NULL, '2024-04-15 17:38:32', '2024-04-15 17:52:52'),
(14, 49, NULL, 'ccczxcxzc', NULL, NULL, NULL, NULL, NULL, NULL, 'IND', NULL, NULL, NULL, '2024-04-15 18:17:45', '2024-04-15 18:19:10'),
(15, 50, NULL, 'Kolkata', NULL, NULL, NULL, 'kolkata', '700123', 'WB', 'IND', 'JSC', NULL, NULL, '2024-04-15 18:18:20', '2024-04-15 18:18:20'),
(16, 51, NULL, 'Kolkata', NULL, NULL, NULL, 'kolkata', '700145', 'WB', 'IND', NULL, NULL, NULL, '2024-04-15 18:18:55', '2024-04-15 18:18:55');

-- --------------------------------------------------------

--
-- Table structure for table `user_categories`
--

CREATE TABLE `user_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_categories`
--

INSERT INTO `user_categories` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'System User', NULL, 1, '2023-08-07 12:51:58', NULL),
(2, 'Vendor', NULL, 1, '2023-08-07 12:52:15', NULL),
(3, 'Supplier', NULL, 1, '2023-08-07 12:52:37', NULL),
(4, 'Staff', NULL, 1, '2023-08-07 21:58:11', NULL),
(5, 'Customer', NULL, 1, '2024-04-15 12:20:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=active, 0=inactive',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `user_id`, `role_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2023-08-12 12:58:51', NULL),
(40, 40, 1, 1, '2024-04-15 13:22:42', NULL),
(41, 41, 2, 1, '2024-04-15 13:23:38', NULL),
(42, 42, 3, 1, '2024-04-15 13:24:22', NULL),
(43, 43, 3, 1, '2024-04-15 13:24:59', NULL),
(44, 44, 3, 1, '2024-04-15 13:25:31', '2024-04-15 16:11:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_categories`
--
ALTER TABLE `company_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_information`
--
ALTER TABLE `company_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crm_settings`
--
ALTER TABLE `crm_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_bundle_free`
--
ALTER TABLE `product_bundle_free`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_master`
--
ALTER TABLE `product_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_meta_fields`
--
ALTER TABLE `product_meta_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_subcategory`
--
ALTER TABLE `product_subcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD UNIQUE KEY `barcode_no` (`barcode_no`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_master`
--
ALTER TABLE `status_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_in`
--
ALTER TABLE `stock_in`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_out`
--
ALTER TABLE `stock_out`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `theme_settings`
--
ALTER TABLE `theme_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit_master`
--
ALTER TABLE `unit_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_profile`
--
ALTER TABLE `users_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_categories`
--
ALTER TABLE `user_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `company_categories`
--
ALTER TABLE `company_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `company_information`
--
ALTER TABLE `company_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `crm_settings`
--
ALTER TABLE `crm_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_bundle_free`
--
ALTER TABLE `product_bundle_free`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_master`
--
ALTER TABLE `product_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product_meta_fields`
--
ALTER TABLE `product_meta_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_subcategory`
--
ALTER TABLE `product_subcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `status_master`
--
ALTER TABLE `status_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stock_in`
--
ALTER TABLE `stock_in`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stock_out`
--
ALTER TABLE `stock_out`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `theme_settings`
--
ALTER TABLE `theme_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `unit_master`
--
ALTER TABLE `unit_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `users_profile`
--
ALTER TABLE `users_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user_categories`
--
ALTER TABLE `user_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
<br />
<b>Warning</b>:  Cannot modify header information - headers already sent by (output started at G:\xampp\phpMyAdmin\libraries\classes\Export\Export.php:212) in <b>G:\xampp\phpMyAdmin\libraries\classes\ResponseRenderer.php</b> on line <b>406</b><br />
