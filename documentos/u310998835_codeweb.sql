-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 13-09-2024 a las 15:47:25
-- Versión del servidor: 10.11.8-MariaDB-cll-lve
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u310998835_codeweb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:25:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:11:\"Leer cursos\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:12:\"Crear cursos\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:17:\"Actualizar cursos\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:15:\"Eliminar cursos\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:13:\"Ver dashboard\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:10:\"Crear role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:11:\"Editar role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:11:\"Listar role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:13:\"Eliminar role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:13:\"Leer usuarios\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:15:\"Editar usuarios\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:14:\"Crear usuarios\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:17:\"Eliminar usuarios\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:15:\"Crear categoria\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:16:\"Editar categoria\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:17:\"Listar categorias\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:18:\"Eliminar categoria\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:11:\"Crear nivel\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:12:\"Editar nivel\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:14:\"Listar niveles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:14:\"Eliminar nivel\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:12:\"Crear precio\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:13:\"Editar precio\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:14:\"Listar precios\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:15:\"Eliminar precio\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}}s:5:\"roles\";a:3:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:10:\"Estudiante\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:10:\"Instructor\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:13:\"Administrador\";s:1:\"c\";s:3:\"web\";}}}', 1726251951);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Desarrollo Web', '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(2, 'Diseño Web', '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(3, 'Desarrollo Móvil', '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(4, 'Diseño Móvil', '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(5, 'Desarrollo de Videojuegos', '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(6, 'Diseño de Videojuegos', '2024-08-30 15:54:52', '2024-08-30 15:54:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `summary` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `image_path` varchar(255) DEFAULT NULL,
  `video_path` varchar(255) DEFAULT NULL,
  `wellcome_message` text DEFAULT NULL,
  `goodbye_message` text DEFAULT NULL,
  `observation` text DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `level_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `price_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `courses`
--

