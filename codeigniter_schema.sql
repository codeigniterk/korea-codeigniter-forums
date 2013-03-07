-- phpMyAdmin SQL Dump
-- version 2.11.10
-- http://www.phpmyadmin.net
--
-- 호스트: localhost
-- 처리한 시간: 12-02-02 14:23 
-- 서버 버전: 5.0.77
-- PHP 버전: 5.1.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 데이터베이스: `codeigniter`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `board_ci`
--

CREATE TABLE IF NOT EXISTS `board_ci` (
  `no` int(11) NOT NULL auto_increment,
  `original_no` int(11) NOT NULL COMMENT '원본글번호-리플일 경우 사용',
  `division` varchar(10) default NULL COMMENT '분류, 말머리',
  `module_no` int(11) NOT NULL COMMENT '모듈 고유번호',
  `user_no` int(11) NOT NULL COMMENT '사용자 번호-users테이블',
  `user_id` varchar(50) NOT NULL COMMENT '사용자 아이디',
  `user_name` varchar(10) NOT NULL COMMENT '작성자 이름',
  `reg_date` datetime NOT NULL COMMENT '등록일',
  `modify_date` datetime NOT NULL COMMENT '수정일',
  `is_notice` enum('Y','N') NOT NULL default 'N' COMMENT '공지글 여부',
  `is_secret` enum('Y','N') NOT NULL default 'N' COMMENT '비밀글 여부',
  `subject` varchar(100) NOT NULL COMMENT '제목',
  `general_setting` text NOT NULL COMMENT '각종 설정',
  `contents` text NOT NULL COMMENT '내용',
  `files_count` int(11) NOT NULL default '0' COMMENT '첨부파일 개수',
  `download_count` int(11) NOT NULL COMMENT '다운로드 수',
  `scrap_count` int(11) NOT NULL COMMENT '스크랩수',
  `hit` int(11) NOT NULL default '0' COMMENT '조회수',
  `trackback_count` int(11) NOT NULL default '0' COMMENT '엮임글 수',
  `reply_count` int(11) NOT NULL default '0' COMMENT '리플수',
  `voted_count` int(11) NOT NULL default '0' COMMENT '추천수',
  `blamed_count` int(11) NOT NULL default '0' COMMENT '신고수',
  `ip` varchar(15) NOT NULL COMMENT '작성자 ip 주소',
  `is_delete` enum('Y','N') NOT NULL default 'N' COMMENT '삭제 여부',
  `password` varchar(20) default NULL COMMENT '로그인시 비밀글의 비밀번호, 비회원은 작성시 비밀번호',
  UNIQUE KEY `no` (`no`),
  KEY `is_delete` (`is_delete`),
  KEY `original_no` (`original_no`),
  KEY `user_id` (`user_id`),
  KEY `user_name` (`user_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='게시물 저장' ;

-- --------------------------------------------------------

--
-- 테이블 구조 `board_ci_make`
--

CREATE TABLE IF NOT EXISTS `board_ci_make` (
  `no` int(11) NOT NULL auto_increment,
  `original_no` int(11) NOT NULL COMMENT '원본글번호-리플일 경우 사용',
  `division` varchar(10) default NULL COMMENT '분류, 말머리',
  `module_no` int(11) NOT NULL COMMENT '모듈 고유번호',
  `user_no` int(11) NOT NULL COMMENT '사용자 번호-users테이블',
  `user_id` varchar(50) NOT NULL COMMENT '사용자 아이디',
  `user_name` varchar(10) NOT NULL COMMENT '작성자 이름',
  `reg_date` datetime NOT NULL COMMENT '등록일',
  `modify_date` datetime NOT NULL COMMENT '수정일',
  `is_notice` enum('Y','N') NOT NULL default 'N' COMMENT '공지글 여부',
  `is_secret` enum('Y','N') NOT NULL default 'N' COMMENT '비밀글 여부',
  `subject` varchar(100) NOT NULL COMMENT '제목',
  `general_setting` text NOT NULL COMMENT '각종 설정',
  `contents` text NOT NULL COMMENT '내용',
  `files_count` int(11) NOT NULL default '0' COMMENT '첨부파일 개수',
  `download_count` int(11) NOT NULL COMMENT '다운로드 수',
  `scrap_count` int(11) NOT NULL COMMENT '스크랩수',
  `hit` int(11) NOT NULL default '0' COMMENT '조회수',
  `trackback_count` int(11) NOT NULL default '0' COMMENT '엮임글 수',
  `reply_count` int(11) NOT NULL default '0' COMMENT '리플수',
  `voted_count` int(11) NOT NULL default '0' COMMENT '추천수',
  `blamed_count` int(11) NOT NULL default '0' COMMENT '신고수',
  `ip` varchar(15) NOT NULL COMMENT '작성자 ip 주소',
  `is_delete` enum('Y','N') NOT NULL default 'N' COMMENT '삭제 여부',
  `password` varchar(20) default NULL COMMENT '로그인시 비밀글의 비밀번호, 비회원은 작성시 비밀번호',
  UNIQUE KEY `no` (`no`),
  KEY `original_no` (`original_no`),
  KEY `user_id` (`user_id`),
  KEY `user_name` (`user_name`),
  KEY `is_delete` (`is_delete`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='게시물 저장' ;

-- --------------------------------------------------------

--
-- 테이블 구조 `board_file`
--

CREATE TABLE IF NOT EXISTS `board_file` (
  `no` int(11) NOT NULL auto_increment,
  `original_no` int(11) NOT NULL COMMENT '원본글번호-리플일 경우 사용',
  `division` varchar(10) default NULL COMMENT '분류, 말머리',
  `module_no` int(11) NOT NULL COMMENT '모듈 고유번호',
  `user_no` int(11) NOT NULL COMMENT '사용자 번호-users테이블',
  `user_id` varchar(50) NOT NULL COMMENT '사용자 아이디',
  `user_name` varchar(10) NOT NULL COMMENT '작성자 이름',
  `reg_date` datetime NOT NULL COMMENT '등록일',
  `modify_date` datetime NOT NULL COMMENT '수정일',
  `is_notice` enum('Y','N') NOT NULL default 'N' COMMENT '공지글 여부',
  `is_secret` enum('Y','N') NOT NULL default 'N' COMMENT '비밀글 여부',
  `subject` varchar(100) NOT NULL COMMENT '제목',
  `general_setting` text NOT NULL COMMENT '각종 설정',
  `contents` text NOT NULL COMMENT '내용',
  `files_count` int(11) NOT NULL default '0' COMMENT '첨부파일 개수',
  `download_count` int(11) NOT NULL COMMENT '다운로드 수',
  `scrap_count` int(11) NOT NULL COMMENT '스크랩수',
  `hit` int(11) NOT NULL default '0' COMMENT '조회수',
  `trackback_count` int(11) NOT NULL default '0' COMMENT '엮임글 수',
  `reply_count` int(11) NOT NULL default '0' COMMENT '리플수',
  `voted_count` int(11) NOT NULL default '0' COMMENT '추천수',
  `blamed_count` int(11) NOT NULL default '0' COMMENT '신고수',
  `ip` varchar(15) NOT NULL COMMENT '작성자 ip 주소',
  `is_delete` enum('Y','N') NOT NULL default 'N' COMMENT '삭제 여부',
  `password` varchar(20) default NULL COMMENT '로그인시 비밀글의 비밀번호, 비회원은 작성시 비밀번호',
  UNIQUE KEY `no` (`no`),
  KEY `is_delete` (`is_delete`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='게시물 저장' ;

-- --------------------------------------------------------

--
-- 테이블 구조 `board_free`
--

CREATE TABLE IF NOT EXISTS `board_free` (
  `no` int(11) NOT NULL auto_increment,
  `original_no` int(11) NOT NULL COMMENT '원본글번호-리플일 경우 사용',
  `division` varchar(10) default NULL COMMENT '분류, 말머리',
  `module_no` int(11) NOT NULL COMMENT '모듈 고유번호',
  `user_no` int(11) NOT NULL COMMENT '사용자 번호-users테이블',
  `user_id` varchar(50) NOT NULL COMMENT '사용자 아이디',
  `user_name` varchar(10) NOT NULL COMMENT '작성자 이름',
  `reg_date` datetime NOT NULL COMMENT '등록일',
  `modify_date` datetime NOT NULL COMMENT '수정일',
  `is_notice` enum('Y','N') NOT NULL default 'N' COMMENT '공지글 여부',
  `is_secret` enum('Y','N') NOT NULL default 'N' COMMENT '비밀글 여부',
  `subject` varchar(100) NOT NULL COMMENT '제목',
  `general_setting` text NOT NULL COMMENT '각종 설정',
  `contents` text NOT NULL COMMENT '내용',
  `files_count` int(11) NOT NULL default '0' COMMENT '첨부파일 개수',
  `download_count` int(11) NOT NULL COMMENT '다운로드 수',
  `scrap_count` int(11) NOT NULL COMMENT '스크랩수',
  `hit` int(11) NOT NULL default '0' COMMENT '조회수',
  `trackback_count` int(11) NOT NULL default '0' COMMENT '엮임글 수',
  `reply_count` int(11) NOT NULL default '0' COMMENT '리플수',
  `voted_count` int(11) NOT NULL default '0' COMMENT '추천수',
  `blamed_count` int(11) NOT NULL default '0' COMMENT '신고수',
  `ip` varchar(15) NOT NULL COMMENT '작성자 ip 주소',
  `is_delete` enum('Y','N') NOT NULL default 'N' COMMENT '삭제 여부',
  `password` varchar(20) default NULL COMMENT '로그인시 비밀글의 비밀번호, 비회원은 작성시 비밀번호',
  UNIQUE KEY `no` (`no`),
  KEY `original_no` (`original_no`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='게시물 저장'  ;

-- --------------------------------------------------------

--
-- 테이블 구조 `board_html5`
--

CREATE TABLE IF NOT EXISTS `board_html5` (
  `no` int(11) NOT NULL auto_increment,
  `original_no` int(11) NOT NULL COMMENT '원본글번호-리플일 경우 사용',
  `division` varchar(10) default NULL COMMENT '분류, 말머리',
  `module_no` int(11) NOT NULL COMMENT '모듈 고유번호',
  `user_no` int(11) NOT NULL COMMENT '사용자 번호-users테이블',
  `user_id` varchar(50) NOT NULL COMMENT '사용자 아이디',
  `user_name` varchar(10) NOT NULL COMMENT '작성자 이름',
  `reg_date` datetime NOT NULL COMMENT '등록일',
  `modify_date` datetime NOT NULL COMMENT '수정일',
  `is_notice` enum('Y','N') NOT NULL default 'N' COMMENT '공지글 여부',
  `is_secret` enum('Y','N') NOT NULL default 'N' COMMENT '비밀글 여부',
  `subject` varchar(100) NOT NULL COMMENT '제목',
  `general_setting` text NOT NULL COMMENT '각종 설정',
  `contents` text NOT NULL COMMENT '내용',
  `files_count` int(11) NOT NULL default '0' COMMENT '첨부파일 개수',
  `download_count` int(11) NOT NULL COMMENT '다운로드 수',
  `scrap_count` int(11) NOT NULL COMMENT '스크랩수',
  `hit` int(11) NOT NULL default '0' COMMENT '조회수',
  `trackback_count` int(11) NOT NULL default '0' COMMENT '엮임글 수',
  `reply_count` int(11) NOT NULL default '0' COMMENT '리플수',
  `voted_count` int(11) NOT NULL default '0' COMMENT '추천수',
  `blamed_count` int(11) NOT NULL default '0' COMMENT '신고수',
  `ip` varchar(15) NOT NULL COMMENT '작성자 ip 주소',
  `is_delete` enum('Y','N') NOT NULL default 'N' COMMENT '삭제 여부',
  `password` varchar(20) default NULL COMMENT '로그인시 비밀글의 비밀번호, 비회원은 작성시 비밀번호',
  UNIQUE KEY `no` (`no`),
  KEY `is_delete` (`is_delete`),
  KEY `original_no` (`original_no`),
  KEY `user_id` (`user_id`),
  KEY `user_name` (`user_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='게시물 저장'  ;

-- --------------------------------------------------------

--
-- 테이블 구조 `board_lecture`
--

CREATE TABLE IF NOT EXISTS `board_lecture` (
  `no` int(11) NOT NULL auto_increment,
  `original_no` int(11) NOT NULL COMMENT '원본글번호-리플일 경우 사용',
  `division` varchar(10) default NULL COMMENT '분류, 말머리',
  `module_no` int(11) NOT NULL COMMENT '모듈 고유번호',
  `user_no` int(11) NOT NULL COMMENT '사용자 번호-users테이블',
  `user_id` varchar(50) NOT NULL COMMENT '사용자 아이디',
  `user_name` varchar(10) NOT NULL COMMENT '작성자 이름',
  `reg_date` datetime NOT NULL COMMENT '등록일',
  `modify_date` datetime NOT NULL COMMENT '수정일',
  `is_notice` enum('Y','N') NOT NULL default 'N' COMMENT '공지글 여부',
  `is_secret` enum('Y','N') NOT NULL default 'N' COMMENT '비밀글 여부',
  `subject` varchar(100) NOT NULL COMMENT '제목',
  `general_setting` text NOT NULL COMMENT '각종 설정',
  `contents` text NOT NULL COMMENT '내용',
  `files_count` int(11) NOT NULL default '0' COMMENT '첨부파일 개수',
  `download_count` int(11) NOT NULL COMMENT '다운로드 수',
  `scrap_count` int(11) NOT NULL COMMENT '스크랩수',
  `hit` int(11) NOT NULL default '0' COMMENT '조회수',
  `trackback_count` int(11) NOT NULL default '0' COMMENT '엮임글 수',
  `reply_count` int(11) NOT NULL default '0' COMMENT '리플수',
  `voted_count` int(11) NOT NULL default '0' COMMENT '추천수',
  `blamed_count` int(11) NOT NULL default '0' COMMENT '신고수',
  `ip` varchar(15) NOT NULL COMMENT '작성자 ip 주소',
  `is_delete` enum('Y','N') NOT NULL default 'N' COMMENT '삭제 여부',
  `password` varchar(20) default NULL COMMENT '로그인시 비밀글의 비밀번호, 비회원은 작성시 비밀번호',
  UNIQUE KEY `no` (`no`),
  KEY `is_delete` (`is_delete`),
  KEY `user_id` (`user_id`),
  KEY `user_name` (`user_name`),
  KEY `original_no` (`original_no`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='게시물 저장'  ;

-- --------------------------------------------------------

--
-- 테이블 구조 `board_list`
--

CREATE TABLE IF NOT EXISTS `board_list` (
  `no` int(11) NOT NULL auto_increment,
  `skin` varchar(30) NOT NULL default 'default' COMMENT '스킨디렉토리',
  `name` varchar(30) NOT NULL COMMENT '한글이름',
  `name_en` varchar(30) NOT NULL COMMENT '영문이름',
  `enable` enum('Y','N') NOT NULL default 'Y' COMMENT '사용여부',
  `permission` varchar(20) NOT NULL COMMENT '권한 1비회원 3준회원 7CI 15운영진',
  `category_word` varchar(100) NOT NULL COMMENT '말머리',
  `detail_setting` longtext NOT NULL COMMENT '세부설정',
  `reg_date` datetime NOT NULL COMMENT '등록일',
  PRIMARY KEY  (`no`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='게시판리스트'  ;

INSERT INTO `board_list` (`no`, `skin`, `name`, `name_en`, `enable`, `permission`, `category_word`, `detail_setting`, `reg_date`) VALUES
(1, 'default', 'CI 뉴스', 'board_news', 'Y', '1|1|3|7', '', '', '2009-06-29 11:32:10'),
(2, 'default', '공지사항', 'board_notice', 'Y', '1|1|3|15', '', '', '2009-06-29 11:33:10'),
(3, 'default', '자유게시판', 'board_free', 'Y', '1|1|3|3', '', '', '2009-06-29 12:49:35'),
(11, 'default', 'html5, css3', 'board_html5', 'Y', '1|3|3|3', '', '', '0000-00-00 00:00:00'),
(4, 'default', 'TIP게시판', 'board_tip', 'Y', '1|1|3|3', '', '', '2009-07-07 22:35:39'),
(5, 'default', '강좌게시판', 'board_lecture', 'Y', '1|1|3|3', '', '', '2009-07-07 22:35:39'),
(6, 'default', 'CI 묻고 답하기', 'board_qna', 'Y', '1|1|3|3', '', '', '2009-07-07 22:35:39'),
(7, 'default', 'CI 코드', 'board_source', 'Y', '1|1|3|3', '', '', '2009-07-07 22:35:39'),
(8, 'default', '일반자료실', 'board_file', 'Y', '1|1|3|3', '', '', '2009-07-07 22:35:39');
-- --------------------------------------------------------

--
-- 테이블 구조 `board_news`
--

CREATE TABLE IF NOT EXISTS `board_news` (
  `no` int(11) NOT NULL auto_increment,
  `original_no` int(11) NOT NULL COMMENT '원본글번호-리플일 경우 사용',
  `division` varchar(10) default NULL COMMENT '분류, 말머리',
  `module_no` int(11) NOT NULL COMMENT '모듈 고유번호',
  `user_no` int(11) NOT NULL COMMENT '사용자 번호-users테이블',
  `user_id` varchar(50) NOT NULL COMMENT '사용자 아이디',
  `user_name` varchar(10) NOT NULL COMMENT '작성자 이름',
  `reg_date` datetime NOT NULL COMMENT '등록일',
  `modify_date` datetime NOT NULL COMMENT '수정일',
  `is_notice` enum('Y','N') NOT NULL default 'N' COMMENT '공지글 여부',
  `is_secret` enum('Y','N') NOT NULL default 'N' COMMENT '비밀글 여부',
  `subject` varchar(100) NOT NULL COMMENT '제목',
  `general_setting` text NOT NULL COMMENT '각종 설정',
  `contents` text NOT NULL COMMENT '내용',
  `files_count` int(11) NOT NULL default '0' COMMENT '첨부파일 개수',
  `download_count` int(11) NOT NULL COMMENT '다운로드 수',
  `scrap_count` int(11) NOT NULL COMMENT '스크랩수',
  `hit` int(11) NOT NULL default '0' COMMENT '조회수',
  `trackback_count` int(11) NOT NULL default '0' COMMENT '엮임글 수',
  `reply_count` int(11) NOT NULL default '0' COMMENT '리플수',
  `voted_count` int(11) NOT NULL default '0' COMMENT '추천수',
  `blamed_count` int(11) NOT NULL default '0' COMMENT '신고수',
  `ip` varchar(15) NOT NULL COMMENT '작성자 ip 주소',
  `is_delete` enum('Y','N') NOT NULL default 'N' COMMENT '삭제 여부',
  `password` varchar(20) default NULL COMMENT '로그인시 비밀글의 비밀번호, 비회원은 작성시 비밀번호',
  UNIQUE KEY `no` (`no`),
  KEY `original_no` (`original_no`),
  KEY `user_id` (`user_id`),
  KEY `user_name` (`user_name`),
  KEY `is_delete` (`is_delete`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='게시물 저장' ;

-- --------------------------------------------------------

--
-- 테이블 구조 `board_notice`
--

CREATE TABLE IF NOT EXISTS `board_notice` (
  `no` int(11) NOT NULL auto_increment,
  `original_no` int(11) NOT NULL COMMENT '원본글번호-리플일 경우 사용',
  `division` varchar(10) default NULL COMMENT '분류, 말머리',
  `module_no` int(11) NOT NULL COMMENT '모듈 고유번호',
  `user_no` int(11) NOT NULL COMMENT '사용자 번호-users테이블',
  `user_id` varchar(50) NOT NULL COMMENT '사용자 아이디',
  `user_name` varchar(10) NOT NULL COMMENT '작성자 이름',
  `reg_date` datetime NOT NULL COMMENT '등록일',
  `modify_date` datetime NOT NULL COMMENT '수정일',
  `is_notice` enum('Y','N') NOT NULL default 'N' COMMENT '공지글 여부',
  `is_secret` enum('Y','N') NOT NULL default 'N' COMMENT '비밀글 여부',
  `subject` varchar(100) NOT NULL COMMENT '제목',
  `general_setting` text NOT NULL COMMENT '각종 설정',
  `contents` text NOT NULL COMMENT '내용',
  `files_count` int(11) NOT NULL default '0' COMMENT '첨부파일 개수',
  `download_count` int(11) NOT NULL COMMENT '다운로드 수',
  `scrap_count` int(11) NOT NULL COMMENT '스크랩수',
  `hit` int(11) NOT NULL default '0' COMMENT '조회수',
  `trackback_count` int(11) NOT NULL default '0' COMMENT '엮임글 수',
  `reply_count` int(11) NOT NULL default '0' COMMENT '리플수',
  `voted_count` int(11) NOT NULL default '0' COMMENT '추천수',
  `blamed_count` int(11) NOT NULL default '0' COMMENT '신고수',
  `ip` varchar(15) NOT NULL COMMENT '작성자 ip 주소',
  `is_delete` enum('Y','N') NOT NULL default 'N' COMMENT '삭제 여부',
  `password` varchar(20) default NULL COMMENT '로그인시 비밀글의 비밀번호, 비회원은 작성시 비밀번호',
  UNIQUE KEY `no` (`no`),
  KEY `original_no` (`original_no`),
  KEY `user_id` (`user_id`),
  KEY `user_name` (`user_name`),
  KEY `is_delete` (`is_delete`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='게시물 저장'  ;

-- --------------------------------------------------------

--
-- 테이블 구조 `board_qna`
--

CREATE TABLE IF NOT EXISTS `board_qna` (
  `no` int(11) NOT NULL auto_increment,
  `original_no` int(11) NOT NULL COMMENT '원본글번호-리플일 경우 사용',
  `division` varchar(10) default NULL COMMENT '분류, 말머리',
  `module_no` int(11) NOT NULL COMMENT '모듈 고유번호',
  `user_no` int(11) NOT NULL COMMENT '사용자 번호-users테이블',
  `user_id` varchar(50) NOT NULL COMMENT '사용자 아이디',
  `user_name` varchar(10) NOT NULL COMMENT '작성자 이름',
  `reg_date` datetime NOT NULL COMMENT '등록일',
  `modify_date` datetime NOT NULL COMMENT '수정일',
  `is_notice` enum('Y','N') NOT NULL default 'N' COMMENT '공지글 여부',
  `is_secret` enum('Y','N') NOT NULL default 'N' COMMENT '비밀글 여부',
  `subject` varchar(100) NOT NULL COMMENT '제목',
  `general_setting` text NOT NULL COMMENT '각종 설정',
  `contents` text NOT NULL COMMENT '내용',
  `files_count` int(11) NOT NULL default '0' COMMENT '첨부파일 개수',
  `download_count` int(11) NOT NULL COMMENT '다운로드 수',
  `scrap_count` int(11) NOT NULL COMMENT '스크랩수',
  `hit` int(11) NOT NULL default '0' COMMENT '조회수',
  `trackback_count` int(11) NOT NULL default '0' COMMENT '엮임글 수',
  `reply_count` int(11) NOT NULL default '0' COMMENT '리플수',
  `voted_count` int(11) NOT NULL default '0' COMMENT '추천수',
  `blamed_count` int(11) NOT NULL default '0' COMMENT '신고수',
  `ip` varchar(15) NOT NULL COMMENT '작성자 ip 주소',
  `is_delete` enum('Y','N') NOT NULL default 'N' COMMENT '삭제 여부',
  `password` varchar(20) default NULL COMMENT '로그인시 비밀글의 비밀번호, 비회원은 작성시 비밀번호',
  UNIQUE KEY `no` (`no`),
  KEY `user_id` (`user_id`),
  KEY `user_name` (`user_name`),
  KEY `original_no` (`original_no`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='게시물 저장'  ;

-- --------------------------------------------------------

--
-- 테이블 구조 `board_source`
--

CREATE TABLE IF NOT EXISTS `board_source` (
  `no` int(11) NOT NULL auto_increment,
  `original_no` int(11) NOT NULL COMMENT '원본글번호-리플일 경우 사용',
  `division` varchar(10) default NULL COMMENT '분류, 말머리',
  `module_no` int(11) NOT NULL COMMENT '모듈 고유번호',
  `user_no` int(11) NOT NULL COMMENT '사용자 번호-users테이블',
  `user_id` varchar(50) NOT NULL COMMENT '사용자 아이디',
  `user_name` varchar(10) NOT NULL COMMENT '작성자 이름',
  `reg_date` datetime NOT NULL COMMENT '등록일',
  `modify_date` datetime NOT NULL COMMENT '수정일',
  `is_notice` enum('Y','N') NOT NULL default 'N' COMMENT '공지글 여부',
  `is_secret` enum('Y','N') NOT NULL default 'N' COMMENT '비밀글 여부',
  `subject` varchar(100) NOT NULL COMMENT '제목',
  `general_setting` text NOT NULL COMMENT '각종 설정',
  `contents` text NOT NULL COMMENT '내용',
  `files_count` int(11) NOT NULL default '0' COMMENT '첨부파일 개수',
  `download_count` int(11) NOT NULL COMMENT '다운로드 수',
  `scrap_count` int(11) NOT NULL COMMENT '스크랩수',
  `hit` int(11) NOT NULL default '0' COMMENT '조회수',
  `trackback_count` int(11) NOT NULL default '0' COMMENT '엮임글 수',
  `reply_count` int(11) NOT NULL default '0' COMMENT '리플수',
  `voted_count` int(11) NOT NULL default '0' COMMENT '추천수',
  `blamed_count` int(11) NOT NULL default '0' COMMENT '신고수',
  `ip` varchar(15) NOT NULL COMMENT '작성자 ip 주소',
  `is_delete` enum('Y','N') NOT NULL default 'N' COMMENT '삭제 여부',
  `password` varchar(20) default NULL COMMENT '로그인시 비밀글의 비밀번호, 비회원은 작성시 비밀번호',
  UNIQUE KEY `no` (`no`),
  KEY `original_no` (`original_no`),
  KEY `user_id` (`user_id`),
  KEY `user_name` (`user_name`),
  KEY `is_delete` (`is_delete`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='게시물 저장' ;

-- --------------------------------------------------------

--
-- 테이블 구조 `board_su`
--

CREATE TABLE IF NOT EXISTS `board_su` (
  `no` int(11) NOT NULL auto_increment,
  `original_no` int(11) NOT NULL COMMENT '원본글번호-리플일 경우 사용',
  `division` varchar(10) default NULL COMMENT '분류, 말머리',
  `module_no` int(11) NOT NULL COMMENT '모듈 고유번호',
  `user_no` int(11) NOT NULL COMMENT '사용자 번호-users테이블',
  `user_id` varchar(50) NOT NULL COMMENT '사용자 아이디',
  `user_name` varchar(10) NOT NULL COMMENT '작성자 이름',
  `reg_date` datetime NOT NULL COMMENT '등록일',
  `modify_date` datetime NOT NULL COMMENT '수정일',
  `is_notice` enum('Y','N') NOT NULL default 'N' COMMENT '공지글 여부',
  `is_secret` enum('Y','N') NOT NULL default 'N' COMMENT '비밀글 여부',
  `subject` varchar(100) NOT NULL COMMENT '제목',
  `general_setting` text NOT NULL COMMENT '각종 설정',
  `contents` text NOT NULL COMMENT '내용',
  `files_count` int(11) NOT NULL default '0' COMMENT '첨부파일 개수',
  `download_count` int(11) NOT NULL COMMENT '다운로드 수',
  `scrap_count` int(11) NOT NULL COMMENT '스크랩수',
  `hit` int(11) NOT NULL default '0' COMMENT '조회수',
  `trackback_count` int(11) NOT NULL default '0' COMMENT '엮임글 수',
  `reply_count` int(11) NOT NULL default '0' COMMENT '리플수',
  `voted_count` int(11) NOT NULL default '0' COMMENT '추천수',
  `blamed_count` int(11) NOT NULL default '0' COMMENT '신고수',
  `ip` varchar(15) NOT NULL COMMENT '작성자 ip 주소',
  `is_delete` enum('Y','N') NOT NULL default 'N' COMMENT '삭제 여부',
  `password` varchar(20) default NULL COMMENT '로그인시 비밀글의 비밀번호, 비회원은 작성시 비밀번호',
  UNIQUE KEY `no` (`no`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='운영진 게시판'  ;

-- --------------------------------------------------------

--
-- 테이블 구조 `board_tip`
--

CREATE TABLE IF NOT EXISTS `board_tip` (
  `no` int(11) NOT NULL auto_increment,
  `original_no` int(11) NOT NULL COMMENT '원본글번호-리플일 경우 사용',
  `division` varchar(10) default NULL COMMENT '분류, 말머리',
  `module_no` int(11) NOT NULL COMMENT '모듈 고유번호',
  `user_no` int(11) NOT NULL COMMENT '사용자 번호-users테이블',
  `user_id` varchar(50) NOT NULL COMMENT '사용자 아이디',
  `user_name` varchar(10) NOT NULL COMMENT '작성자 이름',
  `reg_date` datetime NOT NULL COMMENT '등록일',
  `modify_date` datetime NOT NULL COMMENT '수정일',
  `is_notice` enum('Y','N') NOT NULL default 'N' COMMENT '공지글 여부',
  `is_secret` enum('Y','N') NOT NULL default 'N' COMMENT '비밀글 여부',
  `subject` varchar(100) NOT NULL COMMENT '제목',
  `general_setting` text NOT NULL COMMENT '각종 설정',
  `contents` text NOT NULL COMMENT '내용',
  `files_count` int(11) NOT NULL default '0' COMMENT '첨부파일 개수',
  `download_count` int(11) NOT NULL COMMENT '다운로드 수',
  `scrap_count` int(11) NOT NULL COMMENT '스크랩수',
  `hit` int(11) NOT NULL default '0' COMMENT '조회수',
  `trackback_count` int(11) NOT NULL default '0' COMMENT '엮임글 수',
  `reply_count` int(11) NOT NULL default '0' COMMENT '리플수',
  `voted_count` int(11) NOT NULL default '0' COMMENT '추천수',
  `blamed_count` int(11) NOT NULL default '0' COMMENT '신고수',
  `ip` varchar(15) NOT NULL COMMENT '작성자 ip 주소',
  `is_delete` enum('Y','N') NOT NULL default 'N' COMMENT '삭제 여부',
  `password` varchar(20) default NULL COMMENT '로그인시 비밀글의 비밀번호, 비회원은 작성시 비밀번호',
  UNIQUE KEY `no` (`no`),
  KEY `original_no` (`original_no`),
  KEY `user_id` (`user_id`),
  KEY `user_name` (`user_name`),
  KEY `is_delete` (`is_delete`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='게시물 저장'  ;

-- --------------------------------------------------------

--
-- 테이블 구조 `board_etc_qna`
--

CREATE TABLE IF NOT EXISTS `board_etc_qna` (
  `no` int(11) NOT NULL auto_increment,
  `original_no` int(11) NOT NULL COMMENT '원본글번호-리플일 경우 사용',
  `division` varchar(10) default NULL COMMENT '분류, 말머리',
  `module_no` int(11) NOT NULL COMMENT '모듈 고유번호',
  `user_no` int(11) NOT NULL COMMENT '사용자 번호-users테이블',
  `user_id` varchar(50) NOT NULL COMMENT '사용자 아이디',
  `user_name` varchar(10) NOT NULL COMMENT '작성자 이름',
  `reg_date` datetime NOT NULL COMMENT '등록일',
  `modify_date` datetime NOT NULL COMMENT '수정일',
  `is_notice` enum('Y','N') NOT NULL default 'N' COMMENT '공지글 여부',
  `is_secret` enum('Y','N') NOT NULL default 'N' COMMENT '비밀글 여부',
  `subject` varchar(100) NOT NULL COMMENT '제목',
  `general_setting` text NOT NULL COMMENT '각종 설정',
  `contents` text NOT NULL COMMENT '내용',
  `files_count` int(11) NOT NULL default '0' COMMENT '첨부파일 개수',
  `download_count` int(11) NOT NULL COMMENT '다운로드 수',
  `scrap_count` int(11) NOT NULL COMMENT '스크랩수',
  `hit` int(11) NOT NULL default '0' COMMENT '조회수',
  `trackback_count` int(11) NOT NULL default '0' COMMENT '엮임글 수',
  `reply_count` int(11) NOT NULL default '0' COMMENT '리플수',
  `voted_count` int(11) NOT NULL default '0' COMMENT '추천수',
  `blamed_count` int(11) NOT NULL default '0' COMMENT '신고수',
  `ip` varchar(15) NOT NULL COMMENT '작성자 ip 주소',
  `is_delete` enum('Y','N') NOT NULL default 'N' COMMENT '삭제 여부',
  `password` varchar(20) default NULL COMMENT '로그인시 비밀글의 비밀번호, 비회원은 작성시 비밀번호',
  UNIQUE KEY `no` (`no`),
  KEY `original_no` (`original_no`),
  KEY `user_id` (`user_id`),
  KEY `user_name` (`user_name`),
  KEY `is_delete` (`is_delete`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='게시물 저장'  ;


CREATE TABLE IF NOT EXISTS `board_job` (
  `no` int(11) NOT NULL auto_increment,
  `original_no` int(11) NOT NULL COMMENT '원본글번호-리플일 경우 사용',
  `division` varchar(10) default NULL COMMENT '분류, 말머리',
  `module_no` int(11) NOT NULL COMMENT '모듈 고유번호',
  `user_no` int(11) NOT NULL COMMENT '사용자 번호-users테이블',
  `user_id` varchar(50) NOT NULL COMMENT '사용자 아이디',
  `user_name` varchar(10) NOT NULL COMMENT '작성자 이름',
  `reg_date` datetime NOT NULL COMMENT '등록일',
  `modify_date` datetime NOT NULL COMMENT '수정일',
  `is_notice` enum('Y','N') NOT NULL default 'N' COMMENT '공지글 여부',
  `is_secret` enum('Y','N') NOT NULL default 'N' COMMENT '비밀글 여부',
  `subject` varchar(100) NOT NULL COMMENT '제목',
  `general_setting` text NOT NULL COMMENT '각종 설정',
  `contents` text NOT NULL COMMENT '내용',
  `files_count` int(11) NOT NULL default '0' COMMENT '첨부파일 개수',
  `download_count` int(11) NOT NULL COMMENT '다운로드 수',
  `scrap_count` int(11) NOT NULL COMMENT '스크랩수',
  `hit` int(11) NOT NULL default '0' COMMENT '조회수',
  `trackback_count` int(11) NOT NULL default '0' COMMENT '엮임글 수',
  `reply_count` int(11) NOT NULL default '0' COMMENT '리플수',
  `voted_count` int(11) NOT NULL default '0' COMMENT '추천수',
  `blamed_count` int(11) NOT NULL default '0' COMMENT '신고수',
  `ip` varchar(15) NOT NULL COMMENT '작성자 ip 주소',
  `is_delete` enum('Y','N') NOT NULL default 'N' COMMENT '삭제 여부',
  `password` varchar(20) default NULL COMMENT '로그인시 비밀글의 비밀번호, 비회원은 작성시 비밀번호',
  UNIQUE KEY `no` (`no`),
  KEY `original_no` (`original_no`),
  KEY `user_id` (`user_id`),
  KEY `user_name` (`user_name`),
  KEY `is_delete` (`is_delete`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='게시물 저장'  ;


CREATE TABLE IF NOT EXISTS `board_ad` (
  `no` int(11) NOT NULL auto_increment,
  `original_no` int(11) NOT NULL COMMENT '원본글번호-리플일 경우 사용',
  `division` varchar(10) default NULL COMMENT '분류, 말머리',
  `module_no` int(11) NOT NULL COMMENT '모듈 고유번호',
  `user_no` int(11) NOT NULL COMMENT '사용자 번호-users테이블',
  `user_id` varchar(50) NOT NULL COMMENT '사용자 아이디',
  `user_name` varchar(10) NOT NULL COMMENT '작성자 이름',
  `reg_date` datetime NOT NULL COMMENT '등록일',
  `modify_date` datetime NOT NULL COMMENT '수정일',
  `is_notice` enum('Y','N') NOT NULL default 'N' COMMENT '공지글 여부',
  `is_secret` enum('Y','N') NOT NULL default 'N' COMMENT '비밀글 여부',
  `subject` varchar(100) NOT NULL COMMENT '제목',
  `general_setting` text NOT NULL COMMENT '각종 설정',
  `contents` text NOT NULL COMMENT '내용',
  `files_count` int(11) NOT NULL default '0' COMMENT '첨부파일 개수',
  `download_count` int(11) NOT NULL COMMENT '다운로드 수',
  `scrap_count` int(11) NOT NULL COMMENT '스크랩수',
  `hit` int(11) NOT NULL default '0' COMMENT '조회수',
  `trackback_count` int(11) NOT NULL default '0' COMMENT '엮임글 수',
  `reply_count` int(11) NOT NULL default '0' COMMENT '리플수',
  `voted_count` int(11) NOT NULL default '0' COMMENT '추천수',
  `blamed_count` int(11) NOT NULL default '0' COMMENT '신고수',
  `ip` varchar(15) NOT NULL COMMENT '작성자 ip 주소',
  `is_delete` enum('Y','N') NOT NULL default 'N' COMMENT '삭제 여부',
  `password` varchar(20) default NULL COMMENT '로그인시 비밀글의 비밀번호, 비회원은 작성시 비밀번호',
  UNIQUE KEY `no` (`no`),
  KEY `original_no` (`original_no`),
  KEY `user_id` (`user_id`),
  KEY `user_name` (`user_name`),
  KEY `is_delete` (`is_delete`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='게시물 저장'  ;
-- --------------------------------------------------------

--
-- 테이블 구조 `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) collate utf8_bin NOT NULL default '0',
  `ip_address` varchar(16) collate utf8_bin NOT NULL default '0',
  `user_agent` varchar(150) collate utf8_bin NOT NULL,
  `last_activity` int(10) unsigned NOT NULL default '0',
  `user_data` text collate utf8_bin NOT NULL,
  PRIMARY KEY  (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 테이블 구조 `click`
--

CREATE TABLE IF NOT EXISTS `click` (
  `no` int(11) NOT NULL auto_increment,
  `ip` varchar(20) NOT NULL,
  `referer` varchar(200) NOT NULL,
  `date` datetime NOT NULL,
  `id` varchar(4) NOT NULL COMMENT 'banner id',
  PRIMARY KEY  (`no`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- 테이블 구조 `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `no` int(11) NOT NULL auto_increment,
  `module_id` int(11) NOT NULL COMMENT '모듈 번호(테이블번호)',
  `module_no` int(11) NOT NULL COMMENT '글번호',
  `module_name` varchar(50) NOT NULL COMMENT '모듈이름(테이블이름)',
  `module_type` varchar(20) default NULL COMMENT '리플에서 첨부할때 reply라고 선언',
  `original_name` varchar(128) NOT NULL COMMENT '원본 파일명',
  `file_name` varchar(128) NOT NULL COMMENT '파일명',
  `file_type` varchar(20) NOT NULL COMMENT '파일타입',
  `order_by` int(11) NOT NULL default '1' COMMENT '파일순서',
  `reg_date` datetime NOT NULL COMMENT '등록일',
  PRIMARY KEY  (`no`),
  KEY `module_no` (`module_no`),
  KEY `module_name` (`module_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='첨부파일'  ;

-- --------------------------------------------------------

--
-- 테이블 구조 `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) NOT NULL auto_increment,
  `ip_address` varchar(40) collate utf8_bin NOT NULL,
  `login` varchar(50) collate utf8_bin NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin  ;

-- --------------------------------------------------------

--
-- 테이블 구조 `search_words`
--

CREATE TABLE IF NOT EXISTS `search_words` (
  `no` int(11) NOT NULL auto_increment,
  `admin_no` int(11) NOT NULL COMMENT '사이트 관리자 번호',
  `search_word` varchar(255) NOT NULL COMMENT '검색어',
  `date` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT '검색 일시',
  `search_menu` varchar(50) NOT NULL COMMENT '검색 위치',
  `user_id` varchar(12) NOT NULL,
  `ip` varchar(15) NOT NULL COMMENT '검색자ip',
  PRIMARY KEY  (`no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='검색어 테이블'  ;

-- --------------------------------------------------------

--
-- 테이블 구조 `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `no` int(11) NOT NULL auto_increment COMMENT '고유번호(자동)',
  `module_name` varchar(50) NOT NULL COMMENT '테이블이름',
  `parent_no` int(11) NOT NULL COMMENT '태그 걸린 글 번호',
  `module_type` varchar(20) default NULL COMMENT '예 리플일 경우',
  `tag_name` varchar(50) default NULL COMMENT '태그',
  `reg_date` datetime default NULL COMMENT '등록일',
  PRIMARY KEY  (`no`),
  KEY `tag_name` (`tag_name`),
  KEY `module_name` (`module_name`),
  KEY `parent_no` (`parent_no`),
  KEY `module_type` (`module_type`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='태그' ;

-- --------------------------------------------------------


--
-- 테이블 구조 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL auto_increment,
  `auth_code` varchar(10) collate utf8_bin NOT NULL default '3' COMMENT '권한',
  `userid` varchar(50) collate utf8_bin NOT NULL COMMENT '아이디',
  `username` varchar(50) collate utf8_bin NOT NULL,
  `nickname` varchar(50) collate utf8_bin NOT NULL COMMENT '별명',
  `password` varchar(255) collate utf8_bin NOT NULL,
  `email` varchar(100) collate utf8_bin NOT NULL,
  `activated` tinyint(1) NOT NULL default '1',
  `banned` tinyint(1) NOT NULL default '0',
  `ban_reason` varchar(255) collate utf8_bin default NULL,
  `new_password_key` varchar(50) collate utf8_bin default NULL,
  `new_password_requested` datetime default NULL,
  `new_email` varchar(100) collate utf8_bin default NULL,
  `new_email_key` varchar(50) collate utf8_bin default NULL,
  `last_ip` varchar(40) collate utf8_bin NOT NULL,
  `last_login` datetime NOT NULL default '0000-00-00 00:00:00',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `username` (`username`),
  KEY `nickname` (`nickname`),
  FULLTEXT KEY `userid` (`userid`),
  FULLTEXT KEY `password` (`password`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin ;

-- --------------------------------------------------------

--
-- 테이블 구조 `user_autologin`
--

CREATE TABLE IF NOT EXISTS `user_autologin` (
  `key_id` char(32) collate utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL default '0',
  `user_agent` varchar(150) collate utf8_bin NOT NULL,
  `last_ip` varchar(40) collate utf8_bin NOT NULL,
  `last_login` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`key_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 테이블 구조 `user_profiles`
--

CREATE TABLE IF NOT EXISTS `user_profiles` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `country` varchar(20) collate utf8_bin default NULL,
  `website` varchar(255) collate utf8_bin default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
