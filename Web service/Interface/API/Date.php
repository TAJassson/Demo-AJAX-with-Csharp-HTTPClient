<?php
header('Access-Control-Allow-Origin:*');  
class DateServer {
	function GET($parameters) {
		//Only for the Hwid only....
		//URL: http://<ServerID>/Interface/API/Interface.php/Hwid/<API>
		//Table Hwid
		
		$apiType = array_shift($parameters);
		
		if ($apiType==='Date') {
			//URL: http://<ServerID>/Interface/API/Interface.php/Hwid/CUID/<ID>
			$Date = array_shift($parameters);
			if ($CID===null)
			{
				returnError (' Parameters are null','ErrCode: 0110');
			}else if ($CID==='')
			{
				returnError (' Parameters are null','ErrCode: 0111');
			}
			else {
				$sql = "SELECT * FROM TestTable WHERE Date='$Date'";
	
				require_once 'db.php';
				$dbresult = $conn->query($sql);
				$output = array();
				while ($row = $dbresult->fetch_assoc() ) {
					$output[] = $row;
				}
				echo json_encode($output);
			}
		} 
		else if ($apiType==='') { //API = null
			returnError(' Missing API, fail to get the data', 'ErrCode: 2013');
		}
		else{ //No API calling
			returnError(' Missing API, fail to get the data', 'ErrCode: 2012');
		}
	}
	
	function POST($parameters) {
    $body = file_get_contents('php://input');
    $dataArray = json_decode($body, true);
    if (!empty($dataArray['Date'])) {
        $Hostname = $dataArray['Date'];
    } else {	
		returnError(' Missing or empty Date parameter, failed add record', 'ErrCode: 2111');
    }

	$sqlCheck = "SELECT COUNT(*) FROM TestTable WHERE Date = '$Date'";
    require_once 'db.php';
    $resultCheck = $conn->query($sqlCheck);
	$rowCheck = $resultCheck->fetch_row()[0];
    if ($rowCheck > 0) {
        returnError('failed add record - Data already exists', 'ErrCode: 2101');
    }
	else
	{
		$sql = "INSERT INTO TestTable (Date) VALUES ('$Date')";

    require_once 'db.php';
    try {
        $dbresult = $conn->query($sql);
        $output = array();
        $output['status'] = 'success';
        $output['remark'] = "inserted successfully";
        echo json_encode($output);
        exit;
    } catch (Exception $e) {
        $output = array();
        $output['status'] = 'error';
        $output['errcode'] = '3020';
        $output['errmsg'] = 'SQL failure - failed to insert';
        $output['errDetails'] = $e->getMessage();
       echo json_encode($output);
        exit;
    }
	}
}
	
	function PUT($parameters) {
    $body = file_get_contents('php://input');
    $dataArray = json_decode($body, true);
    
	if (isset($dataArray['Date'])) {
		$Date = $dataArray['Date'];
	} else {
		returnError('Missing Date parameter, fail to edit the data', '2010');
	}
    $sql = "UPDATE TestTable SET ";
    $flag = false;
    if (isset($district)) {
        $sql .= "Date='$Date' ";
        $flag = true;
    }
    $sql .= "WHERE Date='$Date";
    
    require_once 'db.php';
    try {
        $dbresult = $conn->query($sql);
        if ($dbresult) {
            $output = array();
            $output['status'] = 'success';
            $output['remark'] = "Updated successfully";
            echo json_encode($output);
            exit;
        } else {
            $output = array();
            $output['status'] = 'error';
            $output['errcode'] = '3020';
            $output['errmsg'] = 'SQL failure - failed to update';
            echo json_encode($output);
            exit;
        }
    }
    catch (Exception $e) {
        $output = array();
        $output['status'] = 'error';
        $output['errcode'] = '3020';
        $output['errmsg'] = 'SQL failure - failed to update';
        $output['errDetails'] = $e->getMessage();
        echo json_encode($output);
        exit;
    }
}

	//http://<ServerID>/Interface/API/Interface.php/Hwid/<API>
	function DELETE($parameters) {
		$Date = array_shift($parameters);
				
		if (!isset($Date))  {
			$output = array();
			$output['status'] = 'error';
			$output['errcode'] = '2010';
			$output['errmsg'] = 'Missing Date parameter';
			//echo json_encode($output);
			exit;
		}
				
		$sql = "DELETE FROM atm WHERE Date=$Date";
		
		require_once 'db.php';
		
		// exception handling
		try {
			$dbresult = $conn->query($sql);
			if (mysqli_affected_rows($conn)==1) {
				$output = array();
				$output['status'] = 'success';
				$output['remark'] = "Deleted successfully";
				echo json_encode($output);
				exit;
			} else {
				$output = array();
				$output['status'] = 'warning';
				$output['errcode'] = '0010';
				$output['errmsg'] = "Date not found";
				echo json_encode($output);
				exit;
			}
		}
		catch (Exception $e) {
			$output = array();
			$output['status'] = 'error';
			$output['errcode'] = '3010';
			$output['errmsg'] = 'SQL failure - failed to delete';
			echo json_encode($output);
			exit;
		}
	}
}
function returnError($errorMessage, $errorCode) {
    $output = array(
        'status' => 'error',
        'errcode' => $errorCode,
        'errmsg' => $errorMessage
    );
    echo json_encode($output);
    exit;
}









	
	
	