INSERT INTO `courses` (`id`, `title`, `slug`, `summary`, `description`, `published_at`, `created_at`, `updated_at`, `status`, `image_path`, `video_path`, `wellcome_message`, `goodbye_message`, `observation`, `user_id`, `level_id`, `category_id`, `price_id`) VALUES
(1, 'Java Avanzado', 'java-avanzado', NULL, NULL, NULL, '2024-08-30 15:59:25', '2024-08-30 15:59:25', 3, 'courses/images/qNjVoHkx0Qgm8Zanokvol8Ukw5y7AjHXtMLHnc5I.jpg', NULL, NULL, NULL, NULL, 2, 3, 1, 6),
(2, 'Sistemas Informáticos', 'sistemas-informaticos', 'flañfl jdlfj añlfjlasdjflksad', 'ksfkljh kjlsf hjk &nbsp;fasjlkñf jdlñjf ajflk jalfjñalk', NULL, '2024-09-11 17:31:46', '2024-09-11 17:31:56', 3, 'courses/images/tCClolg6FhFyULmZXOFaS0r8Kw8AtOXayPdhuooR.png', NULL, NULL, NULL, NULL, 2, 1, 1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `course_user`
--

CREATE TABLE `course_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `course_user`
--

INSERT INTO `course_user` (`id`, `course_id`, `user_id`, `created_at`, `updated_at`) VALUES
(3, 2, 8, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `goals`
--

CREATE TABLE `goals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `position` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `goals`
--

INSERT INTO `goals` (`id`, `name`, `course_id`, `position`, `created_at`, `updated_at`) VALUES
(1, 'n,fd lafsadlñ nfñ', 1, 1, '2024-08-30 15:59:31', '2024-08-30 15:59:31'),
(2, 'jkfalksdjflkjads', 1, 2, '2024-08-30 15:59:32', '2024-08-30 15:59:32'),
(3, 'fmljsdnfjklnsañ', 1, 3, '2024-08-30 15:59:33', '2024-08-30 15:59:33'),
(4, 'gadgadsg gdag gad', 2, 1, '2024-09-11 17:32:04', '2024-09-11 17:32:04'),
(5, 'dfagdadfg', 2, 2, '2024-09-11 17:32:05', '2024-09-11 17:32:05'),
(6, 'gfdhg ads gf', 2, 3, '2024-09-11 17:32:06', '2024-09-11 17:32:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `images`
--

CREATE TABLE `images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `path` varchar(255) NOT NULL,
  `imageable_type` varchar(255) NOT NULL,
  `imageable_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `images`
--

INSERT INTO `images` (`id`, `path`, `imageable_type`, `imageable_id`, `created_at`, `updated_at`) VALUES
(1, 'courses/images/qNjVoHkx0Qgm8Zanokvol8Ukw5y7AjHXtMLHnc5I.jpg', 'App\\Models\\Course', 1, '2024-08-30 15:59:25', '2024-08-30 15:59:25'),
(2, 'courses/images/tCClolg6FhFyULmZXOFaS0r8Kw8AtOXayPdhuooR.png', 'App\\Models\\Course', 2, '2024-09-11 17:31:46', '2024-09-11 17:31:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lessons`
--

CREATE TABLE `lessons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `platform` int(11) NOT NULL,
  `video_path` varchar(255) DEFAULT NULL,
  `video_original_name` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `document_original_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `document_path` varchar(255) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `position` int(11) NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `is_preview` tinyint(1) NOT NULL DEFAULT 0,
  `is_processed` tinyint(1) NOT NULL DEFAULT 0,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `lessons`
--

INSERT INTO `lessons` (`id`, `name`, `slug`, `platform`, `video_path`, `video_original_name`, `image_path`, `document_original_name`, `description`, `document_path`, `duration`, `position`, `is_published`, `is_preview`, `is_processed`, `section_id`, `created_at`, `updated_at`) VALUES
(36, 'Indigo', 'indigo', 1, 'courses/lessons/pMhO88yNUDNeBM0AL9Cr7xKGRbP3ZBMqHgXh5HRj.mp4', 'Lola Indigo - LA REINA (Video Oficial).mp4', NULL, '[SOLO PARA LOS DEL PROYECTO] Requisitos.pdf', 'hlkfh alkj hjkfladhlkjfhljkahfjkh adñlfhsadhfñlandflkñsa', 'courses/documents/0NSEQCvy8yfSecEYNmqd0EQBPp3Z72OF50NtmsuW.pdf', NULL, 1, 1, 0, 0, 10, '2024-09-05 09:47:16', '2024-09-05 09:47:16'),
(37, 'Billboard hot hits', 'billboard-hot-hits', 2, NULL, 'https://youtu.be/BYPxCDQa3QI?si=-o1QC8kQ87sELXH7', NULL, 'FTT1.pdf', 'lñksajfljlk fljñaj fljsadlkfjkl fjñlajflñjaslkf', 'courses/documents/oWjCFOZ9iZ4uu8oWsCMjOYfeHqLz8A0Ov6PzDAgP.pdf', NULL, 2, 1, 0, 0, 10, '2024-09-05 09:48:20', '2024-09-05 09:48:20'),
(40, 'No Doub sin pdf', 'no-doub-sin-pdf', 1, 'courses/lessons/tiO51p3hysxZerUA2Fb2tDTVqFxmIC2wFdhGI3yE.mp4', 'No Doubt - Dont Speak (Official 4K Music Video).mp4', NULL, 'FTT1.pdf', 'dlakj flñjflajfklñj ldkfjalkjflñjflñajflñajfjalfjasñljfñklasj fl', 'courses/documents/KGsU597HkUJ2LDyHfl0axRol0dXo92TZo2aXIrJI.pdf', NULL, 3, 1, 0, 0, 10, '2024-09-05 09:54:13', '2024-09-05 09:55:49'),
(49, 'Black eyed peas', 'black-eyed-peas', 1, 'courses/lessons/DqiYmVZZkhluSAek095cpLHJpGpq4SsXQsZKYLD1.mp4', 'The Black Eyed Peas - Meet Me Halfway (Official Music Video).mp4', NULL, 'FTT1.pdf', 'asfdsfad', 'courses/documents/uqBs5pTgwhFe19IwpkJbjgjo2bWaWbZgpc60JBoc.pdf', NULL, 4, 1, 0, 0, 10, '2024-09-07 16:58:18', '2024-09-09 07:55:45'),
(50, 'Nelly Furtado ft', 'nelly-furtado-ft', 1, 'courses/lessons/cztqY9057EEdegg4XxwFIzrSG2123aqMWDpZyfYB.mp4', 'Nelly Furtado - Say It Right (Official Music Video).mp4', NULL, 'FTT3.pdf', 'afdsf df sfdsaf fdsda fdsfsadf', 'courses/documents/ETydXW2tymFKMNQeVXvwuQ6ST9UjJzqTEQYZHIpS.pdf', NULL, 5, 1, 0, 0, 10, '2024-09-07 16:58:59', '2024-09-09 07:55:25'),
(51, 'Karol G youtube', 'karol-g-youtube', 2, NULL, 'https://www.youtube.com/watch?v=rohaBCZmp3o', NULL, 'FTT2.pdf', 'sdfasdfsad fdsaf sad fdsaf sfd dfsaf ds', 'courses/documents/YN55g4UZALvbHIwipCUVbjV5FcOqFz8tXdkxYuEl.pdf', NULL, 6, 1, 0, 0, 10, '2024-09-07 16:59:52', '2024-09-07 16:59:52'),
(52, 'Sin video haber que pasa', 'sin-video-haber-que-pasa', 1, NULL, NULL, NULL, 'FTT1.pdf', 'jflñadsj flkjdalfk', 'courses/documents/HWMDPNPcoxeOITMtNHkKXnyKNhP1guOu5FkvLZXu.pdf', NULL, 1, 1, 0, 0, 11, '2024-09-09 09:55:14', '2024-09-09 09:55:14'),
(54, 'Sin document haber que pasa, Indigo again', 'sin-document-haber-que-pasa-indigo-again', 1, 'courses/lessons/gmGrQYNTnHNqyQo6MmyGHuDEqGC78yeTO1Rq3HJ3.mp4', 'Lola Indigo - LA REINA (Video Oficial).mp4', NULL, NULL, 'jfaj jajkflj dfk falkfj ldjflkjfñlajflkjdflk ñajf', NULL, NULL, 2, 1, 0, 0, 11, '2024-09-09 10:05:09', '2024-09-09 10:05:09'),
(56, 'Primera parte', 'primera-parte', 1, 'courses/lessons/C9xvYkrCwsorfYBIt0A67QCsypSfon92mq0o4Rol.mp4', 'SI Clase 1 Parte 1 - Google Drive.mp4', NULL, NULL, 'fanñfnlñnf', NULL, NULL, 1, 1, 0, 0, 12, '2024-09-11 17:34:21', '2024-09-11 17:34:21'),
(57, 'Segunda parte', 'segunda-parte', 1, 'courses/lessons/ZCPWZ2awL3ggzN0Jpg89WFntYWZ5iudAPFuqIjSV.mp4', 'SI Clase 1 Parte 1 - Google Drive.mp4', NULL, NULL, 'fadsfdasfasf', NULL, NULL, 2, 1, 0, 0, 12, '2024-09-11 17:34:57', '2024-09-11 17:34:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lesson_user`
--

CREATE TABLE `lesson_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lesson_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `levels`
--

CREATE TABLE `levels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `levels`
--

INSERT INTO `levels` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Principiante', '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(2, 'Intermedio', '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(3, 'Azanzado', '2024-08-30 15:54:52', '2024-08-30 15:54:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_05_01_174836_add_two_factor_columns_to_users_table', 1),
(5, '2024_05_01_174928_create_personal_access_tokens_table', 1),
(6, '2024_05_04_090720_create_levels_table', 1),
(7, '2024_05_04_090827_create_categories_table', 1),
(8, '2024_05_04_091014_create_prices_table', 1),
(9, '2024_05_04_091124_create_courses_table', 1),
(10, '2024_05_15_172039_create_goals_table', 1),
(11, '2024_05_21_164340_create_course_user_table', 1),
(12, '2024_05_23_090921_create_reviews_table', 1),
(13, '2024_05_25_154350_create_images_table', 1),
(14, '2024_06_11_083128_create_requirements_table', 1),
(15, '2024_06_11_143237_create_sections_table', 1),
(16, '2024_06_12_143836_create_lessons_table', 1),
(17, '2024_06_25_084143_create_lesson_user_table', 1),
(18, '2024_07_02_160613_create_permission_tables', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 8),
(1, 'App\\Models\\User', 10),
(1, 'App\\Models\\User', 11),
(1, 'App\\Models\\User', 12),
(1, 'App\\Models\\User', 15),
(1, 'App\\Models\\User', 16),
(1, 'App\\Models\\User', 17),
(1, 'App\\Models\\User', 18),
(1, 'App\\Models\\User', 19),
(1, 'App\\Models\\User', 20),
(1, 'App\\Models\\User', 21),
(1, 'App\\Models\\User', 22),
(1, 'App\\Models\\User', 23),
(1, 'App\\Models\\User', 24),
(1, 'App\\Models\\User', 25),
(1, 'App\\Models\\User', 26),
(1, 'App\\Models\\User', 27),
(1, 'App\\Models\\User', 28),
(1, 'App\\Models\\User', 29),
(1, 'App\\Models\\User', 30),
(1, 'App\\Models\\User', 31),
(1, 'App\\Models\\User', 32),
(1, 'App\\Models\\User', 33),
(1, 'App\\Models\\User', 34),
(1, 'App\\Models\\User', 35),
(1, 'App\\Models\\User', 36),
(1, 'App\\Models\\User', 37),
(1, 'App\\Models\\User', 38),
(1, 'App\\Models\\User', 39),
(1, 'App\\Models\\User', 40),
(1, 'App\\Models\\User', 41),
(2, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 43),
(2, 'App\\Models\\User', 44),
(2, 'App\\Models\\User', 45),
(2, 'App\\Models\\User', 46),
(3, 'App\\Models\\User', 1),
(3, 'App\\Models\\User', 42);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('81migue81@gmail.com', '$2y$12$MFL47ZUXaCDTdQ6Dy.alpuq9F8St0AvfGmAIOXZGjkuMgWjoFNKhy', '2024-09-09 19:28:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Leer cursos', 'web', '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(2, 'Crear cursos', 'web', '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(3, 'Actualizar cursos', 'web', '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(4, 'Eliminar cursos', 'web', '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(5, 'Ver dashboard', 'web', '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(6, 'Crear role', 'web', '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(7, 'Editar role', 'web', '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(8, 'Listar role', 'web', '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(9, 'Eliminar role', 'web', '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(10, 'Leer usuarios', 'web', '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(11, 'Editar usuarios', 'web', '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(12, 'Crear usuarios', 'web', '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(13, 'Eliminar usuarios', 'web', '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(14, 'Crear categoria', 'web', '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(15, 'Editar categoria', 'web', '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(16, 'Listar categorias', 'web', '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(17, 'Eliminar categoria', 'web', '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(18, 'Crear nivel', 'web', '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(19, 'Editar nivel', 'web', '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(20, 'Listar niveles', 'web', '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(21, 'Eliminar nivel', 'web', '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(22, 'Crear precio', 'web', '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(23, 'Editar precio', 'web', '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(24, 'Listar precios', 'web', '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(25, 'Eliminar precio', 'web', '2024-08-30 15:54:52', '2024-08-30 15:54:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prices`
--

CREATE TABLE `prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `value` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `prices`
--

INSERT INTO `prices` (`id`, `value`, `created_at`, `updated_at`) VALUES
(1, 0, '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(2, 10, '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(3, 15, '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(4, 20, '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(5, 25, '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(6, 30, '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(7, 35, '2024-08-30 15:54:52', '2024-08-30 15:54:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `requirements`
--

CREATE TABLE `requirements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `position` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `requirements`
--

INSERT INTO `requirements` (`id`, `name`, `course_id`, `position`, `created_at`, `updated_at`) VALUES
(1, 'dsjh flkahsdf', 1, 1, '2024-08-30 15:59:37', '2024-08-30 15:59:37'),
(2, 'fkjadsnkljhdaskg', 1, 2, '2024-08-30 15:59:38', '2024-08-30 15:59:38'),
(3, 'gnkjang jklda', 1, 3, '2024-08-30 15:59:39', '2024-08-30 15:59:39'),
(4, 'adsfdas', 2, 1, '2024-09-11 17:32:11', '2024-09-11 17:32:11'),
(5, 'fasdfa', 2, 2, '2024-09-11 17:32:12', '2024-09-11 17:32:12'),
(6, 'fdasfa', 2, 3, '2024-09-11 17:32:12', '2024-09-11 17:32:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `comment` text DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Estudiante', 'web', '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(2, 'Instructor', 'web', '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(3, 'Administrador', 'web', '2024-08-30 15:54:52', '2024-08-30 15:54:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 2),
(3, 2),
(4, 2),
(5, 3),
(6, 3),
(7, 3),
(8, 3),
(9, 3),
(10, 3),
(11, 3),
(12, 3),
(13, 3),
(14, 3),
(15, 3),
(16, 3),
(17, 3),
(18, 3),
(19, 3),
(20, 3),
(21, 3),
(22, 3),
(23, 3),
(24, 3),
(25, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sections`
--

CREATE TABLE `sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `position` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sections`
--

INSERT INTO `sections` (`id`, `name`, `course_id`, `position`, `created_at`, `updated_at`) VALUES
(10, 'Primerita', 1, 1, '2024-09-05 09:46:23', '2024-09-05 09:46:23'),
(11, 'Segunda', 1, 2, '2024-09-09 09:54:32', '2024-09-09 09:54:32'),
(12, 'Primera Clase', 2, 1, '2024-09-11 17:32:50', '2024-09-11 17:32:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('9AaDtBpIuN197ed1H9iEvhrIzqlNtEXtzeotwoid', NULL, '138.246.253.15', 'quic-go-HTTP/3', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoib2t1QXoyM0JDb2pmeHBTSVk1TXQzeFdPc1YwSzRVYnVwQVgzWWZsWCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxODoiaHR0cHM6Ly9jb2Rld2ViLnB3Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1726223677),
('ap8payhcE2cLwT4FYGImJubTgUM28HiTUbKu3uHt', NULL, '2a02:4780:a:c0de::84', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUU9FaWFBMTFEZzM1YlVCdG9FOU9VZkZ3YUtDbGNVSGJySms3OTVxeCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxOToiaHR0cHM6Ly9jb2Rld2ViLnB3LiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1726190821),
('BIWX6BeprHhzhAOHK4eEygZZYtgGRx7zv2zACmKT', 1, '92.176.10.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVEhkOVczV0NFcWY2MUlvcGtWMzBPRTJ5ZEI3VFlvYkZLMUV0ZTBUYiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM5OiJodHRwczovL2NvZGV3ZWIucHcvY3Vyc29zL2phdmEtYXZhbnphZG8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1726166159),
('iiS0lDA9TXlpFI8kWnHowI9K2c8h8GOPvCfKmaSb', NULL, '205.169.39.46', 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiU2NpQVNTaUlyelRtZkVyaFpWWjFFdUFFNGhtU2FPRkJONnJrekhjUiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vY29kZXdlYi5wdy9yZWdpc3RlciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1726213997),
('OfaKL2iMx6Vy1nX5BaxcWchN3sY06izzcQSDSfTp', NULL, '195.178.110.135', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:122.0) Gecko/20100101 Firefox/122.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYXQza2w1eHJOQTh5R2Z5c2JsWWxNUnNuU1FOaWl6SG9NYVNnazFVUSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxODoiaHR0cHM6Ly9jb2Rld2ViLnB3Ijt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTg6Imh0dHBzOi8vY29kZXdlYi5wdyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1726194270),
('RuF0LUV73jWiCWUhVUjZq5y2AFsUCfp7LQxdhRZb', NULL, '205.169.39.46', 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRDQ0SnFtMGJjM3JQd1JsRzM0SE5GOHU2allUWUQyNThHam5rckY0QyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vY29kZXdlYi5wdy9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1726213997),
('uVsEwaevZuhS1Vk88gFTBJE64ce8o6AAt9CcnYED', NULL, '2a02:4780:a:c0de::84', 'Go-http-client/2.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiSVRCWWJ1ZnVJMzkyaHNxSU8xcDluWkRMOWlxNEJwV2lhWkRmZDZ0eiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1726190821),
('WzaPekSShD53yVAjmuE9TRcfWZ7ieEPmqwhnSvym', NULL, '205.169.39.46', 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOHNmb0ZEYWhxU05rYmU2NmJkWFJpZkpyUmxCYW1LNXIxNm5tNk5oeSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxODoiaHR0cHM6Ly9jb2Rld2ViLnB3Ijt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTg6Imh0dHBzOi8vY29kZXdlYi5wdyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1726213997),
('yXgdIANagMX0h4fOCpk7SutwO0bAe7U5QnHZbIab', NULL, '2a02:4780:a:c0de::84', 'Go-http-client/2.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiSGc0NkExTnN4T0xhVHlGbXRYcmRMTGd4RG9zUmNqRTY3V1JUd1BGWCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1726190821);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
(1, 'Michael Night', 'mNight@gmail.com', NULL, '$2y$12$4A0b6uPfrqzgXsM/LlFgiOE3chcfIc3slxzVV1K9xrZFziULzMady', NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-30 15:54:52', '2024-08-30 15:54:52'),
(2, 'Jacinto', 'jacinto99@hotmail.com', NULL, '$2y$12$3s.w1oSOohPNiqnKiYjqhOhIfB6QaO.lzir8/vnmZ3IC01WSYnFQK', NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-30 15:57:46', '2024-09-12 18:10:05'),
(8, 'Miguel', '81migue81@gmail.com', NULL, '$2y$12$/57aHJw4COqeYOUylGAgzeJyRXXVTr1p9HpbQIZL0R/xmT504XNQ.', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-09 19:27:33', '2024-09-12 17:01:19'),
(10, 'Rocío', 'rocio11@hotmail.com', NULL, '$2y$12$ze9K6fhZHcPWxdTFqsuQl.Ni78u1G2jMgadmzv3LsRpoUf16CYnbO', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-12 16:35:08', '2024-09-12 18:10:36'),
(11, 'María', 'maria22@hotmail.com', NULL, '$2y$12$DOllG3wMZB/jKmJCV20wqO44BPAf7wam9KA5a1pnEV7qUk7cYlSkq', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-12 16:35:35', '2024-09-12 18:10:48'),
(12, 'Luís', 'luis33@hotmail.com', NULL, '$2y$12$2ugl8QVX9mh4G4X8SzEK/O9nAt/cNfblcmUouMT4/C7Ci0Vk6eBAW', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-12 16:35:59', '2024-09-12 18:10:59'),
(15, 'Ramoncín', 'ramoncin66@gmail.com', NULL, '$2y$12$b3CXLIYYbokRSl2B5lqxkeRP7mCLE/zmzLs1p48XaNeucQRhggvSy', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-12 16:45:36', '2024-09-12 16:45:36'),
(16, 'Ramiro', 'ramiro77@gmail.com', NULL, '$2y$12$nYbLpg/XihFuEZv4Q/NQHO0DhXGVx2LER3Xx61JljmN89ay.JF.HW', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-12 16:46:13', '2024-09-12 16:46:13'),
(17, 'Eustaquio', 'eustaquio88@hotmail.com', NULL, '$2y$12$gjsidJhbh2ct5xfgcBn7W.7UcbAfPZooeihF8zBk/hFbdeSPeB1xW', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-12 16:46:49', '2024-09-12 18:01:51'),
(18, 'Leticia', 'leticia99@gmail.com', NULL, '$2y$12$V/OzA6W4mt6ociAPUaWrLOgFhB38eLg2smocV2NYd5wEc6R1hJxvK', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-12 16:47:23', '2024-09-12 16:47:23'),
(19, 'Tomás', 'tomas00@hotmail.com', NULL, '$2y$12$XSm8MNRUTLkkf80RdR/Hq.UIoOPyXDYvETVfkGgvizUPv2gBBNoVa', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-12 16:47:53', '2024-09-12 18:02:23'),
(20, 'Salvador', 'salvador12@gmail.com', NULL, '$2y$12$Y3YrkIbz4.b831FU.pIKi.NYZppFOs0KOV/qZVdoJKdeLarqaAB7S', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-12 16:48:24', '2024-09-12 16:48:24'),
(21, 'Elena', 'elena13@hotmail.com', NULL, '$2y$12$E5bITiwNivlM1M8jXlo4Ae7HIoeJhvVKnURfkCDj2Nd45cjpCGegO', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-12 16:49:44', '2024-09-12 18:02:55'),
(22, 'Sebastián', 'sebas14@hotmail.com', NULL, '$2y$12$364KQsykPnrFnsxjylSHbuFo4FckqgI/hYo9ZWtKfU6fbN9ZwKBQK', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-12 16:50:51', '2024-09-12 18:03:26'),
(23, 'Teresa', 'teresa15@hotmail.com', NULL, '$2y$12$Rd5tjCCgCKXMb0rLqhumsuvAdAvdr1JhMYEAH3eA30gGwZSy1GtbW', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-12 16:51:19', '2024-09-12 18:03:47'),
(24, 'Sauron', 'sauron16@gmail.com', NULL, '$2y$12$nxhO13/C2McQcObZ4yn.JucYNLLqpu3lNx/CQ9tS8pwJDabQPA2qy', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-12 16:51:47', '2024-09-12 16:51:47'),
(25, 'Paco', 'paco17@gmail.com', NULL, '$2y$12$1rWQOvyvtqYDEuGer7tkRupdPSMKaRoRl8W9hbdrw6sFZMcbagvwi', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-12 16:52:10', '2024-09-12 16:52:10'),
(26, 'Belinda', 'belinda18@gmail.com', NULL, '$2y$12$r96A6iGbmZkGacWnNsEj5uyoaF11QKj.bGLxnaRuCo3OLYZWgA3Kq', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-12 16:52:44', '2024-09-12 16:52:44'),
(27, 'Serafín', 'serafin19@gmail.com', NULL, '$2y$12$na74zbe/fb5ztg1A8kfATeI7/1NvQGfye2mEOt.8tQ7bGOEvMtm82', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-12 16:53:09', '2024-09-12 16:53:09'),
(28, 'Ana', 'ana21@gmail.com', NULL, '$2y$12$r2NbdKD8P9mITKVE/mpSYeTj12ZfAVIe4QKExmtrydky8TQ/CpW26', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-12 16:53:44', '2024-09-12 16:53:44'),
(29, 'Pelican', 'pelican23@hotmail.com', NULL, '$2y$12$rhRbuv3YMr3W8qOOCejHQu31Hrb1vxYhHefES9s1WVsdQNa.APYk2', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-12 16:54:14', '2024-09-12 18:04:36'),
(30, 'Lorenzo', 'lorenzo34@hotmail.com', NULL, '$2y$12$dcpZbZ/jz8Lzt44VM3na9.afVRNfVOqTGWqbbab/q.eNceBizAClu', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-12 16:54:57', '2024-09-12 18:05:04'),
(31, 'Lautaro', 'lautaro35@gmail.com', NULL, '$2y$12$lkaeEVPSMXk2JlEeqqeIluqBrX2.LsghddeBdX4cD58FcpXcXDndG', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-12 16:55:25', '2024-09-12 16:55:25'),
(32, 'Aaron', 'aaron36@gmail.com', NULL, '$2y$12$w6WW6Cdxr7YZgWZcmxaCQ.SRQiXJUJETjaA/jTelwRSggf5n5FWeW', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-12 16:55:57', '2024-09-12 16:55:57'),
(33, 'Sabino', 'sabino37@gmail.com', NULL, '$2y$12$ek8ujHgwXw3U5E/TCnRZa..hGQO9S78hzt8eGCPxfYD7JDoweiF4y', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-12 16:56:20', '2024-09-12 16:56:20'),
(34, 'Soliman', 'soliman38@gmail.com', NULL, '$2y$12$vJh8xFqjSsRwKfiVLUD.CuQ/Xk6cU.5F9Rw7RYyx9tW27RmZwfm6S', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-12 16:56:50', '2024-09-12 16:56:50'),
(35, 'Tulum', 'tulum39@gmail.com', NULL, '$2y$12$VLZ8lP/vjHe.nZL2S5.qbuMRuY9OnyQZPpVvDs4DSq1Xd6N6Mm.Ca', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-12 16:57:18', '2024-09-12 16:57:18'),
(36, 'Pepe', 'pepe25@hotmail.com', NULL, '$2y$12$IjQUqXJ0roIoA.IHPgVDTeLSU.aUHYKpx2tXXgPPI4PcQOVH7ewtu', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-12 16:57:46', '2024-09-12 18:07:36'),
(37, 'Catalina', 'catalina26@hotmail.com', NULL, '$2y$12$Gyc94Hkeej/hdjz4Me/TN.oRA1eD4sRCqFFxZJWEHfObwgvTVy4b6', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-12 16:58:22', '2024-09-12 18:07:56'),
(38, 'Corina', 'corina27@hotmail.com', NULL, '$2y$12$65h/cFhXoYEcWm0H4pd01ulZ6KELn2ezzBY/OQRkUjJz/NFkB8yVK', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-12 16:58:50', '2024-09-12 18:08:18'),
(39, 'Cecilia', 'cecilia28@gmail.com', NULL, '$2y$12$6cz3ODctrsylaFWMPAKq/.ig/RvJ.RfEX67aK9A228CqIg8m1N7zu', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-12 16:59:17', '2024-09-12 16:59:17'),
(40, 'Carolina', 'carolina29@gmail.com', NULL, '$2y$12$o/1ddlqLkGh/tqenqcYRM.xMYO1BB9CuD8sR.Iet8wXU02/d9ktES', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-12 16:59:47', '2024-09-12 16:59:47'),
(41, 'Cua', 'cua20@gmail.com', NULL, '$2y$12$u1KCTbh6RFfmmO3num.M.OvJJEcefjGOeOr9vQL2w1ga1SB5Pzkhy', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-12 17:00:50', '2024-09-12 17:00:50'),
(42, 'Peluca', 'peluca41@hotmail.com', NULL, '$2y$12$GrnahLYVBpOZ/Tgz315pOO6KXh5LuwwscSRbujJVL9fngMyyfxw2G', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-12 17:02:01', '2024-09-12 18:06:15'),
(43, 'Laredo', 'laredo71@gmail.com', NULL, '$2y$12$/a5ZV1up0y5vOMi85YrP0.WhxMmWlzo/0pOZhLotZGl5aQSAmWyom', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-12 17:02:59', '2024-09-12 17:03:52'),
(44, 'Lisandro', 'lisandro52@hotmail.com', NULL, '$2y$12$yFKxrp0BiF8Hq04KN6A3fu6j5XFt..Dc9f8fcwnAlWdh3.RN7XTWa', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-12 17:04:20', '2024-09-12 18:05:36'),
(45, 'Hugo', 'hugo53@hotmail.com', NULL, '$2y$12$QjOJYXmcrkIgvrfyC/vfQOKUxk5PAF/j0941av8mwtzAPXlbVrXdi', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-12 17:04:58', '2024-09-12 18:05:56'),
(46, 'Amanda', 'amanda54@gmail.com', NULL, '$2y$12$chiQj2vLhRth9./L/MImHurWBY4qH5cR8ATlcIaf1/mXIdgnZasHK', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-12 17:05:24', '2024-09-12 17:05:24');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `courses_slug_unique` (`slug`),
  ADD KEY `courses_user_id_foreign` (`user_id`),
  ADD KEY `courses_level_id_foreign` (`level_id`),
  ADD KEY `courses_category_id_foreign` (`category_id`),
  ADD KEY `courses_price_id_foreign` (`price_id`);

--
-- Indices de la tabla `course_user`
--
ALTER TABLE `course_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_user_course_id_foreign` (`course_id`),
  ADD KEY `course_user_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `goals`
--
ALTER TABLE `goals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `goals_course_id_foreign` (`course_id`);

--
-- Indices de la tabla `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `images_imageable_type_imageable_id_index` (`imageable_type`,`imageable_id`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lessons_section_id_foreign` (`section_id`);

--
-- Indices de la tabla `lesson_user`
--
ALTER TABLE `lesson_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lesson_user_lesson_id_foreign` (`lesson_id`),
  ADD KEY `lesson_user_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `prices`
--
ALTER TABLE `prices`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `requirements`
--
ALTER TABLE `requirements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `requirements_course_id_foreign` (`course_id`);

--
-- Indices de la tabla `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_course_id_foreign` (`course_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indices de la tabla `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sections_course_id_foreign` (`course_id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `course_user`
--
ALTER TABLE `course_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `goals`
--
ALTER TABLE `goals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `images`
--
ALTER TABLE `images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de la tabla `lesson_user`
--
ALTER TABLE `lesson_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `levels`
--
ALTER TABLE `levels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `prices`
--
ALTER TABLE `prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `requirements`
--
ALTER TABLE `requirements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `courses_level_id_foreign` FOREIGN KEY (`level_id`) REFERENCES `levels` (`id`),
  ADD CONSTRAINT `courses_price_id_foreign` FOREIGN KEY (`price_id`) REFERENCES `prices` (`id`),
  ADD CONSTRAINT `courses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `course_user`
--
ALTER TABLE `course_user`
  ADD CONSTRAINT `course_user_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `goals`
--
ALTER TABLE `goals`
  ADD CONSTRAINT `goals_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `lesson_user`
--
ALTER TABLE `lesson_user`
  ADD CONSTRAINT `lesson_user_lesson_id_foreign` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lesson_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `requirements`
--
ALTER TABLE `requirements`
  ADD CONSTRAINT `requirements_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `sections_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
