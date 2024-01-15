-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th1 15, 2024 lúc 02:28 AM
-- Phiên bản máy phục vụ: 8.0.33
-- Phiên bản PHP: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `shop`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bill`
--

CREATE TABLE `bill` (
  `id` int NOT NULL,
  `table_id` int NOT NULL,
  `creater_id` int NOT NULL,
  `total_price` bigint NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `bill`
--

INSERT INTO `bill` (`id`, `table_id`, `creater_id`, `total_price`, `created_at`) VALUES
(19, 22, 1000, 52000, '2022-08-03 05:24:28'),
(20, 1, 999, 50000, '2023-09-19 11:07:30');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `log`
--

CREATE TABLE `log` (
  `id` int NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_id` int NOT NULL,
  `creater_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `menu`
--

CREATE TABLE `menu` (
  `id` int NOT NULL,
  `product_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` bigint NOT NULL,
  `active` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `menu`
--

INSERT INTO `menu` (`id`, `product_name`, `price`, `active`, `deleted_at`, `created_at`) VALUES
(1, 'trà sữa trân châu', 30000, 'Active', NULL, '0000-00-00 00:00:00'),
(2, 'trà đào túi', 30000, 'Active', NULL, '0000-00-00 00:00:00'),
(3, 'trà chanh túi', 20000, 'Active', NULL, '0000-00-00 00:00:00'),
(4, 'trà đào cam sả', 20000, 'Active', NULL, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2022_04_27_235511_create_cache_table', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_in_table`
--

