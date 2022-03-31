<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>บุคลากร</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


</head>
<body>
<div class="container mt-3">
  <h3>บุคลากร </h3>
  <p>&nbsp;รายชื่อคณะกรรมการ</p> 
  <form class="d-flex" action="#" method="post">
        <input class="form-control me-2" type="text" name="kw" placeholder="ค้นหา &hearts;" value="" style = " width: 163px; height: 25px;">
        <button class="btn btn-secondary" type="submit">Search</button>
        <a class="nav-link " href="newstaff.php">เพิ่มบุคลากร &nbsp;<span class='glyphicon glyphicon-plus'></span></a>
  </form>&nbsp;
  <?php 
require_once("dbconfig.php");

@$kw = "%{$_POST['kw']}%";

$sql = "SELECT *
        FROM staff
        WHERE concat(stf_code, stf_name) LIKE ? 
        ORDER BY stf_code";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $kw);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Not found!";
} else {
    echo "Found " . $result->num_rows . " record(s)."; 
?>
  <br>
  <br>
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link" href="document.php">คำสั่งแต่งตั้ง</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" href="staff.php">บุคลากร</a>
    </li>
  </ul>
  <br>
  <?php
            $table = "<table class='table table-hover'>
                        <thead>
                            <tr>
                                <th scope='col'>รหัสพนักงาน</th>
                                <th scope='col'>ชื่อ-นามสกุล</th>
                                <th scope='col'>ชื่อผู้ใช้</th>
                            </tr>
                        </thead>
                        <tbody>";
                        
            // 
            $i = 1; 

            // ดึงข้อมูลออกมาทีละแถว และกำหนดให้ตัวแปร row 
            while($row = $result->fetch_object()){ 
                $table.= "<tr>";
                $table.= "<td>$row->stf_code</td>";
                $table.= "<td>$row->stf_name</td>";
                $table.= "<td >";
                $table.= "<a href='editstaff.php?id=$row->id'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a>";
                $table.= " | ";
                $table.= "<a href='deletestaff.php?id=$row->id'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>";
                $table.= "</td>";
                $table.= "</tr>";
            }

            $table.= "</tbody>";
            $table.= "</table>";
            
            echo $table;
        }
        ?>
    </div>
</div>





    
</body>
</html>