<?php
$userId = (isset($_GET['ID']) && $_GET['ID'] != '') ? $_GET['ID'] : 0;

//print_r($userId);


$usql  = "SELECT u.*,r.details,r.upload_file FROM tbl_users u 
INNER JOIN tbl_reservations r ON u.id = r.uid
WHERE u.id = r.uid
and u.id = $userId";

$res   = dbQuery($usql);
while ($row = dbFetchAssoc($res)) {
  extract($row);
  $stat = '';

  if ($status == "active") {
    $stat = 'success';
  } else if ($status == "lock") {
    $stat = 'warning';
  } else if ($status == "inactive") {
    $stat = 'warning';
  } else if ($status == "delete") {
    $stat = 'danger';
  }
?>
  <div class="col-md-9">
    <div class="box box-solid">
      <div class="box-header with-border"> <i class="fa fa-text-width"></i>
        <h3 class="box-title">User Details</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <dl class="dl-horizontal">
          <dt>UserName</dt>
          <dd><?php echo $name; ?></dd>

          <dt>ชื่อฝ่าย</dt>
          <dd><?php echo $namethai; ?></dd>

          <dt>Address</dt>
          <dd><?php echo $address; ?></dd>

          <dt>Email</dt>
          <dd><?php echo $email; ?></dd>

          <dt>Phone</dt>
          <dd><?php echo $phone; ?></dd>

          <dt>Details</dt>
          <dd><?php echo $details; ?></dd>

          <dt>Booking Status</dt>
          <dd><span class="label label-<?php echo $stat; ?>"><?php echo $status; ?></span></dd>

          </br>
          <dt>Upload File</dt>
          <!-- <dd><span class="label label-<?php echo $stat; ?>"><?php echo $status; ?></span></dd> -->
          <dd>
            <td><a href="<?php echo WEB_ROOT; ?><?php echo $upload_file; ?>">
                <target="_blank" class="btn btn-primary btn-sm"> เปิดดู
              </a></td>
          </dd>

        </dl>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>


  <td>
    <button type="submit" id="print" onclick="printPage()" class="btn btn-primary">Print Data</button>
    <?php ?>
  </td>



  <script>
    function printPage() {
      window.print();
    }
  </script>

<?php
}
?>