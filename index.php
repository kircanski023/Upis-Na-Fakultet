<?php

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
	header("location: login.php");
	exit;
}

include('config.php');

$added = false;


//Add new student  

if (isset($_POST['submit'])) {
	$broj_indeksa = $_POST['br_indeksa'];
	$ime_studenta = $_POST['ime_studenta'];
	$prezime_studenta = $_POST['prezime_studenta'];
	$ime_oca = $_POST['ime_oca'];
	$jmbg = $_POST['student_jmbg'];
	$datum_rodjenja = $_POST['datum_rodjenja'];
	$pol = $_POST['pol'];
	$email = $_POST['email'];
	$broj_telefona = $_POST['broj_telefona'];
	$drzavljanstvo = $_POST['state'];
	$grad = $_POST['grad'];
	$ulica = $_POST['ulica'];
	$opstina = $_POST['opstina'];
	$postanski_broj = $_POST['zip'];
	$ime_majke = $_POST['ime_majke'];
	$napomena = $_POST['napomena'];
	$id_sluzbenika = $_POST['id_sluzbenika'];



	//image upload

	$msg = "";
	$image = $_FILES['image']['name'];
	$target = "upload_images/" . basename($image);

	if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
		$msg = "Uspešno je dodata slika!";
	} else {
		$msg = "Slika nije dodata!";
	}

	$insert_data = "INSERT INTO student(broj_indeksa, ime_studenta, prezime_studenta, ime_oca, jmbg, datum_rodjenja, pol, email, broj_telefona, drzavljanstvo, grad, ulica, opstina, postanski_broj, ime_majke, napomena, id_sluzbenika,slika,upisan) VALUES ('$broj_indeksa','$ime_studenta','$prezime_studenta','$ime_oca','$jmbg','$datum_rodjenja','$pol','$email','$broj_telefona','$drzavljanstvo','$grad','$ulica','$opstina','$postanski_broj','$ime_majke','$napomena','$id_sluzbenika','$image',NOW())";
	$run_data = mysqli_query($con, $insert_data);

	if ($run_data) {
		$added = true;
	} else {
		echo "Podaci nisu upisani!";
	}
}

?>







<!DOCTYPE html>
<html>

