<script type="text/javascript" src="fusion/JS/jquery-1.4.js"></script>


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <i class="glyphicon glyphicon-new-window"></i> Hasil Kuisioner
        </h1>
        <ol class="breadcrumb">
        	<li class="active">
                 <a href="master.php?module=hasil&sub=all">Hasil Kuisioner</a>
            </li>
        	<?php if ($_GET['sub']=='all'){ ?>
            <li class="active">
                 <a href="master.php?module=hasil&sub=all">Data Keseluruhan</a>
            </li>
            <?php } ?>
			<?php if ($_GET['sub']=='pergroup'){ ?>
            <li class="active">
                 <a href="master.php?module=hasil&sub=pergroup">Data Per Group</a>
            </li>
            <?php } ?>
            <?php if ($_GET['sub']=='pergroup'){ ?>
            <li class="active">
                 <a href="master.php?module=hasil&sub=pergroup">Laporan</a>
            </li>
            <?php } ?>

        </ol>
    </div>
</div>
<nav class="navbar navbar-inverse" >
	<ul class="nav navbar-nav">
		<li class="<?php if($_GET['sub']=='all'){echo'active';} ?>"><a href="?module=hasil&sub=all">Data Keseluruhan</a></li>
		<li class="<?php if($_GET['sub']=='pergroup'){echo'active';} ?>"><a href="?module=hasil&sub=pergroup">Data Per Group</a></li>
		<li class="<?php if($_GET['sub']=='laporan'){echo'active';} ?>"><a href="?module=hasil&sub=laporan">Laporan</a></li>
	</ul>
