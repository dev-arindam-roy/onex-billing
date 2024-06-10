-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20230808.7aa9c4a3ab
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2024 at 05:35 PM
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
(1, 'BC000000-000000', 'Stock-Adjust', NULL, 1, '2024-06-10 20:51:36', NULL);

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
(1, 'Difo', NULL, 1, '2024-06-10 20:51:34', NULL, NULL);

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
(1, 'ONEX BILLING', 25, '2023-08-12 01:20:19', '2023-08-11 21:50:11');

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
(1, 'Gents Shoes', 'Shoes for men', 1, 0, 1, NULL, '2024-06-10 20:51:35', NULL, NULL, NULL, NULL, NULL),
(2, 'Ladies Shoes', 'Shoes for ladies', 1, 0, 1, NULL, '2024-06-10 20:51:35', NULL, NULL, NULL, NULL, NULL);

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
(1, 'Gents Shoe', 1, 1, NULL, NULL, 1, '2024-06-10 20:51:35', NULL, NULL, NULL, NULL, NULL),
(2, 'Ladies Shoe', 2, 2, NULL, NULL, 1, '2024-06-10 20:51:35', NULL, NULL, NULL, NULL, NULL);

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
(1, 1, 'Gents/Men', NULL, 1, NULL, 1, '2024-06-10 20:51:35', NULL, NULL, NULL, NULL, NULL),
(2, 2, 'Ladies/Women', NULL, 1, NULL, 1, '2024-06-10 20:51:35', NULL, NULL, NULL, NULL, NULL);

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
  `size` tinyint(4) DEFAULT NULL,
  `color` varchar(100) DEFAULT NULL,
  `is_bundle_product` tinyint(4) NOT NULL DEFAULT 0,
  `have_free_product` tinyint(4) NOT NULL DEFAULT 0,
  `rating_count` decimal(4,2) NOT NULL DEFAULT 0.00,
  `view_count` int(11) NOT NULL DEFAULT 0,
  `available_stock` decimal(8,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(1, 'Piece', 'Pcs', '1 Piece', NULL, NULL, 1, '2024-06-10 20:51:34', NULL, NULL),
(2, 'Box', 'Box', '1 Box', NULL, NULL, 1, '2024-06-10 20:51:34', NULL, NULL);

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
  `email_id` varchar(160) DEFAULT NULL,
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
(1, 'e5ca9e3f-1e9a-4054-8b8c-0bf4f994933e', '7400000713', NULL, 'Onex', NULL, 'Dev', 'onexdev', 'devteam@onexcrm.com', '$2y$10$bzSF3TwgyhYxu8AimDq4aestAM0zF/WX4Q3QzBDssnSHytp9PWxCC', '9836395513', '9836395513', 'Male', 1, NULL, 1, 1, '2024-06-10 20:52:29', NULL, NULL, NULL, NULL, NULL),
(104, 'aa0b3487-8b53-4b21-a260-de75e4829689', '2600000197', NULL, 'Difo', NULL, 'Self', NULL, 'admin@difo.com', NULL, NULL, NULL, NULL, 0, NULL, 2, 1, '2024-06-10 20:51:36', NULL, NULL, NULL, NULL, NULL),
(106, 'aec4078d-ced2-4fd4-8130-52fa0b4cb2a0', '3000000533', NULL, 'Test', NULL, 'Client', 'DifoAdmin', 'superadmin@difo.com', '$2y$10$de2Dj0pVxx9MQcRhyTthCu.Q1cZu76yNUT5MGJPiuXp5l5TyLXCre', NULL, NULL, NULL, 1, NULL, 1, 1, '2024-06-10 21:05:07', NULL, NULL, NULL, NULL, NULL);

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
(96, 1, 1, 1, '2024-06-10 20:52:29', NULL),
(97, 105, 1, 1, '2024-06-10 20:54:22', NULL),
(98, 106, 1, 1, '2024-06-10 21:05:07', NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `batch_products`
--
ALTER TABLE `batch_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `company_categories`
--
ALTER TABLE `company_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `company_information`
--
ALTER TABLE `company_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_meta_fields`
--
ALTER TABLE `product_meta_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_subcategory`
--
ALTER TABLE `product_subcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_products`
--
ALTER TABLE `purchase_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_products`
--
ALTER TABLE `sale_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `users_profile`
--
ALTER TABLE `users_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_categories`
--
ALTER TABLE `user_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
<br />
<b>Warning</b>:  Cannot modify header information - headers already sent by (output started at G:\xampp\phpMyAdmin\libraries\classes\Export\Export.php:212) in <b>G:\xampp\phpMyAdmin\libraries\classes\ResponseRenderer.php</b> on line <b>406</b><br />
