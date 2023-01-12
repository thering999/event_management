<?php

require_once 'Booking.php';
require_once '../library/config.php';
require_once '../library/mail.php';

$cmd = isset($_GET['cmd']) ? $_GET['cmd'] : '';

switch ($cmd) {

	case 'book':
		bookCalendar();
		break;

	case 'holiday':
		addHoliday();
		break;

	case 'hdelete':
		deleteHoliday();
		break;

	case 'calview':
		calendarView();
		break;

	case 'regConfirm':
		regConfirm();
		break;

	case 'delete':
		regDelete();
		break;

	case 'user':
		userDetails();
		break;

	default:
		break;
}

function addHoliday()
{
	$date 		= $_POST['date'];
	$reason 	= $_POST['reason'];

	$errorMessage = '';

	$sql 	= "SELECT * FROM tbl_holidays WHERE date = '$date'";
	$result = dbQuery($sql);

	if (dbNumRows($result) > 0) {
		$errorMessage = 'Holiday already exist in record.';
		header('Location: ../views/?v=HOLY&err=' . urlencode($errorMessage));
		exit();
	} else {
		$sql = "INSERT INTO tbl_holidays (date, reason, bdate)
				VALUES ('$date', '$reason', NOW())";
		dbQuery($sql);
		$msg = 'Holiday successfully added on calendar.';
		header('Location: ../views/?v=HOLY&msg=' . urlencode($msg));
		exit();
	}
}

function bookCalendar()
{
	$userId		= (int)$_POST['userId'];
	$name 		= $_POST['name'];
	$namethai 	= $_POST['namethai'];
	$address 	= $_POST['address'];
	$phone 		= $_POST['phone'];
	$email 		= $_POST['email'];
	$rdate		= $_POST['rdate'];
	$rtime		= $_POST['rtime'];
	$bkdate		= $rdate . ' ' . $rtime;
	$ucount		= $_POST['ucount'];
	$details 	= $_POST['details'];
	$upload     = $_FILES['upload_file1'];


//print_r($upload);

	# Check upload file
        if ($upload <= 0) {
            echo 'Hey, Please choose at least one file';
        } 
			    else if ($upload['size'] < 0)
				 {
                    echo nl2br('Error during file upload ' . $upload['size'] . "\n");
                 } 
				   else if (!empty($upload)) {
					if (file_exists("../uploads/".date("Y-m-d-H-i-s")."/")) {
						// mkdir("../uploads/".$upload['tmp_name']."/");
                        echo nl2br('Hey, File already exists at uploads/' . $upload['name'] . "\n");
                    } else {
						// mkdir("../uploads/".$upload['name']."/");
						mkdir("../uploads/".date("Y-m-d-H-i-s")."/");
						move_uploaded_file($upload['tmp_name'], "../uploads/".date("Y-m-d-H-i-s")."/" . $upload['name']);
						
                        echo nl2br('File successfully uploaded to uploads/'.date("Y-m-d-H-i-s")."/" . $upload['name']."\n");
                    }
           
                 }




	$PATH = '/uploads/'.date("Y-m-d-H-i-s").'/'. $upload['name'];

	# Check Line Notify
	$message =
		'ID ผู้จอง: ' . $userId . "\n" .
		'ชื่อผู้จอง: ' . $name . "\n" .
		'จากฝ่าย: ' . $namethai . "\n" .
		'วันที่จอง: ' . $bkdate . "\n" .
		'รายละเอียด: ' . $details . "\n" .
		'เบอร์ติดต่อ: ' . $phone . "\n" .
		'E-mail: ' . $email . "\n" .
		'จำนวนผู้เข้าร่วมประชุม: ' . $ucount . "\n" .
		'เอกสารที่เกี่ยวข้อง: ' . $upload['name']."\n";


	if ($namethai <> "" || $bkdate <> "" || $details <> "") {
		sendlinemesg();
		header('Content-Type: text/html; charset=utf-8');
		$res = notify_message($message);
		echo "<center>l;ส่งข้อความเรียบร้อยแล้ว</center>";
	} else {
		echo "<center>Error: กรุณากรอกข้อมูลให้ครบถ้วน</center>";
	}


	//TODO first check if that date has a holiday
	$hsql	= "SELECT * FROM tbl_holidays WHERE date = '$rdate'";
	$hresult = dbQuery($hsql);
	if (dbNumRows($hresult) > 0) {
		$errorMessage = 'You can not book any event on Holiday. Please try another day.';
		header('Location: ../views/?v=DB&err=' . urlencode($errorMessage));
		exit();
	}

	/*
	$sql = "INSERT INTO tbl_users (name, address, phone, email, bdate)
			VALUES ('$name', '$address', '$phone', '$email', NOW())";	
	dbQuery($sql);
	$insert_id = dbInsertId();
	*/

	$sql = "INSERT INTO tbl_reservations (name, uid, namethai,ucount, rdate, details, status, comments, bdate,upload_file) 
			VALUES ($userId, $name, '$namethai', $ucount, '$bkdate', '$details', 'PENDING', '', NOW(), '$PATH')";
	dbQuery($sql);

	//send email on registration confirmation
	$bodymsg = "User $name booked the date slot on $bkdate. Requesting you to please take further action on user booking.<br/>Mbr/>Tousif Khan";
	$data = array('to' => 'habusaya@gmail.com', 'sub' => 'Booking on $rdate.', 'msg' => $bodymsg);
	//send_email($data);

	header('Location: ../index.php?msg=' . urlencode('User successfully registered.'));
	exit();
}


