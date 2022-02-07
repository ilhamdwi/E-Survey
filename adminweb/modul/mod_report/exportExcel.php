<?php
error_reporting(0);
$namaFile = "all_responden_recap_report.xls";
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Content-Disposition: attachment; filename=$namaFile");
header("Content-Transfer-Encoding: binary ");

include "../../../koneksi.php";
include "../../../fungsi/fungsi_indotgl.php";

$hasil = mysql_query("SELECT * FROM tdescription");
$date = date('Y-m-d');
$time = date('H:i:s');
$dateIndo = tgl_indo($date);

echo "<table border=1 cellpadding=0 cellspacing=0>
		<tr>
			<td colspan=8 bgcolor=yellow style='border: none'; align='center'>Laporan Rekap Kuisioner Responden</td>
		</tr>
		<tr>
			<td colspan=8>Dicetak : <b>$dateIndo $time</b></td>
		</tr>
		
		<tr>
			<td bgcolor=#c6e1f2 align=center><b>NO</b></td>
			<td bgcolor=#c6e1f2 align=center><b>GROUP ID</b></td>
			<td bgcolor=#c6e1f2 align=center><b>DESCRIPTION</b></td>
			<td bgcolor=#c6e1f2 align=center><b>JAWABAN A</b></td>
			<td bgcolor=#c6e1f2 align=center><b>JAWABAN B</b></td>
			<td bgcolor=#c6e1f2 align=center><b>JAWABAN C</b></td>
			<td bgcolor=#c6e1f2 align=center><b>JAWABAN D</b></td>
			<td bgcolor=#c6e1f2 align=center><b>JAWABAN E</b></td>
		</tr>";
$no = 1;
while ($data = mysql_fetch_array($hasil)){
	$descriptionId = $data[descriptionId];
	$sql = mysql_query("SELECT SUM(jawaban1) As Total1,
						SUM(jawaban2) As Total2,
						SUM(jawaban3) As Total3,
						SUM(jawaban4) As Total4,
						SUM(jawaban5) As Total5
						FROM tanswer WHERE descriptionId = '$descriptionId'");
	
	while($oke = mysql_fetch_array($sql)){
		echo "<tr valign=top>
			<td>$no</td>
			<td>$data[groupId]</td>
			<td>$data[description]</td>
			<td>$oke[Total1]</td>
			<td>$oke[Total2]</td>
			<td>$oke[Total3]</td>
			<td>$oke[Total4]</td>
			<td>$oke[Total5]</td>
		  </tr>";	 
		$no++;
	}
}
$data_count = mysql_fetch_array(mysql_query("SELECT SUM(jawaban1) As Total1,
						SUM(jawaban2) As Total2,
						SUM(jawaban3) As Total3,
						SUM(jawaban4) As Total4,
						SUM(jawaban5) As Total5
						FROM tanswer"));
echo "<tr align=center>
	
	<td bgcolor=#c6e1f2 colspan=3><b>Total</b></td>
	<td bgcolor=#c6e1f2><b>$data_count[Total1]</b></td>
	<td bgcolor=#c6e1f2><b>$data_count[Total2]</b></td>
	<td bgcolor=#c6e1f2><b>$data_count[Total3]</b></td>
	<td bgcolor=#c6e1f2><b>$data_count[Total4]</b></td>
	<td bgcolor=#c6e1f2><b>$data_count[Total5]</b></td>
	</tr></table>";
?>