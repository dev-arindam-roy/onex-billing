-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20230808.7aa9c4a3ab
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2024 at 05:38 PM
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
-- Table structure for table `batches`
--

CREATE TABLE `batches` (
  `id` int(11) NOT NULL,
  `batch_no` varchar(60) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `batches`
--

INSERT INTO `batches` (`id`, `batch_no`, `name`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'BC202405-000047', 'Batch-1', 'Batch one', 3, '2024-05-01 07:06:02', '2024-05-01 07:17:55'),
(2, 'BC202405-000054', 'Batch-2', NULL, 1, '2024-05-01 07:06:11', '2024-05-01 07:17:50'),
(3, 'BC202405-000074', 'Batch 10', NULL, 1, '2024-05-01 07:18:04', '2024-05-01 07:30:45'),
(4, 'BC202405-000040', 'Batch May - Sharma Ji', NULL, 1, '2024-05-01 07:18:20', '2024-05-19 17:20:19'),
(5, 'BC202405-000092', 'HelloBatch', NULL, 1, '2024-05-04 15:11:15', '2024-05-19 10:24:41'),
(6, 'BC202405-000050', 'onex1', NULL, 1, '2024-05-18 09:02:34', '2024-05-19 17:28:12'),
(7, 'BC202405-000039', 'onex2', NULL, 1, '2024-05-18 09:02:39', '2024-05-19 07:41:34');

-- --------------------------------------------------------

--
-- Table structure for table `batch_products`
--

CREATE TABLE `batch_products` (
  `id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_qty` int(11) NOT NULL,
  `purchase_price` decimal(8,2) NOT NULL DEFAULT 0.00,
  `sale_price` decimal(8,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `batch_products`
--

INSERT INTO `batch_products` (`id`, `batch_id`, `product_id`, `product_qty`, `purchase_price`, `sale_price`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 3, 60, 50.00, 120.00, 1, '2024-05-01 18:00:26', '2024-05-18 08:46:53'),
(2, 4, 4, 100, 390.00, 600.00, 1, '2024-05-01 18:00:56', '2024-05-20 15:37:06'),
(3, 3, 3, 0, 230.00, 456.00, 3, '2024-05-16 09:54:08', '2024-05-19 17:05:33'),
(4, 5, 5, 636, 6.00, 9.00, 1, '2024-05-18 07:16:27', '2024-05-18 07:59:13'),
(5, 5, 2, 78, 90.00, 100.00, 1, '2024-05-18 07:59:40', '2024-05-18 07:59:40'),
(6, 4, 1, 0, 78.00, 130.00, 3, '2024-05-18 08:12:50', '2024-05-18 08:45:41'),
(7, 7, 4, 0, 340.00, 560.00, 3, '2024-05-19 07:41:34', '2024-05-20 07:32:29'),
(8, 5, 1, 100, 500.00, 800.00, 1, '2024-05-19 10:24:41', '2024-05-20 07:27:33'),
(9, 6, 3, 0, 99.00, 200.00, 3, '2024-05-19 17:28:12', '2024-05-20 07:34:45');

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
(4, 'Difo', 1, 'HESR', 'GST000000000001', 'VAT000000000001', 'CIN00000000001', 'TAN0000000000001', 'PAN0000000000001', '8877887761', 'admin@difo.com', '7812314519', 'https://dofo.com', 'Barasat, WB, IND', 'WB', 'KOLKATA', '7008987', 'JS Club', 'IND', '2024-04-20 05:57:26', '2024-05-19 18:58:09');

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
(1, 'Shoes', NULL, 1, 0, 0, NULL, '2024-04-21 09:18:59', '2024-04-21 09:18:59', NULL, NULL, NULL, NULL),
(2, 'Sports Shoes', NULL, 1, 0, 0, NULL, '2024-05-19 17:32:39', '2024-05-19 17:32:39', NULL, NULL, NULL, NULL);

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
(1, 1, 3, 'Bata Official Men Star', 'BATA-OFFICIAL-MEN-STAR', 'PU0000000958', NULL, NULL, NULL, 3, 0.00, 0.00, 0.00, 0.00, NULL, 0.00, NULL, 0, 0, 0.00, 0, 100.00, 1, '2024-04-21 09:30:03', '2024-05-20 07:27:33'),
(2, 3, 2, 'School Shoes For Boys', 'KHDM-SCLBOY', 'PU0000000710', NULL, NULL, NULL, 3, 0.00, 0.00, 0.00, 0.00, NULL, 0.00, NULL, 0, 0, 0.00, 0, 0.00, 1, '2024-04-21 09:31:32', '2024-04-21 09:31:32'),
(3, 3, 3, 'New Age Bata School Shoes', 'NBATASC001', 'PU0000000953', NULL, NULL, NULL, 3, 490.00, 580.00, 15.52, 90.00, 'XXX123', 18.00, 'product_image__1713802010.png', 0, 0, 0.00, 0, 46.00, 1, '2024-04-22 16:06:52', '2024-05-20 07:34:45'),
(4, 3, 4, 'Kids 1000 Black Size 6', 'KID10001', 'PU0000000370', NULL, NULL, NULL, 3, 375.00, 500.00, 25.00, 125.00, 'X11100101', 18.00, NULL, 0, 0, 0.00, 0, 89.00, 1, '2024-04-29 17:16:39', '2024-05-20 15:37:06'),
(5, 2, 4, 'LDSHO 10091', 'LDPX1001', 'PU0000000550', NULL, NULL, NULL, 3, 123.00, 233.00, 47.21, 110.00, NULL, 0.00, 'product_image__1716140720.jpeg', 0, 0, 0.00, 0, 0.00, 1, '2024-05-16 10:58:22', '2024-05-19 17:45:21');

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `id` int(11) NOT NULL,
  `hash_id` varchar(100) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `bill_amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `due_amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `payment_status` tinyint(4) DEFAULT NULL COMMENT '0=Pending, 1=Completed',
  `payment_mode` tinyint(4) DEFAULT NULL COMMENT '0=Cash, 1=UPI, 2=Bank Transfer, 3=Cheque',
  `bill_no` varchar(100) DEFAULT NULL,
  `challan_no` varchar(100) DEFAULT NULL,
  `received_date` datetime DEFAULT NULL,
  `note` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`id`, `hash_id`, `batch_id`, `vendor_id`, `bill_amount`, `due_amount`, `payment_status`, `payment_mode`, `bill_no`, `challan_no`, `received_date`, `note`, `status`, `created_at`, `updated_at`) VALUES
(1, '7ac49837-aa2a-4d99-aa1d-41405a0e5521', 4, 45, 9440.00, 4720.00, 0, NULL, 'PUR0001', NULL, '2024-05-01 00:00:00', NULL, 3, '2024-05-01 17:59:44', '2024-05-18 08:45:49'),
(2, 'de6981bd-9cd3-4396-aa57-70244ae9337d', 4, 47, 14248.50, 14248.50, NULL, NULL, NULL, NULL, '2024-05-01 00:00:00', NULL, 1, '2024-05-01 18:00:55', '2024-05-01 18:00:55'),
(3, 'a9cf7806-749e-43e4-a165-e8ddd85fb24d', 3, 46, 4814.40, 4814.40, NULL, NULL, 'INV123456', NULL, '2024-05-16 00:00:00', NULL, 1, '2024-05-16 09:54:08', '2024-05-16 09:54:08'),
(4, '12f9d772-c75f-489a-a365-27dd923fba2f', 3, 46, 151984.00, 151984.00, NULL, NULL, 'INV123456', NULL, '2024-05-18 00:00:00', NULL, 3, '2024-05-18 07:10:25', '2024-05-18 09:01:32'),
(5, 'c9908fa1-d9ba-46b5-a33d-ad45276d06e9', 5, 53, 1476.00, 1476.00, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-05-18 07:16:27', '2024-05-18 07:16:27'),
(6, '80c0909c-4548-4c00-92f9-3c784aabd9c5', 5, 53, 11400.00, 11400.00, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-05-18 07:20:27', '2024-05-18 07:20:27'),
(7, 'd683574d-1ab4-4ecd-9e6f-6fd9d6234ddb', 5, 53, 4442.00, 1922.00, 0, NULL, NULL, NULL, '2024-05-18 00:00:00', NULL, 1, '2024-05-18 07:51:08', '2024-05-18 07:57:38'),
(8, '4e55a897-58c8-4feb-b739-18ed9fdaaf39', 5, 53, 3752.00, 3752.00, NULL, NULL, NULL, NULL, '2024-05-18 00:00:00', NULL, 1, '2024-05-18 07:53:05', '2024-05-18 07:53:05'),
(9, '28a26032-9cae-4750-95ff-9fa3e0c63d87', 5, 45, 7044.00, 7020.00, 0, NULL, NULL, NULL, '2024-05-18 00:00:00', NULL, 1, '2024-05-18 07:59:13', '2024-05-18 07:59:39'),
(10, '160c1d80-0b14-4bc3-9e97-d4ea352387e0', 4, 46, 148464.00, 52884.00, 0, NULL, 'INV01010', NULL, '2024-05-18 00:00:00', NULL, 3, '2024-05-18 08:12:11', '2024-05-18 08:45:41'),
(11, 'e2ed7e22-9cb8-4106-8f0a-5f776e9ed526', 4, 46, 3540.00, 3540.00, NULL, NULL, NULL, NULL, '2024-05-18 00:00:00', NULL, 1, '2024-05-18 08:46:53', '2024-05-18 08:46:53'),
(12, '93bfaeb4-5a9b-4583-ab8a-6493bd21b180', 7, 45, 80240.00, 40120.00, 0, NULL, NULL, NULL, '2024-05-19 00:00:00', NULL, 1, '2024-05-19 07:38:14', '2024-05-19 07:41:32'),
(13, '4b44fbe9-bb79-44b3-b950-39e44dfe7e0f', 5, 46, 100000.00, 100000.00, NULL, NULL, 'INV/x123', NULL, '2024-05-19 00:00:00', NULL, 1, '2024-05-19 10:24:41', '2024-05-19 10:24:41'),
(14, 'e3484d37-a680-44fc-8c21-4b3df8cf45eb', 4, 47, 230100.00, 230100.00, NULL, NULL, '526912', NULL, '2024-05-16 00:00:00', NULL, 1, '2024-05-19 17:20:19', '2024-05-19 17:20:19'),
(15, 'e81673fb-7244-485d-8646-6b3bc6418222', 6, 45, 8177.40, 8177.40, NULL, NULL, 'KAL/123/10090', NULL, '2024-05-14 00:00:00', NULL, 1, '2024-05-19 17:28:12', '2024-05-19 17:28:12');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_products`
--

CREATE TABLE `purchase_products` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_qty` decimal(8,2) NOT NULL DEFAULT 0.00,
  `unit_id` int(11) NOT NULL,
  `purchase_price` decimal(8,2) NOT NULL DEFAULT 0.00,
  `sale_price` decimal(8,2) NOT NULL DEFAULT 0.00,
  `gst_rate` decimal(8,2) NOT NULL DEFAULT 0.00,
  `gst_amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchase_products`
--

INSERT INTO `purchase_products` (`id`, `purchase_id`, `batch_id`, `vendor_id`, `product_id`, `product_qty`, `unit_id`, `purchase_price`, `sale_price`, `gst_rate`, `gst_amount`, `total_amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 45, 3, 20.00, 3, 200.00, 0.00, 18.00, 720.00, 4720.00, 3, '2024-05-01 18:00:26', '2024-05-18 08:45:49'),
(2, 2, 4, 47, 4, 35.00, 3, 345.00, 0.00, 18.00, 2173.50, 14248.50, 1, '2024-05-01 18:00:55', '2024-05-01 18:00:55'),
(3, 3, 3, 46, 3, 12.00, 3, 340.00, 0.00, 18.00, 734.40, 4814.40, 1, '2024-05-16 09:54:08', '2024-05-16 09:54:08'),
(4, 4, 3, 46, 3, 560.00, 3, 230.00, 0.00, 18.00, 23184.00, 151984.00, 3, '2024-05-18 07:10:25', '2024-05-18 09:01:32'),
(5, 5, 5, 53, 5, 12.00, 3, 123.00, 0.00, 0.00, 0.00, 1476.00, 1, '2024-05-18 07:16:27', '2024-05-18 07:16:27'),
(6, 6, 5, 53, 5, 456.00, 3, 25.00, 0.00, 0.00, 0.00, 11400.00, 1, '2024-05-18 07:20:27', '2024-05-18 07:20:27'),
(7, 7, 5, 53, 5, 45.00, 3, 34.00, 0.00, 0.00, 0.00, 1530.00, 1, '2024-05-18 07:51:08', '2024-05-18 07:51:08'),
(8, 8, 5, 53, 5, 67.00, 3, 56.00, 0.00, 0.00, 0.00, 3752.00, 1, '2024-05-18 07:53:05', '2024-05-18 07:53:05'),
(9, 7, 5, 53, 5, 45.00, 3, 56.00, 0.00, 0.00, 0.00, 2520.00, 1, '2024-05-18 07:55:36', '2024-05-18 07:55:36'),
(10, 7, 5, 53, 5, 7.00, 3, 56.00, 0.00, 0.00, 0.00, 392.00, 1, '2024-05-18 07:57:38', '2024-05-18 07:57:38'),
(11, 9, 5, 45, 5, 4.00, 3, 6.00, 0.00, 0.00, 0.00, 24.00, 1, '2024-05-18 07:59:13', '2024-05-18 07:59:13'),
(12, 9, 5, 45, 2, 78.00, 3, 90.00, 0.00, 0.00, 0.00, 7020.00, 1, '2024-05-18 07:59:39', '2024-05-18 07:59:39'),
(13, 10, 4, 46, 3, 900.00, 3, 90.00, 0.00, 18.00, 14580.00, 95580.00, 3, '2024-05-18 08:12:11', '2024-05-18 08:45:41'),
(14, 10, 4, 46, 1, 678.00, 3, 78.00, 0.00, 0.00, 0.00, 52884.00, 3, '2024-05-18 08:12:50', '2024-05-18 08:45:41'),
(15, 11, 4, 46, 3, 60.00, 3, 50.00, 0.00, 18.00, 540.00, 3540.00, 1, '2024-05-18 08:46:53', '2024-05-18 08:46:53'),
(16, 12, 7, 45, 4, 100.00, 3, 340.00, 0.00, 18.00, 6120.00, 40120.00, 1, '2024-05-19 07:38:14', '2024-05-19 07:38:14'),
(17, 12, 7, 45, 4, 100.00, 3, 340.00, 0.00, 18.00, 6120.00, 40120.00, 1, '2024-05-19 07:41:34', '2024-05-19 07:41:34'),
(18, 13, 5, 46, 1, 200.00, 3, 500.00, 0.00, 0.00, 0.00, 100000.00, 1, '2024-05-19 10:24:41', '2024-05-19 10:24:41'),
(19, 14, 4, 47, 4, 500.00, 3, 390.00, 0.00, 18.00, 35100.00, 230100.00, 1, '2024-05-19 17:20:19', '2024-05-19 17:20:19'),
(20, 15, 6, 45, 3, 70.00, 3, 99.00, 0.00, 18.00, 1247.40, 8177.40, 1, '2024-05-19 17:28:12', '2024-05-19 17:28:12');

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
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `invoice_no` varchar(160) NOT NULL,
  `hash_id` varchar(200) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `sale_date` datetime DEFAULT NULL,
  `total_amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `total_discount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `payable_amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `due_amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `total_gst_amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `total_sgst_amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `total_cgst_amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `total_igst_amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `payment_status` tinyint(4) DEFAULT NULL COMMENT '0=Pending, 1=Completed',
  `payment_mode` tinyint(4) DEFAULT NULL COMMENT '0=Cash, 1=UPI, 2=Bank Transfer, 3=Cheque',
  `note` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `invoice_no`, `hash_id`, `customer_id`, `sale_date`, `total_amount`, `total_discount`, `payable_amount`, `due_amount`, `total_gst_amount`, `total_sgst_amount`, `total_cgst_amount`, `total_igst_amount`, `payment_status`, `payment_mode`, `note`, `status`, `created_at`, `updated_at`) VALUES
(2, 'INV202405-000001', '83a61df4-f3b3-455f-a791-c6186e44e3fd', 51, '2024-05-15 00:00:00', 2690.00, 300.00, 2390.00, 0.00, 410.00, 205.00, 205.00, 0.00, NULL, NULL, NULL, 1, '2024-05-19 17:02:28', '2024-05-19 17:02:28'),
(3, 'INV202405-000003', 'fd18c5c9-a5b8-42e4-b2ec-570877da9a83', 59, '2024-05-19 00:00:00', 4956.00, 1000.00, 3956.00, 0.00, 756.00, 378.00, 378.00, 0.00, NULL, NULL, NULL, 1, '2024-05-19 17:05:32', '2024-05-19 17:05:32'),
(4, 'INV202405-000004', '622898c5-39bd-4323-aa73-86d2b6d4858e', 51, '2024-05-19 00:00:00', 122728.00, 10000.00, 112728.00, 112728.00, 7128.00, 3564.00, 3564.00, 0.00, NULL, NULL, NULL, 1, '2024-05-20 07:27:33', '2024-05-20 07:27:33'),
(5, 'INV202405-000005', 'ab6a4a92-612e-4f1e-b402-141c372a3926', 51, '2024-05-20 00:00:00', 19732.00, 0.00, 19732.00, 19732.00, 3012.00, 1505.00, 1505.00, 0.00, NULL, NULL, NULL, 1, '2024-05-20 07:32:29', '2024-05-20 07:32:29'),
(6, 'INV202405-000006', 'f5f1e148-af57-4d47-bbb2-c2747d11a156', 50, '2024-05-20 00:00:00', 37052.00, 0.00, 37052.00, 37052.00, 5652.00, 2826.00, 2826.00, 0.00, NULL, NULL, NULL, 1, '2024-05-20 07:34:45', '2024-05-20 07:34:45'),
(7, 'INV202405-000007', '1eb72b7f-85f8-40d7-8243-2361dcd236a5', 60, '2024-05-20 00:00:00', 63720.00, 999.00, 62721.00, 62721.00, 9720.00, 4860.00, 4860.00, 0.00, NULL, NULL, NULL, 1, '2024-05-20 11:32:39', '2024-05-20 11:32:39'),
(8, 'INV202405-000008', '816116eb-bd9c-490c-a3d7-def635beaa6b', 60, '2024-05-20 00:00:00', 35400.00, 0.00, 35400.00, 35400.00, 5400.00, 2700.00, 2700.00, 0.00, NULL, NULL, NULL, 1, '2024-05-20 11:35:57', '2024-05-20 11:35:57'),
(9, 'INV202405-000009', '0303df41-1757-4ed7-a583-a53266157289', 60, '2024-05-20 00:00:00', 35400.00, 560.00, 34840.00, 34840.00, 5400.00, 2700.00, 2700.00, 0.00, NULL, NULL, NULL, 1, '2024-05-20 12:59:55', '2024-05-20 12:59:55'),
(10, 'INV202405-000010', 'c6a03812-7b1b-4f9f-b6e8-79bbfb75b817', 50, '2024-05-20 00:00:00', 141600.00, 0.00, 141600.00, 141600.00, 21600.00, 10800.00, 10800.00, 0.00, NULL, NULL, NULL, 1, '2024-05-20 15:37:05', '2024-05-20 15:37:05');

-- --------------------------------------------------------

--
-- Table structure for table `sale_products`
--

CREATE TABLE `sale_products` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `invoice_no` varchar(160) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `batch_id` int(11) DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `product_qty` decimal(8,2) NOT NULL DEFAULT 0.00,
  `unit_id` int(11) DEFAULT NULL,
  `sale_price` decimal(8,2) NOT NULL DEFAULT 0.00,
  `gst_rate` decimal(8,2) NOT NULL DEFAULT 0.00,
  `total_gst_amount` decimal(8,2) DEFAULT 0.00,
  `sgst_amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `cgst_amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `igst_amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `unit_total_amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sale_products`
--

INSERT INTO `sale_products` (`id`, `sale_id`, `invoice_no`, `customer_id`, `purchase_id`, `batch_id`, `vendor_id`, `product_id`, `product_qty`, `unit_id`, `sale_price`, `gst_rate`, `total_gst_amount`, `sgst_amount`, `cgst_amount`, `igst_amount`, `unit_total_amount`, `status`, `created_at`, `updated_at`) VALUES
(2, 2, 'INV202405-000001', 51, 3, 3, 46, 3, 5.00, 3, 456.00, 18.00, 410.00, 205.00, 205.00, 0.00, 2690.00, 1, '2024-05-19 17:02:28', '2024-05-19 17:02:28'),
(3, 3, 'INV202405-000003', 59, 3, 3, 46, 3, 7.00, 3, 600.00, 18.00, 756.00, 378.00, 378.00, 0.00, 4956.00, 1, '2024-05-19 17:05:32', '2024-05-19 17:05:32'),
(4, 4, 'INV202405-000004', 51, 13, 5, 46, 1, 100.00, 3, 760.00, 0.00, 0.00, 0.00, 0.00, 0.00, 76000.00, 1, '2024-05-20 07:27:33', '2024-05-20 07:27:33'),
(5, 5, 'INV202405-000005', 51, 15, 6, 45, 3, 50.00, 3, 200.00, 18.00, 1800.00, 900.00, 900.00, 0.00, 11800.00, 1, '2024-05-20 07:32:29', '2024-05-20 07:32:29'),
(6, 6, 'INV202405-000006', 50, 14, 4, 47, 4, 45.00, 3, 600.00, 18.00, 4860.00, 2430.00, 2430.00, 0.00, 31860.00, 1, '2024-05-20 07:34:45', '2024-05-20 07:34:45'),
(7, 6, 'INV202405-000006', 50, 15, 6, 45, 3, 22.00, 3, 200.00, 18.00, 792.00, 396.00, 396.00, 0.00, 5192.00, 1, '2024-05-20 07:34:45', '2024-05-20 07:34:45'),
(8, 7, 'INV202405-000007', 60, 14, 4, 47, 4, 90.00, 3, 600.00, 18.00, 9720.00, 4860.00, 4860.00, 0.00, 63720.00, 1, '2024-05-20 11:32:39', '2024-05-20 11:32:39'),
(9, 8, 'INV202405-000008', 60, 14, 4, 47, 4, 50.00, 3, 600.00, 18.00, 5400.00, 2700.00, 2700.00, 0.00, 35400.00, 1, '2024-05-20 11:35:57', '2024-05-20 11:35:57'),
(10, 9, 'INV202405-000009', 60, 14, 4, 47, 4, 50.00, 3, 600.00, 18.00, 5400.00, 2700.00, 2700.00, 0.00, 35400.00, 1, '2024-05-20 12:59:56', '2024-05-20 12:59:56'),
(11, 10, 'INV202405-000010', 50, 14, 4, 47, 4, 200.00, 3, 600.00, 18.00, 21600.00, 10800.00, 10800.00, 0.00, 141600.00, 1, '2024-05-20 15:37:05', '2024-05-20 15:37:05');

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
(51, '39ba207c-b90c-442e-977e-31e60bc18c73', '2500000948', NULL, 'Customer', NULL, 'Three', NULL, 'customer3@yopmail.com', NULL, '7788998878', NULL, NULL, 0, NULL, 5, 1, '2024-04-15 18:18:54', '2024-04-15 18:18:54', NULL, NULL, NULL, NULL),
(52, '72dc2aef-5d7d-450b-b0e2-0f17a114ddca', '6000000421', 'DZ2WJ2', 'Demo', NULL, 'Userx', 'demoUserX', 'demouserx@yopmail.com', '$2y$10$R9nYR2OU0drvCGIBXAG4fuJYtjhmJBnuS4xDkBctLLlm01P4rLhMK', '6712341231', '6712341231', NULL, 1, NULL, 1, 1, '2024-04-22 15:59:13', '2024-04-22 15:59:36', NULL, NULL, NULL, NULL),
(53, 'ba853d5e-9638-4947-b930-f63b5ca48e33', '6900000598', NULL, 'Demo', NULL, 'Vendor', NULL, 'demovendor1@yopm.com', NULL, '8877110091', '8877110091', NULL, 0, NULL, 2, 1, '2024-04-22 16:00:33', '2024-04-22 16:00:33', NULL, NULL, NULL, NULL),
(54, 'c4533ce5-829c-4f1b-9f72-509d10208c99', '6500001030', NULL, 'Quickc', NULL, 'One', NULL, 'quickc1@yopmail.com', NULL, '7671689012', NULL, NULL, 0, NULL, 5, 1, '2024-05-18 14:11:24', '2024-05-18 14:11:24', NULL, NULL, NULL, NULL),
(55, 'e40843ce-dd8a-40f8-88dc-a71c33b70427', '5500000981', NULL, 'Qcus', NULL, 'Two', NULL, 'qc2@yopmail.com', NULL, '8918893513', NULL, NULL, 0, NULL, 5, 1, '2024-05-18 14:18:27', '2024-05-18 14:18:27', NULL, NULL, NULL, NULL),
(56, 'b69f7bad-33db-48e7-92c4-7f2bc3bdf2ba', '2100000357', 'PH1YEWJWAIMB', 'Qc3', NULL, 'Three', NULL, 'qc3@yopmail.com', NULL, '7781009012', NULL, NULL, 0, NULL, 5, 1, '2024-05-18 14:22:59', '2024-05-18 14:22:59', NULL, NULL, NULL, NULL),
(57, '04d08540-f0cf-4024-846f-d8f25ac52e67', '8900000190', '8EPOE5OA4UKG', 'Qc', NULL, 'Four', NULL, 'qc4@yopmail.com', NULL, '9911220019', NULL, NULL, 0, NULL, 5, 1, '2024-05-18 14:24:05', '2024-05-18 14:24:05', NULL, NULL, NULL, NULL),
(58, '67dfc17b-e95c-4394-a913-f27ee076913a', '1700000207', '56ANRX0MOHYY', 'qc11', NULL, 'Elevn', NULL, 'qc11@yopmail.com', NULL, '9917724491', NULL, NULL, 0, NULL, 5, 1, '2024-05-18 19:21:06', '2024-05-18 19:21:06', NULL, NULL, NULL, NULL),
(59, 'c7d84003-5284-4593-a9ab-ec7816dc5f3f', '1500000751', '5VRKMGR4ZTFE', 'Qc11', NULL, 'elev', NULL, 'qc111@yopmail.com', NULL, '5513243190', NULL, NULL, 0, NULL, 5, 1, '2024-05-19 17:04:46', '2024-05-19 17:04:46', NULL, NULL, NULL, NULL),
(60, '6e1e85b4-d335-49dd-a773-7fadba12cc72', '6000000987', 'GYJPIZ6RRTA1', 'Rahul', NULL, 'Cus', NULL, 'rh123@yopmail.com', NULL, '8891110921', NULL, NULL, 0, NULL, 5, 1, '2024-05-20 11:32:15', '2024-05-20 11:32:15', NULL, NULL, NULL, NULL);

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
(16, 51, NULL, 'Kolkata', NULL, NULL, NULL, 'kolkata', '700145', 'WB', 'IND', NULL, NULL, NULL, '2024-04-15 18:18:55', '2024-04-15 18:18:55'),
(17, 53, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IND', NULL, 'XXXX000000000123456', NULL, '2024-04-22 16:00:34', '2024-04-22 16:00:34'),
(18, 60, NULL, 'Kamrabd, sonaroput, kolkata, ping - 8990123, IND', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'GX0000000001', NULL, '2024-05-20 17:02:15', NULL);

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
(44, 44, 3, 1, '2024-04-15 13:25:31', '2024-04-15 16:11:06'),
(45, 52, 2, 1, '2024-04-22 21:29:13', NULL),
(46, 54, 3, 1, '2024-05-18 19:41:24', NULL),
(47, 55, 3, 1, '2024-05-18 19:48:27', NULL),
(48, 56, 3, 1, '2024-05-18 19:52:59', NULL),
(49, 57, 3, 1, '2024-05-18 19:54:05', NULL),
(50, 58, 3, 1, '2024-05-19 00:51:06', NULL),
(51, 59, 3, 1, '2024-05-19 22:34:46', NULL),
(52, 60, 3, 1, '2024-05-20 17:02:15', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `batch_products`
--
ALTER TABLE `batch_products`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_products`
--
ALTER TABLE `purchase_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_products`
--
ALTER TABLE `sale_products`
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
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `batch_products`
--
ALTER TABLE `batch_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `purchase_products`
--
ALTER TABLE `purchase_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sale_products`
--
ALTER TABLE `sale_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `users_profile`
--
ALTER TABLE `users_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user_categories`
--
ALTER TABLE `user_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
<br />
<b>Warning</b>:  Cannot modify header information - headers already sent by (output started at G:\xampp\phpMyAdmin\libraries\classes\Export\Export.php:212) in <b>G:\xampp\phpMyAdmin\libraries\classes\ResponseRenderer.php</b> on line <b>406</b><br />
