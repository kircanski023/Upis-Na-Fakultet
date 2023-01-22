<?php
include('config.php');

$id = $_GET['id'];

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

	$msg = "";
	$image = $_FILES['image']['name'];
	$target = "upload_images/" . basename($image);

	if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
		$msg = "Image uploaded successfully";
	} else {
		$msg = "Failed to upload image";
	}

	$update = "UPDATE student SET broj_indeksa='$broj_indeksa', ime_studenta = '$ime_studenta', prezime_studenta = '$prezime_studenta', ime_oca = '$ime_oca', ime_majke = '$ime_majke', jmbg = '$jmbg', datum_rodjenja = '$datum_rodjenja', pol = '$pol', email = '$email', broj_telefona = '$broj_telefona', drzavljanstvo = '$drzavljanstvo', grad = '$grad', ulica = '$ulica', opstina = '$opstina', postanski_broj = '$postanski_broj', napomena = '$napomena', id_sluzbenika = '$id_sluzbenika', slika = '$image' WHERE id=$id ";
	$run_update = mysqli_query($con, $update);

	if ($run_update) {
		header('location:index.php');
	} else {
		echo "Data not update";
	}
}
