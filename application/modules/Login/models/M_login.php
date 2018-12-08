<?php 
if(!defined('BASEPATH')) exit('Maaf akses anda kami tutup.');
class M_login extends CI_Model{
	function login($user,$pass){  
		$query_select = "select * from tm_user where fc_userid='".$user."' and fc_password = SUBSTR(MD5(CONCAT(SUBSTR(MD5('".$pass."'),1,16),(select fv_value from t_setup where fc_param = 'KEY_SA'))),1,15) COLLATE utf8_general_ci and fc_hold='0'";
		$query = $this->db->query($query_select);
		return $query->num_rows();
	}
	function getData($userid,$password){
		$query_select = "SELECT
				a.*,c.fv_jabatan,
			CASE b.fc_sex
				WHEN 'L' THEN CONCAT('mr.',b.fv_sname,' ',b.fv_lname,'.')
				WHEN 'P' THEN CONCAT('mrs.',b.fv_sname,' ',b.fv_lname,'.')
			END as greeting
			FROM
				tm_user a
			left outer join tm_karyawan b ON b.fc_nik = a.fc_nik
			left outer join tm_jabatan c on c.fc_jabatan = b.fc_jabatan
			WHERE
				a.fc_userid = '".$userid."'
			AND a.fc_password = SUBSTR(MD5(CONCAT(SUBSTR(MD5('".$password."'), 1, 16),(SELECT fv_value FROM t_setup WHERE fc_param = 'KEY_SA'))),1,15) COLLATE utf8_general_ci
			AND a.fc_hold = '0'";
		$query = $this->db->query($query_select);
		return $query->row();
	}
}