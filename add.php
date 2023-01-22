<?php

include('config.php');

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
		$msg = "Image uploaded successfully";
	} else {
		$msg = "Dodavanje slike nije uspelo";
	}

	$insert_data = "INSERT INTO student(broj_indeksa, ime_studenta, prezime_studenta, ime_oca, jmbg, datum_rodjenja, pol, email, broj_telefona, drzavljanstvo, grad, ulica, opstina, postanski_broj, ime_majke, napomena, id_sluzbenika,image,uploaded) VALUES ('$broj_indeksa','$ime_studenta','$prezime_studenta','$ime_oca','$jmbg','$datum_rodjenja','$pol','$email','$broj_telefona','$drzavljanstvo','$grad','$ulica','$opstina','$postanski_broj','$ime_majke','$napomena','$id_sluzbenika','$image',NOW())";
	$run_data = mysqli_query($con, $insert_data);

	if ($run_data) {
		$added = true;
	} else {
		echo "Podaci nisu upisani";
	}
}