CREATE TABLE `product_in_table` (
  `id` int NOT NULL,
  `table_id` int NOT NULL,
  `product_id` int NOT NULL,
  `note` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creater_id` int NOT NULL,
  `cashier_id` int DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `bill_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_in_table`
--

INSERT INTO `product_in_table` (`id`, `table_id`, `product_id`, `note`, `creater_id`, `cashier_id`, `paid_at`, `created_at`, `bill_id`) VALUES
(158, 17, 28, 'Nhiều sữa', 1000, 999, '2022-05-09 03:12:55', '2022-05-07 14:17:37', 15),
(159, 17, 30, 'Ít ngọt', 1000, 999, '2022-05-09 03:12:55', '2022-05-07 15:27:22', 15),
(160, 17, 29, 'Bình Thường', 1000, 999, '2022-05-09 03:12:55', '2022-05-07 15:31:04', 15),
(161, 18, 28, 'Bình Thường', 999, 999, '2022-05-09 03:16:37', '2022-05-09 03:16:21', 16),
(162, 18, 30, 'Bình Thường', 999, 999, '2022-05-09 03:16:37', '2022-05-09 03:16:21', 16),
(163, 19, 30, 'Bình Thường', 999, 999, '2022-05-09 05:02:09', '2022-05-09 05:01:14', 17),
(164, 19, 28, 'Bình Thường', 999, 999, '2022-05-09 05:02:09', '2022-05-09 05:01:14', 17),
(165, 20, 28, 'Bình Thường', 999, 999, '2022-05-09 05:02:40', '2022-05-09 05:02:30', 18),
(166, 20, 28, 'Bình Thường', 999, 999, '2022-05-09 05:02:40', '2022-05-09 05:02:30', 18),
(167, 20, 28, 'Bình Thường', 999, 999, '2022-05-09 05:02:40', '2022-05-09 05:02:30', 18),
(168, 20, 28, 'Bình Thường', 999, 999, '2022-05-09 05:02:40', '2022-05-09 05:02:30', 18),
(169, 20, 28, 'Bình Thường', 999, 999, '2022-05-09 05:02:40', '2022-05-09 05:02:30', 18),
(170, 22, 31, 'Bình Thường', 1000, 1000, '2022-08-03 05:24:28', '2022-08-03 05:23:37', 19),
(171, 22, 32, 'Bình Thường', 1000, 1000, '2022-08-03 05:24:28', '2022-08-03 05:23:37', 19),
(172, 22, 32, 'Bình Thường', 1000, 1000, '2022-08-03 05:24:28', '2022-08-03 05:23:37', 19),
(173, 22, 32, 'Bình Thường', 1000, 1000, '2022-08-03 05:24:28', '2022-08-03 05:23:37', 19),
(174, 1, 1, 'Bình Thường', 999, NULL, NULL, '2023-09-19 10:48:38', NULL),
(175, 1, 2, 'Bình Thường', 999, 999, '2023-09-19 11:07:30', '2023-09-19 10:49:20', 20),
(176, 1, 3, 'Bình Thường', 999, 999, '2023-09-19 11:07:30', '2023-09-19 10:49:20', 20),
(177, 2, 2, 'Bình Thường', 999, NULL, NULL, '2023-09-19 11:05:51', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `setting`
--

CREATE TABLE `setting` (
  `id` int NOT NULL,
  `key_word` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `setting`
--

INSERT INTO `setting` (`id`, `key_word`, `title`, `value`, `type`) VALUES
(1, 'max_table_number', 'Số bàn tối đa', '30', 'number'),
(2, 'name_shop', 'Tên cửa hàng', 'Trà Sữa GenZ', 'text'),
(3, 'fb_link', 'Link FB', 'https://www.facebook.com/pong.pe.31', 'text'),
(4, 'add_link', 'Địa Chỉ', 'https://goo.gl/maps/5quhjCy7edqdi4EM7', 'text'),
(5, 'banner', 'Banner', '/public/images/banner1.png', 'text'),
(6, 'call_link', 'Số điện thoại', 'tel:+84363153867', 'text'),
(7, 'infor', 'Thông tin chi tiết', 'Địa chỉ 464 lê văn việt- HCM - TP thủ đức\n<br>\nGiao hàng tận nơi', 'textarea');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `table_item`
--

CREATE TABLE `table_item` (
  `id` int NOT NULL,
  `name_table` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_number` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `creater_id` int NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `table_item`
--

INSERT INTO `table_item` (`id`, `name_table`, `table_number`, `created_at`, `creater_id`, `deleted_at`) VALUES
(1, 'Bàn khách số 1', 1, '2022-08-06 10:57:39', 999, NULL),
(2, 'Bàn Anh đức', 2, '2022-08-06 10:57:56', 999, NULL),
(3, 'Bàn khách số 3', 3, '2023-10-09 04:14:36', 999, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `user_id`, `email_verified_at`, `password`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Phương Nam', '1000', NULL, '$2y$10$uKk9cSGViVKKJ2M3kIyeb.RQ7MiZ/jTeb9moRuKsCgtzw0na2YPt2', '#e51248', NULL, '2022-04-29 21:10:01', '2022-05-03 08:58:06'),
(2, 'Nhân viên 1', '1001', NULL, '$2y$10$uKk9cSGViVKKJ2M3kIyeb.RQ7MiZ/jTeb9moRuKsCgtzw0na2YPt2', '#89e0ef', NULL, '2022-04-29 22:35:48', '2022-04-29 22:35:53'),
(3, 'Nguyễn Văn A', '1002', NULL, '$2y$10$uKk9cSGViVKKJ2M3kIyeb.RQ7MiZ/jTeb9moRuKsCgtzw0na2YPt2', '#672254', NULL, '2022-04-29 22:35:58', '2022-04-29 22:36:02'),
(4, 'Admin Nam Trần', '999', NULL, '$2a$12$NyJE7A9ehi3U8wnOTdmBT..NQvjLjWRUx6zZCpKUaAhgXX99vYpXK', '#8e4330', NULL, '2022-05-02 18:52:10', '2022-05-02 18:52:10');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Chỉ mục cho bảng `product_in_table`
--
ALTER TABLE `product_in_table`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `table_item`
--
ALTER TABLE `table_item`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`user_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `bill`
--
ALTER TABLE `bill`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `log`
--
ALTER TABLE `log`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `product_in_table`
--
ALTER TABLE `product_in_table`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT cho bảng `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `table_item`
--
ALTER TABLE `table_item`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
