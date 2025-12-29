<?php
session_start();
if(!isset($_SESSION['doctor_user_id'])||($_SESSION['role']??'')!=='doctor'){ header("Location: doctor_login.php"); exit; }
require 'db.php';

if($_SERVER['REQUEST_METHOD']==='POST'){
  $id=(int)($_POST['id']??0);
  $gemini_json=trim($_POST['gemini_json']??'');
  $doctor_notes=trim($_POST['doctor_notes']??'');

  if($id>0){
    $st=$conn->prepare("UPDATE reports SET gemini_json=?, doctor_notes=?, approved=1 WHERE id=?");
    $st->bind_param("ssi",$gemini_json,$doctor_notes,$id);
    $st->execute(); $st->close();
    header("Location: doctor_dashboard.php"); exit;
  }
}
http_response_code(400);
echo "Bad request";
