<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>คำสั่งแต่งตั้ง</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


</head>
<body>
<div class="container mt-3">
  <h3>The order appointing </h3>
  <p>&nbsp;ค้นหารายชื่อการแต่งตั้ง</p> 
  <form class="d-flex" action="#" method="post">
        <input class="form-control me-2" type="text" name="kw" placeholder="ค้นหา &hearts;" value="" style = " width: 163px; height: 25px;">
        <button class="btn btn-secondary" type="submit">Search</button>
  </form>&nbsp;
  <?php    
    require_once("dbconfig.php");

    @$kw = "%{$_POST['kw']}%";

    $sql = "SELECT DISTINCT documents.* 
    FROM documents LEFT JOIN doc_staff ON documents.id=doc_staff.doc_id
    LEFT JOIN staff ON doc_staff.stf_id=staff.id 
    WHERE concat(doc_num, doc_title,stf_name) LIKE ?
    ORDER BY doc_num;";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $kw);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        echo  "Not found!";
    } else {
        echo "Found " . $result->num_rows . " record(s).";
        
  ?>
  <br>
  <br>
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link " href="document.php">คำสั่งแต่งตั้ง</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="staff.php">บุคลากร</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" href="selectdocument.php">ค้นหารายชื่อ</a>
    </li>
  </ul>
  <br>
  <?php
            $table = "<table class='table table-hover'>
                        <thead>
                            <tr>
                                <th scope='col'>เลขที่คำสั่ง</th>
                                <th scope='col'>ชื่อคำสั่ง</th>
                                <th scope='col'>วันที่เริ่มต้นคำสั่ง</th>
                                <th scope='col'>วันที่สิ้นสุด</th>
                                <th scope='col'>สถานะ</th>
                                <th scope='col'>ชื่อไฟล์เอกสาร</th>
                            </tr>
                        </thead>
                        <tbody>";
                        
             
            $i = 1; 

            while($row = $result->fetch_object()){ 
                $table.= "<tr>";
                $table.= "<td>$row->doc_num &emsp;</td>";
                $table.= "<td>$row->doc_title</td>";
                $table.= "<td>$row->doc_start_date</td>";
                $table.= "<td>$row->doc_to_date</td>";
                $table.= "<td>$row->doc_status</td>";
                $table.= "<td><a href='uploads/$row->doc_file_name'>$row->doc_file_name</a></td>";
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