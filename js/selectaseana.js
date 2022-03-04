function populate(s1,s2)

	{
	var s1 = document.getElementById(s1);
	var s2 = document.getElementById(s2);
	s2.innerHTML = "";


	if (s1.value =="Aseana1") {
	var optionArray = ["|","Meeting Room 5A|Meeting Room 5A","Meeting Room 5B|Meeting Room 5B","Meeting Room 6A|		Meeting Room 6A","Meeting Room 6B|Meeting Room 6B","Training Room 1|Training Room 1","Training Room 2|		Training Room 2","Video Con 1|Video Con 1","Guest Room|Guest Room","Conference Rm|Conference Rm",
		"MIS/Data Center|MIS/Data Center","President Room|President Room","Director's Aseana1 Room|Director's Aseana1 		Room","PRT 	Area|PRT Area","WHE Area|WHE Area","CON Area|CON Area","EI Area|EI Area","JBRB Area|JBRB 		Area","ES Area|ES Area","TED 		Area|TED Area","EV Area|EV Area","SCD Area|SCD Area","MIS Area|MIS 				Area","ADM Area|ADM Area","HR Area|HR Area","FIN Area|FIN Area"]
				}
		



	else if (s1.value == "Aseana2") {
	var optionArray = ["|","Meeting Room 2|Meeting Room 2","Meeting Room 3|Meeting Room 3","Meeting Room 4|Meeting 			Room 4","Meeting Room 5|Meeting Room 5","Training Room 1|Training Room 1",
			"Video Con 2|Video Con 2","WH1 Area|WH1 Area","WH2 Area|WH2 Area","WH3 Area|WH3 			Area","WH4 Area|WH4 Area","Director's Aseana2 Room|Director's Aseana2 Room"];
						}


	else if (s1.value == "BusinessTrip") {
	var optionArray = ["|","Business Trip (JAPAN)|Business Trip(JAPAN)","Business Trip (CHINA)|Business Trip		(CHINA)","Business Trip (THAILAND)|Business Trip(THAILAND)","Business Trip (USA)|		Business Trip				(USA)","Business Trip (ILOILO)|Business Trip(ILOILO)","Business Trip (EMI)|Business Trip(EMI)","Work at Home |Work at Home"];

							}





		for (var option in optionArray) {
			var pair = optionArray[option].split("|");
			var newOption = document.createElement ("option");
			newOption.value = pair[0]; newOption.innerHTML = pair[1];
			s2.options.add(newOption);
		}

}



