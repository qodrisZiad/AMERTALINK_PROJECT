/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50505
Source Host           : 127.0.0.1:3306
Source Database       : db_payroll_walet

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-10-02 19:43:06
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for td_presensi
-- ----------------------------
DROP TABLE IF EXISTS `td_presensi`;
CREATE TABLE `td_presensi` (
  `fc_id` int(11) NOT NULL AUTO_INCREMENT,
  `fc_nik` varchar(16) NOT NULL,
  `fd_date` date NOT NULL,
  `fn_perolehan` double DEFAULT NULL,
  `fv_keterangan` varchar(100) DEFAULT NULL,
  `fd_input` date DEFAULT NULL,
  `fc_userid` varchar(50) DEFAULT NULL,
  `fc_status` varchar(1) DEFAULT 'I',
  PRIMARY KEY (`fc_id`,`fc_nik`,`fd_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of td_presensi
-- ----------------------------

-- ----------------------------
-- Table structure for td_transaksi
-- ----------------------------
DROP TABLE IF EXISTS `td_transaksi`;
CREATE TABLE `td_transaksi` (
  `fc_id` int(11) NOT NULL AUTO_INCREMENT,
  `fc_notrans` varchar(15) DEFAULT NULL,
  `fd_absen` date DEFAULT NULL,
  `fn_pencapaian` int(3) DEFAULT NULL,
  `fn_price` double DEFAULT NULL,
  `fn_subtotal` double DEFAULT NULL,
  PRIMARY KEY (`fc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of td_transaksi
-- ----------------------------

-- ----------------------------
-- Table structure for tm_jabatan
-- ----------------------------
DROP TABLE IF EXISTS `tm_jabatan`;
CREATE TABLE `tm_jabatan` (
  `fc_jabatan` int(11) NOT NULL AUTO_INCREMENT,
  `fv_jabatan` varchar(50) DEFAULT NULL,
  `fc_status` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`fc_jabatan`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tm_jabatan
-- ----------------------------
INSERT INTO `tm_jabatan` VALUES ('2', 'STAFF', 'Y');

-- ----------------------------
-- Table structure for tm_karyawan
-- ----------------------------
DROP TABLE IF EXISTS `tm_karyawan`;
CREATE TABLE `tm_karyawan` (
  `fc_nik` varchar(16) NOT NULL,
  `fv_sname` varchar(50) NOT NULL,
  `fv_lname` varchar(50) DEFAULT NULL,
  `fc_sex` varchar(1) DEFAULT NULL,
  `fc_ktp` varchar(16) DEFAULT NULL,
  `fv_tmp_lahir` varchar(100) DEFAULT NULL,
  `fd_lahir` date DEFAULT NULL,
  `fc_hp` varchar(13) DEFAULT NULL,
  `fc_hp2` varchar(12) DEFAULT NULL,
  `fv_addr_ktp` varchar(225) DEFAULT NULL,
  `fv_addr` varchar(225) DEFAULT NULL,
  `fd_masuk` date DEFAULT NULL,
  `fc_jabatan` int(11) DEFAULT NULL,
  `fd_keluar` date DEFAULT NULL,
  `fv_pict` varchar(100) DEFAULT NULL,
  `fc_status` char(1) DEFAULT NULL,
  PRIMARY KEY (`fc_nik`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tm_karyawan
-- ----------------------------
INSERT INTO `tm_karyawan` VALUES ('KAR000003', 'QODRIS', 'ZIAD', 'L', '23434', '234324', '1995-10-07', '234234234234', '23423434234', 'qqsdhfdfassd', 'asdasdasdas', '2018-01-01', '2', null, '', 'Y');
INSERT INTO `tm_karyawan` VALUES ('KAR000004', 'DIKA', 'SYAHPUTRA', 'L', '4535345', 'SADASDA', '2018-09-26', '234234234234', '32423432', 'asdaSD', 'asDASDA', '2018-09-26', '2', null, '', 'Y');

-- ----------------------------
-- Table structure for tm_pricelist
-- ----------------------------
DROP TABLE IF EXISTS `tm_pricelist`;
CREATE TABLE `tm_pricelist` (
  `fc_price` int(11) NOT NULL AUTO_INCREMENT,
  `fn_price` double DEFAULT NULL,
  `fd_price` date DEFAULT NULL,
  `fc_status` char(1) DEFAULT NULL,
  `fc_userid` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`fc_price`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tm_pricelist
-- ----------------------------
INSERT INTO `tm_pricelist` VALUES ('3', '100000', '2018-09-15', 'Y', 'admin');

-- ----------------------------
-- Table structure for tm_transaksi
-- ----------------------------
DROP TABLE IF EXISTS `tm_transaksi`;
CREATE TABLE `tm_transaksi` (
  `fc_notrans` varchar(15) NOT NULL,
  `fd_trans` date NOT NULL,
  `fc_nik` varchar(16) DEFAULT NULL,
  `fn_tot_kerja` int(3) DEFAULT NULL,
  `fc_reward` varchar(1) DEFAULT NULL,
  `fc_punish` varchar(1) DEFAULT NULL,
  `fn_reward` double DEFAULT NULL,
  `fn_subtotal` double DEFAULT NULL,
  `fn_bonus` double DEFAULT NULL,
  `fn_potongan` double DEFAULT NULL,
  `fn_total` double DEFAULT NULL,
  `fc_bayar` varchar(1) DEFAULT NULL,
  `fc_status` varchar(1) DEFAULT NULL,
  `fc_userid` varchar(25) DEFAULT NULL,
  `fd_input` date DEFAULT NULL,
  PRIMARY KEY (`fc_notrans`,`fd_trans`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tm_transaksi
-- ----------------------------

-- ----------------------------
-- Table structure for tm_user
-- ----------------------------
DROP TABLE IF EXISTS `tm_user`;
CREATE TABLE `tm_user` (
  `fc_id` int(11) NOT NULL AUTO_INCREMENT,
  `fc_userid` varchar(25) DEFAULT NULL,
  `fc_password` varchar(16) DEFAULT NULL,
  `fc_hold` varchar(1) DEFAULT NULL,
  `fd_input` date DEFAULT NULL,
  `fc_nik` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`fc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tm_user
-- ----------------------------
INSERT INTO `tm_user` VALUES ('1', 'admin', '0da0b427c0f62a1', 'N', '2018-09-12', '123456789101112');

-- ----------------------------
-- Table structure for t_hakakses
-- ----------------------------
DROP TABLE IF EXISTS `t_hakakses`;
CREATE TABLE `t_hakakses` (
  `fc_nik` varchar(25) DEFAULT NULL,
  `fc_idmenu` int(11) DEFAULT NULL,
  `fc_input` char(1) DEFAULT NULL,
  `fc_update` char(1) DEFAULT NULL,
  `fc_delete` char(1) DEFAULT NULL,
  `fc_view` char(1) DEFAULT NULL,
  `fc_userinput` varchar(25) DEFAULT NULL,
  `fd_input` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of t_hakakses
-- ----------------------------
INSERT INTO `t_hakakses` VALUES ('123456789101112', '1', 'N', 'N', 'N', 'Y', 'admin', '2018-09-13');
INSERT INTO `t_hakakses` VALUES ('123456789101112', '2', 'N', 'N', 'N', 'Y', 'admin', '2018-09-13');
INSERT INTO `t_hakakses` VALUES ('123456789101112', '3', 'N', 'N', 'N', 'Y', 'admin', '2018-09-13');
INSERT INTO `t_hakakses` VALUES ('123456789101112', '4', 'N', 'N', 'N', 'Y', 'admin', '2018-09-13');
INSERT INTO `t_hakakses` VALUES ('123456789101112', '5', 'Y', 'Y', 'Y', 'Y', 'admin', '2018-09-13');
INSERT INTO `t_hakakses` VALUES ('123456789101112', '6', 'Y', 'Y', 'Y', 'Y', 'admin', '2018-09-13');
INSERT INTO `t_hakakses` VALUES ('123456789101112', '7', 'Y', 'Y', 'Y', 'Y', 'admin', '2018-09-13');
INSERT INTO `t_hakakses` VALUES ('123456789101112', '8', 'Y', 'Y', 'Y', 'Y', 'admin', '2018-09-13');
INSERT INTO `t_hakakses` VALUES ('123456789101112', '9', 'Y', 'Y', 'Y', 'Y', 'admin', '2018-09-13');
INSERT INTO `t_hakakses` VALUES ('123456789101112', '10', 'Y', 'Y', 'Y', 'Y', 'admin', '2018-09-13');
INSERT INTO `t_hakakses` VALUES ('123456789101112', '11', 'Y', 'Y', 'Y', 'Y', 'admin', '2018-09-13');
INSERT INTO `t_hakakses` VALUES ('123456789101112', '12', 'N', 'N', 'N', 'Y', 'admin', '2018-09-13');
INSERT INTO `t_hakakses` VALUES ('123456789101112', '13', 'N', 'N', 'N', 'Y', 'admin', '2018-09-13');
INSERT INTO `t_hakakses` VALUES ('123456789101112', '14', 'N', 'N', 'N', 'Y', 'admin', '2018-09-13');
INSERT INTO `t_hakakses` VALUES ('123456789101112', '15', 'Y', 'Y', 'Y', 'Y', 'admin', '2018-09-13');

-- ----------------------------
-- Table structure for t_menu
-- ----------------------------
DROP TABLE IF EXISTS `t_menu`;
CREATE TABLE `t_menu` (
  `fc_id` int(11) NOT NULL AUTO_INCREMENT,
  `fc_parent` int(11) DEFAULT NULL,
  `fv_menu` varchar(20) DEFAULT NULL,
  `fc_link` varchar(50) DEFAULT NULL,
  `fv_class1` varchar(50) DEFAULT NULL,
  `fv_class2` varchar(50) DEFAULT NULL,
  `fc_hold` char(1) DEFAULT NULL,
  PRIMARY KEY (`fc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of t_menu
-- ----------------------------
INSERT INTO `t_menu` VALUES ('1', null, 'Home', 'home', 'fa-home', null, 'N');
INSERT INTO `t_menu` VALUES ('2', null, 'Master', '#', 'fa-plug', null, 'N');
INSERT INTO `t_menu` VALUES ('3', null, 'Transaksi', '#', 'fa-dollar', null, 'N');
INSERT INTO `t_menu` VALUES ('4', null, 'Laporan', '#', 'fa-desktop', null, 'N');
INSERT INTO `t_menu` VALUES ('5', '2', 'Jabatan', 'jabatan', null, null, 'N');
INSERT INTO `t_menu` VALUES ('6', '2', 'Price', 'price', null, null, 'N');
INSERT INTO `t_menu` VALUES ('7', '2', 'Punish / Reward', 'punish', null, null, 'N');
INSERT INTO `t_menu` VALUES ('8', '2', 'Karyawan', 'karyawan', null, null, 'N');
INSERT INTO `t_menu` VALUES ('9', '2', 'user', 'user', null, null, 'Y');
INSERT INTO `t_menu` VALUES ('10', '3', 'Presensi', 'presensi', null, null, 'N');
INSERT INTO `t_menu` VALUES ('11', '3', 'Payroll', 'payroll', null, null, 'N');
INSERT INTO `t_menu` VALUES ('12', '4', 'View Presensi', 'v_presensi', null, null, 'N');
INSERT INTO `t_menu` VALUES ('13', '4', 'View Payroll', 'v_payroll', null, null, 'N');
INSERT INTO `t_menu` VALUES ('14', '4', 'View Punish / Reward', 'v_reward', null, null, 'N');
INSERT INTO `t_menu` VALUES ('15', '3', 'Cetak Payroll', 'cetak', null, null, 'N');

-- ----------------------------
-- Table structure for t_nomor
-- ----------------------------
DROP TABLE IF EXISTS `t_nomor`;
CREATE TABLE `t_nomor` (
  `fc_param` varchar(20) DEFAULT NULL,
  `fc_prefix` varchar(5) DEFAULT NULL,
  `fn_nomor` int(9) DEFAULT NULL,
  `fn_long` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of t_nomor
-- ----------------------------
INSERT INTO `t_nomor` VALUES ('nik', 'KAR', '5', '6');
INSERT INTO `t_nomor` VALUES ('payroll', 'PAY', '1', '8');

-- ----------------------------
-- Table structure for t_setup
-- ----------------------------
DROP TABLE IF EXISTS `t_setup`;
CREATE TABLE `t_setup` (
  `fc_param` varchar(15) DEFAULT NULL,
  `fv_value` varchar(50) DEFAULT NULL,
  `fv_ket` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of t_setup
-- ----------------------------
INSERT INTO `t_setup` VALUES ('KEY_SA', 'SA_DEV', '');
INSERT INTO `t_setup` VALUES ('PUNISH', '1000', 'untuk punishment nya');
INSERT INTO `t_setup` VALUES ('REWARD', '10000', 'untuk rewardnya');
INSERT INTO `t_setup` VALUES ('limit_punish', '2', 'untuk batas masuk kena punish');
INSERT INTO `t_setup` VALUES ('limit_reward', '6', 'untuk batas masuk kena reward');

-- ----------------------------
-- Function structure for rupiah
-- ----------------------------
DROP FUNCTION IF EXISTS `rupiah`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `rupiah`(number BIGINT) RETURNS varchar(255) CHARSET latin1
    DETERMINISTIC
BEGIN  
DECLARE hasil VARCHAR(255);  
SET hasil = REPLACE(REPLACE(REPLACE(FORMAT(number, 0), '.', '|'), ',', '.'), '|', ',');  
RETURN (hasil);  
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `update_nota`;
DELIMITER ;;
CREATE TRIGGER `update_nota` BEFORE UPDATE ON `tm_transaksi` FOR EACH ROW BEGIN
	DECLARE done INT DEFAULT FALSE;
	DECLARE nomor VARCHAR(20);
	DECLARE tanggal date;
	DECLARE tanggal2 date;
	DECLARE cur CURSOR FOR SELECT fd_date FROM td_presensi WHERE fc_nik=old.fc_nik and fc_status ='I';
	DECLARE cur2 CURSOR FOR SELECT fd_date FROM td_presensi WHERE fc_nik=old.fc_nik and fc_status ='F';
	DECLARE CONTINUE HANDLER FOR NOT FOUND set done= true;
	OPEN cur;
	OPEN cur2;
	SET nomor = (select CONCAT(fc_prefix,LPAD(fn_nomor,fn_long,'0')) FROM t_nomor WHERE fc_param='payroll');
	IF new.fc_status='F' THEN
			read_loop:LOOP
			FETCH cur INTO tanggal;
				IF done THEN
					LEAVE read_loop;
				END IF;
				UPDATE td_presensi set fc_status='F' WHERE fc_nik=old.fc_nik and fd_date=tanggal;
				UPDATE td_transaksi set fc_notrans=nomor where fc_notrans=old.fc_notrans;  
				set new.fc_notrans=nomor; 
			END LOOP;
			UPDATE t_nomor set fn_nomor=fn_nomor+1 where fc_param='payroll';
	ELSEIF new.fc_status='D' THEN
		read_loop:LOOP
			FETCH cur2 INTO tanggal2;
				IF done THEN
					LEAVE read_loop;
				END IF;
				UPDATE td_presensi set fc_status='I' WHERE fc_nik=old.fc_nik and fd_date=tanggal2; 
			END LOOP;
	END IF;
	CLOSE cur;
end
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `hapus_nota`;
DELIMITER ;;
CREATE TRIGGER `hapus_nota` BEFORE DELETE ON `tm_transaksi` FOR EACH ROW BEGIN
		DELETE FROM td_transaksi WHERE fc_notrans = old.fc_notrans;
END
;;
DELIMITER ;