function sendlinemesg()
{

	define('LINE_API', "https://notify-api.line.me/api/notify");
	define('LINE_TOKEN', 'xxxxxx');
	//define('LINE_TOKEN', 'C55uKHqcWzrFSVbXEHLwFDNiHhOJgo0zB8lWygzeaAR');

	function notify_message($message)
	{

		$queryData = array('message' => $message);
		$queryData = http_build_query($queryData, '', '&');
		$headerOptions = array(
			'http' => array(
				'method' => 'POST',
				'header' => "Content-Type: application/x-www-form-urlencoded\r\n"
					. "Authorization: Bearer " . LINE_TOKEN . "\r\n"
					. "Content-Length: " . strlen($queryData) . "\r\n",
				'content' => $queryData
			)
		);
		$context = stream_context_create($headerOptions);
		$result = file_get_contents(LINE_API, FALSE, $context);
		$res = json_decode($result);
		return $res;
	}
}



function regConfirm()
{
	$userId		= $_GET['userId'];
	$action 	= $_GET['action'];
	$stat		= ($action == 'approve') ? 'APPROVED' : 'DENIED';

	$sql		= "UPDATE tbl_reservations SET status = '$stat' WHERE uid = $userId";
	dbQuery($sql);

	//send email now.
	$data = array();

	header('Location: ../views/?v=DB&msg=' . urlencode('Reservation status successfully changed.'));
	exit();
}

function regDelete()
{
	$userId	= $_GET['userId'];
	$sql1	= "DELETE FROM tbl_reservations WHERE uid = $userId";
	dbQuery($sql1);
	// $sql2	= "DELETE FROM tbl_users WHERE id = $userId";
	// dbQuery($sql2);

	header('Location: ../views/?v=LIST&msg=' . urlencode('User record successfully deleted.'));
	exit();
}

function deleteHoliday()
{
	$holyId	= $_GET['hId'];
	$dsql	= "DELETE FROM tbl_holidays WHERE id = $holyId";
	dbQuery($dsql);
	header('Location: ../views/?v=HOLY&msg=' . urlencode('Holiday record successfully deleted.'));
	exit();
}

function calendarView()
{
	$start 	= $_POST['start'];
	//$sdate	= date("Y-m-d\TH:i\Z", time($start));
	$end 	= $_POST['end'];
	//$edate	= date("Y-m-d\TH:i\Z", time($end));
	$bookings = array();
	$sql	= "SELECT u.name AS u_name ,u.namethai, u.id AS user_id, r.rdate, r.status 
			   FROM tbl_users u, tbl_reservations r 
			   WHERE u.id = r.uid  
			   AND (r.rdate BETWEEN '$start' AND '$end')";
	//AND r.status = 'APPROVED'
	$result = dbQuery($sql);
	while ($row = dbFetchAssoc($result)) {
		extract($row);
		$book = new Booking();
		$book->title = $u_name;
		$book->start = $rdate;
		$bgClr = '#f39c12'; //pending
		if ($status == 'DENIED') {
			$bgClr = '#ff0000';
		} else if ($status == 'APPROVED') {
			$bgClr = '#00cc00';
		}
		$book->backgroundColor = $bgClr; //#7FFF00 -> green, #ff0000 red, #f39c12 -> pending 
		$book->borderColor = $bgClr;
		$book->url = WEB_ROOT . 'views/?v=USER&ID=' . $user_id;
		$bookings[] = $book;
	}
	//execute SQLs to get the Holiday blocking days List within the limit of start, end date;
	$hsql	= "SELECT * FROM tbl_holidays 
			   WHERE (date BETWEEN '$start' AND '$end')";
	$hresult = dbQuery($hsql);
	while ($hrow = dbFetchAssoc($hresult)) {
		extract($hrow);
		$b = new Booking();
		$b->block = true;
		$b->title = $reason;
		$b->start = $date;
		$b->allDay = true;
		$b->borderColor = '#F0F0F0';
		$b->className = 'fc-disabled';
		$bookings[] = $b;
	} //while
	echo json_encode($bookings);
}

function userDetails()
{
	$userId	= $_GET['userId'];
	$hsql	= "SELECT * FROM tbl_users WHERE id = $userId";
	$hresult = dbQuery($hsql);
	$user = array();
	while ($hrow = dbFetchAssoc($hresult)) {
		extract($hrow);
		$user['user_id'] = $id;
		$user['namethai'] = $namethai;
		$user['address'] = $address;
		$user['phone_no'] = $phone;
		$user['email'] = $email;
		$user['details'] = $details;
	} //while
	echo json_encode($user);
}
