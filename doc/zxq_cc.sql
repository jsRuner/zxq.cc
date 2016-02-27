-- phpMyAdmin SQL Dump
-- version 4.4.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2016-02-27 13:07:30
-- 服务器版本： 5.6.21
-- PHP Version: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zxq.cc`
--

-- --------------------------------------------------------

--
-- 表的结构 `football`
--

CREATE TABLE IF NOT EXISTS `football` (
  `id` int(11) NOT NULL,
  `football_code` varchar(11) NOT NULL COMMENT '比赛编号',
  `football_date` int(11) NOT NULL COMMENT '比赛日期',
  `football_team1` varchar(125) NOT NULL COMMENT '比赛主队',
  `team1_rank` int(11) NOT NULL COMMENT '主队排名',
  `football_team2` varchar(125) NOT NULL COMMENT '客队',
  `team2_rank` int(11) NOT NULL COMMENT '客队排名',
  `football_score` varchar(11) NOT NULL COMMENT '比分。如3：1',
  `football_result` varchar(11) NOT NULL COMMENT '比赛结果',
  `add_time` int(11) NOT NULL COMMENT '添加记录时间',
  `update_time` int(11) NOT NULL COMMENT '修改记录时间',
  `data_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '数据状态默认为1。'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='足球彩票';

--
-- 转存表中的数据 `football`
--

INSERT INTO `football` (`id`, `football_code`, `football_date`, `football_team1`, `team1_rank`, `football_team2`, `team2_rank`, `football_score`, `football_result`, `add_time`, `update_time`, `data_status`) VALUES
(6, '32121', 1456502400, '321', 321, '321', 321, '321', '321321', 0, 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `football_peilv`
--

CREATE TABLE IF NOT EXISTS `football_peilv` (
  `id` int(11) NOT NULL,
  `peilv_type` varchar(11) NOT NULL COMMENT '让球数量',
  `peilv_win` float NOT NULL COMMENT '胜',
  `peilv_draw` float NOT NULL COMMENT '平',
  `peilv_fail` float NOT NULL COMMENT '负',
  `add_time` int(11) NOT NULL COMMENT '新增时间',
  `update_time` int(11) NOT NULL COMMENT '修改时间',
  `data_status` tinyint(1) NOT NULL COMMENT '数据状态',
  `football_code` varchar(11) NOT NULL COMMENT '关联的比赛编号',
  `football_id` int(11) NOT NULL COMMENT '关联的比赛id'
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='足球比赛的赔率表';

--
-- 转存表中的数据 `football_peilv`
--

INSERT INTO `football_peilv` (`id`, `peilv_type`, `peilv_win`, `peilv_draw`, `peilv_fail`, `add_time`, `update_time`, `data_status`, `football_code`, `football_id`) VALUES
(1, '11', 22, 33, 444, 0, 0, 0, '', 1),
(2, '21', 21, 21, 21, 0, 0, 0, '', 1),
(3, '1', 1, 2, 3, 0, 0, 0, '', 1),
(4, '11', 22, 33, 444, 0, 0, 0, '', 1),
(5, '11', 22, 333, 4444, 0, 0, 0, '', 2),
(6, '11', 22, 33, 444, 0, 0, 0, '', 2),
(7, '11', 22, 333, 444, 0, 0, 0, '', 2),
(8, '21', 21, 21, 21, 0, 0, 0, '', 2),
(9, '1321321', 3222110, 11, 32321, 0, 0, 0, '', 4),
(10, '11', 22, 33, 44, 0, 0, 0, '', 4),
(11, '1', 2, 3, 4, 0, 0, 0, '', 4),
(13, '12', 22, 33, 444, 0, 0, 0, '', 5),
(16, '+1', 1, 2, 3, 0, 0, 0, '', 6),
(17, '-2ba', 2, 2.1, 2.2, 0, 0, 0, '', 6),
(18, '-2', 11, 22, 33, 0, 0, 0, '', 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `football`
--
ALTER TABLE `football`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `football_peilv`
--
ALTER TABLE `football_peilv`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `football`
--
ALTER TABLE `football`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `football_peilv`
--
ALTER TABLE `football_peilv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
