        var table = document.getElementById('table');
                
                for(var i = 1; i < table.rows.length; i++)
                {
                    table.rows[i].onclick = function()
                    {
                         //rIndex = this.rowIndex;
                         document.getElementById("devauto").value = this.cells[0].innerHTML;
                         document.getElementById("devname").value = this.cells[2].innerHTML;
			document.getElementById("devcontrol").value = this.cells[3].innerHTML;
			document.getElementById("status").value = this.cells[5].innerHTML;			
                       				
                    };
                }
    