</nav>
<?php if ($_GET['sub']=='all'){ ?>
	<div class="panel panel-primary">
		
		<div class="panel-body">

			<?php 
				$query1= mysql_query("SELECT descriptionId FROM tdescription"); 
				$query2= mysql_query("SELECT * FROM tcompany");


			?>
			<table id="myHTMLTable" border="0" cellpadding="5" class="table table-striped">
				<tr>
					<td><font size=3 face=tahoma>No</font></td>
					<td><font size=3 face=tahoma>Responden</font></td>
					<?php $no = 1; while ($hasill= mysql_fetch_array($query1)) : ?>
						<td><font size=3 face=tahoma><?php echo "Q".$no++; ?></font></td>
					<?php endwhile; ?>
					<td><font size=3 face=tahoma>JML</font></td>
					<td><font size=3 face=tahoma>HASIL(*2,5)</font></td>
				</tr>
				
				<?php $nomor = 1; ?>
				<?php while ( $hasil = mysql_fetch_array($query2)) : ?>
				<?php $query3= mysql_query("SELECT descriptionId FROM tdescription");?>
				<?php $jmlnilai = 0; ?>
				<tr>
						<td><?php echo $nomor++; ?></td>
						<td><?php echo $hasil[companyId]; ?></td>
						<?php $no=0; ?>
						<?php while ($hasill= mysql_fetch_array($query3)) : ?>
							<?php $query5 = mysql_query("SELECT jawaban FROM tanswer WHERE companyId='".$hasil[companyId]."' AND descriptionId = ".$hasill[descriptionId].""); ?>
							<?php 
								$nilaii =mysql_fetch_array($query5); 
								$nilai=$nilaii[jawaban];
							?>
								<?php if ($nilaii>0) { ?>
									<?php if ($nilai == "A"){
										$nilai = 5;
									}elseif ($nilai=="B") {
										$nilai = 4;
									}elseif ($nilai=="C") {
										$nilai = 3;
									}elseif ($nilai=="D") {
										$nilai = 2;
									}elseif ($nilai=="E") {
										$nilai = 1;
									}
									?>
								<?php $no++; ?>
			
								<?php if ($no % 2 == 0){ ?>
									<?php $hasilnilai= 5-$nilai ?>
									<td><font size=3 face=tahoma><?php echo $hasilnilai ; ?></font></td>
								<?php }else{ ?>
									<?php $hasilnilai= $nilai-1 ?>
									<td><font size=3 face=tahoma><?php echo $hasilnilai ; ?></font></td>
								<?php } ?>
								
							<?php }else{ ?>
								<td><font size=3 face=tahoma><?php echo 0 ; ?></font></td>
							<?php } ?>
							
							<?php $jmlnilai += $hasilnilai; ?>
		
						<?php endwhile; ?>
						<?php  ?>
						<td><?php echo $jmlnilai; ?></td>
						<td><?php echo $hasil=$jmlnilai*2.5; ?></td>
						<?php $jmltotal+=$hasil; ?>
						<?php $jmlbagi=mysql_num_rows($query2); ?>
				</tr>
				<?php endwhile; ?>
				<tr>
					<td></td>
					<td>jumlah</td>
					<td>hasil:</td>
					<td><?php echo $jmltotal; ?></td>
				</tr>
				<tr>
					<td></td>
					<td>rata-rata</td>
					<td>hasil responden</td>
					<td><?php echo $jmltotal/$jmlbagi; ?></td>
				</tr>				
			</table>
			<script type="text/javascript">
			$('#myHTMLTable').convertToFusionCharts({
				swfPath: "fusion/Charts/",
				type: "MSColumn2D",
				data: "#myHTMLTable",
				dataFormat: "HTMLTable",
				width:1000,
				height:500,
			});
			</script>
		</div>
	</div>
<?php } ?>
<?php if ($_GET['sub']=='pergroup'){ ?>

		<?php
		error_reporting(1);
		$result=mysql_query("SELECT groupId from tgroup group by groupId ");
		$kolom = 2;
		$array=array();
		while ($sql=mysql_fetch_array($result)) 
		{
			array_push($array, $sql);
		}
		$chunks=array_chunk($array, $kolom);

			foreach ($chunks as $chunk) {
			    foreach ($chunk as $data) {
			        echo "<div class='col-md-15'style='padding-left:0px;padding-right:0px;'>";
			        $data2=mysql_fetch_array(mysql_query("SELECT *from tgroup where groupId='$data[groupId]' group by groupId "));
			        ?>
					<div class="panel panel-primary" style='margin-left:10px'>
						<div class="panel-heading">
							<div class="panel-title"><?php echo $data2['groupName']; ?></div>
						</div>
						
							<?php 
				$query1= mysql_query("SELECT descriptionId FROM tdescription WHERE groupId =".$data2[groupId]." "); 
				$query2= mysql_query("SELECT * FROM tcompany");


			?>
			<table id="myHTMLTable" border="0" cellpadding="5" class="table table-striped">
				<tr>
					<td><font size=3 face=tahoma>No</font></td>
					<td><font size=3 face=tahoma>Responden</font></td>
					<?php $no = 1; while ($hasill= mysql_fetch_array($query1)) : ?>
						<td><font size=3 face=tahoma><?php echo "Q".$no++; ?></font></td>
					<?php endwhile; ?>
					<td><font size=3 face=tahoma>JML</font></td>
					<td><font size=3 face=tahoma>HASIL(*2,5)</font></td>
				</tr>
				
				<?php $nomor = 1; ?>
				<?php while ( $hasil = mysql_fetch_array($query2)) : ?>
				<?php $query3= mysql_query("SELECT descriptionId FROM tdescription WHERE groupId =".$data2[groupId]."");?>
				<?php $jmlnilai = 0; ?>
				<tr>
						<td><?php echo $nomor++; ?></td>
						<td><?php echo $hasil[companyId]; ?></td>
						<?php $no=0; ?>
						<?php while ($hasill= mysql_fetch_array($query3)) : ?>
							<?php $query5 = mysql_query("SELECT * FROM tanswer WHERE companyId='".$hasil[companyId]."' AND descriptionId = ".$hasill[descriptionId]." AND groupId =".$data2[groupId]." "); ?>
							<?php 
								$nilaii =mysql_fetch_array($query5); 
								$nilai=$nilaii[jawaban];
							?>
								<?php if ($nilaii>0) { ?>
									<?php if ($nilai == "A"){
										$nilai = 5;
									}elseif ($nilai=="B") {
										$nilai = 4;
									}elseif ($nilai=="C") {
										$nilai = 3;
									}elseif ($nilai=="D") {
										$nilai = 2;
									}elseif ($nilai=="E") {
										$nilai = 1;
									}
									?>
								<?php $no++; ?>
			
								<?php if ($no % 2 == 0){ ?>
									<?php $hasilnilai= 5-$nilai ?>
									<td><font size=3 face=tahoma><?php echo $hasilnilai ; ?></font></td>
								<?php }else{ ?>
									<?php $hasilnilai= $nilai-1 ?>
									<td><font size=3 face=tahoma><?php echo $hasilnilai ; ?></font></td>
								<?php } ?>
								
							<?php }else{ ?>
								<td><font size=3 face=tahoma><?php echo 0 ; ?></font></td>
							<?php } ?>
							
							<?php $jmlnilai += $hasilnilai; ?>
		
						<?php endwhile; ?>
						<?php  ?>
						<td><?php echo $jmlnilai; ?></td>
						<td><?php echo $hasil=$jmlnilai*2.5; ?></td>
						<?php $jmltotal+=$hasil; ?>
						<?php $jmlbagi=mysql_num_rows($query2); ?>
				</tr>
				<?php endwhile; ?>
				
				</tr>				
			</table>
			<table id="myHTMLTable" border="0" cellpadding="5" class="table table-striped" >
				<tr>
					<td></td>
					<td>jumlah hasil:</td>
					<td><?php echo $jmltotal; ?></td>
				</tr>
				<tr>
					<td></td>
					<td>rata-rata hasil responden</td>
					<td><?php echo $jmltotal/$jmlbagi; ?></td>
			</table>
			<?php $jmltotal=0; ?>
							
							<script type="text/javascript">
							$('#myHTMLTable<?php echo $data2[groupId]; ?>').convertToFusionCharts({
								swfPath: "fusion/Charts/",
								type: "MSColumn3D",
								data: "#myHTMLTable",
								dataFormat: "HTMLTable",
								width:500,
								height:300,
							});
							</script>
						</div>
					</div>
			        <?php
			        echo '</div>';
			    }
			    
			}
			
		?>
	
 <?php } ?>
 <?php if ($_GET['sub']=='laporan')
 { ?>
			
				<div class="panel-body">
					<div class="row">
						<div class="col-md-5">
							<div class="panel panel-default">
								<div class="panel-heading">
									<div class="panel-title"> Tampilkan Berdasarkan Tanggal</div>
								</div>
								<div class="panel-body">
									<form action="?module=hasil&sub=laporan&tampilkan=pertanggal" method="post" class="form-horizontal">
									<?php include "../fungsi/fungsi_combobox.php"; include "../fungsi/library.php";?>
										<div class="form-group">
											<label for="tanggal1" class="control-label col-sm-4">Dari tanggal</label>
											<div class="col-sm-7">
											
											<?php	combotgl(01,31,'tgl_mulai',$tgl_skrg);
											combobln(01,12,'bln_mulai',$bln_sekarang);
											combothn(2000,$thn_sekarang,'thn_mulai',$thn_sekarang); 
											?>
					 						</div>
										</div>
										<div class="form-group">
											<label for="tanggal2" class="control-label col-sm-4">s/d Tanggal</label>
											<div class="col-sm-7">
												
												<?php	combotgl(01,31,'tgl_selesai',$tgl_skrg);
												combobln(01,12,'bln_selesai',$bln_sekarang);
												combothn(2000,$thn_sekarang,'thn_selesai',$thn_sekarang); 
												?>
						 					</div>
						 				</div>
						 				<div class="col-sm-4">
						 				<input type="hidden" name="pertanggal" value="pertanggal">
						 				</div>
						 				<div class="col-sm-4">
						 					<button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-search"></span>  Oke</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>

					<?php if($_GET['tampilkan']=='pertanggal'){ 
							$tgl_awal= $_POST['thn_mulai']."-".$_POST['bln_mulai']."-".$_POST['tgl_mulai'];
							$tgl_akhir= $_POST['thn_selesai']."-".$_POST['bln_selesai']."-".$_POST['tgl_selesai'];
							$awalindo=tgl_indo($tgl_awal);
							$akhirindo=tgl_indo($tgl_akhir);

						?>
							<div class="alert alert-info" role="alert">
 								 Menampilkan data dari tanggal <b><?php echo $awalindo." Sampai dengan ".$akhirindo ?><b/> 
							</div>
							<table id="tablekonten" class="table table-striped table-bordered">
						         <th><div id='kontentd'>No</div>
						         </th>
						         <th><div id='kontentd'>Nama Responden</div></th>
						         <th>Tanggal Isi Survey</th>
						         <th><div id='kontentd'>komentar dan saran</div></th>
						         <th><div id='kontentd'>Nomor Telepon</div></th>
						         <th><div id='kontentd'>Aksi</div></th></tr>
									<?php
									include "../../koneksi.php";
									include "../../fungsi/fungsi_indotgl.php";
									error_reporting(1);
										$jumlahdata = mysql_num_rows(mysql_query("SELECT * FROM tcompany WHERE dateSurvey BETWEEN '$tgl_awal' AND '$tgl_akhir'"));
										$sql = mysql_query("SELECT * FROM tcompany WHERE dateSurvey BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER by companyName ");
										$no =1;
									while ($data = mysql_fetch_array($sql)){
										$dateIndo = tgl_indo($data['dateSurvey']);
										?>
										<tr><td><div id='kontentd'><?php echo $no;?></div></td>
												 <td><div id='kontentd'><?php echo $data['companyName'] ?></div></td>
												 <td><?php echo $dateIndo ?></td>
												 <td><?php echo $data['suggestion']; ?></td>
												  <td><?php echo $data['companyPhoneHp']; ?></td>
												 <td><div id='kontentd'><a target='_blank' href='modul/mod_report/responden.php?act=detail&id=<?php echo $data[companyId];?>' >
												 <button class='btn btn-sm btn-success'><span class=\"glyphicon glyphicon-zoom-in\"></span> Detail</button></a>
												 <?php if($_SESSION['level']=="Super"){?><a href='modul/mod_report/responden.php?act=hapus&id=<?php echo $data[companyId]?>'>
												 <button class='btn btn-sm btn-danger' onclick=\"return confirm('Hapus Deskripsi?')\"><span class=\"glyphicon glyphicon-trash\"></span> Hapus</button></a><?php } ?>
												 </div>
									   </td></tr>
											<?php
										$no++;
									}
									?>
									
							</table>
							<div class="col-md-12">
								<div class="well">
									<?php echo "Jumlah Responden : <font face='tahoma' size='3'><b>$jumlahdata </b> Responden</font>"; ?>
								</div>
							</div>
							<?php	
							}
							else
							{ ?>
							<div class="alert alert-info" role="alert">
 								 <strong>Menampilkan semua hasil survey</strong> 
							</div>
									<table id="tablekonten" class="table table-striped table-bordered">
						         <th><div id='kontentd'>No</div>
						         </th>
						         <th><div id='kontentd'>Nama Responden</div></th>
						         <th>Tanggal Isi Survey</th>
						         <th><div id='kontentd'>komentar dan saran</div></th>
						         <th><div id='kontentd'>Nomor Telepon</div></th>
						         <th><div id='kontentd'>Aksi</div></th></tr>
									<?php
											include "../../koneksi.php";
											include "../../fungsi/fungsi_indotgl.php";
											error_reporting(1);
											
											
												$jumlahdata = mysql_num_rows(mysql_query("SELECT * FROM tcompany "));
												$p      = new PagingHasil;
												$batas  = 10;
												$posisi = $p->cariPosisi($batas);
												$sql = mysql_query("SELECT * FROM tcompany  ORDER by companyName ASC LIMIT $posisi,$batas");
												$no = $posisi+1;
											while ($data = mysql_fetch_array($sql)){
												$dateIndo = tgl_indo($data['dateSurvey']);
												?>
												<tr><td><div id='kontentd'><?php echo $no;?></div></td>
														 <td><div id='kontentd'><?php echo $data['companyName'] ?></div></td>
														 <td><?php echo $dateIndo ?></td>
														 <td><?php echo $data['suggestion']; ?></td>
														  <td><?php echo $data['companyPhoneHp']; ?></td>
														 <td><div id='kontentd'><a target='_blank' href='modul/mod_report/responden.php?act=detail&id=<?php echo $data[companyId];?>' >
														 <button class='btn btn-sm btn-success'><span class=\"glyphicon glyphicon-zoom-in\"></span> Detail</button></a>
														 <?php if($_SESSION['level']=="Super"){?><a href='modul/mod_report/responden.php?act=hapus&id=<?php echo $data[companyId]?>'>
														 <button class='btn btn-sm btn-danger' onclick=\"return confirm('Hapus Deskripsi?')\"><span class=\"glyphicon glyphicon-trash\"></span> Hapus</button></a><?php } ?>
														 </div>
											   		</td>
											   </tr>
													<?php
												$no++;
											}
											?>
									</table>
									<div class="col-md-12">
										<div class="well">
											<?php echo "Jumlah Responden : <font face='tahoma' size='3'><b>$jumlahdata </b> Responden</font>"; ?>
										</div>
									</div>
							<?php

								$jmldata = mysql_num_rows(mysql_query("SELECT * FROM tcompany "));
								$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
								$linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);
							
								echo "<ul class='pagination'>$linkHalaman</ul> ";
							
							}
						?>
				</div>
			</div>
 <?php 
 } ?>