<head>
	<title>Upis Studenta Na Fakultet</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

	<div class="container">

		<hr>

		<!-- adding alert notification  -->
		<?php
		if ($added) {
			echo "
			<div class='btn-success' style='padding: 15px; text-align:center;'>
				Vaši podaci o studentu su uspešno upisani!
			</div><br>
		";
		}

		?>





		<a href="logout.php" class="btn btn-success"><i class="fa fa-lock"></i> Odjavi se</a>
		<button class="btn btn-success" type="button" data-toggle="modal" data-target="#myModal">
			<i class="fa fa-plus"></i> Dodaj studenta
		</button>
		<hr>
		<table class="table table-bordered table-striped table-hover" id="myTable">
			<thead>
				<tr>
					<th class="text-center" scope="col">Redni broj</th>
					<th class="text-center" scope="col">Ime</th>
					<th class="text-center" scope="col">Broj indeksa</th>
					<th class="text-center" scope="col">Telefon</th>
					<th class="text-center" scope="col">Id mentora</th>
					<th class="text-center" scope="col">Prikazi</th>
					<th class="text-center" scope="col">Uredi</th>
					<th class="text-center" scope="col">Obrisi</th>
				</tr>
			</thead>
			<?php

			$get_data = "SELECT * FROM student order by 1 desc";
			$run_data = mysqli_query($con, $get_data);
			$i = 0;
			while ($row = mysqli_fetch_array($run_data)) {
				$sl = ++$i;
				$id = $row['id'];
				$broj_indeksa = $row['broj_indeksa'];
				$ime_studenta = $row['ime_studenta'];
				$prezime_studenta = $row['prezime_studenta'];
				$broj_telefona = $row['broj_telefona'];
				$napomena = $row['napomena'];
				$id_sluzbenika = $row['id_sluzbenika'];

				$image = $row['slika'];

				echo "

				<tr>
				<td class='text-center'>$sl</td>
				<td class='text-left'>$ime_studenta   $prezime_studenta</td>
				<td class='text-left'>$broj_indeksa</td>
				<td class='text-left'>$broj_telefona</td>
				<td class='text-center'>$id_sluzbenika</td>
			
				<td class='text-center'>
					<span>
					<a href='#' class='btn btn-success mr-3 profile' data-toggle='modal' data-target='#view$id' title='Prfile'><i class='fa fa-address-card-o' aria-hidden='true'></i></a>
					</span>
					
				</td>
				<td class='text-center'>
					<span>
					<a href='#' class='btn btn-warning mr-3 edituser' data-toggle='modal' data-target='#edit$id' title='Edit'><i class='fa fa-pencil-square-o fa-lg'></i></a>

					     
					    
					</span>
					
				</td>
				<td class='text-center'>
					<span>
					
						<a href='#' class='btn btn-danger deleteuser' title='Delete'>
						     <i class='fa fa-trash-o fa-lg' data-toggle='modal' data-target='#$id' style='' aria-hidden='true'></i>
						</a>
					</span>
					
				</td>
			</tr>


        		";
			}

			?>



		</table>
		<form method="post" action="export.php">
			<input type="submit" name="export" class="btn btn-success" value="Štampaj" />
		</form>
	</div>


	<!---Add in modal---->

	<!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form method="POST" enctype="multipart/form-data">

						<!-- This is test for New Card Activate Form  -->
						<!-- This is Address with email id  -->
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="inputEmail4">Broj indeksa</label>
								<input type="text" class="form-control" name="br_indeksa" placeholder="Unesite broj indeksa" maxlength="12" required>
							</div>
							<div class="form-group col-md-6">
								<label for="inputPassword4">Broj telefona</label>
								<input type="phone" class="form-control" name="broj_telefona" placeholder="Unesite broj telefona" maxlength="10" required>
							</div>
						</div>


						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="firstname">Ime</label>
								<input type="text" class="form-control" name="ime_studenta" placeholder="Unesite ime">
							</div>
							<div class="form-group col-md-6">
								<label for="lastname">Prezime</label>
								<input type="text" class="form-control" name="prezime_studenta" placeholder="Unesite prezime">
							</div>
						</div>


						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="fathername">Ime oca</label>
								<input type="text" class="form-control" name="ime_oca" placeholder="Unesite ime oca">
							</div>
							<div class="form-group col-md-6">
								<label for="mothername">Ime majke</label>
								<input type="text" class="form-control" name="ime_majke" placeholder="Unesite ime majke">
							</div>
						</div>


						<div class="form-row" style="color: skyblue;">
							<div class="form-group col-md-6">
								<label for="email">Email adresa</label>
								<input type="email" class="form-control" name="email" placeholder="Uneiste email adresu">
							</div>
							<div class="form-group col-md-6">
								<label for="jmbgBr">JMBG</label>
								<input type="text" class="form-control" name="student_jmbg" maxlength="13" placeholder="Unesite JMBG">
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="inputState">Pol</label>
								<select id="inputState" name="pol" class="form-control">
									<option selected>Izaberite...</option>
									<option>Muško</option>
									<option>Žensko</option>
								</select>
							</div>
							<div class="form-group col-md-6">
								<label for="inputPassword4">Datum rodjenja</label>
								<input type="date" class="form-control" name="datum_rodjenja" placeholder="Date of Birth">
							</div>
						</div>


						<div class="form-group">
							<label for="napomena">Napomena</label>
							<textarea class="form-control" name="napomena" rows="3"></textarea>
						</div>


						<div class="form-group">
							<label for="inputAddress2">Opstina</label>
							<input type="text" class="form-control" name="opstina" placeholder="Opstina">
						</div>
						<div class="form-row">
							<div class="form-group">
								<label for="inputCity">Grad</label>
								<input type="text" class="form-control" name="grad">
							</div>
							<div class="form-group">
								<label for=" inputAddress">Ulica</label>
								<input type="text" class="form-control" name="ulica" placeholder="Ulica i br.">
							</div>
							<div class="form-group">
								<label for="inputState">Drzavljanstvo</label>
								<input type="text" class="form-control" name="state" placeholder="Unesite drzavljanstvo">
							</div>
							<div class="form-group">
								<label for="inputZip">Postanski broj</label>
								<input type="text" class="form-control" name="zip">
							</div>
						</div>

						<div class="form-group">
							<label for="inputAddress">ID službenika</label>
							<input type="text" class="form-control" name="id_sluzbenika" maxlength="12" placeholder="Enter 12-digit Staff Id">
						</div>



						<div class="form-group">
							<label>Slika</label>
							<input type="file" name="image" class="form-control">
						</div>


						<input type="submit" name="submit" class="btn btn-info btn-large" value="Potvrdi">


					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Zatvori</button>
				</div>
			</div>

		</div>
	</div>


	<!------DELETE modal---->




	<!-- Modal -->
	<?php

	$get_data = "SELECT * FROM student";
	$run_data = mysqli_query($con, $get_data);

	while ($row = mysqli_fetch_array($run_data)) {
		$id = $row['id'];
		echo "

<div id='$id' class='modal fade' role='dialog'>
  <div class='modal-dialog'>

    <!-- Modal content-->
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal'>&times;</button>
        <h4 class='modal-title text-center'>Student će biti obrisan!</h4>
      </div>
      <div class='modal-body'>
        <a href='delete.php?id=$id' class='btn btn-danger' style='margin-left:250px'>Obriši</a>
      </div>
      
    </div>

  </div>
</div>


	";
	}


	?>


	<!-- View modal  -->
	<?php

	// <!-- profile modal start -->
	$get_data = "SELECT * FROM student";
	$run_data = mysqli_query($con, $get_data);

	while ($row = mysqli_fetch_array($run_data)) {
		$id = $row['id'];
		$broj_indeksa = $row['broj_indeksa'];
		$ime = $row['ime_studenta'];
		$prezime = $row['prezime_studenta'];
		$otac = $row['ime_oca'];
		$majka = $row['ime_majke'];
		$pol = $row['pol'];
		$email = $row['email'];
		$jmbg = $row['jmbg'];
		$Bday = $row['datum_rodjenja'];
		$napomena = $row['napomena'];
		$phone = $row['broj_telefona'];
		$address = $row['drzavljanstvo'];
		$ulica = $row['ulica'];
		$opstina = $row['opstina'];
		$grad = $row['grad'];
		$zip = $row['postanski_broj'];
		$state = $row['drzavljanstvo'];
		$time = $row['upisan'];

		$image = $row['slika'];
		echo "

		<div class='modal fade' id='view$id' tabindex='-1' role='dialog' aria-labelledby='userViewModalLabel' aria-hidden='true'>
		<div class='modal-dialog'>
			<div class='modal-content'>
			<div class='modal-header'>
				<h5 class='modal-title' id='exampleModalLabel'>Profil Studenta <i class='fa fa-user-circle-o' aria-hidden='true'></i></h5>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>&times;</span>
				</button>
			</div>
			<div class='modal-body'>
			<div class='container' id='profile'> 
				<div class='row'>
					<div class='col-sm-4 col-md-2'>
						<img src='upload_images/$image' alt='' style='width: 150px; height: 150px;' ><br>
		
						<i class='fa fa-id-card' aria-hidden='true'></i> $broj_indeksa<br>
						<i class='fa fa-phone' aria-hidden='true'></i> $phone  <br>
						Datum upisa : $time
					</div>
					<div class='col-sm-3 col-md-6'>
						<h3 class='text-primary'>$ime $prezime</h3>
						<p class='text-secondary'>
						<strong>Ime oca: </strong> $otac <br>
						<strong>Ime majke :</strong>$majka <br>
						<strong>JMBG :</strong> $jmbg <br>
						<i class='fa fa-venus-mars' aria-hidden='true'></i>$pol
						<br />
						<i class='fa fa-envelope-o' aria-hidden='true'></i> $email
						<br />
						<div class='card' style='width: 18rem;'>
						<i class='fa fa-users' aria-hidden='true'></i> Napomena :
								<div class='card-body'>
								<p> $napomena </p>
								</div>
						</div>
						
						<i class='fa fa-home' aria-hidden='true'> Adresa : </i> $ulica, $opstina, <br> $grad, $state - $zip
						<br />
						</p>
						<!-- Split button -->
					</div>
				</div>

			</div>   
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-secondary' data-dismiss='modal'>Zatvori</button>
			</div>
			</form>
			</div>
		</div>
		</div> 


    ";
	}


	// <!-- profile modal end -->


	?>





	<!----edit Data--->

	<?php

	$get_data = "SELECT * FROM student";
	$run_data = mysqli_query($con, $get_data);

	while ($row = mysqli_fetch_array($run_data)) {
		$id = $row['id'];
		$broj_indeksa = $row['broj_indeksa'];
		$ime = $row['ime_studenta'];
		$prezime = $row['prezime_studenta'];
		$otac = $row['ime_oca'];
		$majka = $row['ime_majke'];
		$pol = $row['pol'];
		$email = $row['email'];
		$jmbg = $row['jmbg'];
		$Bday = $row['datum_rodjenja'];
		$napomena = $row['napomena'];
		$phone = $row['broj_telefona'];
		$address = $row['drzavljanstvo'];
		$ulica = $row['ulica'];
		$opstina = $row['opstina'];
		$grad = $row['grad'];
		$zip = $row['postanski_broj'];
		$state = $row['drzavljanstvo'];
		$staffCard = $row['id_sluzbenika'];
		$time = $row['upisan'];
		$image = $row['slika'];
		echo "

<div id='edit$id' class='modal fade' role='dialog'>
  <div class='modal-dialog'>

    <!-- Modal content-->
    <div class='modal-content'>
      <div class='modal-header'>
             <button type='button' class='close' data-dismiss='modal'>&times;</button>
             <h4 class='modal-title text-center'>Uredi podatke</h4> 
      </div>

      <div class='modal-body'>
        <form action='edit.php?id=$id' method='post' enctype='multipart/form-data'>

		<div class='form-row'>
		<div class='form-group col-md-6'>
		<label for='inputEmail4'>Broj indeksa</label>
		<input type='text' class='form-control' name='br_indeksa' placeholder='Unesite broj indeksa' maxlength='12' value='$broj_indeksa' required>
		</div>
		<div class='form-group col-md-6'>
		<label for='inputPassword4'>Broj telefona</label>
		<input type='phone' class='form-control' name='broj_telefona' placeholder='Unesite broj telefona' maxlength='10' value='$phone' required>
		</div>
		</div>
		
		
		<div class='form-row'>
		<div class='form-group col-md-6'>
		<label for='firstname'>Ime</label>
		<input type='text' class='form-control' name='ime_studenta' placeholder='Upisite ime' value='$ime'>
		</div>
		<div class='form-group col-md-6'>
		<label for='lastname'>Prezime</label>
		<input type='text' class='form-control' name='prezime_studenta' placeholder='Upisite prezime' value='$prezime'>
		</div>
		</div>
		
		
		<div class='form-row'>
		<div class='form-group col-md-6'>
		<label for='fathername'>Ime oca</label>
		<input type='text' class='form-control' name='ime_oca' placeholder='Upisi ime oca' value='$otac'>
		</div>
		<div class='form-group col-md-6'>
		<label for='mothername'>Ime majke</label>
		<input type='text' class='form-control' name='ime_majke' placeholder='Upisi ime majke' value='$majka'>
		</div>
		</div>
		
		
		<div class='form-row'>
		<div class='form-group col-md-6'>
		<label for='email'>Email</label>
		<input type='email' class='form-control' name='email' placeholder='Unesite email adresu' value='$email'>
		</div>
		<div class='form-group col-md-6'>
		<label for='jmbgBr'>JMBG</label>
		<input type='text' class='form-control' name='student_jmbg' maxlength='13' placeholder='Unesite JMBG' value='$jmbg'>
		</div>
		</div>
		
		<div class='form-row'>
		<div class='form-group col-md-6'>
		<label for='inputState'>Pol</label>
		<select id='inputState' name='pol' class='form-control' value='$pol'>
		  <option selected>$pol</option>
		  <option>Muško</option>
		  <option>Žensko</option>
		</select>
		</div>
		<div class='form-group col-md-6'>
		<label for='inputPassword4'>Datum rodjenja</label>
		<input type='date' class='form-control' name='datum_rodjenja' placeholder='Datum rodjenja' value='$Bday'>
		</div>
		</div>
		
		
		<div class='form-group'>
		<label for='napomena'>Napomena</label>
			<textarea class='form-control' name='napomena' rows='3'>$napomena</textarea>
		</div>
		
		
		<div class='form-group'>
		<label for='inputAddress2'>Opština</label>
		<input type='text' class='form-control' name='opstina' placeholder='Unesite opštinu' value='$opstina'>
		</div>
		<div class='form-group'>
		<label for='inputCity'>Grad</label>
		<input type='text' class='form-control' name='grad' value='$grad'>
		</div>
		<div class='form-group'>
		<label for='inputAddress'>Ulica</label>
		<input type='text' class='form-control' name='ulica' placeholder='Ulica i br.' value='$ulica'>
		</div>
		<div class='form-row'>
		<div class='form-group'>
		<label for='inputState'>Državljanstvo</label>
		<input type='text' class='form-control' name='grad' value='$state'>
		<div class='form-group'>
		<label for='inputZip'>Poštanski broj</label>
		<input type='text' class='form-control' name='zip' value='$zip'>
		</div>
		</div>
		
		
		<div class='form-group'>
		<label for='inputAddress'>ID službenika</label>
		<input type='text' class='form-control' name='id_sluzbenika' maxlength='12' value='$staffCard'>
		</div>
        	

        	<div class='form-group'>
        		<label>Slika</label>
        		<input type='file' name='image' class='form-control'>
        		<img src = 'upload_images/$image' style='width:50px; height:50px'>
        	</div>

        	
        	
			 <div class='modal-footer'>
			 <input type='submit' name='submit' class='btn btn-info btn-large' value='Potvrdi'>
			 <button type='button' class='btn btn-secondary' data-dismiss='modal'>Zatvori</button>
		 </div>


        </form>
      </div>

    </div>

  </div>
</div>


	";
	}


	?>

	<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
	<script>
		$(document).ready(function() {
			$('#myTable').DataTable();

		});
	</script>

</body>

</html>