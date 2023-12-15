<?php
require("../../../model/rdv.php");
require("../../../model/nurse.php");
require("../../../model/patient.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /**********IMPORT DATA**********/

    // old RDV Data
    $old_infos_value = $_POST['old_infos_value'];
    $old_date_value = $_POST['old_date_value'];

    // old Nurse Data
    $old_last_name_value_n = $_POST['old_last_name_value_n'];
    $old_first_name_value_n = $_POST['old_first_name_value_n'];
    $old_email_value_n = $_POST['old_email_value_n'];
    $old_phone_value_n = $_POST['old_phone_value_n'];

    // old Patient Data
    $old_last_name_value_p = $_POST['old_last_name_value_p'];
    $old_first_name_value_p = $_POST['old_first_name_value_p'];
    $old_email_value_p = $_POST['old_email_value_p'];
    $old_phone_value_p = $_POST['old_phone_value_p'];

    //new RDV data
    $new_infos_value = $_POST['new_infos_value'];
    $new_date_value = $_POST['new_date_value'];

    // new Nurse Data
    $new_last_name_value_n = $_POST['new_last_name_value_n'];
    $new_first_name_value_n = $_POST['new_first_name_value_n'];
    $new_email_value_n = $_POST['new_email_value_n'];
    $new_phone_value_n = $_POST['new_phone_value_n'];

    // new Patient Data
    $new_last_name_value_p = $_POST['new_last_name_value_p'];
    $new_first_name_value_p = $_POST['new_first_name_value_p'];
    $new_email_value_p = $_POST['new_email_value_p'];
    $new_phone_value_p = $_POST['new_phone_value_p'];
    /********************************/
    /**************MERGE OLD AND NEW DATA*****************/
    //rdv merge 
    if ($new_infos_value == NULL) {
        $new_infos_value = $old_infos_value;
    }
    if ($new_date_value == NULL) {
        $new_date_value = $old_date_value;
    }
    //pation merge
    if ($new_first_name_value_p == NULL) {
        $new_first_name_value_p = $old_first_name_value_p;
    }
    if ($new_last_name_value_p == NULL) {
        $new_last_name_value_p = $old_last_name_value_p;
    }
    if ($new_email_value_p == NULL) {
        $new_email_value_p = $old_email_value_p;
    }
    if ($new_phone_value_p == NULL) {
        $new_phone_value_p = $old_phone_value_p;
    }
    //nurse merge
    if ($new_first_name_value_n == NULL) {
        $new_first_name_value_n = $old_first_name_value_n;
    }
    if ($new_last_name_value_n == NULL) {
        $new_last_name_value_n = $old_last_name_value_n;
    }
    if ($new_email_value_n == NULL) {
        $new_email_value_n = $old_email_value_n;
    }
    if ($new_phone_value_n == NULL) {
        $new_phone_value_n = $old_phone_value_n;
    }

/***********************************************************/
/************************UPDATE USING THE MERGED DATA***************************/

$id_rdv = $_POST["id_rdv"];
$cinn = $_POST["cinn"];
$cinp = $_POST["cinp"];
/********************UPDATE RDV*****************/
echo "RDV Data:<br>";
echo "INFOS: $new_infos_value<br>";
echo "DATE: $new_date_value<br>";
$new_rdv = new rdv();
$field ="infos";
$new_rdv->update_RDV($id_rdv, $field, $new_infos_value);
$field ="date";
$new_rdv->update_RDV($id_rdv, $field, $new_date_value);
/*********************UPDATE NURSE*******************/
echo "<br>Nurse Data:<br>";
echo "Last Name: $new_last_name_value_n<br>";
echo "First Name: $new_first_name_value_n<br>";
echo "Email: $new_email_value_n<br>";
echo "Phone: $new_phone_value_n<br>";
$new_nurse = new nurse();
$field = "lastname";
$new_nurse->update_NRS($cinn, $field, $new_last_name_value_n);
$field = "firstname";
$new_nurse->update_NRS($cinn, $field, $new_first_name_value_n);
$field = "email";
$new_nurse->update_NRS($cinn, $field, $new_email_value_n);
$field = "phone";
$new_nurse->update_NRS($cinn, $field, $new_phone_value_n);
/************************UPDATE PATIENT************/
echo "<br>Patient Data:<br>";
echo "Last Name: $new_last_name_value_p<br>";
echo "First Name: $new_first_name_value_p<br>";
echo "Email: $new_email_value_p<br>";
echo "Phone: $new_phone_value_p<br>";

$new_patient = new patient();
$field = "lastname";
$new_patient->update_PTT($cinp, $field, $new_last_name_value_p);
$field = "firstname";
$new_patient->update_PTT($cinp, $field, $new_first_name_value_p);
$field = "email";
$new_patient->update_PTT($cinp, $field, $new_email_value_p);
$field = "phone";
$new_patient->update_PTT($cinp, $field, $new_phone_value_p);
header('Location: ../../../view/back_office/RDV/MainAdminRdv.php') ;  


}
?>