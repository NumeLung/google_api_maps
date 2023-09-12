<?php
include 'model.php';

$model = new Model();

$rows = $model->fetch1();

echo json_encode($rows);