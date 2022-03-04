function populate2(s11,s22)
	{
	var s11 = document.getElementById(s11);
	var s22 = document.getElementById(s22);
	s22.innerHTML = "";
	if (s11.value =="EXT_DVD") {
		var optionArray = ["|","DVDPL-001|DVDPL-001","DVDPL-002|DVDPL-002"]
	}
		else if (s11.value == "EXT_HDD") {
		var optionArray = ["|","HDD-001|HDD-001","HDD-002|HDD-002"];
	}


		else if (s11.value == "CAMERA") {
		var optionArray = ["|","CM-001|CM-001","CM-002|CM-002"];
	}

		else if (s11.value == "HEADSET") {
		var optionArray = ["|","HDST-002|HDST-002","HDST-003|HDST-003"];
	}

		else if (s11.value == "Ipad_Air") {
		var optionArray = ["|","iPad_003|iPad_003","iPad_004|iPad_004"];
	}

		else if (s11.value == "JABRA") {
		var optionArray = ["|","JB-001|JB-001","JB-002|JB-002","JB-002|JB-002","JB-003|JB-003","JB-004|JB-004","JB-005|JB-005","JB-006|JB-006"];
	}

		else if (s11.value == "LAPTOP_PC") {
		var optionArray = ["|","LTP-001|LTP-001","LTP-002|LTP-002","LTP-003|LTP-003","LTP-004|LTP-004","LTP-005|LTP-005","LTP-006|LTP-006","LTP-007|LTP-007","LTP-008|LTP-008"];
	}

		else if (s11.value == "MEMORY_STICK") {
		var optionArray = ["|","CRD-001|CRD-001","CRD-002|CRD-002"];
	}

		else if (s11.value == "PROJECTOR") {
		var optionArray = ["|","PROJECTOR -016|PROJECTOR -016","PROJECTOR-033|PROJECTOR-033"];
	}

		else if (s11.value == "SPEAKER") {
		var optionArray = ["|","HPSPKR-001|HPSPKR-001","HPSPKR-002|HPSPKR-002","HPSPKR-003|HPSPKR-003"];
	}

		else if (s11.value == "SPKR_ANALOG") {
		var optionArray = ["|","SPKPHN-001|SPKPHN-001","SPKPHN-002|SPKPHN-002","SPKPHN-003|SPKPHN-003"];
	}

		else if (s11.value == "SPKR_LAN") {
		var optionArray = ["|","SPKPHN-005|SPKPHN-005","SPKPHN-006|SPKPHN-006"];
	}

		else if (s11.value == "SD_CARD") {
		var optionArray = ["|","SD-001|SD-001","SD-002|SD-002","SD-003|SD-003"];
	}

		else if (s11.value == "USB") {
		var optionArray = ["|","USB-001|USB-001","USB-002|USB-002","USB-003|USB-003","USB-004|USB-004","USB-005|USB-005","USB-006|USB-006","USB-007|USB-007","USB-008|USB-008","USB-009|USB-009","USB-010|USB-010"];
	}
	else if (s11.value == "WEBCAM") {
		var optionArray = ["|","WBCAM-001|WBCAM-001"];
	}
		for (var option in optionArray) {
			var pair = optionArray[option].split("|");
			var newOption = document.createElement ("option");
			newOption.value = pair[0]; newOption.innerHTML = pair[1];
			s22.options.add(newOption);
		}
}


