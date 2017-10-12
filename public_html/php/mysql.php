<?php
function dbUpdate ($query,$conn) {
	if ($conn->query($query) === TRUE) {
	    //echo "Record updated successfully";
	} else {
	    //echo "Error updating record: " . $conn->error;
	}

	$conn->close();
}
