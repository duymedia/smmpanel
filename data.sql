-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 30, 2026 lúc 10:23 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `mydb`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `activity` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`activity`)),
  `domain` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `type`, `activity`, `domain`, `created_at`) VALUES
(1, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-04-15 15:50:21'),
(2, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-04-16 02:59:35'),
(3, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-04-16 10:55:34'),
(4, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-04-17 04:57:32'),
(5, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-04-17 09:49:14'),
(6, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-04-17 19:39:52'),
(7, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-04-18 05:23:40'),
(8, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-04-18 11:10:56'),
(9, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-04-18 20:52:52'),
(10, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-04-20 13:18:43'),
(11, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-04-21 06:28:33'),
(12, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-04-21 06:28:38'),
(13, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-04-21 16:31:14'),
(14, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-04-22 12:27:22'),
(15, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-04-23 15:33:56'),
(17, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-04-25 02:48:07'),
(18, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-04-25 09:00:29'),
(19, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-04-25 14:00:27'),
(20, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-04-25 19:53:55'),
(21, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-04-25 20:04:45'),
(22, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-04-26 07:51:30'),
(23, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-04-26 07:59:37'),
(24, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-04-26 08:44:36'),
(25, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-04-26 16:24:28'),
(26, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-04-29 12:18:16'),
(27, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-01 11:15:16'),
(28, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-03 09:49:41'),
(29, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-07 13:38:31'),
(30, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-07 13:40:36'),
(31, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-08 08:17:42'),
(32, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-09 05:55:44'),
(33, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-09 15:23:35'),
(34, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-10 06:26:57'),
(35, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-10 07:32:06'),
(36, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-10 07:33:16'),
(37, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-10 12:56:06'),
(38, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-11 11:46:47'),
(39, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-11 20:33:32'),
(40, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-12 05:58:47'),
(41, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-12 17:06:08'),
(42, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-12 18:28:48'),
(43, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-12 18:29:48'),
(44, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-12 18:31:22'),
(45, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-12 18:32:01'),
(46, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-13 00:37:32'),
(47, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-13 01:04:16'),
(48, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-13 02:29:44'),
(49, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-13 02:41:08'),
(50, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-13 07:20:38'),
(51, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-13 09:42:31'),
(52, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-13 09:48:15'),
(53, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-13 10:38:16'),
(54, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-13 10:39:12'),
(55, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-13 10:39:36'),
(56, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/147.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-13 10:40:02'),
(57, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-15 04:37:03'),
(58, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-15 06:02:12'),
(59, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-15 09:39:12'),
(60, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-15 10:34:39'),
(61, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-15 10:40:11'),
(62, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-15 10:46:32'),
(63, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-15 10:55:38'),
(64, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-19 13:58:15'),
(65, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-20 11:39:11'),
(66, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-20 11:39:29'),
(67, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-20 14:17:32'),
(68, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-20 14:20:41'),
(69, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-20 14:20:49'),
(70, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-20 14:25:01'),
(71, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-20 14:28:05'),
(72, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-20 14:31:56'),
(73, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-20 14:32:51'),
(74, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-20 14:33:19'),
(75, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-20 14:38:10'),
(76, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-20 14:40:33'),
(77, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-20 15:11:12'),
(78, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-21 00:19:56'),
(79, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-21 00:43:32'),
(80, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-21 00:45:36'),
(81, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-21 00:59:27'),
(82, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-21 05:56:14'),
(83, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-21 10:07:30'),
(84, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-21 13:28:49'),
(85, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-21 13:44:25'),
(86, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-22 05:06:42'),
(87, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-22 09:44:22'),
(88, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-22 14:04:27'),
(89, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-23 03:07:28'),
(90, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-23 06:22:44'),
(91, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-23 13:21:05'),
(92, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-24 02:31:57'),
(93, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-25 05:27:15'),
(94, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-25 16:22:19'),
(95, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-26 06:27:39'),
(96, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-26 16:58:09'),
(97, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-27 08:03:04'),
(98, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-27 08:53:45'),
(99, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-28 09:21:39'),
(100, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-28 16:34:02'),
(101, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-30 08:14:17'),
(102, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-30 19:18:57'),
(103, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-30 19:21:27'),
(104, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Linux; Android 6.0; Nexus 5 Build\\\\\\/MRA58N) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Mobile Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-30 19:21:50'),
(105, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-30 19:50:00'),
(106, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-30 19:53:11'),
(107, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-30 19:56:13'),
(108, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-30 20:02:55'),
(109, 1, 'login', '\"{\\\"ip_address\\\":\\\"127.0.0.1\\\",\\\"user_agent\\\":\\\"Mozilla\\\\\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/148.0.0.0 Safari\\\\\\/537.36\\\"}\"', '127.0.0.1', '2026-05-30 20:18:16');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `affiliates`
--

CREATE TABLE `affiliates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `referrer_id` bigint(20) UNSIGNED NOT NULL,
  `referred_id` bigint(20) UNSIGNED NOT NULL,
  `referral_code` varchar(255) DEFAULT NULL,
  `commission_rate` decimal(8,4) NOT NULL DEFAULT 0.0000,
  `total_earned` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `total_orders` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `orders_count` int(11) NOT NULL DEFAULT 0,
  `status` enum('active','inactive','suspended') NOT NULL DEFAULT 'active',
  `first_order_at` timestamp NULL DEFAULT NULL,
  `last_order_at` timestamp NULL DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `domain` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `affiliates`
--

INSERT INTO `affiliates` (`id`, `referrer_id`, `referred_id`, `referral_code`, `commission_rate`, `total_earned`, `total_orders`, `orders_count`, `status`, `first_order_at`, `last_order_at`, `note`, `created_at`, `updated_at`, `domain`) VALUES
(21, 1, 8, 'td9txVuh', 10.0000, 2.0000, 20.0000, 1, 'active', NULL, '2026-04-26 09:48:40', NULL, '2026-04-26 09:06:51', '2026-04-26 09:48:40', '127.0.0.1'),
(22, 1, 9, 'td9txVuh', 10.0000, 5.5000, 55.0000, 2, 'active', NULL, '2026-05-03 12:18:49', NULL, '2026-04-26 09:15:54', '2026-05-03 12:18:49', '127.0.0.1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `api_providers`
--

CREATE TABLE `api_providers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `api_key` varchar(255) NOT NULL,
  `rate_api` varchar(255) DEFAULT NULL,
  `balance` decimal(15,8) NOT NULL DEFAULT 0.00000000,
  `fixed_decimal` varchar(255) NOT NULL DEFAULT '4',
  `warning` tinyint(1) NOT NULL DEFAULT 1,
  `currency` varchar(255) NOT NULL DEFAULT 'USD',
  `note` text DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `domain` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `api_providers`
--

INSERT INTO `api_providers` (`id`, `name`, `type`, `link`, `api_key`, `rate_api`, `balance`, `fixed_decimal`, `warning`, `currency`, `note`, `position`, `status`, `created_at`, `updated_at`, `domain`) VALUES
(2, 'smmkay.com', 'api', 'https://smmkay.com/api/v2', 'd9bc3553c74c27fe440d5f087300d468', '1', 105.26931000, '10', 0, 'USD', NULL, 0, 1, '2026-05-22 16:25:13', '2026-05-25 05:28:34', '127.0.0.1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `platform_id` bigint(20) UNSIGNED NOT NULL,
  `name` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`name`)),
  `image` varchar(255) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `domain` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `platform_id`, `name`, `image`, `position`, `status`, `created_at`, `updated_at`, `domain`) VALUES
(1, 1, '{\"en\":\"Like\"}', 'fa-brands fa-facebook', 2, 1, '2026-04-15 15:54:05', '2026-04-15 15:54:22', '127.0.0.1'),
(2, 1, '{\"en\":\"Subbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb\"}', 'fa-brands fa-facebook', 1, 1, '2026-04-15 15:54:19', '2026-04-15 15:54:22', '127.0.0.1'),
(3, 1, '{\"en\":\"1\"}', 'fa-brands fa-facebook', 3, 1, '2026-04-15 17:17:22', '2026-04-15 17:17:22', '127.0.0.1'),
(4, 1, '{\"en\":\"32112132\"}', 'fa-brands fa-facebook', 4, 1, '2026-04-15 17:19:52', '2026-04-15 17:19:52', '127.0.0.1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `child_panels`
--

CREATE TABLE `child_panels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `domain` varchar(255) NOT NULL,
  `domain_panel` varchar(255) NOT NULL,
  `total_orders` int(11) NOT NULL DEFAULT 0,
  `total_services` int(11) NOT NULL DEFAULT 0,
  `total_users` int(11) NOT NULL DEFAULT 0,
  `price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `access` varchar(255) NOT NULL DEFAULT 'child',
  `settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`settings`)),
  `status` enum('pending','completed','suspended') NOT NULL DEFAULT 'pending',
  `last_sync_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `configs`
--

CREATE TABLE `configs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL DEFAULT 'Perfect Panel Vietnam',
  `description` text NOT NULL DEFAULT 'Perfect Panel Vietnam',
  `keywords` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `logo_square` varchar(255) DEFAULT NULL,
  `logo_facebook` varchar(255) DEFAULT NULL,
  `namesv1` varchar(255) DEFAULT NULL,
  `namesv2` varchar(255) DEFAULT NULL,
  `child_panel_cost` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `child_panel_status` tinyint(1) NOT NULL DEFAULT 0,
  `default_landingpage` varchar(255) NOT NULL DEFAULT 'default',
  `default_login` varchar(255) NOT NULL DEFAULT 'default',
  `default_interface` varchar(255) NOT NULL DEFAULT 'default',
  `default_theme` varchar(255) NOT NULL DEFAULT 'light',
  `default_currency` varchar(255) NOT NULL DEFAULT 'USD',
  `default_lang` varchar(255) NOT NULL DEFAULT 'en',
  `timezone` int(11) NOT NULL DEFAULT 0,
  `announcement_position` varchar(255) NOT NULL DEFAULT 'page',
  `announcement_content` varchar(255) DEFAULT NULL,
  `announcement_status` tinyint(1) NOT NULL DEFAULT 1,
  `addfund_content` varchar(255) DEFAULT NULL,
  `terms_content` varchar(255) DEFAULT NULL,
  `keep_orders` text DEFAULT NULL,
  `keep_orders_status` tinyint(1) NOT NULL DEFAULT 0,
  `link_facebook` varchar(255) DEFAULT NULL,
  `link_zalo` varchar(255) DEFAULT NULL,
  `link_telegram` varchar(255) DEFAULT NULL,
  `link_whatsapp` varchar(255) DEFAULT NULL,
  `affiliate_allow_convert` tinyint(1) NOT NULL DEFAULT 0,
  `affiliate_allow_withdraw` tinyint(1) NOT NULL DEFAULT 0,
  `affiliate_percent` decimal(5,2) NOT NULL DEFAULT 10.00,
  `affiliate_min` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `affiliate_max` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `affiliate_status` tinyint(1) NOT NULL DEFAULT 1,
  `markup_retail` decimal(5,2) NOT NULL DEFAULT 100.00,
  `markup_agent` decimal(5,2) NOT NULL DEFAULT 100.00,
  `markup_distributor` decimal(5,2) NOT NULL DEFAULT 100.00,
  `show_multi_rate` tinyint(1) NOT NULL DEFAULT 0,
  `min_total_deposit_child_panel` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `min_total_deposit_reseller` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `script_header` text DEFAULT NULL,
  `script_css` text DEFAULT NULL,
  `script_footer` text DEFAULT NULL,
  `telegram_token_bot` varchar(255) DEFAULT NULL,
  `telegram_public_chat_id` varchar(255) DEFAULT NULL,
  `telegram_private_chat_id` varchar(255) DEFAULT NULL,
  `telegram_notify_add_service` tinyint(1) NOT NULL DEFAULT 0,
  `telegram_notify_update_service` tinyint(1) NOT NULL DEFAULT 0,
  `telegram_notify_manual_order` tinyint(1) NOT NULL DEFAULT 0,
  `telegram_notify_deposit` tinyint(1) NOT NULL DEFAULT 0,
  `telegram_status` tinyint(1) NOT NULL DEFAULT 0,
  `smtp_host` varchar(255) DEFAULT NULL,
  `smtp_port` int(11) DEFAULT NULL,
  `smtp_username` varchar(255) DEFAULT NULL,
  `smtp_password` varchar(255) DEFAULT NULL,
  `smtp_from_name` varchar(255) DEFAULT NULL,
  `cloudflare_email` varchar(255) DEFAULT NULL,
  `cloudflare_global_key` varchar(255) DEFAULT NULL,
  `cloudflare_account_id` varchar(255) DEFAULT NULL,
  `cloudflare_token` varchar(255) DEFAULT NULL,
  `cloudflare_ip_host` varchar(255) DEFAULT NULL,
  `cpanel_server` varchar(255) DEFAULT NULL,
  `cpanel_username` varchar(255) DEFAULT NULL,
  `cpanel_password` varchar(255) DEFAULT NULL,
  `module_oauth_google` tinyint(1) NOT NULL DEFAULT 0,
  `google_oauth_client_id` varchar(255) DEFAULT NULL,
  `google_oauth_client_secret` varchar(255) DEFAULT NULL,
  `google_oauth_status` tinyint(1) NOT NULL DEFAULT 0,
  `fake_order_step_min` int(11) NOT NULL DEFAULT 1,
  `fake_order_step_max` int(11) NOT NULL DEFAULT 1000,
  `fake_order_status` tinyint(1) NOT NULL DEFAULT 0,
  `domain_main` varchar(255) DEFAULT NULL,
  `enable_services` tinyint(1) NOT NULL DEFAULT 1,
  `service_allow_report` tinyint(1) NOT NULL DEFAULT 1,
  `service_require_login` tinyint(1) NOT NULL DEFAULT 1,
  `service_average_time` tinyint(1) NOT NULL DEFAULT 1,
  `require_confirm_service` tinyint(1) NOT NULL DEFAULT 1,
  `check_duplicate_order_status` tinyint(1) NOT NULL DEFAULT 1,
  `check_duplicate_order_time` tinyint(1) NOT NULL DEFAULT 1,
  `enable_products` int(11) NOT NULL DEFAULT 0,
  `allow_register` tinyint(1) NOT NULL DEFAULT 1,
  `allow_multi_device_login` tinyint(1) NOT NULL DEFAULT 0,
  `recaptcha_site_key` varchar(255) DEFAULT NULL,
  `recaptcha_secret_key` varchar(255) DEFAULT NULL,
  `recaptcha_status` tinyint(1) NOT NULL DEFAULT 0,
  `blocked_ips` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`blocked_ips`)),
  `module_coupon` tinyint(1) NOT NULL DEFAULT 0,
  `module_crisp_chat` tinyint(1) NOT NULL DEFAULT 0,
  `module_crisp_chat_id` varchar(255) DEFAULT NULL,
  `member_level_status` tinyint(1) NOT NULL DEFAULT 0,
  `member_levels` text DEFAULT NULL,
  `domain` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `enable_signup` tinyint(1) NOT NULL DEFAULT 1,
  `multiple_login_status` tinyint(1) NOT NULL DEFAULT 1,
  `gcaptcha_status` tinyint(1) NOT NULL DEFAULT 0,
  `gcaptcha_site_key` varchar(255) DEFAULT NULL,
  `gcaptcha_secret_key` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `configs`
--

INSERT INTO `configs` (`id`, `user_id`, `title`, `description`, `keywords`, `favicon`, `logo`, `logo_square`, `logo_facebook`, `namesv1`, `namesv2`, `child_panel_cost`, `child_panel_status`, `default_landingpage`, `default_login`, `default_interface`, `default_theme`, `default_currency`, `default_lang`, `timezone`, `announcement_position`, `announcement_content`, `announcement_status`, `addfund_content`, `terms_content`, `keep_orders`, `keep_orders_status`, `link_facebook`, `link_zalo`, `link_telegram`, `link_whatsapp`, `affiliate_allow_convert`, `affiliate_allow_withdraw`, `affiliate_percent`, `affiliate_min`, `affiliate_max`, `affiliate_status`, `markup_retail`, `markup_agent`, `markup_distributor`, `show_multi_rate`, `min_total_deposit_child_panel`, `min_total_deposit_reseller`, `script_header`, `script_css`, `script_footer`, `telegram_token_bot`, `telegram_public_chat_id`, `telegram_private_chat_id`, `telegram_notify_add_service`, `telegram_notify_update_service`, `telegram_notify_manual_order`, `telegram_notify_deposit`, `telegram_status`, `smtp_host`, `smtp_port`, `smtp_username`, `smtp_password`, `smtp_from_name`, `cloudflare_email`, `cloudflare_global_key`, `cloudflare_account_id`, `cloudflare_token`, `cloudflare_ip_host`, `cpanel_server`, `cpanel_username`, `cpanel_password`, `module_oauth_google`, `google_oauth_client_id`, `google_oauth_client_secret`, `google_oauth_status`, `fake_order_step_min`, `fake_order_step_max`, `fake_order_status`, `domain_main`, `enable_services`, `service_allow_report`, `service_require_login`, `service_average_time`, `require_confirm_service`, `check_duplicate_order_status`, `check_duplicate_order_time`, `enable_products`, `allow_register`, `allow_multi_device_login`, `recaptcha_site_key`, `recaptcha_secret_key`, `recaptcha_status`, `blocked_ips`, `module_coupon`, `module_crisp_chat`, `module_crisp_chat_id`, `member_level_status`, `member_levels`, `domain`, `status`, `enable_signup`, `multiple_login_status`, `gcaptcha_status`, `gcaptcha_site_key`, `gcaptcha_secret_key`, `created_at`, `updated_at`) VALUES
(1, 1, 'SMM Panel', 'Hệ thống quản lý dịch vụ mạng xã hội', '111', NULL, NULL, NULL, NULL, '1', '2', 1.0000, 1, '5', '6', 'default', 'dark', 'USD', 'en', 14400, 'page_and_modal', '<p><br></p>', 1, NULL, '<p>aaaa</p><p>ccccc</p><p><strong>bbbb</strong></p>', '[\"Invalid service\",\"23123132131\",\"12231\"]', 1, '1', '2', NULL, NULL, 0, 0, 10.00, 0.0000, 0.0000, 1, 100.00, 100.00, 100.00, 1, 1.0000, 10.0000, NULL, NULL, NULL, '8544935208:AAF-yTHr1CIjci8tXGJHPqWRuzy1SJYQ50E', '8409353479', '8409353479', 1, 1, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, 1, 1000, 0, '127.0.0.1', 1, 1, 1, 0, 1, 0, 0, 0, 1, 1, NULL, NULL, 1, '[]', 0, 1, '213312312', 1, '[{\"name\":\"NEWBIE\",\"min_deposit\":\"11\",\"bonus_percent\":\"1\"},{\"name\":\"JUNIOR\",\"min_deposit\":\"111\",\"bonus_percent\":\"2\"},{\"name\":\"ELITE\",\"min_deposit\":\"1111\",\"bonus_percent\":\"3\"},{\"name\":\"FREQUENT\",\"min_deposit\":\"111110\",\"bonus_percent\":\"4\"},{\"name\":\"VIP\",\"min_deposit\":\"1111110\",\"bonus_percent\":\"5\"}]', '127.0.0.1', 1, 1, 1, 0, NULL, NULL, '2026-04-15 15:50:19', '2026-05-28 18:29:26'),
(2, 2, 'SMM Panel', 'Hệ thống quản lý dịch vụ mạng xã hội', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.0000, 0, 'default', 'default', 'default', 'light', 'USD', 'en', 14400, 'page', NULL, 1, NULL, NULL, NULL, 0, '3', '4', NULL, NULL, 0, 0, 102.00, 0.0000, 0.0000, 1, 20.00, 10.00, 5.00, 0, 0.0000, 0.0000, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, 1, 1000, 0, 'localhost', 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, NULL, 0, NULL, 0, 0, NULL, 0, NULL, '127.0.0.1', 1, 1, 1, 0, NULL, NULL, '2026-04-23 16:25:57', '2026-04-23 16:25:57'),
(3, 12, 'SMM Panel', 'SMM Panel', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.0000, 0, 'default', 'default', 'default', 'light', 'USD', 'en', 14400, 'page', NULL, 1, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 10.00, 0.0000, 0.0000, 1, 20.00, 10.00, 5.00, 0, 0.0000, 0.0000, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, 1, 1000, 0, '127.0.0.2', 1, 1, 1, 1, 1, 1, 1, 0, 1, 0, NULL, NULL, 0, NULL, 0, 0, NULL, 0, NULL, '127.0.0.2', 1, 1, 1, 0, NULL, NULL, '2026-05-21 05:29:54', '2026-05-21 05:29:54');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(50) NOT NULL,
  `discount_type` enum('percent','fixed') NOT NULL DEFAULT 'percent',
  `discount_value` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `usage_limit` int(10) UNSIGNED DEFAULT NULL,
  `usage_per_account` int(10) UNSIGNED DEFAULT NULL,
  `used_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `account_role` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`account_role`)),
  `item_type` enum('service','product') DEFAULT NULL,
  `min_order` decimal(15,4) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `domain` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `discount_type`, `discount_value`, `usage_limit`, `usage_per_account`, `used_count`, `start_date`, `end_date`, `account_role`, `item_type`, `min_order`, `note`, `status`, `domain`, `created_at`, `updated_at`) VALUES
(3, '13231', 'fixed', 3213.0000, 2131, 123, 0, '2026-05-27 17:26:00', '2026-05-28 17:26:00', '[\"reseller\"]', 'service', 23331.0000, '11', 1, '127.0.0.1', '2026-05-27 10:26:54', '2026-05-27 10:26:54');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `coupon_usages`
--

CREATE TABLE `coupon_usages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coupon_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `item_type` enum('service','product') DEFAULT NULL,
  `item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `discount_value` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `domain` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `currency`
--

CREATE TABLE `currency` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `symbol` varchar(255) NOT NULL,
  `exchange_rate` decimal(15,8) NOT NULL DEFAULT 1.00000000,
  `name` varchar(255) NOT NULL,
  `sync` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `symbol_position` enum('before','after') NOT NULL DEFAULT 'before',
  `domain` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `currency`
--

INSERT INTO `currency` (`id`, `code`, `symbol`, `exchange_rate`, `name`, `sync`, `status`, `symbol_position`, `domain`, `created_at`, `updated_at`) VALUES
(333, 'USD', '$', 1.00000000, 'US Dollar', 0, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-03 10:42:45'),
(334, 'AED', 'د.إ', 3.67000000, 'United Arab Emirates Dirham', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-03 10:42:45'),
(335, 'AFN', '؋', 63.70000000, 'Afghan Afghani', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(336, 'ALL', 'L', 82.00000000, 'Albanian Lek', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-03 10:42:45'),
(337, 'AMD', '֏', 368.00000000, 'Armenian Dram', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(338, 'ANG', 'ƒ', 1.79000000, 'Netherlands Antillean Guilder', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-03 10:42:45'),
(339, 'AOA', 'Kz', 927.00000000, 'Angolan Kwanza', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(340, 'ARS', '$', 1395.00000000, 'Argentine Peso', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(341, 'AUD', 'A$', 1.40000000, 'Australian Dollar', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(342, 'AWG', 'ƒ', 1.79000000, 'Aruban Florin', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-03 10:42:45'),
(343, 'AZN', '₼', 1.70000000, 'Azerbaijani Manat', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-03 10:42:45'),
(344, 'BAM', 'КМ', 1.68000000, 'Bosnia-Herzegovina Convertible Mark', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(345, 'BBD', '$', 2.00000000, 'Barbadian Dollar', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-03 10:42:45'),
(346, 'BDT', '৳', 123.00000000, 'Bangladeshi Taka', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-03 10:42:45'),
(347, 'BGN', 'лв', 1.68000000, 'Bulgarian Lev', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(348, 'BHD', '.د.ب', 0.37600000, 'Bahraini Dinar', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-03 10:42:45'),
(349, 'BIF', 'FBu', 2984.00000000, 'Burundian Franc', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(350, 'BMD', '$', 1.00000000, 'Bermudan Dollar', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-03 10:42:45'),
(351, 'BND', '$', 1.28000000, 'Brunei Dollar', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(352, 'BOB', '$b', 6.93000000, 'Bolivian Boliviano', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(353, 'BRL', 'R$', 5.04000000, 'Brazilian Real', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(354, 'BSD', '$', 1.00000000, 'Bahamian Dollar', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-03 10:42:45'),
(355, 'BTN', 'Nu.', 96.40000000, 'Bhutanese Ngultrum', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(356, 'BWP', 'P', 13.80000000, 'Botswanan Pula', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(357, 'BYN', 'Br', 2.75000000, 'Belarusian Ruble', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(358, 'BZD', 'BZ$', 2.00000000, 'Belize Dollar', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-03 10:42:45'),
(359, 'CAD', 'C$', 1.37000000, 'Canadian Dollar', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(360, 'CDF', 'FC', 2251.00000000, 'Congolese Franc', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(361, 'CHF', 'CHF', 0.78480000, 'Swiss Franc', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(362, 'CLF', 'CLF', 0.02299000, 'CLF', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(363, 'CLP', '$', 909.00000000, 'Chilean Peso', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(364, 'CNH', 'CNH', 6.80000000, 'CNH', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(365, 'CNY', '¥', 6.81000000, 'Chinese Yuan', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(366, 'COP', '$', 3791.00000000, 'Colombian Peso', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(367, 'CRC', '₡', 455.00000000, 'Costa Rican Colón', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(368, 'CUP', '₱', 24.00000000, 'Cuban Peso', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-03 10:42:45'),
(369, 'CVE', '$', 94.70000000, 'Cape Verdean Escudo', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(370, 'CZK', 'Kč', 20.90000000, 'Czech Republic Koruna', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(371, 'DJF', 'Fdj', 178.00000000, 'Djiboutian Franc', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-03 10:42:45'),
(372, 'DKK', 'kr', 6.41000000, 'Danish Krone', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(373, 'DOP', 'RD$', 59.50000000, 'Dominican Peso', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-03 10:42:45'),
(374, 'DZD', 'دج', 132.00000000, 'Algerian Dinar', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(375, 'EGP', '£', 53.30000000, 'Egyptian Pound', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(376, 'ERN', 'Nfk', 15.00000000, 'Eritrean Nakfa', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-03 10:42:45'),
(377, 'ETB', 'Br', 156.00000000, 'Ethiopian Birr', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-03 10:42:45'),
(378, 'EUR', '€', 0.85840000, 'Euro', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(379, 'FJD', '$', 2.19000000, 'Fijian Dollar', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(380, 'FKP', '£', 0.74560000, 'Falkland Islands Pound', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(381, 'FOK', 'FOK', 6.41000000, 'FOK', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(382, 'GBP', '£', 0.74560000, 'British Pound Sterling', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(383, 'GEL', '₾', 2.67000000, 'Georgian Lari', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(384, 'GGP', '£', 0.74560000, 'Guernsey Pound', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(385, 'GHS', '¢', 11.40000000, 'Ghanaian Cedi', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(386, 'GIP', '£', 0.74560000, 'Gibraltar Pound', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(387, 'GMD', 'D', 74.20000000, 'Gambian Dalasi', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-03 10:42:45'),
(388, 'GNF', 'FG', 8768.00000000, 'Guinean Franc', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(389, 'GTQ', 'Q', 7.62000000, 'Guatemalan Quetzal', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(390, 'GYD', '$', 209.00000000, 'Guyanaese Dollar', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-03 10:42:45'),
(391, 'HKD', 'HK$', 7.83000000, 'Hong Kong Dollar', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-03 10:42:45'),
(392, 'HNL', 'L', 26.60000000, 'Honduran Lempira', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-03 10:42:45'),
(393, 'HRK', 'kn', 6.47000000, 'Croatian Kuna', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-19 14:22:59'),
(394, 'HTG', 'G', 131.00000000, 'Haitian Gourde', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:45', '2026-05-03 10:42:45'),
(395, 'HUF', 'Ft', 309.00000000, 'Hungarian Forint', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(396, 'IDR', 'Rp', 17667.00000000, 'Indonesian Rupiah', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(397, 'ILS', '₪', 2.90000000, 'Israeli New Sheqel', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(398, 'IMP', '£', 0.74560000, 'Manx pound', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(399, 'INR', '₹', 96.40000000, 'Indian Rupee', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(400, 'IQD', 'ع.د', 1311.00000000, 'Iraqi Dinar', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-03 10:42:46'),
(401, 'IRR', '﷼', 1219379.00000000, 'Iranian Rial', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(402, 'ISK', 'kr', 123.00000000, 'Icelandic Króna', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-03 10:42:46'),
(403, 'JEP', '£', 0.74560000, 'Jersey Pound', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(404, 'JMD', 'J$', 158.00000000, 'Jamaican Dollar', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(405, 'JOD', 'JD', 0.70900000, 'Jordanian Dinar', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-03 10:42:46'),
(406, 'JPY', '¥', 159.00000000, 'Japanese Yen', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(407, 'KES', 'KSh', 129.00000000, 'Kenyan Shilling', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-03 10:42:46'),
(408, 'KGS', 'лв', 87.50000000, 'Kyrgystani Som', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-03 10:42:46'),
(409, 'KHR', '៛', 4036.00000000, 'Cambodian Riel', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(410, 'KID', 'KID', 1.40000000, 'KID', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(411, 'KMF', 'CF', 422.00000000, 'Comorian Franc', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(412, 'KRW', '₩', 1494.00000000, 'South Korean Won', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(413, 'KWD', 'KD', 0.30830000, 'Kuwaiti Dinar', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(414, 'KYD', '$', 0.83330000, 'Cayman Islands Dollar', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-03 10:42:46'),
(415, 'KZT', '₸', 468.00000000, 'Kazakhstani Tenge', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(416, 'LAK', '₭', 21812.00000000, 'Laotian Kip', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(417, 'LBP', '£', 89500.00000000, 'Lebanese Pound', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-03 10:42:46'),
(418, 'LKR', '₨', 326.00000000, 'Sri Lankan Rupee', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(419, 'LRD', '$', 183.00000000, 'Liberian Dollar', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(420, 'LSL', 'M', 16.60000000, 'Lesotho Loti', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(421, 'LYD', 'LD', 6.35000000, 'Libyan Dinar', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-03 10:42:46'),
(422, 'MAD', 'MAD', 9.21000000, 'Moroccan Dirham', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(423, 'MDL', 'lei', 17.20000000, 'Moldovan Leu', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-03 10:42:46'),
(424, 'MGA', 'Ar', 4200.00000000, 'Malagasy Ariary', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(425, 'MKD', 'ден', 52.90000000, 'Macedonian Denar', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(426, 'MMK', 'K', 2098.00000000, 'Myanma Kyat', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(427, 'MNT', '₮', 3555.00000000, 'Mongolian Tugrik', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(428, 'MOP', 'MOP$', 8.07000000, 'Macanese Pataca', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-03 10:42:46'),
(429, 'MRU', 'UM', 40.10000000, 'Mauritanian Ouguiya', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(430, 'MUR', '₨', 47.20000000, 'Mauritian Rupee', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(431, 'MVR', 'Rf', 15.40000000, 'Maldivian Rufiyaa', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(432, 'MWK', 'MK', 1743.00000000, 'Malawian Kwacha', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(433, 'MXN', '$', 17.30000000, 'Mexican Peso', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(434, 'MYR', 'RM', 3.97000000, 'Malaysian Ringgit', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-03 10:42:46'),
(435, 'MZN', 'MT', 63.70000000, 'Mozambican Metical', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-03 10:42:46'),
(436, 'NAD', '$', 16.60000000, 'Namibian Dollar', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(437, 'NGN', '₦', 1369.00000000, 'Nigerian Naira', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(438, 'NIO', 'C$', 36.80000000, 'Nicaraguan Córdoba', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(439, 'NOK', 'kr', 9.27000000, 'Norwegian Krone', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(440, 'NPR', '₨', 154.00000000, 'Nepalese Rupee', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(441, 'NZD', 'NZ$', 1.70000000, 'New Zealand Dollar', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-03 10:42:46'),
(442, 'OMR', '﷼', 0.38450000, 'Omani Rial', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-03 10:42:46'),
(443, 'PAB', 'B/.', 1.00000000, 'Panamanian Balboa', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-03 10:42:46'),
(444, 'PEN', 'S/.', 3.43000000, 'Peruvian Nuevo Sol', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(445, 'PGK', 'K', 4.36000000, 'Papua New Guinean Kina', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(446, 'PHP', '₱', 61.70000000, 'Philippine Peso', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(447, 'PKR', '₨', 279.00000000, 'Pakistani Rupee', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-03 10:42:46'),
(448, 'PLN', 'zł', 3.64000000, 'Polish Zloty', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(449, 'PYG', 'Gs', 6104.00000000, 'Paraguayan Guarani', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(450, 'QAR', '﷼', 3.64000000, 'Qatari Rial', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-03 10:42:46'),
(451, 'RON', 'lei', 4.47000000, 'Romanian Leu', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(452, 'RSD', 'Дин.', 101.00000000, 'Serbian Dinar', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(453, 'RUB', '₽', 72.50000000, 'Russian Ruble', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(454, 'RWF', 'R₣', 1467.00000000, 'Rwandan Franc', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(455, 'SAR', '﷼', 3.75000000, 'Saudi Riyal', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-03 10:42:46'),
(456, 'SBD', '$', 7.93000000, 'Solomon Islands Dollar', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-03 10:42:46'),
(457, 'SCR', '₨', 14.80000000, 'Seychellois Rupee', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(458, 'SDG', 'ج.س.', 454.00000000, 'Sudanese Pound', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(459, 'SEK', 'kr', 9.39000000, 'Swedish Krona', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(460, 'SGD', 'S$', 1.28000000, 'Singapore Dollar', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(461, 'SHP', '£', 0.74560000, 'Saint Helena Pound', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(462, 'SLE', 'Le', 24.60000000, 'Sierra Leonean Leone', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(463, 'SLL', 'Le', 24574.00000000, 'Sierra Leonean Leone (Old)', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(464, 'SOS', 'S', 571.00000000, 'Somali Shilling', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-03 10:42:46'),
(465, 'SRD', '$', 37.10000000, 'Surinamese Dollar', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(466, 'SSP', '£', 4718.00000000, 'South Sudanese Pound', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(467, 'STN', 'Db', 21.00000000, 'São Tomé and Príncipe Dobra', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(468, 'SYP', '£', 112.00000000, 'Syrian Pound', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(469, 'SZL', 'E', 16.60000000, 'Swazi Lilangeni', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(470, 'THB', '฿', 32.50000000, 'Thai Baht', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-03 10:42:46'),
(471, 'TJS', 'SM', 9.32000000, 'Tajikistani Somoni', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(472, 'TMT', 'T', 3.50000000, 'Turkmenistani Manat', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-03 10:42:46'),
(473, 'TND', 'د.ت', 2.90000000, 'Tunisian Dinar', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(474, 'TOP', 'T$', 2.34000000, 'Tongan Paʻanga', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(475, 'TRY', '₺', 45.60000000, 'Turkish Lira', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(476, 'TTD', 'TT$', 6.75000000, 'Trinidad and Tobago Dollar', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(477, 'TVD', '$', 1.40000000, 'Tuvaluan Dollar', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(478, 'TWD', 'NT$', 31.60000000, 'New Taiwan Dollar', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-03 10:42:46'),
(479, 'TZS', 'TSh', 2578.00000000, 'Tanzanian Shilling', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(480, 'UAH', '₴', 44.10000000, 'Ukrainian Hryvnia', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(481, 'UGX', 'USh', 3730.00000000, 'Ugandan Shilling', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(482, 'UYU', '$U', 40.10000000, 'Uruguayan Peso', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(483, 'UZS', 'лв', 11963.00000000, 'Uzbekistan Som', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(484, 'VES', 'Bs', 518.00000000, 'Venezuelan Bolívar Soberano', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(485, 'VND', '₫', 26256.00000000, 'Vietnamese Dong', 0, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-23 08:26:19'),
(486, 'VUV', 'VT', 118.00000000, 'Vanuatu Vatu', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(487, 'WST', 'WS$', 2.69000000, 'Samoan Tala', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(488, 'XAF', 'FCFA', 563.00000000, 'CFA Franc BEAC', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(489, 'XCD', '$', 2.70000000, 'East Caribbean Dollar', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-03 10:42:46'),
(490, 'XCG', 'XCG', 1.79000000, 'XCG', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-03 10:42:46'),
(491, 'XDR', 'SDR', 0.73030000, 'Special Drawing Rights', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(492, 'XOF', 'CFA', 563.00000000, 'CFA Franc BCEAO', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(493, 'XPF', '₣', 102.00000000, 'CFP Franc', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-03 10:42:46'),
(494, 'YER', '﷼', 238.00000000, 'Yemeni Rial', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(495, 'ZAR', 'R', 16.60000000, 'South African Rand', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:22:59'),
(496, 'ZMW', 'ZK', 18.90000000, 'Zambian Kwacha', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-03 10:42:46'),
(497, 'ZWG', 'ZWG', 25.90000000, 'ZWG', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:23:00'),
(498, 'ZWL', 'Z$', 25.90000000, 'Zimbabwean Dollar', 1, 1, 'before', '127.0.0.1', '2026-05-03 10:42:46', '2026-05-19 14:23:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `type` enum('spin','box') NOT NULL DEFAULT 'spin',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `max_spins_per_day` int(11) NOT NULL DEFAULT 1,
  `max_spins_total` int(11) NOT NULL DEFAULT 0,
  `rewards` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`rewards`)),
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  `domain` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `event_spins`
--

CREATE TABLE `event_spins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `reward_name` varchar(255) NOT NULL,
  `reward_amount` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `ip_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `flag` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `domain` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `flag`, `status`, `created_at`, `updated_at`, `domain`) VALUES
(2, 'Tiếng Việt', 'vi', 'fi fi-vn', 1, '2026-04-21 07:54:55', '2026-04-21 07:54:55', '127.0.0.1'),
(3, 'English', 'en', 'fi fi-us', 1, '2026-04-21 07:54:55', '2026-04-21 07:54:55', '127.0.0.1'),
(8, 'Afghanistan', 'af', 'fi fi-af', 1, '2026-04-29 14:56:09', '2026-04-29 14:56:09', '127.0.0.1'),
(9, 'Albania', 'al', 'fi fi-al', 1, '2026-04-29 14:57:25', '2026-04-29 14:57:25', '127.0.0.1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(4, '2025_12_10_075057_create_tickets_table', 1),
(5, '2025_12_11_000000_create_platforms_table', 1),
(6, '2025_12_11_000001_create_categories_table', 1),
(8, '2025_12_11_000003_create_api_providers_table', 1),
(9, '2025_12_11_000004_create_configs_table', 1),
(10, '2025_12_11_000011_create_payment_methods_table', 1),
(11, '2025_12_11_000012_create_payments_table', 1),
(12, '2025_12_11_000013_create_orders_table', 1),
(13, '2025_12_11_000014_create_affiliates_table', 1),
(14, '2025_12_15_064148_create_languages_table', 1),
(15, '2025_12_22_080000_create_currency_table', 1),
(16, '2025_12_30_000000_create_ticket_messages_table', 1),
(17, '2026_01_17_000000_create_events_table', 1),
(18, '2026_01_23_190911_create_child_panels_table', 1),
(20, '2026_03_28_000001_create_product_categories_table', 1),
(21, '2026_03_28_000002_create_product_groups_table', 1),
(23, '2026_03_28_000004_create_product_goods_table', 1),
(24, '2026_03_28_194917_create_news_table', 1),
(25, '2026_04_02_140418_create_product_orders_table', 1),
(26, '2025_12_11_000002_create_services_table', 2),
(27, '2025_12_10_075040_create_transactions_table', 3),
(28, '2026_03_28_000003_create_products_table', 4),
(29, '2026_03_25_000000_create_service_sync_logs_table', 5),
(30, '2025_12_11_000020_add_security_fields_to_configs_table', 6),
(31, '2025_01_13_130000_create_activity_logs_table', 7),
(32, '2026_05_09_130144_create_user_custom_rates_table', 7),
(33, '2026_05_27_000000_create_coupons_table', 8),
(34, '2026_05_27_000001_create_coupon_usages_table', 9),
(35, '2026_05_28_163000_create_payment_method_groups_table', 10);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext DEFAULT NULL,
  `domain` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `link` text DEFAULT NULL,
  `comment` longtext DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `rate` decimal(15,8) NOT NULL DEFAULT 4.00000000,
  `charge` decimal(15,8) NOT NULL DEFAULT 4.00000000,
  `total` decimal(15,8) NOT NULL DEFAULT 4.00000000,
  `start_count` int(11) NOT NULL DEFAULT 0,
  `remains` int(11) NOT NULL DEFAULT 0,
  `orders_api` varchar(255) DEFAULT NULL,
  `service_api` varchar(255) DEFAULT NULL,
  `provider_id` varchar(255) DEFAULT NULL,
  `provider_name` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'default',
  `refill` tinyint(1) NOT NULL DEFAULT 0,
  `refill_status` enum('pending','rejected','in progress','completed') DEFAULT NULL,
  `cancel` tinyint(1) NOT NULL DEFAULT 0,
  `cancel_status` enum('pending','completed') DEFAULT NULL,
  `dripfeed` tinyint(1) NOT NULL DEFAULT 0,
  `ticket` varchar(255) DEFAULT NULL,
  `ticket_status` enum('processing','completed') DEFAULT NULL,
  `loop_quantity` int(11) DEFAULT NULL,
  `loop_spacing` int(11) DEFAULT NULL,
  `schedule_time` timestamp NULL DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `success_time` timestamp NULL DEFAULT NULL,
  `note` text DEFAULT NULL,
  `reaction` varchar(255) DEFAULT NULL,
  `status` enum('awaiting','pending','processing','in progress','completed','partial','canceled','failed') NOT NULL DEFAULT 'pending',
  `currency` varchar(255) NOT NULL DEFAULT 'USD',
  `order_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`order_data`)),
  `response_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`response_data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `domain` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `service_id`, `link`, `comment`, `quantity`, `rate`, `charge`, `total`, `start_count`, `remains`, `orders_api`, `service_api`, `provider_id`, `provider_name`, `type`, `refill`, `refill_status`, `cancel`, `cancel_status`, `dripfeed`, `ticket`, `ticket_status`, `loop_quantity`, `loop_spacing`, `schedule_time`, `start_time`, `success_time`, `note`, `reaction`, `status`, `currency`, `order_data`, `response_data`, `created_at`, `updated_at`, `domain`) VALUES
(247, 1, 3, 'https://www.facebook.com/profile.php?id=69618', NULL, 36547, 0.00600000, 0.95000000, 0.78000000, 890, 36547, NULL, NULL, '3', 'smmcoder.com', 'default', 0, NULL, 0, NULL, 0, 'refill', 'processing', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 'USD', NULL, NULL, '2026-04-17 04:04:02', '2026-05-08 09:06:16', 'localhost'),
(248, 1, 3, 'https://www.youtube.com/watch?v=44721', NULL, 22421, 0.05800000, 3.09000000, 0.40000000, 968, 0, NULL, NULL, '4', 'smmcoder.com', 'default', 0, NULL, 0, NULL, 0, 'speedup', 'processing', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'completed', 'USD', NULL, NULL, '2026-04-14 21:54:02', '2026-05-08 09:06:20', 'localhost'),
(249, 1, 3, 'https://www.youtube.com/watch?v=87352', NULL, 45266, 0.03100000, 1.78000000, 3.03000000, 488, 1138, NULL, NULL, '4', 'smmcoder.com', 'default', 0, NULL, 0, NULL, 0, 'request_cancel', 'processing', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'partial', 'USD', NULL, NULL, '2026-03-29 01:47:02', '2026-03-29 03:22:02', 'localhost'),
(250, 1, 3, 'https://www.instagram.com/p/25022', NULL, 29660, 0.05500000, 0.49000000, 3.79000000, 9006, 1395, NULL, NULL, '3', 'smmcoder.com', 'default', 0, NULL, 0, NULL, 0, 'request_cancel', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', NULL, NULL, '2026-04-12 18:57:02', '2026-04-12 19:22:02', 'localhost'),
(251, 1, 3, 'http://127.0.0.1:8000/cron/sync/services?provider=1', NULL, 100, 0.10500000, 0.01050000, 0.01050000, 0, 100, '2214155', '1138', '1', 'smmkay.com', 'normal', 1, NULL, 1, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'canceled', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\",\\\"vi\\\":\\\"vi\\\"},\\\"service_id\\\":3,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/cron\\/sync\\/services?provider=1\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":0.105,\\\"charge\\\":0.0105,\\\"total\\\":0.0105,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '{\"last_status_check\":\"2026-04-26 02:01:21\",\"status_response\":{\"charge\":0,\"start_count\":0,\"status\":\"Canceled\",\"remains\":100,\"note\":\"\"}}', '2026-04-25 18:44:57', '2026-04-25 19:01:21', '127.0.0.1'),
(252, 1, 3, 'http://127.0.0.1:8000/new', NULL, 100, 0.10500000, 0.01050000, 0.01050000, 0, 100, '2214547', '1138', '1', 'smmkay.com', 'normal', 1, 'completed', 1, 'completed', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in progress', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\",\\\"vi\\\":\\\"vi\\\"},\\\"service_id\\\":3,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/new\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":0.105,\\\"charge\\\":0.0105,\\\"total\\\":0.0105,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '{\"last_status_check\":\"2026-04-26 02:12:16\",\"status_response\":{\"charge\":0,\"start_count\":0,\"status\":\"Canceled\",\"remains\":100,\"note\":\"\"}}', '2026-04-25 19:06:34', '2026-04-25 19:12:16', '127.0.0.1'),
(253, 1, 3, 'http://127.0.0.1:8000/admin/accounts/smmkay/customrates', NULL, 100, 1.00000000, 0.10000000, 0.10000000, 0, 100, NULL, NULL, NULL, NULL, 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\",\\\"vi\\\":\\\"vi\\\"},\\\"service_id\\\":3,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/accounts\\/smmkay\\/customrates\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":1,\\\"charge\\\":0.1,\\\"total\\\":0.1,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', NULL, '2026-05-09 08:31:49', '2026-05-09 08:31:49', '127.0.0.1'),
(254, 1, 3, 'http://127.0.0.1:8000/admin/accounts/smmkay/customrates', NULL, 100, 1.00000000, 0.10000000, 0.10000000, 0, 100, NULL, NULL, NULL, NULL, 'normal', 1, NULL, 1, 'completed', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\",\\\"vi\\\":\\\"viaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa\\\"},\\\"service_id\\\":3,\\\"service_type\\\":\\\"Comments Custom\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/accounts\\/smmkay\\/customrates\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":1,\\\"charge\\\":0.1,\\\"total\\\":0.1,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', NULL, '2026-05-13 10:30:50', '2026-05-13 10:30:50', '127.0.0.1'),
(255, 1, 3, 'C:\\xampp\\htdocs\\resources\\views\\clients\\theme-4\\auth', NULL, 100, 1.00000000, 0.10000000, 0.10000000, 0, 100, NULL, NULL, NULL, NULL, 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\",\\\"vi\\\":\\\"viaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa\\\"},\\\"service_id\\\":3,\\\"service_type\\\":\\\"Comments Custom\\\",\\\"link\\\":\\\"C:\\\\\\\\xampp\\\\\\\\htdocs\\\\\\\\resources\\\\\\\\views\\\\\\\\clients\\\\\\\\theme-4\\\\\\\\auth\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":1,\\\"charge\\\":0.1,\\\"total\\\":0.1,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', NULL, '2026-05-15 06:08:23', '2026-05-15 06:08:23', '127.0.0.1'),
(256, 1, 4, 'https://www.tiktok.com/@duyhopham5', NULL, 100, 2.10000000, 0.21000000, 0.21000000, 0, 100, '2830603', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"https:\\/\\/www.tiktok.com\\/@duyhopham5\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.21000000000000002,\\\"total\\\":0.21000000000000002,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2830603}\"', '2026-05-25 05:29:18', '2026-05-25 05:29:18', '127.0.0.1'),
(257, 1, 4, 'https://smmkay.com/apidoc', NULL, 101, 2.10000000, 0.21210000, 0.21210000, 0, 101, '2830646', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"https:\\/\\/smmkay.com\\/apidoc\\\",\\\"quantity\\\":\\\"101\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.2121,\\\"total\\\":0.2121,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2830646}\"', '2026-05-25 05:31:24', '2026-05-25 05:31:24', '127.0.0.1'),
(258, 1, 4, 'https://chatgpt.com/c/6a13df1f-dffc-83ec-a39d-d629874eaee6', NULL, 100, 2.10000000, 0.21000000, 0.21000000, 0, 100, '2830916', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"https:\\/\\/chatgpt.com\\/c\\/6a13df1f-dffc-83ec-a39d-d629874eaee6\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.21000000000000002,\\\"total\\\":0.21000000000000002,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2830916}\"', '2026-05-25 05:44:06', '2026-05-25 08:01:03', '127.0.0.1'),
(259, 1, 4, 'http://127.0.0.1:8000/admin/orders?per_page=50', NULL, 101, 2.10000000, 0.21210000, 0.21210000, 0, 101, '2836035', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/orders?per_page=50\\\",\\\"quantity\\\":101,\\\"rate\\\":2.1,\\\"charge\\\":0.2121,\\\"total\\\":0.2121,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2836035}\"', '2026-05-25 09:49:19', '2026-05-25 09:49:19', '127.0.0.1'),
(260, 1, 4, 'http://127.0.0.1:8000/admin/orders?per_page=50', NULL, 101, 2.10000000, 0.21210000, 0.21210000, 0, 101, '2836175', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/orders?per_page=50\\\",\\\"quantity\\\":101,\\\"rate\\\":2.1,\\\"charge\\\":0.2121,\\\"total\\\":0.2121,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2836175}\"', '2026-05-25 09:55:40', '2026-05-25 09:55:40', '127.0.0.1'),
(261, 1, 4, 'http://127.0.0.1:8000/admin/orders?per_page=50', NULL, 101, 2.10000000, 0.21210000, 0.21210000, 0, 101, '2836209', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/orders?per_page=50\\\",\\\"quantity\\\":101,\\\"rate\\\":2.1,\\\"charge\\\":0.2121,\\\"total\\\":0.2121,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2836209}\"', '2026-05-25 09:57:24', '2026-05-25 09:57:24', '127.0.0.1'),
(262, 1, 4, 'http://127.0.0.1:8000/admin/orders?per_page=50', NULL, 101, 2.10000000, 0.21210000, 0.21210000, 0, 101, '2836352', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/orders?per_page=50\\\",\\\"quantity\\\":101,\\\"rate\\\":2.1,\\\"charge\\\":0.2121,\\\"total\\\":0.2121,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2836352}\"', '2026-05-25 10:02:28', '2026-05-25 10:02:28', '127.0.0.1'),
(263, 1, 4, 'http://127.0.0.1:8000/admin/orders', NULL, 100, 2.10000000, 0.21000000, 0.21000000, 0, 100, '2836363', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/orders\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.21000000000000002,\\\"total\\\":0.21000000000000002,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2836363}\"', '2026-05-25 10:03:01', '2026-05-25 10:03:01', '127.0.0.1'),
(264, 1, 4, 'https://127.0.0.1/api/v2', NULL, 100, 2.10000000, 0.21000000, 0.21000000, 0, 100, '2836385', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'processing', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"https:\\/\\/127.0.0.1\\/api\\/v2\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.21000000000000002,\\\"total\\\":0.21000000000000002,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2836385}\"', '2026-05-25 10:04:13', '2026-05-25 10:11:48', '127.0.0.1'),
(265, 1, 4, 'http://127.0.0.1:8000/new1', NULL, 100, 2.10000000, 0.21000000, 0.21000000, 0, 100, '2836554', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/new1\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.21000000000000002,\\\"total\\\":0.21000000000000002,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2836554}\"', '2026-05-25 10:12:23', '2026-05-25 10:12:23', '127.0.0.1'),
(266, 1, 3, 'http://127.0.0.1:8000/new1', NULL, 100, 1.26130000, 0.12613000, 0.12613000, 0, 100, '2837268', '1056', '2', 'smmkay.com', 'normal', 0, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"Twitter Likes | Mix Profiles | Day 10K \\u26a1 | No Warranty \\u26a0\\ufe0f\\\"},\\\"service_id\\\":3,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/new1\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":1.2613,\\\"charge\\\":0.12613000000000002,\\\"total\\\":0.12613000000000002,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2837268}\"', '2026-05-25 10:44:04', '2026-05-25 10:44:04', '127.0.0.1'),
(267, 1, 4, '793212189565550', NULL, 100, 2.10000000, 0.21000000, 0.21000000, 0, 100, '2837296', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'processing', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"793212189565550\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.21000000000000002,\\\"total\\\":0.21000000000000002,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2837296}\"', '2026-05-25 10:45:26', '2026-05-25 10:52:44', '127.0.0.1'),
(268, 1, 4, '793212189565550', NULL, 100, 2.10000000, 0.21000000, 0.21000000, 0, 100, '2837484', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"793212189565550\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.21000000000000002,\\\"total\\\":0.21000000000000002,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2837484}\"', '2026-05-25 10:53:24', '2026-05-25 10:53:24', '127.0.0.1'),
(269, 1, 4, '793212189565551', NULL, 100, 2.10000000, 0.21000000, 0.21000000, 0, 100, '2837486', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'processing', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"793212189565551\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.21000000000000002,\\\"total\\\":0.21000000000000002,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2837486}\"', '2026-05-25 10:53:26', '2026-05-25 10:59:19', '127.0.0.1'),
(270, 1, 4, '793212189565550', NULL, 100, 2.10000000, 0.21000000, 0.21000000, 0, 100, '2837614', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"793212189565550\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.21000000000000002,\\\"total\\\":0.21000000000000002,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2837614}\"', '2026-05-25 10:59:25', '2026-05-25 10:59:25', '127.0.0.1'),
(271, 1, 4, '793212189565551', NULL, 100, 2.10000000, 0.21000000, 0.21000000, 0, 100, '2837616', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"793212189565551\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.21000000000000002,\\\"total\\\":0.21000000000000002,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2837616}\"', '2026-05-25 10:59:26', '2026-05-25 10:59:26', '127.0.0.1'),
(272, 1, 4, '793212189565550', NULL, 100, 2.10000000, 0.21000000, 0.21000000, 0, 100, '2837771', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"793212189565550\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.21000000000000002,\\\"total\\\":0.21000000000000002,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2837771}\"', '2026-05-25 11:06:54', '2026-05-25 11:06:54', '127.0.0.1'),
(273, 1, 4, '793212189565551', NULL, 100, 2.10000000, 0.21000000, 0.21000000, 0, 100, '2837773', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'processing', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"793212189565551\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.21000000000000002,\\\"total\\\":0.21000000000000002,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2837773}\"', '2026-05-25 11:06:56', '2026-05-25 11:17:09', '127.0.0.1'),
(274, 1, 4, '793212189565550', NULL, 100, 2.10000000, 0.21000000, 0.21000000, 0, 100, '2837956', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"793212189565550\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.21000000000000002,\\\"total\\\":0.21000000000000002,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2837956}\"', '2026-05-25 11:17:13', '2026-05-25 11:17:13', '127.0.0.1'),
(275, 1, 4, '793212189565551', NULL, 100, 2.10000000, 0.21000000, 0.21000000, 0, 100, '2837958', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'processing', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"793212189565551\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.21000000000000002,\\\"total\\\":0.21000000000000002,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2837958}\"', '2026-05-25 11:17:15', '2026-05-25 11:30:42', '127.0.0.1'),
(276, 1, 4, '793212189565550', NULL, 100, 2.10000000, 0.21000000, 0.21000000, 0, 100, '2838274', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"793212189565550\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.21000000000000002,\\\"total\\\":0.21000000000000002,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2838274}\"', '2026-05-25 11:30:59', '2026-05-25 11:30:59', '127.0.0.1'),
(277, 1, 4, '793212189565551', NULL, 100, 2.10000000, 0.21000000, 0.21000000, 0, 100, '2838276', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"793212189565551\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.21000000000000002,\\\"total\\\":0.21000000000000002,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2838276}\"', '2026-05-25 11:31:02', '2026-05-25 11:31:02', '127.0.0.1'),
(278, 1, 4, '793212189565550', NULL, 100, 2.10000000, 0.21000000, 0.21000000, 0, 100, '2838284', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"793212189565550\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.21000000000000002,\\\"total\\\":0.21000000000000002,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2838284}\"', '2026-05-25 11:31:22', '2026-05-25 11:31:22', '127.0.0.1'),
(279, 1, 4, '793212189565550', NULL, 100, 2.10000000, 0.21000000, 0.21000000, 0, 100, '2838295', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"793212189565550\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.21000000000000002,\\\"total\\\":0.21000000000000002,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2838295}\"', '2026-05-25 11:31:39', '2026-05-25 11:31:39', '127.0.0.1'),
(280, 1, 4, 'http://127.0.0.1:8000/admin/orders', NULL, 100, 2.10000000, 0.21000000, 0.21000000, 0, 100, '2848454', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/orders\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.21000000000000002,\\\"total\\\":0.21000000000000002,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2848454}\"', '2026-05-25 19:44:40', '2026-05-25 19:44:40', '127.0.0.1'),
(281, 1, 4, 'http://127.0.0.1:8000/admin/settings/service', NULL, 100, 2.10000000, 0.21000000, 0.21000000, 0, 100, '2848527', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'processing', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/settings\\/service\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.21000000000000002,\\\"total\\\":0.21000000000000002,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2848527}\"', '2026-05-25 19:48:35', '2026-05-25 19:51:11', '127.0.0.1'),
(282, 1, 4, 'http://127.0.0.1:8000/admin/settings/service', NULL, 100, 2.10000000, 0.21000000, 0.21000000, 0, 100, '2848581', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/settings\\/service\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.21000000000000002,\\\"total\\\":0.21000000000000002,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2848581}\"', '2026-05-25 19:51:25', '2026-05-25 19:51:25', '127.0.0.1'),
(283, 1, 4, 'http://127.0.0.1:8000/admin/settings/service', NULL, 100, 2.10000000, 0.21000000, 0.21000000, 0, 100, '2848596', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'processing', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/settings\\/service\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.21000000000000002,\\\"total\\\":0.21000000000000002,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2848596}\"', '2026-05-25 19:52:06', '2026-05-25 19:59:45', '127.0.0.1'),
(284, 1, 4, 'http://127.0.0.1:8000/admin/orders', NULL, 101, 2.10000000, 0.21210000, 0.21210000, 0, 101, '2848740', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/orders\\\",\\\"quantity\\\":\\\"101\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.2121,\\\"total\\\":0.2121,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2848740}\"', '2026-05-25 19:59:51', '2026-05-25 19:59:51', '127.0.0.1'),
(285, 1, 4, 'http://127.0.0.1:8000/admin/orders', NULL, 102, 2.10000000, 0.21420000, 0.21420000, 0, 102, '2848773', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/orders\\\",\\\"quantity\\\":\\\"102\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.2142,\\\"total\\\":0.2142,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2848773}\"', '2026-05-25 20:01:35', '2026-05-25 20:01:35', '127.0.0.1'),
(286, 1, 4, 'http://127.0.0.1:8000/admin/orders', NULL, 100, 2.10000000, 0.21000000, 0.21000000, 0, 100, '2848778', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/orders\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.21000000000000002,\\\"total\\\":0.21000000000000002,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2848778}\"', '2026-05-25 20:01:48', '2026-05-25 20:01:48', '127.0.0.1'),
(287, 1, 4, 'http://127.0.0.1:8000/admin/orders', NULL, 100, 2.10000000, 0.21000000, 0.21000000, 0, 100, '2848791', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/orders\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.21000000000000002,\\\"total\\\":0.21000000000000002,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2848791}\"', '2026-05-25 20:02:28', '2026-05-25 20:02:28', '127.0.0.1'),
(288, 1, 4, 'http://127.0.0.1:8000/admin/orders', NULL, 100, 2.10000000, 0.21000000, 0.21000000, 0, 100, '2848800', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'processing', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/orders\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.21000000000000002,\\\"total\\\":0.21000000000000002,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2848800}\"', '2026-05-25 20:02:55', '2026-05-25 20:10:47', '127.0.0.1'),
(289, 1, 4, 'http://127.0.0.1:8000/admin/orders', NULL, 100, 2.10000000, 0.21000000, 0.21000000, 0, 100, '2848949', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/orders\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.21000000000000002,\\\"total\\\":0.21000000000000002,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2848949}\"', '2026-05-25 20:10:58', '2026-05-25 20:10:58', '127.0.0.1'),
(290, 1, 4, 'http://127.0.0.1:8000/admin/orders', NULL, 100, 2.10000000, 0.21000000, 0.21000000, 0, 100, '2848957', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/orders\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.21000000000000002,\\\"total\\\":0.21000000000000002,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2848957}\"', '2026-05-25 20:11:20', '2026-05-25 20:11:20', '127.0.0.1'),
(291, 1, 4, 'http://127.0.0.1:8000/admin/orders', NULL, 102, 2.10000000, 0.21420000, 0.21420000, 0, 102, '2849038', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'processing', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/orders\\\",\\\"quantity\\\":\\\"102\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.2142,\\\"total\\\":0.2142,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2849038}\"', '2026-05-25 20:15:14', '2026-05-25 20:15:27', '127.0.0.1'),
(292, 1, 4, 'http://127.0.0.1:8000/admin/orders', NULL, 103, 2.10000000, 0.21630000, 0.21630000, 0, 103, '2849044', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/orders\\\",\\\"quantity\\\":\\\"103\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.2163,\\\"total\\\":0.2163,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2849044}\"', '2026-05-25 20:15:30', '2026-05-25 20:15:30', '127.0.0.1'),
(293, 1, 4, 'http://127.0.0.1:8000/admin/orders1', NULL, 103, 2.10000000, 0.21630000, 0.21630000, 0, 103, '2849046', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/orders1\\\",\\\"quantity\\\":\\\"103\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.2163,\\\"total\\\":0.2163,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2849046}\"', '2026-05-25 20:15:32', '2026-05-25 20:15:32', '127.0.0.1'),
(294, 1, 4, 'http://127.0.0.1:8000/admin/orders', NULL, 103, 2.10000000, 0.21630000, 0.21630000, 0, 103, '2849079', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/orders\\\",\\\"quantity\\\":\\\"103\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.2163,\\\"total\\\":0.2163,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2849079}\"', '2026-05-25 20:17:18', '2026-05-25 20:17:18', '127.0.0.1'),
(295, 1, 4, 'http://127.0.0.1:8000/admin/orders1', NULL, 103, 2.10000000, 0.21630000, 0.21630000, 0, 103, '2849081', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/orders1\\\",\\\"quantity\\\":\\\"103\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.2163,\\\"total\\\":0.2163,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2849081}\"', '2026-05-25 20:17:19', '2026-05-25 20:17:19', '127.0.0.1'),
(296, 1, 4, 'http://127.0.0.1:8000/admin/orders1', NULL, 103, 2.10000000, 0.21630000, 0.21630000, 0, 103, '2849082', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'processing', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/orders1\\\",\\\"quantity\\\":\\\"103\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.2163,\\\"total\\\":0.2163,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2849082}\"', '2026-05-25 20:17:21', '2026-05-25 20:38:47', '127.0.0.1'),
(297, 1, 4, 'http://127.0.0.1:8000/admin/orders', NULL, 100, 2.10000000, 0.21000000, 0.21000000, 0, 100, '2849518', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/orders\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.21000000000000002,\\\"total\\\":0.21000000000000002,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2849518}\"', '2026-05-25 20:39:04', '2026-05-25 20:39:05', '127.0.0.1'),
(298, 1, 4, 'http://127.0.0.1:8000/admin/orders1', NULL, 100, 2.10000000, 0.21000000, 0.21000000, 0, 100, '2849519', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/orders1\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.21000000000000002,\\\"total\\\":0.21000000000000002,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2849519}\"', '2026-05-25 20:39:06', '2026-05-25 20:39:07', '127.0.0.1'),
(299, 1, 4, 'http://127.0.0.1:8000/admin/orders1', NULL, 100, 2.10000000, 0.21000000, 0.21000000, 0, 0, '2849521', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'completed', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/orders1\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.21000000000000002,\\\"total\\\":0.21000000000000002,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2849521}\"', '2026-05-25 20:39:08', '2026-05-25 21:07:23', '127.0.0.1'),
(300, 1, 4, 'http://127.0.0.1:8000/admin/orders', NULL, 100, 2.10000000, 0.21000000, 0.21000000, 0, 100, '2850094', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/orders\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.21000000000000002,\\\"total\\\":0.21000000000000002,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2850094}\"', '2026-05-25 21:07:28', '2026-05-25 21:07:54', '127.0.0.1'),
(301, 1, 4, 'http://127.0.0.1:8000/admin/orders1', NULL, 100, 2.10000000, 0.21000000, 0.21000000, 0, 100, '2850095', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/orders1\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.21000000000000002,\\\"total\\\":0.21000000000000002,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2850095}\"', '2026-05-25 21:07:28', '2026-05-25 21:07:55', '127.0.0.1'),
(302, 1, 4, 'http://127.0.0.1:8000/admin/orders1', NULL, 100, 2.10000000, 0.21000000, 0.21000000, 0, 100, '2850096', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/orders1\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.21000000000000002,\\\"total\\\":0.21000000000000002,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2850096}\"', '2026-05-25 21:07:29', '2026-05-25 21:08:05', '127.0.0.1'),
(303, 1, 4, 'http://127.0.0.1:8000/admin/orders', NULL, 111, 2.10000000, 0.23310000, 0.23310000, 0, 111, '2850140', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/orders\\\",\\\"quantity\\\":\\\"111\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.2331,\\\"total\\\":0.2331,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2850140}\"', '2026-05-25 21:09:28', '2026-05-25 21:09:59', '127.0.0.1'),
(304, 1, 4, 'http://127.0.0.1:8000/admin/orders1', NULL, 111, 2.10000000, 0.23310000, 0.23310000, 0, 111, '2850142', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/orders1\\\",\\\"quantity\\\":\\\"111\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.2331,\\\"total\\\":0.2331,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2850142}\"', '2026-05-25 21:09:28', '2026-05-25 21:10:00', '127.0.0.1'),
(305, 1, 4, 'http://127.0.0.1:8000/admin/orders1', NULL, 111, 2.10000000, 0.23310000, 0.23310000, 0, 111, '2850143', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/orders1\\\",\\\"quantity\\\":\\\"111\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.2331,\\\"total\\\":0.2331,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2850143}\"', '2026-05-25 21:09:28', '2026-05-25 21:10:02', '127.0.0.1'),
(306, 1, 4, 'http://127.0.0.1:8000/admin/orders', NULL, 112, 2.10000000, 0.23520000, 0.23520000, 0, 112, '2852665', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"order\\\":2852665}\"', '\"{\\\"order\\\":2852665}\"', '2026-05-25 21:10:08', '2026-05-25 23:18:57', '127.0.0.1'),
(307, 1, 4, 'http://127.0.0.1:8000/admin/orders1', NULL, 112, 2.10000000, 0.23520000, 0.23520000, 0, 112, '2850193', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"order\\\":2850193}\"', '\"{\\\"order\\\":2850193}\"', '2026-05-25 21:10:09', '2026-05-25 21:12:03', '127.0.0.1'),
(308, 1, 4, 'http://127.0.0.1:8000/admin/orders1', NULL, 112, 2.10000000, 0.23520000, 0.23520000, 0, 112, '2852444', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"order\\\":2852444}\"', '\"{\\\"order\\\":2852444}\"', '2026-05-25 21:10:09', '2026-05-25 23:07:51', '127.0.0.1');
INSERT INTO `orders` (`id`, `user_id`, `service_id`, `link`, `comment`, `quantity`, `rate`, `charge`, `total`, `start_count`, `remains`, `orders_api`, `service_api`, `provider_id`, `provider_name`, `type`, `refill`, `refill_status`, `cancel`, `cancel_status`, `dripfeed`, `ticket`, `ticket_status`, `loop_quantity`, `loop_spacing`, `schedule_time`, `start_time`, `success_time`, `note`, `reaction`, `status`, `currency`, `order_data`, `response_data`, `created_at`, `updated_at`, `domain`) VALUES
(309, 1, 4, 'http://127.0.0.1:8000/admin/orders', NULL, 100, 2.10000000, 0.21000000, 0.21000000, 0, 100, '2850520', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/orders\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.21000000000000002,\\\"total\\\":0.21000000000000002,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2850520}\"', '2026-05-25 21:28:23', '2026-05-25 21:28:34', '127.0.0.1'),
(310, 1, 4, 'http://127.0.0.1:8000/admin/orders1', NULL, 100, 2.10000000, 0.21000000, 0.21000000, 0, 100, '2850521', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/orders1\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.21000000000000002,\\\"total\\\":0.21000000000000002,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2850521}\"', '2026-05-25 21:28:23', '2026-05-25 21:28:35', '127.0.0.1'),
(311, 1, 4, 'http://127.0.0.1:8000/admin/orders1', NULL, 100, 2.10000000, 0.21000000, 0.21000000, 0, 100, '2850522', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/orders1\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.21000000000000002,\\\"total\\\":0.21000000000000002,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', '\"{\\\"order\\\":2850522}\"', '2026-05-25 21:28:24', '2026-05-25 21:28:37', '127.0.0.1'),
(312, 1, 4, 'http://127.0.0.1:8000/admin/orders', NULL, 107, 2.10000000, 0.22470000, 0.22470000, 0, 107, NULL, '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'canceled', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/orders\\\",\\\"quantity\\\":\\\"107\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.2247,\\\"total\\\":0.2247,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\",\\\"api_error\\\":\\\"This service is inactive\\\",\\\"error_status\\\":\\\"canceled\\\",\\\"api_response\\\":{\\\"error\\\":\\\"This service is inactive\\\"},\\\"canceled_at\\\":\\\"2026-05-26T04:29:29+07:00\\\",\\\"refund\\\":0.2247}\"', '\"{\\\"error\\\":\\\"This service is inactive\\\"}\"', '2026-05-25 21:29:12', '2026-05-25 21:29:29', '127.0.0.1'),
(313, 1, 4, 'http://127.0.0.1:8000/admin/orders1', NULL, 107, 2.10000000, 0.22470000, 0.22470000, 0, 107, NULL, '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'canceled', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\\\"},\\\"service_id\\\":4,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/orders1\\\",\\\"quantity\\\":\\\"107\\\",\\\"rate\\\":2.1,\\\"charge\\\":0.2247,\\\"total\\\":0.2247,\\\"refill\\\":true,\\\"cancel\\\":true,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\",\\\"api_error\\\":\\\"This service is inactive\\\",\\\"error_status\\\":\\\"canceled\\\",\\\"api_response\\\":{\\\"error\\\":\\\"This service is inactive\\\"},\\\"canceled_at\\\":\\\"2026-05-26T04:29:30+07:00\\\",\\\"refund\\\":0.2247}\"', '\"{\\\"error\\\":\\\"This service is inactive\\\"}\"', '2026-05-25 21:29:12', '2026-05-25 21:29:30', '127.0.0.1'),
(314, 1, 4, 'http://127.0.0.1:8000/admin/orders1', NULL, 107, 2.10000000, 0.22470000, 0.22470000, 0, 107, '2852751', '1138', '2', 'smmkay.com', 'normal', 1, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"order\\\":2852751}\"', '\"{\\\"order\\\":2852751}\"', '2026-05-25 21:29:13', '2026-05-25 23:23:14', '127.0.0.1'),
(315, 1, 3, 'http://127.0.0.1:8000/new', NULL, 100, 1.26130000, 0.12613000, 0.12613000, 0, 100, NULL, NULL, NULL, NULL, 'normal', 0, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"Twitter Likes | Mix Profiles | Day 10K \\u26a1 | No Warranty \\u26a0\\ufe0f\\\"},\\\"service_id\\\":3,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/new\\\",\\\"quantity\\\":\\\"100\\\",\\\"rate\\\":1.2613,\\\"charge\\\":0.12613000000000002,\\\"total\\\":0.12613000000000002,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', NULL, '2026-05-26 07:09:36', '2026-05-26 07:09:36', '127.0.0.1'),
(316, 1, 3, 'http://127.0.0.1:8000/new', NULL, 110, 1.26130000, 0.13874300, 0.13874300, 0, 110, NULL, NULL, NULL, NULL, 'normal', 0, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"Twitter Likes | Mix Profiles | Day 10K \\u26a1 | No Warranty \\u26a0\\ufe0f\\\"},\\\"service_id\\\":3,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/new\\\",\\\"quantity\\\":\\\"110\\\",\\\"rate\\\":1.2613,\\\"charge\\\":0.138743,\\\"total\\\":0.138743,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', NULL, '2026-05-26 07:11:49', '2026-05-26 07:11:49', '127.0.0.1'),
(317, 1, 3, 'http://127.0.0.1:8000/new', NULL, 111, 1.26130000, 0.14000430, 0.14000430, 0, 111, NULL, NULL, NULL, NULL, 'normal', 0, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"Twitter Likes | Mix Profiles | Day 10K \\u26a1 | No Warranty \\u26a0\\ufe0f\\\"},\\\"service_id\\\":3,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/new\\\",\\\"quantity\\\":\\\"111\\\",\\\"rate\\\":1.2613,\\\"charge\\\":0.1400043,\\\"total\\\":0.1400043,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', NULL, '2026-05-26 07:12:10', '2026-05-26 07:12:10', '127.0.0.1'),
(318, 1, 3, 'http://127.0.0.1:8000/new', NULL, 111, 1.26130000, 0.14000430, 0.14000430, 0, 111, NULL, NULL, NULL, NULL, 'normal', 0, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in progress', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"Twitter Likes | Mix Profiles | Day 10K \\u26a1 | No Warranty \\u26a0\\ufe0f\\\"},\\\"service_id\\\":3,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/new\\\",\\\"quantity\\\":\\\"111\\\",\\\"rate\\\":1.2613,\\\"charge\\\":0.1400043,\\\"total\\\":0.1400043,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', NULL, '2026-05-26 07:23:16', '2026-05-27 09:08:53', '127.0.0.1'),
(319, 1, 3, 'http://127.0.0.1:8000/admin/settings/modules', NULL, 111, 1.26130000, 0.14000430, 0.14000430, 0, 111, NULL, NULL, NULL, NULL, 'normal', 0, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in progress', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"Twitter Likes | Mix Profiles | Day 10K \\u26a1 | No Warranty \\u26a0\\ufe0f\\\"},\\\"service_id\\\":3,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/settings\\/modules\\\",\\\"quantity\\\":\\\"111\\\",\\\"rate\\\":1.2613,\\\"charge\\\":0.1400043,\\\"total\\\":0.1400043,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', NULL, '2026-05-26 07:25:33', '2026-05-27 09:04:45', '127.0.0.1'),
(320, 1, 3, 'http://127.0.0.1:8000/admin/settings/modules', NULL, 111, 1.26130000, 0.14000430, 0.14000430, 0, 111, NULL, NULL, NULL, NULL, 'normal', 0, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in progress', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"Twitter Likes | Mix Profiles | Day 10K \\u26a1 | No Warranty \\u26a0\\ufe0f\\\"},\\\"service_id\\\":3,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/settings\\/modules\\\",\\\"quantity\\\":\\\"111\\\",\\\"rate\\\":1.2613,\\\"charge\\\":0.1400043,\\\"total\\\":0.1400043,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', NULL, '2026-05-26 07:26:08', '2026-05-27 09:04:31', '127.0.0.1'),
(321, 1, 3, 'http://127.0.0.1:8000/admin/settings/modules', NULL, 111, 1.26130000, 0.14000430, 0.14000430, 0, 111, NULL, NULL, NULL, NULL, 'normal', 0, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in progress', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"Twitter Likes | Mix Profiles | Day 10K \\u26a1 | No Warranty \\u26a0\\ufe0f\\\"},\\\"service_id\\\":3,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/settings\\/modules\\\",\\\"quantity\\\":\\\"111\\\",\\\"rate\\\":1.2613,\\\"charge\\\":0.1400043,\\\"total\\\":0.1400043,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', NULL, '2026-05-26 07:26:32', '2026-05-27 08:03:17', '127.0.0.1'),
(322, 1, 3, 'http://127.0.0.1:8000/admin/settings/modules', NULL, 111, 1.26130000, 0.14000430, 0.14000430, 0, 111, NULL, NULL, NULL, NULL, 'normal', 0, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in progress', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"Twitter Likes | Mix Profiles | Day 10K \\u26a1 | No Warranty \\u26a0\\ufe0f\\\"},\\\"service_id\\\":3,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/settings\\/modules\\\",\\\"quantity\\\":\\\"111\\\",\\\"rate\\\":1.2613,\\\"charge\\\":0.1400043,\\\"total\\\":0.1400043,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', NULL, '2026-05-26 07:26:53', '2026-05-26 18:37:25', '127.0.0.1'),
(323, 1, 3, 'http://127.0.0.1:8000/admin/settings/modules', NULL, 123, 1.26130000, 0.15513990, 0.15513990, 0, 123, NULL, NULL, NULL, NULL, 'normal', 0, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in progress', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"Twitter Likes | Mix Profiles | Day 10K \\u26a1 | No Warranty \\u26a0\\ufe0f\\\"},\\\"service_id\\\":3,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/settings\\/modules\\\",\\\"quantity\\\":\\\"123\\\",\\\"rate\\\":1.2613,\\\"charge\\\":0.1551399,\\\"total\\\":0.1551399,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', NULL, '2026-05-26 07:27:02', '2026-05-26 18:59:21', '127.0.0.1'),
(324, 1, 3, 'http://127.0.0.1:8000/admin/settings/modules', NULL, 111, 1.26130000, 0.14000430, 0.14000430, 0, 0, NULL, NULL, NULL, NULL, 'normal', 0, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'completed', 'USD', '\"{\\\"service_name\\\":{\\\"en\\\":\\\"Twitter Likes | Mix Profiles | Day 10K \\u26a1 | No Warranty \\u26a0\\ufe0f\\\"},\\\"service_id\\\":3,\\\"service_type\\\":\\\"Default\\\",\\\"link\\\":\\\"http:\\/\\/127.0.0.1:8000\\/admin\\/settings\\/modules\\\",\\\"quantity\\\":\\\"111\\\",\\\"rate\\\":1.2613,\\\"charge\\\":0.1400043,\\\"total\\\":0.1400043,\\\"type\\\":\\\"normal\\\",\\\"currency\\\":\\\"USD\\\"}\"', NULL, '2026-05-26 07:27:41', '2026-05-26 18:48:39', '127.0.0.1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `bonus_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(15,2) NOT NULL,
  `currency` varchar(10) NOT NULL DEFAULT 'USD',
  `exchange_rate` decimal(15,4) NOT NULL DEFAULT 1.0000,
  `status` enum('pending','processing','completed','failed','cancelled') NOT NULL DEFAULT 'pending',
  `note` text DEFAULT NULL,
  `payment_info` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payment_info`)),
  `domain` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `payment_method_id`, `transaction_id`, `amount`, `bonus_amount`, `total_amount`, `currency`, `exchange_rate`, `status`, `note`, `payment_info`, `domain`, `created_at`, `updated_at`) VALUES
(61, 1, 8, '12466', 10000.00, 1000.00, 11000.00, 'VND', 26256.0000, 'completed', NULL, '{\"bonus_percent\":10,\"webhook\":true}', '127.0.0.1', '2026-05-28 14:01:14', '2026-05-28 14:01:14'),
(62, 1, 10, 'FT26148136039625', 10000.00, 0.00, 10000.00, 'VND', 26256.0000, 'completed', NULL, '{\"bonus_percent\":0,\"webhook\":true}', '127.0.0.1', '2026-05-28 14:16:25', '2026-05-28 14:16:25');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `method_payment_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'other',
  `image` varchar(255) DEFAULT NULL,
  `currency` varchar(10) NOT NULL DEFAULT 'USD',
  `min` decimal(15,2) NOT NULL DEFAULT 0.00,
  `max` decimal(15,2) NOT NULL DEFAULT 0.00,
  `max_transactions` int(11) NOT NULL DEFAULT 0,
  `max_total_funds` decimal(15,2) NOT NULL DEFAULT 0.00,
  `bonus` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`bonus`)),
  `details` varchar(255) DEFAULT NULL,
  `config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`config`)),
  `position` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `domain` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `method_payment_id`, `name`, `type`, `image`, `currency`, `min`, `max`, `max_transactions`, `max_total_funds`, `bonus`, `details`, `config`, `position`, `status`, `domain`, `created_at`, `updated_at`) VALUES
(8, 1, 'acb', 'bank_vn', 'aaaaa', 'USD', 0.00, 0.00, 0, 0.00, '[{\"min\":0.7,\"percent\":10}]', NULL, '{\"account\":\"18145511\",\"name\":\"PHAM QUOC DUY\",\"signature\":\"fc0b6e97ba250e17bc6f40865014840e\",\"rate\":\"27000\"}', 1, 1, '127.0.0.1', '2026-05-22 16:13:57', '2026-05-28 18:07:12'),
(9, 20, 'binance', 'binance', 'aa', 'USD', 0.00, 0.00, 0, 0.00, '[{\"min\":1,\"percent\":10}]', NULL, '{\"binance_id\":\"866091474\",\"key\":\"UIEunypFvxah7GcpECdhxNqHOxWWGDnN555WQy2u5uSiyiYdRXCK6HO28II0jxh5\",\"secret\":\"OSNcHyt0DInxMWVyQjOQZ5g0neKmgoHV0wt0F0LpjcsDPFanC5A6xZUD3yYyJQ0H\",\"qr_image\":\"aaa\"}', 2, 1, '127.0.0.1', '2026-05-23 03:08:23', '2026-05-23 06:26:57'),
(10, 3, 'MBBANK', 'bank_vn', 'https://i.imgur.com/zVEduxd.png', 'USD', 0.00, 0.00, 0, 0.00, '[]', NULL, '{\"account\":\"1399999909\",\"name\":\"PHAM QUOC DUY\",\"signature\":\"xxxxxxxx\",\"rate\":\"27000\"}', 3, 1, '127.0.0.1', '2026-05-28 09:29:31', '2026-05-28 09:29:31');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payment_method_groups`
--

CREATE TABLE `payment_method_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `methods` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`methods`)),
  `position` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `domain` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `platforms`
--

CREATE TABLE `platforms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `domain` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `platforms`
--

INSERT INTO `platforms` (`id`, `name`, `image`, `position`, `status`, `created_at`, `updated_at`, `domain`) VALUES
(1, 'Facebook 1', 'fa-brands fa-facebook', 1, 1, '2026-04-15 15:53:51', '2026-04-15 15:54:30', '127.0.0.1'),
(2, '12312', 'fa-brands fa-facebook', 2, 1, '2026-04-15 17:19:48', '2026-04-15 17:19:48', '127.0.0.1'),
(3, '3211332', 'fa-brands fa-facebook', 3, 1, '2026-04-15 17:21:43', '2026-04-15 17:21:43', '127.0.0.1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `domain` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `warranty_policy` text DEFAULT NULL,
  `product_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_group_id` bigint(20) UNSIGNED DEFAULT NULL,
  `group_tag` varchar(255) DEFAULT NULL,
  `type` enum('Manual','Api') NOT NULL DEFAULT 'Manual',
  `api_provider_id` bigint(20) UNSIGNED DEFAULT NULL,
  `api_service_id` varchar(255) DEFAULT NULL,
  `process_type` varchar(255) DEFAULT NULL,
  `cost_price` decimal(20,10) NOT NULL DEFAULT 0.0000000000,
  `price` decimal(20,10) NOT NULL DEFAULT 0.0000000000,
  `price_1` decimal(20,10) NOT NULL DEFAULT 0.0000000000,
  `price_2` decimal(20,10) NOT NULL DEFAULT 0.0000000000,
  `price_percent` decimal(8,2) NOT NULL DEFAULT 110.00,
  `price_1_percent` decimal(8,2) NOT NULL DEFAULT 108.00,
  `price_2_percent` decimal(8,2) NOT NULL DEFAULT 105.00,
  `min` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `max` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `sync` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('In stock','Out of stock','Inactive') NOT NULL DEFAULT 'In stock',
  `position` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `domain`, `name`, `slug`, `thumbnail`, `description`, `warranty_policy`, `product_category_id`, `product_group_id`, `group_tag`, `type`, `api_provider_id`, `api_service_id`, `process_type`, `cost_price`, `price`, `price_1`, `price_2`, `price_percent`, `price_1_percent`, `price_2_percent`, `min`, `max`, `sync`, `status`, `position`, `created_at`, `updated_at`) VALUES
(1, '127.0.0.1', 'Nhóm Zalo 500 - 1000 thành viên thật', 'nhom-zalo-500-1000-thanh-vien-that', 'https://cdn.pixabay.com/photo/2021/01/05/06/40/icon-5889010_640.png', '<p>Nhóm Zalo thật, thành viên Việt Nam, giao hàng trong 24h.</p>', '<p>Bảo hành 7 ngày nếu nhóm bị xóa hoặc không đủ thành viên.</p>', 1, 1, '500-1000', 'Manual', NULL, NULL, 'Manual', 3.0000000000, 5.0000000000, 4.8000000000, 4.5000000000, 110.00, 108.00, 105.00, 1, 100, 0, 'In stock', 1, '2026-04-21 08:21:29', '2026-04-21 08:21:29'),
(2, '127.0.0.1', 'Nhóm Zalo 1000 - 1500 thành viên thật', 'nhom-zalo-1000-1500-thanh-vien-that', 'https://cdn.pixabay.com/photo/2021/01/05/06/40/icon-5889010_640.png', '<p>Nhóm Zalo thật, thành viên Việt Nam, giao hàng trong 24h.</p>', '<p>Bảo hành 7 ngày nếu nhóm bị xóa hoặc không đủ thành viên.</p>', 1, 1, '1000-1500', 'Manual', NULL, NULL, 'Manual', 5.0000000000, 8.0000000000, 7.7000000000, 7.2000000000, 110.00, 108.00, 105.00, 1, 50, 0, 'In stock', 2, '2026-04-21 08:21:29', '2026-04-21 08:21:29'),
(3, '127.0.0.1', 'Nhóm Zalo 1700 - 2000 thành viên thật', 'nhom-zalo-1700-2000-thanh-vien-that', 'https://cdn.pixabay.com/photo/2021/01/05/06/40/icon-5889010_640.png', '<p>Nhóm Zalo thật, thành viên Việt Nam, giao hàng trong 24h.</p>', '<p>Bảo hành 7 ngày nếu nhóm bị xóa hoặc không đủ thành viên.</p>', 1, 1, '1700-2000', 'Manual', NULL, NULL, 'Manual', 8.0000000000, 12.0000000000, 11.5000000000, 11.0000000000, 110.00, 108.00, 105.00, 1, 20, 0, 'In stock', 3, '2026-04-21 08:21:29', '2026-04-21 08:21:29'),
(4, '127.0.0.1', 'Tài khoản Facebook cá nhân Việt Nam', 'tai-khoan-facebook-ca-nhan-viet-nam', 'https://cdn.pixabay.com/photo/2021/06/15/12/28/facebook-6338507_640.png', '<p>Tài khoản Facebook Việt Nam, đã xác minh số điện thoại.</p>', '<p>Bảo hành 3 ngày nếu tài khoản bị khóa do lỗi từ phía chúng tôi.</p>', 2, 2, 'Cá nhân', 'Manual', NULL, NULL, 'Manual', 2.0000000000, 3.5000000000, 3.3000000000, 3.1000000000, 110.00, 108.00, 105.00, 1, 500, 0, 'In stock', 1, '2026-04-21 08:21:29', '2026-04-21 08:21:29'),
(5, '127.0.0.1', 'Tài khoản Facebook Business', 'tai-khoan-facebook-business', 'https://cdn.pixabay.com/photo/2021/06/15/12/28/facebook-6338507_640.png', '<p>Tài khoản Facebook Business đã xác minh, sẵn sàng chạy quảng cáo.</p>', '<p>Bảo hành 3 ngày nếu tài khoản bị khóa do lỗi từ phía chúng tôi.</p>', 2, 2, 'Business', 'Manual', NULL, NULL, 'Manual', 10.0000000000, 15.0000000000, 14.5000000000, 14.0000000000, 110.00, 108.00, 105.00, 1, 100, 0, 'In stock', 2, '2026-04-21 08:21:29', '2026-04-21 08:21:29'),
(6, '127.0.0.1', 'Canva Premium 1 tháng', 'canva-premium-1-thang', 'https://cdn.pixabay.com/photo/2022/01/30/17/54/canva-6981481_640.png', '<p>Tài khoản Canva Pro, dùng riêng, đầy đủ tính năng premium.</p>', '<p>Bảo hành đủ 30 ngày, đổi mới nếu hết hạn sớm.</p>', 3, 3, '1 tháng', 'Manual', NULL, NULL, 'Manual', 1.5000000000, 2.5000000000, 2.3000000000, 2.1000000000, 110.00, 108.00, 105.00, 1, 999, 0, 'In stock', 1, '2026-04-21 08:21:29', '2026-04-21 08:21:29'),
(7, '127.0.0.1', 'Netflix Premium 1 tháng', 'netflix-premium-1-thang', 'https://cdn.pixabay.com/photo/2019/11/05/15/44/netflix-4603951_640.png', '<p>Tài khoản Netflix Premium 4K, dùng riêng, không chia sẻ.</p>', '<p>Bảo hành đủ 30 ngày, đổi mới nếu hết hạn sớm.</p>', 3, 3, '1 tháng', 'Manual', NULL, NULL, 'Manual', 2.5000000000, 4.0000000000, 3.8000000000, 3.5000000000, 110.00, 108.00, 105.00, 1, 999, 0, 'In stock', 2, '2026-04-21 08:21:29', '2026-04-21 08:21:29');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_categories`
--

CREATE TABLE `product_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `domain` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `position` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_categories`
--

INSERT INTO `product_categories` (`id`, `name`, `domain`, `status`, `position`, `created_at`, `updated_at`) VALUES
(1, 'Zalo', '127.0.0.1', 1, 1, '2026-04-20 14:22:22', '2026-04-20 14:22:22'),
(2, 'Facebook', '127.0.0.1', 1, 2, '2026-04-20 14:22:22', '2026-04-20 14:22:22'),
(3, 'Account', '127.0.0.1', 1, 3, '2026-04-20 14:22:22', '2026-04-20 14:22:22');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_goods`
--

CREATE TABLE `product_goods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `warehouse_id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `used` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_groups`
--

CREATE TABLE `product_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `domain` varchar(255) NOT NULL,
  `position` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_groups`
--

INSERT INTO `product_groups` (`id`, `name`, `domain`, `position`, `created_at`, `updated_at`) VALUES
(1, 'Nhóm Zalo', '127.0.0.1', 1, '2026-04-20 14:22:22', '2026-04-20 14:22:22'),
(2, 'Tài khoản Facebook', '127.0.0.1', 2, '2026-04-20 14:22:22', '2026-04-20 14:22:22'),
(3, 'Tài khoản Premium', '127.0.0.1', 3, '2026-04-20 14:22:22', '2026-04-20 14:22:22');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_orders`
--

CREATE TABLE `product_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `domain` varchar(255) DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `provider_product_order_id` varchar(255) DEFAULT NULL,
  `status` enum('Awaiting','Manual','Pending','In progress','Completed','Canceled','Failed','Partial') NOT NULL DEFAULT 'Awaiting',
  `amount` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `charge` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `refill` tinyint(1) NOT NULL DEFAULT 0,
  `refill_status` enum('Pending','In progress','Completed','Rejected') DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_orders`
--

INSERT INTO `product_orders` (`id`, `user_id`, `domain`, `product_id`, `provider_product_order_id`, `status`, `amount`, `charge`, `quantity`, `refill`, `refill_status`, `note`, `created_at`, `updated_at`) VALUES
(3, 1, '127.0.0.1', 4, NULL, 'Canceled', 3.5000, 3.5000, 1, 0, NULL, '1', '2026-04-21 16:32:06', '2026-05-27 10:14:18'),
(4, 1, 'localhost', 1, NULL, 'Canceled', 30.3800, 33.4180, 7, 1, 'Pending', NULL, '2026-04-14 19:39:42', '2026-04-14 19:44:42'),
(5, 1, 'localhost', 1, NULL, 'Completed', 97.4400, 107.1840, 8, 1, 'Completed', NULL, '2026-04-11 07:39:42', '2026-04-11 08:13:42'),
(6, 1, 'localhost', 1, NULL, 'Canceled', 38.4800, 42.3280, 8, 1, 'Completed', NULL, '2026-04-19 14:39:42', '2026-04-19 15:09:42'),
(7, 1, 'localhost', 1, NULL, 'Completed', 101.5200, 111.6720, 9, 1, 'Completed', NULL, '2026-03-24 17:39:42', '2026-03-24 18:47:42'),
(8, 1, 'localhost', 1, NULL, 'Partial', 20.4600, 22.5060, 6, 1, 'In progress', NULL, '2026-04-07 15:39:42', '2026-04-07 17:24:42'),
(9, 1, 'localhost', 1, NULL, 'Canceled', 10.0400, 11.0440, 2, 1, 'Pending', NULL, '2026-03-31 10:39:42', '2026-03-31 11:42:42'),
(10, 1, 'localhost', 1, NULL, 'Completed', 83.3700, 91.7070, 7, 1, 'Completed', NULL, '2026-04-10 16:39:42', '2026-04-10 18:16:42'),
(11, 1, 'localhost', 1, NULL, 'Canceled', 3.4100, 3.7510, 1, 1, 'Rejected', NULL, '2026-04-10 16:39:42', '2026-04-10 16:47:42'),
(12, 1, 'localhost', 1, NULL, 'Completed', 92.6100, 101.8710, 9, 1, 'In progress', NULL, '2026-04-05 02:39:42', '2026-04-05 03:13:42'),
(13, 1, 'localhost', 1, NULL, 'Completed', 134.3000, 147.7300, 10, 1, 'Pending', NULL, '2026-04-15 13:39:42', '2026-04-15 15:14:42'),
(14, 1, 'localhost', 1, NULL, 'Completed', 47.5000, 52.2500, 5, 1, 'Pending', NULL, '2026-04-16 19:39:42', '2026-04-16 20:39:42'),
(15, 1, 'localhost', 1, NULL, 'Canceled', 90.9000, 99.9900, 10, 1, 'Completed', NULL, '2026-04-05 06:39:42', '2026-04-05 07:58:42'),
(16, 1, 'localhost', 1, NULL, 'Partial', 28.4400, 31.2840, 6, 1, 'Completed', NULL, '2026-04-20 00:39:42', '2026-04-20 02:26:42'),
(17, 1, 'localhost', 2, NULL, 'Canceled', 7.5400, 8.2940, 2, 1, 'Pending', NULL, '2026-03-25 23:39:42', '2026-03-25 23:54:42'),
(18, 1, 'localhost', 2, NULL, 'Partial', 10.2300, 11.2530, 3, 1, 'In progress', NULL, '2026-03-26 04:39:42', '2026-03-26 06:37:42'),
(19, 1, 'localhost', 2, NULL, 'Partial', 12.3300, 13.5630, 1, 1, 'In progress', NULL, '2026-04-10 08:39:42', '2026-04-10 08:48:42'),
(20, 1, 'localhost', 2, NULL, 'Completed', 63.1200, 69.4320, 6, 1, 'Rejected', NULL, '2026-04-22 04:39:42', '2026-04-22 06:08:42'),
(21, 1, 'localhost', 2, NULL, 'Completed', 11.2500, 12.3750, 5, 1, 'Pending', NULL, '2026-04-14 16:39:42', '2026-04-14 18:06:42'),
(22, 1, 'localhost', 2, NULL, 'Completed', 10.7600, 11.8360, 4, 1, 'Completed', NULL, '2026-04-07 06:39:42', '2026-04-07 08:30:42'),
(23, 1, 'localhost', 2, NULL, 'Completed', 14.7500, 16.2250, 5, 1, 'Rejected', NULL, '2026-04-09 17:39:42', '2026-04-09 19:23:42'),
(24, 1, 'localhost', 2, NULL, 'Completed', 10.9800, 12.0780, 2, 1, 'Pending', NULL, '2026-03-25 18:39:42', '2026-03-25 18:51:42'),
(25, 1, 'localhost', 2, NULL, 'Partial', 50.4500, 55.4950, 5, 1, 'In progress', NULL, '2026-04-10 21:39:42', '2026-04-10 23:23:42'),
(26, 1, 'localhost', 2, NULL, 'Completed', 68.5300, 75.3830, 7, 1, 'Completed', NULL, '2026-04-03 00:39:42', '2026-04-03 00:51:42'),
(27, 1, 'localhost', 2, NULL, 'Partial', 11.9700, 13.1670, 1, 1, 'Pending', NULL, '2026-03-25 19:39:42', '2026-03-25 20:13:42'),
(28, 1, 'localhost', 2, NULL, 'Canceled', 5.2100, 5.7310, 1, 1, 'Pending', NULL, '2026-04-15 04:39:42', '2026-04-15 06:28:42'),
(29, 1, 'localhost', 2, NULL, 'Completed', 53.5500, 58.9050, 9, 1, 'Pending', NULL, '2026-04-18 09:39:42', '2026-04-18 10:47:42'),
(30, 1, 'localhost', 2, NULL, 'Completed', 125.4000, 137.9400, 10, 1, 'Pending', NULL, '2026-04-12 20:39:42', '2026-04-12 21:02:42'),
(31, 1, 'localhost', 2, NULL, 'Completed', 73.6200, 80.9820, 9, 1, 'Pending', NULL, '2026-04-04 01:39:42', '2026-04-04 03:38:42'),
(32, 1, 'localhost', 3, NULL, 'Completed', 32.5500, 35.8050, 3, 1, 'In progress', NULL, '2026-04-08 11:39:42', '2026-04-08 13:04:42'),
(33, 1, 'localhost', 3, NULL, 'Partial', 8.3200, 9.1520, 1, 1, 'Pending', NULL, '2026-04-09 22:39:42', '2026-04-09 23:38:42'),
(34, 1, 'localhost', 3, NULL, 'Partial', 40.2300, 44.2530, 9, 1, 'Pending', NULL, '2026-03-25 12:39:42', '2026-03-25 14:02:42'),
(35, 1, 'localhost', 3, NULL, 'Completed', 30.9900, 34.0890, 3, 1, 'Rejected', NULL, '2026-04-07 07:39:42', '2026-04-07 08:16:42'),
(36, 1, 'localhost', 3, NULL, 'Completed', 107.5000, 118.2500, 10, 1, 'Completed', NULL, '2026-03-25 21:39:42', '2026-03-25 23:37:42'),
(37, 1, 'localhost', 3, NULL, 'Completed', 26.4000, 29.0400, 2, 1, 'Pending', NULL, '2026-04-05 07:39:42', '2026-04-05 08:04:42'),
(38, 1, 'localhost', 3, NULL, 'Completed', 20.7600, 22.8360, 4, 1, 'Pending', NULL, '2026-04-22 12:39:42', '2026-04-22 13:25:42'),
(39, 1, 'localhost', 3, NULL, 'Canceled', 66.7800, 73.4580, 7, 1, 'Rejected', NULL, '2026-04-01 05:39:42', '2026-04-01 05:56:42'),
(40, 1, 'localhost', 3, NULL, 'Completed', 22.9000, 25.1900, 2, 1, 'Pending', NULL, '2026-03-30 13:39:42', '2026-03-30 15:12:42'),
(41, 1, 'localhost', 3, NULL, 'Canceled', 6.2300, 6.8530, 1, 1, 'Rejected', NULL, '2026-03-26 17:39:42', '2026-03-26 17:45:42'),
(42, 1, 'localhost', 3, NULL, 'Completed', 75.2000, 82.7200, 8, 1, 'Pending', NULL, '2026-03-28 21:39:42', '2026-03-28 23:25:42'),
(43, 1, 'localhost', 3, NULL, 'Partial', 24.4000, 26.8400, 8, 1, 'Pending', NULL, '2026-04-10 17:39:42', '2026-04-10 19:09:42'),
(44, 1, 'localhost', 3, NULL, 'Completed', 19.8800, 21.8680, 2, 1, 'Rejected', NULL, '2026-03-28 02:39:42', '2026-03-28 03:52:42'),
(45, 1, 'localhost', 3, NULL, 'Completed', 106.2000, 116.8200, 10, 1, 'Pending', NULL, '2026-04-07 04:39:42', '2026-04-07 06:35:42'),
(46, 1, 'localhost', 3, NULL, 'Completed', 35.2200, 38.7420, 6, 1, 'Completed', NULL, '2026-04-12 12:39:42', '2026-04-12 13:31:42'),
(47, 1, 'localhost', 4, NULL, 'Completed', 36.4500, 40.0950, 5, 1, 'Completed', NULL, '2026-04-10 08:39:42', '2026-04-10 10:10:42'),
(48, 1, 'localhost', 4, NULL, 'Completed', 32.7500, 36.0250, 5, 1, 'Pending', NULL, '2026-04-19 18:39:42', '2026-04-19 20:27:42'),
(49, 1, 'localhost', 4, NULL, 'Canceled', 54.9900, 60.4890, 9, 1, 'Pending', NULL, '2026-04-17 05:39:42', '2026-04-17 07:00:42'),
(50, 1, 'localhost', 4, NULL, 'Completed', 13.4600, 14.8060, 2, 1, 'Rejected', NULL, '2026-04-09 17:39:42', '2026-04-09 18:37:42'),
(51, 1, 'localhost', 4, NULL, 'Completed', 12.4500, 13.6950, 1, 1, 'Pending', NULL, '2026-04-22 22:39:42', '2026-04-22 23:49:42'),
(52, 1, 'localhost', 4, NULL, 'Partial', 127.4000, 140.1400, 10, 1, 'Rejected', NULL, '2026-04-07 04:39:42', '2026-04-07 06:39:42'),
(53, 1, 'localhost', 4, NULL, 'Completed', 29.5400, 32.4940, 2, 1, 'Rejected', NULL, '2026-04-18 15:39:42', '2026-04-18 16:15:42'),
(54, 1, 'localhost', 4, NULL, 'Canceled', 88.4800, 97.3280, 7, 1, 'Completed', NULL, '2026-03-27 01:39:42', '2026-03-27 03:24:42'),
(55, 1, 'localhost', 4, NULL, 'Partial', 51.7500, 56.9250, 5, 1, 'Completed', NULL, '2026-04-02 05:39:42', '2026-04-02 06:32:42'),
(56, 1, 'localhost', 4, NULL, 'Canceled', 13.9600, 15.3560, 4, 1, 'In progress', NULL, '2026-04-10 22:39:42', '2026-04-10 23:37:42'),
(57, 1, 'localhost', 4, NULL, 'Partial', 8.4900, 9.3390, 1, 1, 'In progress', NULL, '2026-04-08 14:39:42', '2026-04-08 14:59:42'),
(58, 1, 'localhost', 4, NULL, 'Partial', 74.8200, 82.3020, 6, 1, 'In progress', NULL, '2026-03-30 09:39:42', '2026-03-30 10:18:42'),
(59, 1, 'localhost', 4, NULL, 'Completed', 39.0600, 42.9660, 7, 1, 'In progress', NULL, '2026-04-01 16:39:42', '2026-04-01 17:58:42'),
(60, 1, 'localhost', 5, NULL, 'Completed', 19.0800, 20.9880, 2, 1, 'Rejected', NULL, '2026-04-08 23:39:42', '2026-04-09 00:27:42'),
(61, 1, 'localhost', 5, NULL, 'Canceled', 61.3900, 67.5290, 7, 1, 'Pending', NULL, '2026-04-12 19:39:42', '2026-04-12 20:29:42'),
(62, 1, 'localhost', 5, NULL, 'Completed', 44.7600, 49.2360, 6, 1, 'In progress', NULL, '2026-04-14 16:39:42', '2026-04-14 18:07:42'),
(63, 1, 'localhost', 5, NULL, 'Completed', 17.1000, 18.8100, 6, 1, 'Rejected', NULL, '2026-03-27 07:39:42', '2026-03-27 08:50:42'),
(64, 1, 'localhost', 5, NULL, 'Completed', 45.9900, 50.5890, 7, 1, 'Pending', NULL, '2026-04-05 11:39:42', '2026-04-05 12:57:42'),
(65, 1, 'localhost', 5, NULL, 'Canceled', 13.1400, 14.4540, 2, 1, 'Completed', NULL, '2026-04-16 13:39:42', '2026-04-16 14:08:42'),
(66, 1, 'localhost', 5, NULL, 'Completed', 80.8200, 88.9020, 9, 1, 'Completed', NULL, '2026-04-06 17:39:42', '2026-04-06 18:37:42'),
(67, 1, 'localhost', 5, NULL, 'Partial', 19.3600, 21.2960, 8, 1, 'Pending', NULL, '2026-04-05 12:39:42', '2026-04-05 14:01:42'),
(68, 1, 'localhost', 5, NULL, 'Partial', 65.9200, 72.5120, 8, 1, 'Rejected', NULL, '2026-04-05 06:39:42', '2026-04-05 08:29:42'),
(69, 1, 'localhost', 5, NULL, 'Completed', 94.5900, 104.0490, 9, 1, 'Pending', NULL, '2026-04-16 05:39:42', '2026-04-16 06:51:42'),
(70, 1, 'localhost', 6, NULL, 'Completed', 39.6900, 43.6590, 3, 1, 'Pending', NULL, '2026-04-16 20:39:42', '2026-04-16 20:50:42'),
(71, 1, 'localhost', 6, NULL, 'Completed', 15.8800, 17.4680, 4, 1, 'Completed', NULL, '2026-03-30 14:39:42', '2026-03-30 15:26:42'),
(72, 1, 'localhost', 6, NULL, 'Partial', 16.0400, 17.6440, 2, 1, 'Pending', NULL, '2026-04-08 15:39:42', '2026-04-08 15:52:42'),
(73, 1, 'localhost', 6, NULL, 'Completed', 10.1600, 11.1760, 4, 1, 'Rejected', NULL, '2026-04-10 22:39:42', '2026-04-11 00:35:42'),
(74, 1, 'localhost', 6, NULL, 'Completed', 25.7000, 28.2700, 5, 1, 'Rejected', NULL, '2026-04-16 17:39:42', '2026-04-16 19:16:42'),
(75, 1, 'localhost', 6, NULL, 'Completed', 119.6800, 131.6480, 8, 1, 'Pending', NULL, '2026-04-09 09:39:42', '2026-04-09 11:10:42'),
(76, 1, 'localhost', 6, NULL, 'Completed', 80.4300, 88.4730, 7, 1, 'In progress', NULL, '2026-04-22 22:39:42', '2026-04-23 00:30:42'),
(77, 1, 'localhost', 6, NULL, 'Partial', 46.6200, 51.2820, 7, 1, 'Rejected', NULL, '2026-04-21 12:39:42', '2026-04-21 13:47:42'),
(78, 1, 'localhost', 6, NULL, 'Canceled', 43.3500, 47.6850, 5, 1, 'In progress', NULL, '2026-03-24 22:39:42', '2026-03-25 00:16:42'),
(79, 1, 'localhost', 6, NULL, 'Completed', 25.2000, 27.7200, 10, 1, 'In progress', NULL, '2026-04-17 14:39:42', '2026-04-17 15:29:42'),
(80, 1, 'localhost', 6, NULL, 'Completed', 86.1600, 94.7760, 6, 1, 'In progress', NULL, '2026-04-03 01:39:42', '2026-04-03 02:27:42'),
(81, 1, 'localhost', 7, NULL, 'Completed', 27.9200, 30.7120, 4, 1, 'Completed', NULL, '2026-04-06 15:39:42', '2026-04-06 17:07:42'),
(82, 1, 'localhost', 7, NULL, 'Completed', 2.3100, 2.5410, 1, 1, 'Pending', NULL, '2026-04-09 20:39:42', '2026-04-09 22:33:42'),
(83, 1, 'localhost', 7, NULL, 'Completed', 32.1000, 35.3100, 10, 1, 'Pending', NULL, '2026-03-26 10:39:42', '2026-03-26 11:10:42'),
(84, 1, 'localhost', 7, NULL, 'Completed', 15.1800, 16.6980, 3, 1, 'Completed', NULL, '2026-03-31 15:39:42', '2026-05-27 10:12:37'),
(85, 1, 'localhost', 7, NULL, 'Partial', 48.2000, 53.0200, 10, 1, 'Completed', NULL, '2026-04-10 11:39:42', '2026-05-27 10:12:37'),
(86, 1, 'localhost', 7, NULL, 'Completed', 11.0000, 12.1000, 2, 1, 'In progress', NULL, '2026-04-14 17:39:42', '2026-05-27 10:11:30'),
(87, 1, 'localhost', 7, NULL, 'Completed', 55.4500, 60.9950, 5, 1, 'In progress', NULL, '2026-03-24 21:39:42', '2026-05-27 10:07:23'),
(88, 1, 'localhost', 7, NULL, 'Completed', 15.7500, 17.3250, 7, 1, 'Completed', NULL, '2026-04-19 06:39:42', '2026-04-19 07:43:42'),
(89, 1, 'localhost', 7, NULL, 'Completed', 47.3600, 52.0960, 8, 1, 'Completed', NULL, '2026-03-29 18:39:42', '2026-03-29 19:26:42'),
(90, 1, 'localhost', 7, NULL, 'Completed', 8.9400, 9.8340, 1, 1, 'Rejected', NULL, '2026-04-20 00:39:42', '2026-04-20 01:30:42'),
(91, 1, 'localhost', 7, NULL, 'Partial', 25.4800, 28.0280, 7, 1, 'Completed', NULL, '2026-04-03 03:39:42', '2026-04-03 04:50:42'),
(92, 1, 'localhost', 7, NULL, 'Completed', 148.4000, 163.2400, 10, 1, 'Rejected', NULL, '2026-04-03 01:39:42', '2026-04-03 02:05:42'),
(93, 1, 'localhost', 7, NULL, 'Completed', 24.4000, 26.8400, 2, 1, 'In progress', NULL, '2026-04-03 03:39:42', '2026-05-27 09:58:18'),
(94, 1, '127.0.0.1', 1, NULL, 'Completed', 5.0000, 5.0000, 1, 0, NULL, '112', '2026-05-07 13:41:07', '2026-05-27 10:13:33');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_warehouses`
--

CREATE TABLE `product_warehouses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `domain` varchar(255) NOT NULL,
  `position` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`name`)),
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0,
  `attributes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attributes`)),
  `rate_original` decimal(15,8) NOT NULL DEFAULT 4.00000000,
  `rate_retail` decimal(15,8) DEFAULT NULL,
  `rate_agent` decimal(15,8) DEFAULT NULL,
  `rate_distributor` decimal(15,8) DEFAULT NULL,
  `rate_retail_up` decimal(15,8) DEFAULT NULL,
  `rate_agent_up` decimal(15,8) DEFAULT NULL,
  `rate_distributor_up` decimal(15,8) DEFAULT NULL,
  `sync_rate` tinyint(1) NOT NULL DEFAULT 0,
  `sync_min_max` tinyint(1) NOT NULL DEFAULT 0,
  `sync_refill` tinyint(1) NOT NULL DEFAULT 0,
  `sync_cancel` tinyint(1) NOT NULL DEFAULT 0,
  `sync_status` tinyint(1) NOT NULL DEFAULT 0,
  `min` int(11) NOT NULL DEFAULT 1,
  `max` int(11) NOT NULL DEFAULT 10000,
  `service_api` varchar(255) DEFAULT NULL,
  `provider_name` varchar(255) DEFAULT NULL,
  `provider_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'api',
  `type_service` varchar(255) DEFAULT NULL,
  `type_radio` varchar(255) DEFAULT NULL,
  `refill` tinyint(1) NOT NULL DEFAULT 0,
  `cancel` tinyint(1) NOT NULL DEFAULT 0,
  `dripfeed` tinyint(1) NOT NULL DEFAULT 0,
  `average_time` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `reaction` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `domain` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `services`
--

INSERT INTO `services` (`id`, `category_id`, `name`, `title`, `description`, `image`, `position`, `attributes`, `rate_original`, `rate_retail`, `rate_agent`, `rate_distributor`, `rate_retail_up`, `rate_agent_up`, `rate_distributor_up`, `sync_rate`, `sync_min_max`, `sync_refill`, `sync_cancel`, `sync_status`, `min`, `max`, `service_api`, `provider_name`, `provider_id`, `type`, `type_service`, `type_radio`, `refill`, `cancel`, `dripfeed`, `average_time`, `note`, `reaction`, `status`, `created_at`, `updated_at`, `domain`) VALUES
(1, 1, '{\"en\":\"\\ud83c\\udf0d Whatsapp - Channel Member ~ Global ~ Max 10k ~ 500-2k\\/days ~ INSTANT\"}', '🌍 Whatsapp - Channel Member ~ Global ~ Max 10k ~ 500-2k/days ~ INSTANT', '', 'fa-brands fa-facebook', 0, NULL, 7.99116000, 7.99116000, 7.99116000, 7.99116000, 100.00000000, 100.00000000, 100.00000000, 1, 1, 1, 1, 1, 10, 10000, '1289', 'smmkay.com', 2, 'api', 'Default', NULL, 0, 0, 0, NULL, NULL, NULL, 1, '2026-05-24 02:36:53', '2026-05-24 02:36:53', '127.0.0.1'),
(2, 1, '{\"en\":\"\\ud83c\\uddfb\\ud83c\\uddf3 Whatsapp - Channel Member ~ Vietnam ~ Max 5k ~ 500\\/days ~ INSTANT\"}', '🇻🇳 Whatsapp - Channel Member ~ Vietnam ~ Max 5k ~ 500/days ~ INSTANT', '', 'fa-brands fa-facebook', 0, NULL, 6.04800000, 6.04800000, 6.04800000, 6.04800000, 100.00000000, 100.00000000, 100.00000000, 1, 1, 1, 1, 1, 10, 5000, '1298', 'smmkay.com', 2, 'api', 'Default', NULL, 0, 0, 0, NULL, NULL, NULL, 1, '2026-05-24 02:36:55', '2026-05-24 02:36:55', '127.0.0.1'),
(3, 2, '{\"en\":\"\\ud83c\\udde7\\ud83c\\uddf7 Whatsapp - Channel Member ~ Brazil ~ Max 5k ~ 500\\/days ~ INSTANT\"}', 'Twitter Likes | Mix Profiles | Day 10K ⚡ | No Warranty ⚠️', '<p>aaa</p><p><strong>bbb</strong></p><p><em>ccccc</em></p>', 'fa-brands fa-facebook', 0, '[]', 7.76808000, 7.76808000, 7.76808000, 7.76808000, 100.00000000, 100.00000000, 100.00000000, 1, 1, 1, 1, 1, 10, 100000, NULL, NULL, NULL, 'manual', 'Default', NULL, 0, 0, 0, '0', NULL, NULL, 1, '2026-05-24 02:37:07', '2026-05-28 11:44:21', '127.0.0.1'),
(4, 1, '{\"en\":\"TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar\\/Video | Refill 7 Day | 500 - 2K\\/Day \\u26d4\\u267b\\ufe0f\\u26a1\\ufe0f\"}', 'TikTok Followers Vietnam VIP | Instant | High Quality Real + Avatar/Video | Refill 7 Day | 500 - 2K/Day ⛔♻️⚡️', '', 'fa-brands fa-facebook', 0, NULL, 2.10000000, 2.10000000, 2.10000000, 2.10000000, 100.00000000, 100.00000000, 100.00000000, 1, 1, 1, 1, 1, 100, 10000000, '1138', 'smmkay.com', 2, 'api', 'Default', NULL, 1, 1, 0, NULL, NULL, NULL, 1, '2026-05-25 05:28:52', '2026-05-25 05:28:52', '127.0.0.1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `service_sync_logs`
--

CREATE TABLE `service_sync_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `provider_id` bigint(20) UNSIGNED DEFAULT NULL,
  `provider_name` varchar(255) DEFAULT NULL,
  `service_api` varchar(255) DEFAULT NULL,
  `change_type` varchar(255) NOT NULL DEFAULT 'price_increase',
  `old_value` decimal(20,4) DEFAULT NULL,
  `new_value` decimal(20,4) DEFAULT NULL,
  `field_changed` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `domain` varchar(255) DEFAULT NULL,
  `log_type` enum('website','api') NOT NULL DEFAULT 'api',
  `sync_batch` varchar(36) DEFAULT NULL,
  `changes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`changes`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `service_sync_logs`
--

INSERT INTO `service_sync_logs` (`id`, `service_id`, `provider_id`, `provider_name`, `service_api`, `change_type`, `old_value`, `new_value`, `field_changed`, `is_read`, `domain`, `log_type`, `sync_batch`, `changes`, `created_at`, `updated_at`) VALUES
(10, 3, 1, 'smmkay.com', '1138', 'price_decrease', 2.1000, 2.2000, 'rate', 1, '127.0.0.1', 'website', NULL, NULL, '2026-04-25 18:26:34', '2026-05-07 13:43:49'),
(11, 3, 1, 'smmkay.com', '1138', 'price_decrease', 2.1000, 2.1000, 'rate', 1, '127.0.0.1', 'website', NULL, NULL, '2026-04-25 18:31:34', '2026-05-07 13:43:49'),
(12, 3, 1, 'smmkay.com', '1138', 'price_decrease', 2.1000, 2.1000, 'rate', 1, '127.0.0.1', 'website', NULL, NULL, '2026-04-25 18:32:07', '2026-05-07 13:43:49'),
(13, 3, NULL, NULL, NULL, 'price_decrease', 1.0000, 1.0000, 'rate', 0, '127.0.0.1', 'website', NULL, NULL, '2026-05-09 08:31:41', '2026-05-09 08:31:41'),
(14, 3, NULL, NULL, NULL, 'price_decrease', 1.0000, 1.0000, 'rate', 0, '127.0.0.1', 'website', NULL, NULL, '2026-05-23 09:08:50', '2026-05-23 09:08:50'),
(15, 3, NULL, NULL, NULL, 'price_decrease', 1.0000, 1.0000, 'rate', 0, '127.0.0.1', 'website', NULL, NULL, '2026-05-23 09:11:33', '2026-05-23 09:11:33'),
(16, 3, NULL, NULL, NULL, 'price_decrease', 1.0000, 1.0000, 'rate', 0, '127.0.0.1', 'website', NULL, NULL, '2026-05-23 09:11:43', '2026-05-23 09:11:43'),
(17, 3, NULL, NULL, NULL, 'price_decrease', 1.0000, 1.0000, 'rate', 0, '127.0.0.1', 'website', NULL, NULL, '2026-05-23 09:33:34', '2026-05-23 09:33:34'),
(18, 3, NULL, NULL, NULL, 'price_decrease', 1.0000, 1.0000, 'rate', 0, '127.0.0.1', 'website', NULL, NULL, '2026-05-23 09:34:11', '2026-05-23 09:34:11'),
(19, 3, NULL, NULL, NULL, 'price_decrease', 1.0000, 1.0000, 'rate', 0, '127.0.0.1', 'website', NULL, NULL, '2026-05-23 09:36:26', '2026-05-23 09:36:26'),
(20, 3, NULL, NULL, NULL, 'price_decrease', 1.0000, 1.0000, 'rate', 0, '127.0.0.1', 'website', NULL, NULL, '2026-05-23 09:39:50', '2026-05-23 09:39:50'),
(21, 3, NULL, NULL, NULL, 'price_decrease', 1.0000, 1.0000, 'rate', 0, '127.0.0.1', 'website', NULL, NULL, '2026-05-23 09:41:51', '2026-05-23 09:41:51'),
(22, 8, 2, 'smmkay.com', '1291', 'price_decrease', 6.0480, 6.0480, 'rate', 0, '127.0.0.1', 'website', NULL, NULL, '2026-05-23 14:55:11', '2026-05-23 14:55:11'),
(23, 3, NULL, NULL, NULL, 'price_increase', 1.2613, 7.7681, 'rate', 0, '127.0.0.1', 'website', NULL, NULL, '2026-05-28 11:44:21', '2026-05-28 11:44:21'),
(24, 3, NULL, NULL, NULL, 'min_max_change', 100.0000, 10.0000, 'min', 0, '127.0.0.1', 'website', NULL, NULL, '2026-05-28 11:44:21', '2026-05-28 11:44:21'),
(25, 3, NULL, NULL, NULL, 'min_max_change', 2000.0000, 100000.0000, 'max', 0, '127.0.0.1', 'website', NULL, NULL, '2026-05-28 11:44:21', '2026-05-28 11:44:21');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `domain` varchar(255) DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `custom_fields` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`custom_fields`)),
  `status` enum('open','answered','closed') NOT NULL DEFAULT 'open',
  `priority` enum('low','medium','high') NOT NULL DEFAULT 'medium',
  `last_reply_at` timestamp NULL DEFAULT NULL,
  `assigned_to` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tickets`
--

INSERT INTO `tickets` (`id`, `user_id`, `domain`, `subject_id`, `subject`, `message`, `custom_fields`, `status`, `priority`, `last_reply_at`, `assigned_to`, `created_at`, `updated_at`) VALUES
(1, 1, '127.0.0.1', 1, 'Other', '21332113232', '[]', 'open', 'medium', '2026-05-11 20:46:43', 1, '2026-05-07 13:41:30', '2026-05-11 20:46:43'),
(2, 1, '127.0.0.1', 1, 'Other', '1', '[]', 'open', 'medium', NULL, NULL, '2026-05-11 20:42:24', '2026-05-11 20:42:24');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ticket_reply`
--

CREATE TABLE `ticket_reply` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `is_system` tinyint(1) NOT NULL DEFAULT 0,
  `attachments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attachments`)),
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ticket_reply`
--

INSERT INTO `ticket_reply` (`id`, `ticket_id`, `user_id`, `message`, `is_admin`, `is_system`, `attachments`, `read_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '21332113232', 0, 0, '[]', '2026-05-07 13:44:20', '2026-05-07 13:41:30', '2026-05-07 13:44:20'),
(2, 1, 1, '1231233', 1, 0, '[]', '2026-05-11 20:42:25', '2026-05-07 13:44:21', '2026-05-11 20:42:25'),
(3, 2, 1, '1', 0, 0, '[]', NULL, '2026-05-11 20:42:24', '2026-05-11 20:42:24'),
(4, 1, 1, '213', 0, 0, '[]', NULL, '2026-05-11 20:42:28', '2026-05-11 20:42:28'),
(5, 1, 1, '11', 0, 0, '[{\"original_name\":\"fb.gif\",\"file_name\":\"1778532402_fb.gif\",\"file_path\":\"ticket-attachments\\/1778532402_fb.gif\",\"mime_type\":\"image\\/gif\",\"file_size\":977248}]', NULL, '2026-05-11 20:46:43', '2026-05-11 20:46:43');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ticket_subjects`
--

CREATE TABLE `ticket_subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(255) NOT NULL,
  `subcategory` varchar(255) DEFAULT NULL,
  `show_message_only` tinyint(1) NOT NULL DEFAULT 0,
  `required_fields` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`required_fields`)),
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ticket_subjects`
--

INSERT INTO `ticket_subjects` (`id`, `category`, `subcategory`, `show_message_only`, `required_fields`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Other', NULL, 0, NULL, 1, 0, '2026-05-07 13:41:30', '2026-05-07 13:41:30');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(20,9) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'order',
  `status` varchar(255) NOT NULL DEFAULT 'completed',
  `payment_method` varchar(255) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `balance_after` decimal(20,9) DEFAULT NULL,
  `domain` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `order_id`, `amount`, `type`, `status`, `payment_method`, `transaction_id`, `description`, `balance_after`, `domain`, `created_at`, `updated_at`) VALUES
(1, 1, 13, -0.000040000, 'order', 'completed', 'balance', 'ORDER-13', 'Order #13 - Service #1', 0.819540000, '127.0.0.1', '2026-04-18 06:39:15', '2026-04-18 06:39:15'),
(2, 1, 14, -0.011000000, 'order', 'completed', 'balance', 'ORDER-14', 'Order #14 - Service #3', 0.797580000, '127.0.0.1', '2026-04-20 13:33:52', '2026-04-20 13:33:52'),
(3, 1, 15, -0.011000000, 'order', 'completed', 'balance', 'ORDER-15', 'Order #15 - Service #3', 0.786580000, '127.0.0.1', '2026-04-20 13:34:14', '2026-04-20 13:34:14'),
(4, 1, 16, -0.011000000, 'order', 'completed', 'balance', 'ORDER-16', 'Order #16 - Service #3', 0.775580000, '127.0.0.1', '2026-04-20 13:36:37', '2026-04-20 13:36:37'),
(5, 1, 17, -0.011000000, 'order', 'completed', 'balance', 'ORDER-17', 'Order #17 - Service #3', 0.764580000, '127.0.0.1', '2026-04-20 13:37:54', '2026-04-20 13:37:54'),
(6, 1, 18, -0.011000000, 'order', 'completed', 'balance', 'ORDER-18', 'Order #18 - Service #3', 0.753580000, '127.0.0.1', '2026-04-20 13:43:56', '2026-04-20 13:43:56'),
(7, 1, 19, -0.011000000, 'order', 'completed', 'balance', 'ORDER-19', 'Order #19 - Service #3', 0.742580000, '127.0.0.1', '2026-04-20 13:44:33', '2026-04-20 13:44:33'),
(8, 1, NULL, -5.000000000, 'order', 'completed', 'balance', 'PRODUCT-1', 'Product order #1 - Nhóm Zalo 500 - 1000 thành viên thật', -5.000000000, '127.0.0.1', '2026-04-20 14:40:46', '2026-04-20 14:40:46'),
(9, 1, NULL, -5.000000000, 'order', 'completed', 'balance', 'PRODUCT-2', 'Product order #2 - Nhóm Zalo 500 - 1000 thành viên thật', 0.000000000, '127.0.0.1', '2026-04-20 14:47:17', '2026-04-20 14:47:17'),
(10, 1, NULL, -3.500000000, 'order', 'completed', 'balance', 'PRODUCT-3', 'Product order #3 - Tài khoản Facebook cá nhân Việt Nam', -2.000000000, '127.0.0.1', '2026-04-21 16:32:07', '2026-04-21 16:32:07'),
(11, 1, 251, -0.010500000, 'order', 'completed', 'balance', 'ORDER-251', 'Order #251 - Service #3', 1.479000000, '127.0.0.1', '2026-04-25 18:44:57', '2026-04-25 18:44:57'),
(12, 1, 252, -0.010500000, 'order', 'completed', 'balance', 'ORDER-252', 'Order #252 - Service #3', 0.979000000, '127.0.0.1', '2026-04-25 19:06:34', '2026-04-25 19:06:34'),
(13, 3, NULL, 10.000000000, 'bonus', 'completed', 'Bonus', 'ADMIN-1777190769-3', NULL, NULL, '127.0.0.1', '2026-04-26 08:06:09', '2026-04-26 08:06:09'),
(14, 3, NULL, 10.000000000, 'bonus', 'completed', 'Bonus', 'ADMIN-1777190873-3', NULL, NULL, '127.0.0.1', '2026-04-26 08:07:53', '2026-04-26 08:07:53'),
(15, 3, NULL, 10.000000000, 'bonus', 'completed', 'Bonus', 'ADMIN-1777191112-3', NULL, NULL, '127.0.0.1', '2026-04-26 08:11:52', '2026-04-26 08:11:52'),
(16, 1, NULL, -5.000000000, 'order', 'completed', 'balance', 'PRODUCT-94', 'Product order #94 - Nhóm Zalo 500 - 1000 thành viên thật', 2327.500000000, '127.0.0.1', '2026-05-07 13:41:07', '2026-05-07 13:41:07'),
(17, 1, 253, -0.100000000, 'order', 'completed', 'balance', 'ORDER-253', 'Order #253 - Service #3', 0.800000000, '127.0.0.1', '2026-05-09 08:31:49', '2026-05-09 08:31:49'),
(18, 1, 254, -0.100000000, 'order', 'completed', 'balance', 'ORDER-254', 'Order #254 - Service #3', 10.800000000, '127.0.0.1', '2026-05-13 10:30:50', '2026-05-13 10:30:50'),
(19, 1, 255, -0.100000000, 'order', 'completed', 'balance', 'ORDER-255', 'Order #255 - Service #3', 10.700000000, '127.0.0.1', '2026-05-15 06:08:23', '2026-05-15 06:08:23'),
(20, 1, NULL, 2.000000000, 'deposit', 'pending', NULL, NULL, NULL, NULL, NULL, '2026-05-22 08:40:49', '2026-05-22 08:40:49'),
(21, 1, NULL, 20.000000000, 'deposit', 'pending', NULL, NULL, NULL, NULL, NULL, '2026-05-22 08:43:28', '2026-05-22 08:43:28'),
(22, 1, NULL, 2.000000000, 'deposit', 'pending', NULL, NULL, NULL, NULL, NULL, '2026-05-22 08:45:19', '2026-05-22 08:45:19'),
(26, 1, 256, -0.210000000, 'order', 'completed', 'balance', 'ORDER-256', 'Order #256 - Service #4', -0.001048140, '127.0.0.1', '2026-05-25 05:29:18', '2026-05-25 05:29:18'),
(27, 1, 257, -0.212100000, 'order', 'completed', 'balance', 'ORDER-257', 'Order #257 - Service #4', 110.784751860, '127.0.0.1', '2026-05-25 05:31:24', '2026-05-25 05:31:24'),
(28, 1, 258, -0.210000000, 'order', 'completed', 'balance', 'ORDER-258', 'Order #258 - Service #4', 110.576851860, '127.0.0.1', '2026-05-25 05:44:06', '2026-05-25 05:44:06'),
(29, 1, 259, -0.212100000, 'order', 'completed', 'balance', 'ORDER-259', 'Order #259 - Service #4', 110.362651860, '127.0.0.1', '2026-05-25 09:49:19', '2026-05-25 09:49:19'),
(30, 1, 260, -0.212100000, 'order', 'completed', 'balance', 'ORDER-260', 'Order #260 - Service #4', 110.150551860, '127.0.0.1', '2026-05-25 09:55:40', '2026-05-25 09:55:40'),
(31, 1, 261, -0.212100000, 'order', 'completed', 'balance', 'ORDER-261', 'Order #261 - Service #4', 109.938451860, '127.0.0.1', '2026-05-25 09:57:24', '2026-05-25 09:57:24'),
(32, 1, 262, -0.212100000, 'order', 'completed', 'balance', 'ORDER-262', 'Order #262 - Service #4', 109.726351860, '127.0.0.1', '2026-05-25 10:02:28', '2026-05-25 10:02:28'),
(33, 1, 263, -0.210000000, 'order', 'completed', 'balance', 'ORDER-263', 'Order #263 - Service #4', 109.518451860, '127.0.0.1', '2026-05-25 10:03:01', '2026-05-25 10:03:01'),
(34, 1, 264, -0.210000000, 'order', 'completed', 'balance', 'ORDER-264', 'Order #264 - Service #4', 109.308451860, '127.0.0.1', '2026-05-25 10:04:13', '2026-05-25 10:04:13'),
(35, 1, 265, -0.210000000, 'order', 'completed', 'balance', 'ORDER-265', 'Order #265 - Service #4', 109.098451860, '127.0.0.1', '2026-05-25 10:12:23', '2026-05-25 10:12:23'),
(36, 1, 266, -0.126130000, 'order', 'completed', 'balance', 'ORDER-266', 'Order #266 - Service #3', 109.056191860, '127.0.0.1', '2026-05-25 10:44:04', '2026-05-25 10:44:04'),
(37, 1, 267, -0.210000000, 'order', 'completed', 'balance', 'ORDER-267', 'Order #267 - Service #4', 108.762321860, '127.0.0.1', '2026-05-25 10:45:26', '2026-05-25 10:45:26'),
(38, 1, 268, -0.210000000, 'order', 'completed', 'balance', 'ORDER-268', 'Order #268 - Service #4', 108.552321860, '127.0.0.1', '2026-05-25 10:53:24', '2026-05-25 10:53:24'),
(39, 1, 269, -0.210000000, 'order', 'completed', 'balance', 'ORDER-269', 'Order #269 - Service #4', 108.342321860, '127.0.0.1', '2026-05-25 10:53:26', '2026-05-25 10:53:26'),
(40, 1, 270, -0.210000000, 'order', 'completed', 'balance', 'ORDER-270', 'Order #270 - Service #4', 108.132321860, '127.0.0.1', '2026-05-25 10:59:25', '2026-05-25 10:59:25'),
(41, 1, 271, -0.210000000, 'order', 'completed', 'balance', 'ORDER-271', 'Order #271 - Service #4', 107.922321860, '127.0.0.1', '2026-05-25 10:59:26', '2026-05-25 10:59:26'),
(42, 1, 272, -0.210000000, 'order', 'completed', 'balance', 'ORDER-272', 'Order #272 - Service #4', 107.712321860, '127.0.0.1', '2026-05-25 11:06:54', '2026-05-25 11:06:54'),
(43, 1, 273, -0.210000000, 'order', 'completed', 'balance', 'ORDER-273', 'Order #273 - Service #4', 107.502321860, '127.0.0.1', '2026-05-25 11:06:56', '2026-05-25 11:06:56'),
(44, 1, 274, -0.210000000, 'order', 'completed', 'balance', 'ORDER-274', 'Order #274 - Service #4', 107.292321860, '127.0.0.1', '2026-05-25 11:17:13', '2026-05-25 11:17:13'),
(45, 1, 275, -0.210000000, 'order', 'completed', 'balance', 'ORDER-275', 'Order #275 - Service #4', 107.082321860, '127.0.0.1', '2026-05-25 11:17:15', '2026-05-25 11:17:15'),
(46, 1, 276, -0.210000000, 'order', 'completed', 'balance', 'ORDER-276', 'Order #276 - Service #4', 106.872321860, '127.0.0.1', '2026-05-25 11:30:59', '2026-05-25 11:30:59'),
(47, 1, 277, -0.210000000, 'order', 'completed', 'balance', 'ORDER-277', 'Order #277 - Service #4', 106.662321860, '127.0.0.1', '2026-05-25 11:31:02', '2026-05-25 11:31:02'),
(48, 1, 278, -0.210000000, 'order', 'completed', 'balance', 'ORDER-278', 'Order #278 - Service #4', 106.452321860, '127.0.0.1', '2026-05-25 11:31:22', '2026-05-25 11:31:22'),
(49, 1, 279, -0.210000000, 'order', 'completed', 'balance', 'ORDER-279', 'Order #279 - Service #4', 106.242321860, '127.0.0.1', '2026-05-25 11:31:39', '2026-05-25 11:31:39'),
(50, 1, 280, -0.210000000, 'order', 'completed', 'balance', 'ORDER-280', 'Order #280 - Service #4', 106.032321860, '127.0.0.1', '2026-05-25 19:44:40', '2026-05-25 19:44:40'),
(51, 1, 281, -0.210000000, 'order', 'completed', 'balance', 'ORDER-281', 'Order #281 - Service #4', 105.822321860, '127.0.0.1', '2026-05-25 19:48:35', '2026-05-25 19:48:35'),
(52, 1, 282, -0.210000000, 'order', 'completed', 'balance', 'ORDER-282', 'Order #282 - Service #4', 105.612321860, '127.0.0.1', '2026-05-25 19:51:25', '2026-05-25 19:51:25'),
(53, 1, 283, -0.210000000, 'order', 'completed', 'balance', 'ORDER-283', 'Order #283 - Service #4', 105.402321860, '127.0.0.1', '2026-05-25 19:52:06', '2026-05-25 19:52:06'),
(54, 1, 284, -0.212100000, 'order', 'completed', 'balance', 'ORDER-284', 'Order #284 - Service #4', 105.188121860, '127.0.0.1', '2026-05-25 19:59:51', '2026-05-25 19:59:51'),
(55, 1, 285, -0.214200000, 'order', 'completed', 'balance', 'ORDER-285', 'Order #285 - Service #4', 104.971821860, '127.0.0.1', '2026-05-25 20:01:35', '2026-05-25 20:01:35'),
(56, 1, 286, -0.210000000, 'order', 'completed', 'balance', 'ORDER-286', 'Order #286 - Service #4', 104.766021860, '127.0.0.1', '2026-05-25 20:01:48', '2026-05-25 20:01:48'),
(57, 1, 287, -0.210000000, 'order', 'completed', 'balance', 'ORDER-287', 'Order #287 - Service #4', 104.556021860, '127.0.0.1', '2026-05-25 20:02:28', '2026-05-25 20:02:28'),
(58, 1, 288, -0.210000000, 'order', 'completed', 'balance', 'ORDER-288', 'Order #288 - Service #4', 104.346021860, '127.0.0.1', '2026-05-25 20:02:56', '2026-05-25 20:02:56'),
(59, 1, 289, -0.210000000, 'order', 'completed', 'balance', 'ORDER-289', 'Order #289 - Service #4', 104.136021860, '127.0.0.1', '2026-05-25 20:10:58', '2026-05-25 20:10:58'),
(60, 1, 290, -0.210000000, 'order', 'completed', 'balance', 'ORDER-290', 'Order #290 - Service #4', 103.926021860, '127.0.0.1', '2026-05-25 20:11:20', '2026-05-25 20:11:20'),
(61, 1, 291, -0.214200000, 'order', 'completed', 'balance', 'ORDER-291', 'Order #291 - Service #4', 103.707621860, '127.0.0.1', '2026-05-25 20:15:14', '2026-05-25 20:15:14'),
(62, 1, 292, -0.216300000, 'order', 'completed', 'balance', 'ORDER-292', 'Order #292 - Service #4', 103.489221860, '127.0.0.1', '2026-05-25 20:15:30', '2026-05-25 20:15:30'),
(63, 1, 293, -0.216300000, 'order', 'completed', 'balance', 'ORDER-293', 'Order #293 - Service #4', 103.272921860, '127.0.0.1', '2026-05-25 20:15:32', '2026-05-25 20:15:32'),
(64, 1, 294, -0.216300000, 'order', 'completed', 'balance', 'ORDER-294', 'Order #294 - Service #4', 103.056621860, '127.0.0.1', '2026-05-25 20:17:18', '2026-05-25 20:17:18'),
(65, 1, 295, -0.216300000, 'order', 'completed', 'balance', 'ORDER-295', 'Order #295 - Service #4', 102.840321860, '127.0.0.1', '2026-05-25 20:17:19', '2026-05-25 20:17:19'),
(66, 1, 296, -0.216300000, 'order', 'completed', 'balance', 'ORDER-296', 'Order #296 - Service #4', 102.624021860, '127.0.0.1', '2026-05-25 20:17:21', '2026-05-25 20:17:21'),
(67, 1, 297, -0.210000000, 'order', 'completed', 'balance', 'ORDER-297', 'Order #297 - Service #4', 102.420321860, '127.0.0.1', '2026-05-25 20:39:04', '2026-05-25 20:39:04'),
(68, 1, 298, -0.210000000, 'order', 'completed', 'balance', 'ORDER-298', 'Order #298 - Service #4', 102.210321860, '127.0.0.1', '2026-05-25 20:39:06', '2026-05-25 20:39:06'),
(69, 1, 299, -0.210000000, 'order', 'completed', 'balance', 'ORDER-299', 'Order #299 - Service #4', 102.000321860, '127.0.0.1', '2026-05-25 20:39:08', '2026-05-25 20:39:08'),
(70, 1, 300, -0.210000000, 'order', 'completed', 'balance', 'ORDER-300', 'Order #300 - Service #4', 101.790321860, '127.0.0.1', '2026-05-25 21:07:28', '2026-05-25 21:07:28'),
(71, 1, 301, -0.210000000, 'order', 'completed', 'balance', 'ORDER-301', 'Order #301 - Service #4', 101.580321860, '127.0.0.1', '2026-05-25 21:07:28', '2026-05-25 21:07:28'),
(72, 1, 302, -0.210000000, 'order', 'completed', 'balance', 'ORDER-302', 'Order #302 - Service #4', 101.370321860, '127.0.0.1', '2026-05-25 21:07:29', '2026-05-25 21:07:29'),
(73, 1, 303, -0.233100000, 'order', 'completed', 'balance', 'ORDER-303', 'Order #303 - Service #4', 101.114121860, '127.0.0.1', '2026-05-25 21:09:28', '2026-05-25 21:09:28'),
(74, 1, 304, -0.233100000, 'order', 'completed', 'balance', 'ORDER-304', 'Order #304 - Service #4', 100.881021860, '127.0.0.1', '2026-05-25 21:09:28', '2026-05-25 21:09:28'),
(75, 1, 305, -0.233100000, 'order', 'completed', 'balance', 'ORDER-305', 'Order #305 - Service #4', 100.647921860, '127.0.0.1', '2026-05-25 21:09:28', '2026-05-25 21:09:28'),
(76, 1, 306, -0.235200000, 'order', 'completed', 'balance', 'ORDER-306', 'Order #306 - Service #4', 100.410621860, '127.0.0.1', '2026-05-25 21:10:08', '2026-05-25 21:10:08'),
(77, 1, 307, -0.235200000, 'order', 'completed', 'balance', 'ORDER-307', 'Order #307 - Service #4', 100.175421860, '127.0.0.1', '2026-05-25 21:10:09', '2026-05-25 21:10:09'),
(78, 1, 308, -0.235200000, 'order', 'completed', 'balance', 'ORDER-308', 'Order #308 - Service #4', 99.940221860, '127.0.0.1', '2026-05-25 21:10:09', '2026-05-25 21:10:09'),
(79, 1, 309, -0.210000000, 'order', 'completed', 'balance', 'ORDER-309', 'Order #309 - Service #4', 99.755421860, '127.0.0.1', '2026-05-25 21:28:23', '2026-05-25 21:28:23'),
(80, 1, 310, -0.210000000, 'order', 'completed', 'balance', 'ORDER-310', 'Order #310 - Service #4', 99.545421860, '127.0.0.1', '2026-05-25 21:28:23', '2026-05-25 21:28:23'),
(81, 1, 311, -0.210000000, 'order', 'completed', 'balance', 'ORDER-311', 'Order #311 - Service #4', 99.335421860, '127.0.0.1', '2026-05-25 21:28:24', '2026-05-25 21:28:24'),
(82, 1, 312, -0.224700000, 'order', 'completed', 'balance', 'ORDER-312', 'Order #312 - Service #4', 99.096021860, '127.0.0.1', '2026-05-25 21:29:12', '2026-05-25 21:29:12'),
(83, 1, 313, -0.224700000, 'order', 'completed', 'balance', 'ORDER-313', 'Order #313 - Service #4', 98.871321860, '127.0.0.1', '2026-05-25 21:29:12', '2026-05-25 21:29:12'),
(84, 1, 314, -0.224700000, 'order', 'completed', 'balance', 'ORDER-314', 'Order #314 - Service #4', 98.646621860, '127.0.0.1', '2026-05-25 21:29:13', '2026-05-25 21:29:13'),
(85, 1, 312, 0.224700000, 'refund', 'completed', 'balance', 'REFUND-ORDER-312', 'Refund for canceled Order #312 — Smm error: This service is inactive', 99.096021860, '127.0.0.1', '2026-05-25 21:29:29', '2026-05-25 21:29:29'),
(86, 1, 313, 0.224700000, 'refund', 'completed', 'balance', 'REFUND-ORDER-313', 'Refund for canceled Order #313 — Smm error: This service is inactive', 99.320721860, '127.0.0.1', '2026-05-25 21:29:30', '2026-05-25 21:29:30'),
(87, 1, 314, 0.224700000, 'refund', 'completed', 'balance', 'REFUND-ORDER-314', 'Refund for canceled Order #314 — Smm error: This service is inactive', 99.545421860, '127.0.0.1', '2026-05-25 21:29:30', '2026-05-25 21:29:30'),
(88, 1, 315, -0.126130000, 'order', 'completed', 'balance', 'ORDER-315', 'Order #315 - Service #3', 99.293161860, '127.0.0.1', '2026-05-26 07:09:36', '2026-05-26 07:09:36'),
(89, 1, 316, -0.138743000, 'order', 'completed', 'balance', 'ORDER-316', 'Order #316 - Service #3', 99.141805860, '127.0.0.1', '2026-05-26 07:11:49', '2026-05-26 07:11:49'),
(90, 1, 317, -0.140004300, 'order', 'completed', 'balance', 'ORDER-317', 'Order #317 - Service #3', 99.000540260, '127.0.0.1', '2026-05-26 07:12:10', '2026-05-26 07:12:10'),
(91, 1, 318, -0.140004300, 'order', 'completed', 'balance', 'ORDER-318', 'Order #318 - Service #3', 98.860535960, '127.0.0.1', '2026-05-26 07:23:16', '2026-05-26 07:23:16'),
(92, 1, 319, -0.140004300, 'order', 'completed', 'balance', 'ORDER-319', 'Order #319 - Service #3', 98.720531660, '127.0.0.1', '2026-05-26 07:25:33', '2026-05-26 07:25:33'),
(93, 1, 320, -0.140004300, 'order', 'completed', 'balance', 'ORDER-320', 'Order #320 - Service #3', 98.580527360, '127.0.0.1', '2026-05-26 07:26:08', '2026-05-26 07:26:08'),
(94, 1, 321, -0.140004300, 'order', 'completed', 'balance', 'ORDER-321', 'Order #321 - Service #3', 98.440523060, '127.0.0.1', '2026-05-26 07:26:32', '2026-05-26 07:26:32'),
(95, 1, 322, -0.140004300, 'order', 'completed', 'balance', 'ORDER-322', 'Order #322 - Service #3', 98.300518760, '127.0.0.1', '2026-05-26 07:26:53', '2026-05-26 07:26:53'),
(96, 1, 323, -0.155139900, 'order', 'completed', 'balance', 'ORDER-323', 'Order #323 - Service #3', 98.130243260, '127.0.0.1', '2026-05-26 07:27:02', '2026-05-26 07:27:02'),
(97, 1, 324, -0.140004300, 'order', 'completed', 'balance', 'ORDER-324', 'Order #324 - Service #3', 98.005374560, '127.0.0.1', '2026-05-26 07:27:41', '2026-05-26 07:27:41');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `balance` decimal(15,8) NOT NULL DEFAULT 4.00000000,
  `spent` decimal(15,8) NOT NULL DEFAULT 4.00000000,
  `api_key` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `timezone` int(11) NOT NULL DEFAULT 14400,
  `lang` varchar(255) NOT NULL DEFAULT 'en',
  `currency` varchar(255) NOT NULL DEFAULT 'USD',
  `level` enum('retail','agent','distributor') NOT NULL DEFAULT 'retail',
  `role` enum('member','admin') NOT NULL DEFAULT 'member',
  `transfer_code` varchar(255) DEFAULT NULL,
  `referral_code` varchar(255) DEFAULT NULL,
  `two_factor_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `two_factor_secret` varchar(255) DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `domain` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `phone`, `email_verified_at`, `password`, `balance`, `spent`, `api_key`, `is_active`, `timezone`, `lang`, `currency`, `level`, `role`, `transfer_code`, `referral_code`, `two_factor_enabled`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `created_at`, `updated_at`, `domain`) VALUES
(1, 'smmpanel', 'smmkay', 'xoankhong00@gmail.com', NULL, NULL, '$2y$12$i4iSiSV5GLp1paxFCKaLue2ESjLWibmqvCoM6dqpu1PW8zoSKVm4e', 0.79981719, 0.00000000, 'eoGxhOLgB75auPlE50CU13ohIvt9DCZy', 1, -50400, 'vi', 'USD', 'retail', 'admin', 'fdIeT4ey', 'td9txVuh', 0, 'BICMHKC6PX3KP4MC', NULL, NULL, 'MVGC4zc4BlQlBsfUyoTizOLXxxYDrfAlApp5XHyUqObqUO3G1s7ifh70VVts', '2026-04-15 15:50:18', '2026-05-28 14:16:25', '127.0.0.1'),
(8, 'PHAM QUOC DUY', 'smmkay123', 'smmkay123@gmail.com', NULL, NULL, '$2y$12$yzdOYcoXA5nIZMw5XBgmDudYUHat6IBnE7ty6JCA2BXIakQ4/BC62', 20.00000000, 0.00000000, 'OiNriG0YeYkkegNuFP30fBFuBWI1QCQK', 1, 14400, 'vi', 'USD', 'retail', 'member', NULL, 'kwg0CvAc', 0, NULL, NULL, NULL, 'ncT2jFNpWndGxLCyN4VLrDVqkk5J6HiBF8F836vFoCdHoJNYTEAKYlTxKixC', '2026-04-26 09:06:51', '2026-04-26 09:48:40', '127.0.0.1'),
(9, 'Quốc Duy', 'smmkay2222131', 'smmkay2222131@gmail.com', NULL, NULL, '$2y$12$9heMGaYVndWiRlPVnDmbd.Q5l1hWVJGX.caTNFpJCo6fGm6OvbR2S', 55.00000000, 0.00000000, 'j77kbhgQCumtyiAAXdHMzohngZrpL9KH', 1, 14400, 'vi', 'USD', 'retail', 'member', NULL, 'vj8Ra5sD', 0, NULL, NULL, NULL, 'iFo701XY4LJZFEYBUWRYkQ4D8hNEyyoukvlAKwIr5dWjZ56BL0k66cV8Bo12', '2026-04-26 09:15:54', '2026-05-03 12:18:49', '127.0.0.1'),
(10, 'PHAM QUOC DUY', 'admin2004', 'duybuntv2004@gmail.com', NULL, NULL, '$2y$12$VOvezGBLulhmUEZoZNN8Eup2ZvtZ0GVb.QQzEh3iXTVIPT09cfML6', 0.00000000, 0.00000000, 'B1skjc93xgKbfwjGtUr0MhMLQHi73N1w', 1, 14400, 'vi', 'USD', 'retail', 'admin', NULL, 'yekK8O9f', 0, NULL, NULL, NULL, 'amjJt88bmYuBCHpI8Nt7UyVsBtRmQCOYLJtsQwevhrIaicuXDoEZ96SBk9k8', '2026-05-08 08:18:14', '2026-05-08 09:06:44', 'localhost'),
(11, 'Quốc Duy', 'smmkay2222', 'smmkay2222@gmail.com', NULL, NULL, '$2y$12$oZdXeKOLUbAmPiwkesFLBe66ElUMXR4k6hADD927x4Ncj/d6DsCJS', 0.00000000, 0.00000000, 'POp0L2KEU1ndQIicWaT5uylD5jh4fPEF', 1, 14400, 'vi', 'USD', 'retail', 'member', NULL, 'Zq4gSEn7', 0, NULL, NULL, NULL, 'M2xBSPADmtgcSsiwJdja6Ebcb7u8js3GWJrK7rjiyOiGmXHNXpo3Ofs2N3Qu', '2026-05-12 06:03:33', '2026-05-12 06:03:33', '127.0.0.1'),
(12, 'Facebook', 'quocduy', 'duybuntv2@gmail.com', NULL, NULL, '$2y$12$GH.zP71GRMmOEKJencN97.RdkLJYQ6GKDv/5NkAP/hUOaxvqvH4P6', 0.00000000, 0.00000000, 'Ba8qNtGIao4xA7SaSWWC35T3zY2QoPvm', 1, 14400, 'en', 'USD', 'distributor', 'admin', NULL, 'b6QnHWfP', 0, NULL, NULL, NULL, NULL, '2026-05-21 05:29:54', '2026-05-21 05:29:54', '127.0.0.2'),
(13, 'Quốc Duy', 'smmkay2', 'quocduy1102044@gmail.com', NULL, NULL, '$2y$12$tFo.NyGIJTGNXuk2bZZwWe0FWmQK0jgMw.5FG3/f93/37RdSTcn1q', 4.00000000, 0.00000000, 'vHcIbZDl8dlFeoeaX4ULh6ckp22ZjhGg', 1, 14400, 'en', 'USD', 'retail', 'member', 'MFAgQtas', 'YqB7z9RQ', 0, NULL, NULL, NULL, 'aWnFi2fQNiaudWKKy19NonLirqE3WjnBlTjFJcgMgbO7O81mRPA1694qf0Kn', '2026-05-23 04:46:09', '2026-05-23 06:19:34', '127.0.0.1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_custom_rates`
--

CREATE TABLE `user_custom_rates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` int(11) NOT NULL DEFAULT 0,
  `rate` decimal(15,8) DEFAULT NULL,
  `percent` decimal(8,2) DEFAULT NULL,
  `domain` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user_custom_rates`
--

INSERT INTO `user_custom_rates` (`id`, `user_id`, `service_id`, `rate`, `percent`, `domain`, `created_at`, `updated_at`) VALUES
(10, 9, 3, 0.50000000, NULL, '127.0.0.1', '2026-05-09 07:59:44', '2026-05-09 08:13:50'),
(11, 1, 3, NULL, 10.00, '127.0.0.1', '2026-05-09 08:21:27', '2026-05-09 08:51:50');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_type_created_at_index` (`type`,`created_at`),
  ADD KEY `activity_logs_user_id_index` (`user_id`),
  ADD KEY `activity_logs_domain_index` (`domain`),
  ADD KEY `activity_logs_created_at_index` (`created_at`);

--
-- Chỉ mục cho bảng `affiliates`
--
ALTER TABLE `affiliates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `affiliates_referrer_id_referred_id_unique` (`referrer_id`,`referred_id`),
  ADD KEY `affiliates_referrer_id_status_index` (`referrer_id`,`status`),
  ADD KEY `affiliates_referred_id_status_index` (`referred_id`,`status`),
  ADD KEY `affiliates_referral_code_index` (`referral_code`),
  ADD KEY `affiliates_status_index` (`status`),
  ADD KEY `affiliates_created_at_index` (`created_at`);

--
-- Chỉ mục cho bảng `api_providers`
--
ALTER TABLE `api_providers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `api_providers_name_domain_unique` (`name`,`domain`),
  ADD KEY `api_providers_type_index` (`type`),
  ADD KEY `api_providers_status_index` (`status`),
  ADD KEY `api_providers_created_at_index` (`created_at`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_platform_id_index` (`platform_id`),
  ADD KEY `categories_status_index` (`status`),
  ADD KEY `categories_created_at_index` (`created_at`);

--
-- Chỉ mục cho bảng `child_panels`
--
ALTER TABLE `child_panels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `child_panels_domain_panel_unique` (`domain_panel`),
  ADD KEY `child_panels_user_id_index` (`user_id`),
  ADD KEY `child_panels_domain_index` (`domain`),
  ADD KEY `child_panels_domain_panel_index` (`domain_panel`),
  ADD KEY `child_panels_access_index` (`access`),
  ADD KEY `child_panels_status_index` (`status`),
  ADD KEY `child_panels_created_at_index` (`created_at`);

--
-- Chỉ mục cho bảng `configs`
--
ALTER TABLE `configs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `configs_user_id_index` (`user_id`),
  ADD KEY `configs_status_index` (`status`),
  ADD KEY `configs_created_at_index` (`created_at`);

--
-- Chỉ mục cho bảng `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_domain_code_unique` (`domain`,`code`),
  ADD KEY `coupons_status_start_date_end_date_index` (`status`,`start_date`,`end_date`),
  ADD KEY `coupons_domain_index` (`domain`);

--
-- Chỉ mục cho bảng `coupon_usages`
--
ALTER TABLE `coupon_usages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coupon_usages_coupon_id_created_at_index` (`coupon_id`,`created_at`),
  ADD KEY `coupon_usages_user_id_created_at_index` (`user_id`,`created_at`),
  ADD KEY `coupon_usages_item_type_item_id_index` (`item_type`,`item_id`),
  ADD KEY `coupon_usages_domain_index` (`domain`);

--
-- Chỉ mục cho bảng `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `currency_code_unique` (`code`),
  ADD KEY `currency_status_index` (`status`),
  ADD KEY `currency_domain_index` (`domain`),
  ADD KEY `currency_code_index` (`code`),
  ADD KEY `currency_status_domain_index` (`status`,`domain`),
  ADD KEY `currency_created_at_index` (`created_at`);

--
-- Chỉ mục cho bảng `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_status_start_date_end_date_index` (`status`,`start_date`,`end_date`),
  ADD KEY `events_domain_index` (`domain`),
  ADD KEY `events_created_at_index` (`created_at`);

--
-- Chỉ mục cho bảng `event_spins`
--
ALTER TABLE `event_spins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_spins_event_id_user_id_created_at_index` (`event_id`,`user_id`,`created_at`),
  ADD KEY `event_spins_user_id_index` (`user_id`),
  ADD KEY `event_spins_created_at_index` (`created_at`);

--
-- Chỉ mục cho bảng `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `languages_name_unique` (`name`),
  ADD UNIQUE KEY `languages_code_unique` (`code`),
  ADD KEY `languages_status_index` (`status`),
  ADD KEY `languages_code_index` (`code`),
  ADD KEY `languages_created_at_index` (`created_at`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_created_at_index` (`created_at`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_index` (`user_id`),
  ADD KEY `orders_service_id_index` (`service_id`),
  ADD KEY `orders_status_index` (`status`),
  ADD KEY `orders_created_at_index` (`created_at`),
  ADD KEY `orders_provider_id_index` (`provider_id`),
  ADD KEY `orders_user_id_status_index` (`user_id`,`status`),
  ADD KEY `orders_user_id_created_at_index` (`user_id`,`created_at`);

--
-- Chỉ mục cho bảng `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payments_transaction_id_unique` (`transaction_id`),
  ADD KEY `payments_user_id_status_index` (`user_id`,`status`),
  ADD KEY `payments_payment_method_id_status_index` (`payment_method_id`,`status`),
  ADD KEY `payments_status_created_at_index` (`status`,`created_at`),
  ADD KEY `payments_transaction_id_index` (`transaction_id`),
  ADD KEY `payments_domain_index` (`domain`);

--
-- Chỉ mục cho bảng `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_methods_status_index` (`status`),
  ADD KEY `payment_methods_status_position_index` (`status`,`position`),
  ADD KEY `payment_methods_currency_index` (`currency`),
  ADD KEY `payment_methods_domain_index` (`domain`),
  ADD KEY `payment_methods_type_index` (`type`),
  ADD KEY `payment_methods_method_payment_id_index` (`method_payment_id`);

--
-- Chỉ mục cho bảng `payment_method_groups`
--
ALTER TABLE `payment_method_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_method_groups_domain_index` (`domain`),
  ADD KEY `payment_method_groups_status_index` (`status`);

--
-- Chỉ mục cho bảng `platforms`
--
ALTER TABLE `platforms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `platforms_status_index` (`status`),
  ADD KEY `platforms_position_index` (`position`),
  ADD KEY `platforms_created_at_index` (`created_at`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_product_group_id_foreign` (`product_group_id`),
  ADD KEY `products_domain_index` (`domain`),
  ADD KEY `products_product_category_id_index` (`product_category_id`),
  ADD KEY `products_status_index` (`status`),
  ADD KEY `products_type_index` (`type`);

--
-- Chỉ mục cho bảng `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_categories_domain_index` (`domain`),
  ADD KEY `product_categories_status_index` (`status`);

--
-- Chỉ mục cho bảng `product_goods`
--
ALTER TABLE `product_goods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_goods_warehouse_id_index` (`warehouse_id`),
  ADD KEY `product_goods_used_index` (`used`);

--
-- Chỉ mục cho bảng `product_groups`
--
ALTER TABLE `product_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_groups_domain_index` (`domain`);

--
-- Chỉ mục cho bảng `product_orders`
--
ALTER TABLE `product_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_orders_domain_index` (`domain`),
  ADD KEY `product_orders_user_id_index` (`user_id`),
  ADD KEY `product_orders_status_index` (`status`),
  ADD KEY `product_orders_product_id_index` (`product_id`);

--
-- Chỉ mục cho bảng `product_warehouses`
--
ALTER TABLE `product_warehouses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_warehouses_domain_index` (`domain`);

--
-- Chỉ mục cho bảng `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_category_id_status_index` (`category_id`,`status`),
  ADD KEY `services_status_type_index` (`status`,`type`),
  ADD KEY `services_provider_name_index` (`provider_name`),
  ADD KEY `services_created_at_index` (`created_at`),
  ADD KEY `services_domain_index` (`domain`);

--
-- Chỉ mục cho bảng `service_sync_logs`
--
ALTER TABLE `service_sync_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_sync_logs_domain_is_read_index` (`domain`,`is_read`),
  ADD KEY `service_sync_logs_service_id_index` (`service_id`),
  ADD KEY `service_sync_logs_created_at_index` (`created_at`),
  ADD KEY `service_sync_logs_log_type_index` (`log_type`),
  ADD KEY `service_sync_logs_sync_batch_index` (`sync_batch`);

--
-- Chỉ mục cho bảng `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tickets_subject_id_foreign` (`subject_id`),
  ADD KEY `tickets_assigned_to_foreign` (`assigned_to`),
  ADD KEY `tickets_domain_index` (`domain`),
  ADD KEY `tickets_user_id_index` (`user_id`),
  ADD KEY `tickets_status_index` (`status`),
  ADD KEY `tickets_priority_index` (`priority`),
  ADD KEY `tickets_created_at_index` (`created_at`),
  ADD KEY `tickets_user_id_status_index` (`user_id`,`status`);

--
-- Chỉ mục cho bảng `ticket_reply`
--
ALTER TABLE `ticket_reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_reply_ticket_id_index` (`ticket_id`),
  ADD KEY `ticket_reply_user_id_index` (`user_id`),
  ADD KEY `ticket_reply_created_at_index` (`created_at`),
  ADD KEY `ticket_reply_ticket_id_created_at_index` (`ticket_id`,`created_at`);

--
-- Chỉ mục cho bảng `ticket_subjects`
--
ALTER TABLE `ticket_subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_subjects_status_index` (`status`),
  ADD KEY `ticket_subjects_sort_order_index` (`sort_order`);

--
-- Chỉ mục cho bảng `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_user_id_index` (`user_id`),
  ADD KEY `transactions_order_id_index` (`order_id`),
  ADD KEY `transactions_type_index` (`type`),
  ADD KEY `transactions_status_index` (`status`),
  ADD KEY `transactions_created_at_index` (`created_at`),
  ADD KEY `transactions_user_id_created_at_index` (`user_id`,`created_at`),
  ADD KEY `transactions_user_id_domain_index` (`user_id`,`domain`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_api_key_unique` (`api_key`),
  ADD UNIQUE KEY `users_transfer_code_unique` (`transfer_code`),
  ADD UNIQUE KEY `users_referral_code_unique` (`referral_code`),
  ADD KEY `users_email_index` (`email`),
  ADD KEY `users_username_index` (`username`),
  ADD KEY `users_api_key_index` (`api_key`),
  ADD KEY `users_is_active_index` (`is_active`),
  ADD KEY `users_created_at_index` (`created_at`);

--
-- Chỉ mục cho bảng `user_custom_rates`
--
ALTER TABLE `user_custom_rates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ucr_user_service_domain_unique` (`user_id`,`service_id`,`domain`),
  ADD KEY `user_custom_rates_user_id_index` (`user_id`),
  ADD KEY `user_custom_rates_service_id_index` (`service_id`),
  ADD KEY `user_custom_rates_domain_index` (`domain`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT cho bảng `affiliates`
--
ALTER TABLE `affiliates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `api_providers`
--
ALTER TABLE `api_providers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `child_panels`
--
ALTER TABLE `child_panels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `configs`
--
ALTER TABLE `configs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `coupon_usages`
--
ALTER TABLE `coupon_usages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `currency`
--
ALTER TABLE `currency`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=499;

--
-- AUTO_INCREMENT cho bảng `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `event_spins`
--
ALTER TABLE `event_spins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT cho bảng `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=325;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT cho bảng `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `payment_method_groups`
--
ALTER TABLE `payment_method_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `platforms`
--
ALTER TABLE `platforms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `product_goods`
--
ALTER TABLE `product_goods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `product_groups`
--
ALTER TABLE `product_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `product_orders`
--
ALTER TABLE `product_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT cho bảng `product_warehouses`
--
ALTER TABLE `product_warehouses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `service_sync_logs`
--
ALTER TABLE `service_sync_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT cho bảng `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `ticket_reply`
--
ALTER TABLE `ticket_reply`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `ticket_subjects`
--
ALTER TABLE `ticket_subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `user_custom_rates`
--
ALTER TABLE `user_custom_rates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `affiliates`
--
ALTER TABLE `affiliates`
  ADD CONSTRAINT `affiliates_referred_id_foreign` FOREIGN KEY (`referred_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `affiliates_referrer_id_foreign` FOREIGN KEY (`referrer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `coupon_usages`
--
ALTER TABLE `coupon_usages`
  ADD CONSTRAINT `coupon_usages_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coupon_usages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `user_custom_rates`
--
ALTER TABLE `user_custom_rates`
  ADD CONSTRAINT `user_custom_rates_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
