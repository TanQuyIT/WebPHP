-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: mysql-server
-- Thời gian đã tạo: Th1 14, 2022 lúc 12:33 PM
-- Phiên bản máy phục vụ: 8.0.1-dmr
-- Phiên bản PHP: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `database`
--
CREATE DATABASE IF NOT EXISTS `database` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `database`;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `user` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gioitinh` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ngaysinh` date DEFAULT NULL,
  `chucvu` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `idPhong` int(11) NOT NULL,
  `phongban` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `avata` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `songaynghi` int(20) DEFAULT '0',
  `ngayxinphep` date DEFAULT NULL,
  `active` int(10) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`id`, `user`, `pass`, `name`, `gioitinh`, `ngaysinh`, `chucvu`, `idPhong`, `phongban`, `avata`, `songaynghi`, `ngayxinphep`, `active`) VALUES
(1, 'admin', '$2y$12$HixACqUh.sadpgLFh.uS..AG2INIIWKGdYpk8JQzTWErxWBDBWh/6', 'Lê Tấn Quý', 'Nam', '1998-04-10', 'Giám đốc', 0, '---', '/Nhanvien/Avatars/admin.jpg', 0, NULL, 1),
(2, 'leminhkhanhdu', '$2y$12$AglJSpTgDRIg5Nx5n9SBYOJB6mss1T3rNmVZS9okIG.1JeAMo8//y', 'Lê Minh Khánh Dư', 'Nam', '2000-07-24', 'Trưởng phòng', 4, 'Công nghệ', NULL, 0, NULL, 1),
(3, 'kimphuc', '$2y$12$1aTcwfdI/L65OlLv.fsc0uKMghsf9M8lWNWl/WpPpiEVOxYsEUDEG', 'Kim Phúc', 'Nữ', '2021-12-21', 'Trưởng phòng', 2, 'Kế toán', '/Nhanvien/Avatars/kimphuc.jpg', 0, '2022-01-12', 1),
(4, 'maiphuongthuy', '$2y$12$cUC9npw68UVMCTJMxHMn/O.aAYEJPqDyUZZRB2i5jn5NmVM2/TKCi', 'Mai Phương Thuý', 'Nữ', '2021-12-21', 'Trưởng phòng', 3, 'Văn Phòng', NULL, 0, '2022-01-13', 1),
(5, 'hoangvancuong', '$2y$12$7RHfj4dMQTcHSBxm9o3cKOJCYP7lQnUxwSDXPeLFuoMcfMUVzBr5u', 'Hoàng Văn Cường', 'Nam', '2021-12-21', 'Nhân viên', 5, 'marketing', '/Nhanvien/Avatars/hoangvancuong.jpg', 0, NULL, 1),
(6, 'vanthanhan', '$2y$12$blw67nTX5T.JwAP5bvxvbebrYsBIyh6B6SNUIByArh3bFIG3gkfiS', 'Văn Thành An', 'Nam', '2021-12-21', 'Trưởng phòng', 1, 'Nhân sự', NULL, 0, NULL, 1),
(7, 'caothienthien', 'caothienthien', 'Cao Thiên Thiên', 'Nam', '2021-12-21', 'Nhân viên', 1, 'Nhân sự', NULL, 0, NULL, 0),
(8, 'demo', '$2y$12$PLKiKGqklCUUmdVyJA/5ye3aFJexwnw9hXrJEOympiMcaZ86zzhuW', 'Đề Mô', 'Nam', '2000-01-01', 'Trưởng phòng', 5, 'marketing', '/Nhanvien/Avatars/demo.jpg', 2, '2022-01-02', 1),
(9, 'nguyenminhtien', 'nguyenminhtien', 'Nguyễn Minh Tiến ', 'Nam', '1994-05-10', 'Nhân viên', 5, 'Marketing', NULL, 0, NULL, 0),
(16, 'lyhuynhkim', '$2y$12$UDwVwg4TLux.vZiL00ccpOCF7pRjA0zKxOYh0BSG9BViSK9Yyiyj6', 'Lý Huỳnh Kim', 'Nữ', '2002-12-12', 'Nhân viên', 2, 'Kế toán', NULL, 0, '2022-01-13', 1),
(17, 'tranhuyentrang', '$2y$12$nnxYAkLsTWb7/1.h29kwmexlfU7mPoJfdIsyMJhVZPFnkCNFKC/5G', 'Trần Huyền Trang', 'Nữ', '1999-06-17', 'Nhân viên', 5, 'Marketing', NULL, 0, '2022-01-12', 1),
(18, 'mytam', '$2y$12$54Gt3VLOLaeg6iaHW6Sk.O5MLq6rFqLpyTfHEP5T6m9yZVKsejopK', 'Mỹ Tâm', 'Nữ', '1996-03-08', 'Nhân viên', 4, 'Công nghệ', NULL, 4, '2022-01-13', 1),
(19, 'lethithao', '$2y$12$bJXR7LuGkI5a2FHZJWxwGODQ/CvSJ2HAe.fNo0eP/0miYwwLcI6EK', 'Lê Thị Thảo', 'Nữ', '1997-06-10', 'Nhân viên', 3, 'Văn Phòng', NULL, 0, NULL, 1),
(20, 'nguyenthanhtung', 'nguyenthanhtung', 'Nguyễn Thanh Tùng', 'Nam', '1999-10-10', 'Nhân viên', 7, 'Phát triển - công nghệ', NULL, 0, NULL, 0),
(21, 'nguyenthilan', 'nguyenthilan', 'Nguyễn Thị Lan', 'Nữ', '1999-05-30', 'Nhân viên', 3, 'Văn Phòng', NULL, 0, NULL, 0),
(22, 'hoangthiha', 'hoangthiha', 'Hoàng Thị Hà', 'Nữ', '1994-08-15', 'Nhân viên', 1, 'Nhân sự', NULL, 0, NULL, 0),
(23, 'lephuongninh', '$2y$12$4BK7GUP2z9LkpLgQooIJ.eGLOHsUWg6ytVvfoX7ReQotW/EBlDHxS', 'Lê Phương Ninh', 'Nữ', '1998-01-14', 'Nhân viên', 2, 'Kế toán', NULL, 0, NULL, 1),
(24, 'hoanglehieu', 'hoanglehieu', 'Hoàng Lê Hiếu', 'Nam', '1995-01-12', 'Nhân viên', 4, 'Công nghệ', NULL, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitiettask`
--

CREATE TABLE `chitiettask` (
  `id` int(11) NOT NULL,
  `idTask` int(11) NOT NULL,
  `noidung` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timesubmit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dealine` date NOT NULL,
  `file` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tp_nv` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chitiettask`
--

INSERT INTO `chitiettask` (`id`, `idTask`, `noidung`, `timesubmit`, `dealine`, `file`, `tp_nv`) VALUES
(7, 18, 'báo cáo thử nghiệm thành công', '2021-12-31 00:00:01', '2022-01-09', '', 0),
(18, 18, 'Tốt đã nhận được báo cáo thử nghiệm của bạn', '2021-12-31 00:00:02', '2022-01-09', '', 1),
(26, 25, 'Đã cập nhật NV submit task', '2022-01-01 00:00:03', '2022-01-09', '', 0),
(27, 25, 'thực hiện lại task', '2022-01-01 00:00:04', '2022-01-09', '', 1),
(28, 25, 'đã submit lại', '2022-01-01 00:00:05', '2022-01-09', '', 0),
(29, 25, 'test reload page', '2022-01-01 00:00:06', '2022-01-09', '', 1),
(30, 25, 'Thêm location.reload() trong js', '2022-01-01 00:00:07', '2022-01-09', '', 0),
(31, 25, 'chưa thành công hãy thử lại', '2022-01-01 00:00:08', '2022-01-09', '', 1),
(32, 25, 'đã thay đổi window.location.href', '2022-01-01 00:00:10', '2022-01-09', '', 0),
(33, 25, 'kiểm tra các file submit', '0000-00-00 00:00:00', '2022-01-09', '', 1),
(34, 25, 'demo gửi báo cáo', '0000-00-00 00:00:00', '2022-01-09', '', 0),
(35, 25, 'tiếp tục thử lại', '0000-00-00 00:00:00', '2022-01-09', '', 1),
(36, 25, 'thử lại lần 1', '0000-00-00 00:00:00', '2022-01-09', '', 0),
(37, 25, 'chỉnh giờ Y-m-d H:i:s', '2022-01-01 21:27:45', '2022-01-09', '', 1),
(38, 25, 'đã chỉnh Y-m-d H:i:s', '2022-01-01 21:28:03', '2022-01-09', '', 0),
(39, 25, 'kiểm tra tính năng đính kèm\r\n', '2022-01-01 21:28:36', '2022-01-09', '', 1),
(40, 25, 'Kiểm tra hoạt động', '2022-01-01 21:30:13', '0000-00-00', '', 0),
(41, 25, 'làm lại 1 lần nữa\r\n', '2022-01-01 21:41:56', '2022-01-09', '', 1),
(42, 25, 'đã sửa file js', '2022-01-01 21:42:44', '2022-01-09', '', 0),
(43, 25, 'làm lại', '2022-01-01 21:43:20', '2022-01-09', '', 1),
(44, 25, 'Ghi nhập nội dung F', '2022-01-01 21:43:44', '2022-01-09', '', 0),
(45, 25, 'Cần làm lại toàn bộ', '2022-01-01 21:44:08', '2022-01-09', '', 1),
(46, 25, 'Kiểm tra file k load page', '2022-01-01 21:44:23', '2022-01-09', '', 0),
(47, 25, 'chưa in được file', '2022-01-01 21:45:18', '2022-01-09', '', 1),
(48, 25, 'thử in Chứng nhận', '2022-01-01 21:45:28', '2022-01-09', '', 0),
(49, 25, 'chưa in được file', '2022-01-01 21:50:20', '2022-01-09', '', 1),
(50, 25, 'báo cáo', '2022-01-01 21:50:30', '2022-01-09', '', 0),
(51, 25, 'báo cáo lần cuối\r\n', '2022-01-01 21:50:59', '2022-01-09', '', 1),
(52, 25, 'đã đổi thành hàm iset', '2022-01-01 21:51:17', '2022-01-09', '', 0),
(53, 25, 'báo cáo lần cuối\r\nthử với file 1', '2022-01-01 21:52:07', '2022-01-09', '', 1),
(54, 25, 'báo cáo thử 1', '2022-01-01 21:53:44', '2022-01-09', '', 0),
(55, 25, '\r\nthử với file 2', '2022-01-01 21:53:56', '2022-01-09', '1641070436.jpg', 1),
(56, 25, 'quên xoá file', '2022-01-01 21:54:20', '2022-01-09', '', 0),
(57, 25, 'đã xoá fiel', '2022-01-01 21:54:32', '2022-01-09', '', 1),
(58, 25, 'đã nhận được file xoá', '2022-01-01 21:54:55', '2022-01-09', '', 0),
(60, 25, 'test rejected task', '2022-01-01 22:00:32', '2022-01-06', '', 1),
(61, 25, 'có thể chuyển đổi', '2022-01-01 22:01:20', '2022-01-06', '', 0),
(63, 25, 'Hoàn thành ở mức: Bad', '2022-01-01 22:58:17', '2022-01-06', NULL, 1),
(64, 20, 'In progress', '2022-01-01 23:26:27', '2022-01-09', NULL, 0),
(65, 19, 'test list', '2022-01-01 23:28:48', '2022-01-06', '', 0),
(66, 19, 'Hoàn thành ở mức: Ok', '2022-01-11 13:02:58', '2022-01-06', NULL, 1),
(67, 28, 'Kiểm việc thay đổi hình ảnh và tập tin ngoài các tập tin thực thi', '2022-01-11 13:46:49', '2022-01-12', '', 1),
(68, 28, 'Canceled', '2022-01-11 13:51:04', '2022-01-12', NULL, 1),
(69, 29, 'Lập danh sách thưởng tết theo file đính kèm', '2022-01-11 14:06:38', '2022-01-12', '1641909998file-excel-tinh-tien-thuong-tet-nguyen-dan.xls', 1),
(70, 20, 'Hãng Boon Siew Honda cho biết, thực hiện theo yêu cầu từ Bộ Giao thông Malaysia, mẫu xe số 100 phân khối sẽ dừng bán từ ngày 31/12. Nguyên nhân do Dream 100 không phù hợp với các quy định chung về khí thải.', '2022-01-11 14:31:26', '2022-01-09', '1641911486honda-dream.jpg', 0),
(71, 1, 'In progress', '2022-01-12 11:29:30', '2022-01-08', NULL, 0),
(72, 1, 'Đội tuyển Việt Nam có 2 cầu thủ bị nhiễm Covid', '2022-01-12 13:28:18', '2022-01-08', '', 0),
(73, 29, 'In progress', '2022-01-13 10:42:50', '2022-01-12', NULL, 0),
(74, 29, 'Xin lỗi sếp em nộp trễ \r\nCó thể cho em làm lại được không ạ', '2022-01-13 10:43:24', '2022-01-12', '', 0),
(75, 31, 'Tuyển thêm 3 nhân viên thời vụ dịp tết', '2022-01-13 13:12:17', '2022-01-15', '', 1),
(76, 32, 'Thông kê danh sách nhân viên còn làm việc trong năm 2021', '2022-01-13 13:13:45', '2022-01-16', '', 1),
(77, 31, 'Canceled', '2022-01-13 13:14:03', '2022-01-15', NULL, 1),
(78, 33, 'Tuyển nhân viên thời vụ tết Nhâm Dần 2022', '2022-01-13 13:14:56', '2022-01-15', '', 1),
(79, 34, 'Báo cáo kinh phí hoạt động cho hoạt động ngoại khoá của công ty trong năm 2021', '2022-01-13 13:20:08', '2022-01-15', '', 1),
(80, 35, 'Kiểm tra nhân viên đủ điều kiện nâng lương trong năm 2022', '2022-01-13 13:21:02', '2022-01-17', '', 1),
(81, 34, 'In progress', '2022-01-13 13:28:17', '2022-01-15', NULL, 0),
(82, 36, 'Kiểm tra số lượng văn phòng phẩm còn tồn trong năm 2021 chưa sử dụng (phân loại có thể tái sử dụng trong năm 2022)', '2022-01-13 13:35:03', '2022-01-15', '', 1),
(83, 37, 'Trang trí - khu vực sảnh, mặt tiền công ty và phòng tiếp khách', '2022-01-13 13:36:34', '2022-01-16', '', 1),
(84, 36, 'In progress', '2022-01-13 13:37:30', '2022-01-15', NULL, 0),
(85, 36, 'Còn tồn kho một vài tập giấy A4 ', '2022-01-13 13:38:13', '2022-01-15', '', 0),
(86, 36, 'Bổ sung số lượng?\r\nChất lượng có thể tái sử dụng được không?', '2022-01-13 13:38:50', '2022-01-15', '', 1),
(87, 36, 'số lượng 100\r\n50 bộ đã hư\r\n40 có thể tái sử dụng\r\n10 đang kiểm tra', '2022-01-13 13:39:31', '2022-01-15', '', 0),
(88, 36, 'Tiếp tục kiểm tra báo cáo tiếp', '2022-01-13 13:39:57', '2022-01-15', '', 1),
(89, 38, 'Tìm hiểu trên mạng về ngôn ngữ lập trình PHP và trình bày cho dự án sắp tới', '2022-01-13 13:46:59', '2022-01-18', '', 1),
(90, 39, 'Liên công ty FLcS để điều chỉnh một số thông tin trang trang web mà công ty đã xây dựng theo đúng theo hồ sơ công ty FLcS yêu cầu', '2022-01-13 13:48:56', '2022-01-17', '', 1),
(91, 39, 'In progress', '2022-01-13 14:10:26', '2022-01-17', NULL, 0),
(92, 39, 'Nội dung ở file đính kèm', '2022-01-13 14:12:10', '2022-01-17', '1642083130img123.jpg', 0),
(93, 40, 'Báo cáo tình hình vận hành hệ thống thông tin công ty trong năm 2021\r\n', '2022-01-13 14:13:10', '2022-01-15', '', 1),
(94, 40, 'In progress', '2022-01-13 14:13:19', '2022-01-15', NULL, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nghiphep`
--

CREATE TABLE `nghiphep` (
  `id` int(11) NOT NULL,
  `nhanvien` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `idNV` int(255) NOT NULL,
  `idPhong` int(11) NOT NULL,
  `chucvu` text COLLATE utf8_unicode_ci NOT NULL,
  `ngayBDnghi` date NOT NULL,
  `songaymuonnghi` int(20) NOT NULL,
  `lydo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trangthai` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'waiting',
  `ngaythaydoi` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nghiphep`
--

INSERT INTO `nghiphep` (`id`, `nhanvien`, `idNV`, `idPhong`, `chucvu`, `ngayBDnghi`, `songaymuonnghi`, `lydo`, `file`, `trangthai`, `ngaythaydoi`) VALUES
(3, 'demo', 8, 5, 'Trưởng phòng', '2022-01-03', 2, 'nghỉ tết thêm', '', 'approved', '2022-01-02 18:17:05'),
(4, 'Mỹ Tâm', 18, 4, 'Nhân viên', '2022-01-04', 4, 'Nghỉ đi sắm đồ tết', '', 'approved', '2022-01-02 20:03:09'),
(5, 'Trần Huyền Trang', 17, 5, 'Nhân viên', '2022-01-14', 2, 'Muốn nghỉ 2 ngày ăn đám cưới', '1641977160Dơn nghỉ phép .txt', 'waiting', '2022-01-12 08:46:00'),
(7, 'Kim Phúc', 3, 2, 'Trưởng phòng', '2022-01-14', 2, 'Nghỉ để đi ăn đám hỏi', '', 'waiting', '2022-01-12 09:15:40'),
(8, 'Lý Huỳnh Kim', 16, 2, 'Nhân viên', '2022-01-14', 5, 'Nghỉ đi khám bệnh', '', 'waiting', '2022-01-13 10:52:32'),
(9, 'Mai Phương Thuý', 4, 3, 'Trưởng phòng', '2022-01-14', 5, 'Nghỉ để đi du lịch', '', 'refused', '2022-01-13 13:31:46');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phongban`
--

CREATE TABLE `phongban` (
  `id` int(11) NOT NULL,
  `sophong` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mota` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `truongphong` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idTruongphong` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `phongban`
--

INSERT INTO `phongban` (`id`, `sophong`, `name`, `mota`, `truongphong`, `idTruongphong`) VALUES
(1, 1, 'Nhân sự', 'Quản lý các vấn đề về nhân sự của công ty và báo cáo thường xuyên cho giám đốc.', 'Văn Thành An', 6),
(2, 2, 'Kế toán', 'Phụ trách tình hình thu chi của công ty; Đặt dưới sự giám sát trực tiếp của giám đốc.', 'Kim Phúc', 3),
(3, 3, 'Văn Phòng', 'Quản lý văn bản - hồ sơ sổ sách', 'Mai Phương Thuý', 4),
(4, 4, 'Công nghệ', 'Quản lý - xây dựng công nghệ để duy trình hoạt động và đẩy mạnh phát triển khoa học kỹ thuật của công ty theo xu hướng công nghệ hiện đại.', 'Lê Minh Khánh Dư', 2),
(5, 5, 'Marketing', 'Hoạt định chiến lược phát triển công ty - Thực hiên các hoạt động quảng cáo theo hợp đồng ký kết ', 'Đề Mô', 8),
(7, 7, 'Phát triển - công nghệ', 'Nghiêng cứu các và nắm vững các công nghệ mới mang tính xu hướng để áp dụng vào quá trình hoạt động phát triển cho công ty.', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `idNV` int(255) NOT NULL,
  `nhanvien` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mota` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `danhgia` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trangthai` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'New',
  `dungthoihan` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `srcFile` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '#',
  `dealine` date NOT NULL,
  `idPhong` int(255) NOT NULL,
  `ngaygiao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ngaythaydoi` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `task`
--

INSERT INTO `task` (`id`, `name`, `idNV`, `nhanvien`, `mota`, `danhgia`, `trangthai`, `dungthoihan`, `file`, `srcFile`, `dealine`, `idPhong`, `ngaygiao`, `ngaythaydoi`) VALUES
(1, 'Lên kịch bản truyền thông cổ vũ tuyển Việt Nam', 5, 'Hoàng Văn Cường', 'Lên danh sách những việc cần làm ', NULL, 'Waiting', NULL, '', '', '2022-01-08', 5, '2021-12-10 00:00:00', '2022-01-12 13:28:18'),
(18, 'Tìm hình ảnh cho quảng cáo FPT play box 2020', 5, 'Hoàng Văn Cường', '', 'Ok', 'Completed', 'đúng', '', '', '2022-01-09', 5, '2021-12-29 00:00:00', '2021-12-29 00:00:00'),
(19, 'Xem xét mâu viettel box 2.0', 5, 'Hoàng Văn Cường', 'Xem xét tình hình doanh thu của Viettel box và các tivi box khác trên thị trường hiện nay', 'Ok', 'Completed', 'đúng deadline', '', '#', '2022-01-06', 5, '2021-12-29 00:00:00', '2022-01-11 13:02:58'),
(20, 'Tìm kiếm hình ảnh Honda Dream ', 9, 'Nguyen Minh Tien ', 'Tìm kiếm và chọn lựa hình ảnh Honda Dream để làm quảng cáo', NULL, 'Waiting', NULL, '', '#', '2022-01-09', 5, '2021-12-31 00:00:00', '2022-01-11 14:31:26'),
(25, 'Kiểm tra tạo task', 5, 'Hoàng Văn Cường', 'Kiểm tra tạo bộ chức năng tạo task theo đúng yêu cầu cũng như tiện ích nhất cho người dùng về mặt cảm quan và tối ưu hoá công nghệ.', 'Bad', 'Completed', 'đúng deadline', '', '#', '2022-01-06', 5, '2022-01-01 00:00:00', '2022-01-01 22:58:17'),
(27, 'Hoàn thiện giao diện task ', 5, 'Hoàng Văn Cường', 'Chỉnh sửa kiểm tra các lỗi có thể xẩy ra cũng như vận hành hệ thống quản lý task và thực hiện task từ hai phía', 'Ok', 'Completed', 'đúng deadline', '', '#', '2022-01-06', 5, '2021-12-29 00:00:00', '2022-01-11 13:02:58'),
(28, 'Kiểm tra hình ảnh', 17, 'Trần Huyền Trang', 'Kiểm việc thay đổi hình ảnh và tập tin ngoài các tập tin thực thi', NULL, 'Canceled', NULL, '', '#', '2022-01-12', 5, '2022-01-11 13:46:49', '2022-01-11 13:51:04'),
(29, 'Lập danh sách thưởng tết', 16, 'Lý Huỳnh Kim', 'Lập danh sách thưởng tết theo file đính kèm', NULL, 'Waiting', NULL, '1641909998file-excel-tinh-tien-thuong-tet-nguyen-dan.xls', '#', '2022-01-12', 2, '2022-01-11 14:06:38', '2022-01-13 10:43:24'),
(31, 'Tuyển nhân viên mới - 2022', 7, 'Cao Thiên Thiên', 'Tuyển thêm 3 nhân viên thời vụ dịp tết', NULL, 'Canceled', NULL, '', '#', '2022-01-15', 1, '2022-01-13 13:12:17', '2022-01-13 13:14:03'),
(32, 'Kiểm tra danh sách nhân viên - 2021', 22, 'Hoàng Thị Hà', 'Thông kê danh sách nhân viên còn làm việc trong năm 2021', NULL, 'New', NULL, '', '#', '2022-01-16', 1, '2022-01-13 13:13:45', '2022-01-13 13:13:45'),
(33, 'Tuyển nhân viên thời vụ - 2022', 7, 'Cao Thiên Thiên', 'Tuyển nhân viên thời vụ tết Nhâm Dần 2022', NULL, 'New', NULL, '', '#', '2022-01-15', 1, '2022-01-13 13:14:56', '2022-01-13 13:14:56'),
(34, 'Báo cáo kinh phí hoạt động', 23, 'Lê Phương Ninh', 'Báo cáo kinh phí hoạt động cho hoạt động ngoại khoá của công ty trong năm 2021', NULL, 'In progress', NULL, '', '#', '2022-01-15', 2, '2022-01-13 13:20:08', '2022-01-13 13:28:17'),
(35, 'Lập danh sách nâng lương', 16, 'Lý Huỳnh Kim', 'Kiểm tra nhân viên đủ điều kiện nâng lương trong năm 2022', NULL, 'New', NULL, '', '#', '2022-01-17', 2, '2022-01-13 13:21:02', '2022-01-13 13:21:02'),
(36, 'Thông kê văn phòng phẩm - 2021', 19, 'Lê Thị Thảo', 'Kiểm tra số lượng văn phòng phẩm còn tồn trong năm 2021 chưa sử dụng (phân loại có thể tái sử dụng trong năm 2022)', NULL, 'Rejected', NULL, '', '#', '2022-01-15', 3, '2022-01-13 13:35:03', '2022-01-13 13:39:57'),
(37, 'Lên kế hoạch trang trí công ty tết 2022', 21, 'Nguyễn Thị Lan', 'Trang trí - khu vực sảnh, mặt tiền công ty và phòng tiếp khách', NULL, 'New', NULL, '', '#', '2022-01-16', 3, '2022-01-13 13:36:34', '2022-01-13 13:36:34'),
(38, 'Xây dựng tài liệu về PHP', 24, 'Hoàng Lê Hiếu', 'Tìm hiểu trên mạng về ngôn ngữ lập trình PHP và trình bày cho dự án sắp tới', NULL, 'New', NULL, '', '#', '2022-01-18', 4, '2022-01-13 13:46:59', '2022-01-13 13:46:59'),
(39, 'Điểu chỉnh trang tin - Khách hàng', 18, 'Mỹ Tâm', 'Liên công ty FLcS để điều chỉnh một số thông tin trang trang web mà công ty đã xây dựng theo đúng theo hồ sơ công ty FLcS yêu cầu', NULL, 'Waiting', NULL, '', '#', '2022-01-17', 4, '2022-01-13 13:48:56', '2022-01-13 14:12:10'),
(40, 'Kiểm tra hệ thống thông tin - 2021', 18, 'Mỹ Tâm', 'Báo cáo tình hình vận hành hệ thống thông tin công ty trong năm 2021\r\n', NULL, 'In progress', NULL, '', '#', '2022-01-15', 4, '2022-01-13 14:13:10', '2022-01-13 14:13:19');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `chitiettask`
--
ALTER TABLE `chitiettask`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `nghiphep`
--
ALTER TABLE `nghiphep`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `phongban`
--
ALTER TABLE `phongban`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `chitiettask`
--
ALTER TABLE `chitiettask`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT cho bảng `nghiphep`
--
ALTER TABLE `nghiphep`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `phongban`
--
ALTER TABLE `phongban`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
