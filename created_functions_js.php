<script>
//set value of an element with query	
//parameters component = value to searcj, query = query, id_to_set = id of the element to set,  collumn_value_to_search = column name of the table to search, collumn_value_to_put = value to be search in table , \
// param_data[] if paramaeters are sent via array it also accept

function trigger_change_js(id_change){

	$("#"+id_change).trigger('change');
}
function trigger_change_set_querydata()
{
	
	var component_ = "";
	var query = "";
	var id_to_set = "";
	var collumn_value_to_search = "";
	var collumn_value_to_put = "";
	var id = component_.id;
	var param_data = [];
	
	//$("#txt_acronym_4edit").val('test');
	//alert('test');
	
	
	if(arguments.length == 1)
		{
			param_data.push(arguments[0][0]);
			param_data.push(arguments[0][1]);
			param_data.push(arguments[0][2]);
			param_data.push(arguments[0][3]);
			param_data.push(arguments[0][4]);
			
		}
	else
		{
			param_data.push(arguments[0]);
			param_data.push(arguments[1]);
			param_data.push(arguments[2]);
			param_data.push(arguments[3]);
			param_data.push(arguments[4]);		
		}
	
	
	if(param_data[0] =="")
	{
	  return alert("component not set");
	}
	else
	{
	
		
		component_ = param_data[0];
		
	}
	if(param_data[1] == "")
	{
	  return alert("query not set");
	}
	else
	{
	   query = param_data[1];
	}
	if(arguments[2]=="")
	{
	   return alert("id of component to set, not set");
	}
	else
	{
	   id_to_set = param_data[2];
	}
	if(param_data[3]=="")
	{
	   return alert("column to search, not set");
	}
	else
	{
	   collumn_value_to_search = param_data[3];
	}
	if(param_data[4]=="")
	{
	   return alert("column of query table not selected, not set");
	}
	else
	{
	   collumn_value_to_put = param_data[4];
	}
	
	query = query + " WHERE " + collumn_value_to_search + " ='" + component_ + "'";
	

  $.ajax({

               type: "GET",
               url: 'created_functions_php.php',
      	   		data: {
                   query_: query , collumn_value_to_put:collumn_value_to_put  },
                 //  query_ : query  },
               success: function(res){
			      var query_info_ = jQuery.parseJSON(res);
           
				   
					if(query_info_ =="no row found")
						{
							alert('no data found');
						}
					else
						{
							set_value(id_to_set,query_info_);
						}   

					   }
 });
	
	  
	
	
	

}

// set_value(param1,param2) param 1 = id of element param2 = value to set	
function set_value()
	{

		var value = "";
		var id = "";
		
		if(arguments.length >3)
			{
				return alert('arguments greater than 3');
				
			}
		if(arguments.length <2)
			{
				
				if(Array.isArray(arguments[0]) )
				{
		
					id = arguments[0][0];
					value = arguments[0][1];
					//alert(id);
				}
			}
		else{
			if(arguments[0] =="")
			{
				
					return alert("set_value: id not set");
				}
			else
				{
					id = arguments[0];
				}
			if(arguments[1]=="")
				{
					return alert("set_value: value not set");
				}
			else
			{
				value = arguments[1];

			}
		}
		
		var element = document.getElementById(id);
			if(element.tagName === 'SELECT')
			{
				
				element.value = value;
			}
			else if(element.tagName === 'INPUT' && element.type === 'text') 
			{
				
				element.value = value;
			}else if(element.tagName === 'INPUT' && element.type === 'time') 
			{
				
				element.value = value;
			
			}else if(element.tagName === 'INPUT' && element.type === 'date') 
			{
				
				element.value = value;
			
			}else if(element.tagName === 'INPUT' && element.type === 'email') 
			{
				
				element.value = value;
			  
			}
			else if(element.tagName === 'INPUT' && element.type === 'textarea') 
			{
				element.value = value;
			}
			else if(element.tagName === 'LABEL')
			{
				if(arguments[2] != "")
				{
					value = value.fontcolor(arguments[2]);
				}
				$("#"+id).empty();
				$("#"+id).append(value);
				
			}
			else if(element.tagName === 'DIV')
				{
					
				}
			else alert('element Tag name not supported');
		
		
	}
//trigger_change_id_to_name()

function trigger_change_id_to_name()
{
	
	var query = "";
	var id_to_get = "";
	var id_to_set = "";
	var collumn_value_to_search = "";
	var collumn_value_to_put = "";
	var param_data = [];
	//$("#txt_acronym_4edit").val('test');
	//alert('test');

	if(arguments.length == 1)
		{
			param_data.push(arguments[0][0]);
			param_data.push(arguments[0][1]);
			param_data.push(arguments[0][2]);
			param_data.push(arguments[0][3]);
			param_data.push(arguments[0][4]);
		}
	else
		{
			param_data.push(arguments[0]);
			param_data.push(arguments[1]);
			param_data.push(arguments[2]);
			param_data.push(arguments[3]);
			param_data.push(arguments[4]);
		}
	
	
	if(param_data[0] == "")
	{
	  return alert("query not set");
	}
	else
	{
	   query = param_data[0];
	}
	if(param_data[1]=="")
	{
	   return alert("id of component to get, not set");
	}
	else
	{
	   id_to_get = param_data[1];
	}	
	if(param_data[2]=="")
	{
	   return alert("id of component to set, not set");
	}
	else
	{
	   id_to_set = param_data[2];
	}
	if(param_data[3]=="")
	{
	   return alert("column to search, not set");
	}
	else
	{
	   collumn_value_to_search = param_data[3];
	}
	if(param_data[4]=="")
	{
	   return alert("column of query table not selected");
	}
	else
	{
	   collumn_value_to_put = param_data[4];
	}
	query = query + " WHERE " + collumn_value_to_search + " ='" + document.getElementById(id_to_get).value  + "'";

  $.ajax({

               type: "GET",
               url: 'created_functions_php.php',
      	   		data: {
                   query_id_to_name: query , collumn_value_to_put:collumn_value_to_put  },
                success: function(res){
			      var query_info_ = jQuery.parseJSON(res);
           
				   
					if(query_info_ =="no row found")
						{
							alert('trigger_change_id_to_name:no id found');
							clear_data_components(id_to_set);
						}
					else
						{
						
							
							set_value(id_to_set,query_info_);
							
						}   

					   }
 });
	
}
	//clear_data_components(id1,id2...) id of elements to be clear
function clear_data_components()
	{
		
		for(var i =0;i<= arguments.length-1 ;i++)
			{
				//alert(arguments[i]);
			 var element = document.getElementById(arguments[i]);
				if(element.tagName === 'SELECT')
				{
				 	document.getElementById(arguments[i]).selectedIndex = "0";
				}
				else if(element.tagName === 'INPUT' && element.type === 'text') 
				{
					element.value = "";
				}else if(element.tagName === 'INPUT' && element.type === 'time') 
				{
					element.value = "";
				}else if(element.tagName === 'INPUT' && element.type === 'date') 
				{
					element.value = "";
				}else if(element.tagName === 'INPUT' && element.type === 'email') 
				{
					element.value = "";
				}
				else if(element.tagName === 'INPUT' && element.type === 'textarea') 
				{
				 	element.value = "";
				}
				else if(element.tagName === 'LABEL')
				{
						 $("#"+arguments[i]).empty();
				}
			}
		
	}
function set_required(id,value)
	{
	//	document.getElementById(id).required = value;
		$("#txt_inv_plan_no").prop('required',value);
          
	}
	
function callback_jquery(method1,method1_param,method2,method2_param)
	{
		//alert(method_arr1[0]+" test2");
    /*if (method_arr1 instanceof Array == false) {
        return alert("method_arr1 not an array!");
    } 
	if (method_arr2 instanceof Array == false) {
        return alert("method_arr2 not an array!");
    }
		*/
		//alert(method2_param);
		//alert(method1_param);
		$.ajax({
				url:  method1(method1_param),
				success:function(){
				method2(method2_param);
						
				}
				});
		
	}
	function multiple_callback_jquery(methods,method_params)
	{
		//alert(method_arr1[0]+" test2");
    /*if (method_arr1 instanceof Array == false) {
        return alert("method_arr1 not an array!");
    } 
	if (method_arr2 instanceof Array == false) {
        return alert("method_arr2 not an array!");
    }
		*/
		//alert(method2_param);
		//alert(method1_param);
		
		if(Array.isArray(methods))
			{
			alert(method_params[0]);
			alert(methods[0]);
				for(var i =0 ;i <= methods.length -1; i++)
					{
						if(i + 1 <= methods.length -1 )
							{
								alert(i);
								
								$.ajax({
								url:  methods[i](method_params[i]),
								success:function(){
									
								methods[i+1](method_params[i+1]);
									
								}
								});
								
							}
						
							
					}
			
			}
		else{
			alert('not array');
		
		}
	
		
	}
	
function check_data_existquery_js(table_name,input_id,column,label_id,error_txt,correct_txt)
	{
		
		 var element = document.getElementById(input_id);
		 var value = element.value;
		if(element.value.trim() =="")
			{
				clear_data_components(label_id);
				return;
			}
	/*	if(arguments.length == 7 )
			{
			  var class_id_to_put = arguments[6];
			}
		*/
		var query = "SELECT * FROM "+table_name+" WHERE "+column+" = '"+value+"'";
		  $.ajax({

               type: "GET",
               url: 'created_functions_php.php',
      	   		data: {
                  checkdataexistqueryjs_query:query  },
                success: function(res){
			      var query_info_ = jQuery.parseJSON(res);
					if(query_info_ =="no row found")
						{
							//set_value(label_id,correct_txt,"Green");
							clear_data_components(label_id);
							remove_class_error_textbox(input_id);
							add_class_valid_textbox(input_id);
							
							return "true";
						}
					else
						{
							
							set_value(label_id,error_txt,"#a94442");
							remove_class_valid_textbox(input_id);
							add_class_error_textbox(input_id);
							return "false";
						}   

					   }
					});
		
	}
	
function check_required_datasubmit(id_arr,alert_value)
	{
		if(id_arr.length != alert_value.length )
			{
				 alert("id array and alert array not equal: "+id_arr.length+":"+alert_value.length);	
				return false;	
			}
		//alert(id_arr[0]);
		//alert(alert_value[0]);
		for(var i = 0; i <= id_arr.length -1; i++)
			{
		
				var element = document.getElementById(id_arr[i]);
			
				if(element.value.trim() == "")
					{
						alert(alert_value[i]);
						element.focus();
						return false;
					}
			}
	}
	
function element_hide(id,boolean)
	{
		if(boolean == true)
		{
		$('#'+id).show();
		
		}
		else
		{
		$('#'+id).hide();
		
		}
	}
function set_disable(id,boolean)
	{
		$('#'+id).prop('disabled', boolean);
	}
function set_readonly(id,boolean)
	{
		$('#'+id).prop('readonly', boolean);
	}
function display_error_content(id)
	{
		if ($('#'+id).is(':empty'))
			{
				$('#'+id).css("display","none");
			}
		else{
			$('#'+id).css("display","block");
		}
		
	}
	
function js_pad (str, max) {
  str = str.toString();
  return str.length < max ? pad("0" + str, max) : str;
}
function check_element_empty_string(id)
	{
		if($('#'+id).text().length > 0)
		{
			return "true";
		}
		else
			return "false";
		
	}
	
function ai_ctrl_no(splitter,ai_pos,input,ai_pad)
	{
		var ai_ctrl = input.split(splitter);
		var val_ai = parseInt(ai_ctrl[ai_pos])+1;
			ai_ctrl[ai_pos] = js_pad(val_ai,ai_pad);
		return ai_ctrl.join(splitter);
	}
function ai_ctrl_no_query(query_4select,splitter,ai_pos,id_to_input,ai_pad,query_4acro,column_val_4acro)
	{
		 $.ajax({

               type: "GET",
               url: 'created_functions_php.php',
      	   		data: {
                  ai_ctrl_no_query_query_4select:query_4select, ai_ctrl_no_query_query_4acro:query_4acro ,ai_ctrl_no_query_column_val_4acro:column_val_4acro },
                success: function(res){
			      var query_info_ = jQuery.parseJSON(res);
				
							//set_value(label_id,correct_txt,"Green");
							set_value(id_to_input,ai_ctrl_no(splitter,0,query_info_,ai_pad));
							return;
					   }
					});
		
		
	}
function check_error_div(Element_id_arr,error_div_id)
	{
		var element_bool_arr = [];
		
		for(var i = 0; i <= Element_id_arr.length-1; i++)
			{
				var elemet_val = check_element_empty_string(Element_id_arr[i]);
				element_bool_arr.push(elemet_val);
			//	alert(Element_id_arr[i]);
			//	alert(elemet_val);
				if(elemet_val == "true")
					{
							element_hide(Element_id_arr[i],true);
					}
				else
					{
							element_hide(Element_id_arr[i],false);
					}
			}
		if(element_bool_arr.includes("true"))
			{
				element_hide(error_div_id,true);
				//$("#"+error_div_id).show();
			}
		else
			{
				element_hide(error_div_id,false);
			}
		
	}
function add_class_element(id,class_name)
	{
		$('#'+id).addClass(class_name);
	}
function remove_class_element(id,class_name)
	{
		
		$('#'+id).removeClass(class_name);
	}
function add_class_error_textbox(id)
	{
		add_class_element(id,"form-class error");
	}
function remove_class_error_textbox(id)
	{
		remove_class_element(id,"error");
	}
function add_class_valid_textbox(id)
	{
		add_class_element(id,"form-class valid");
	}
function remove_class_valid_textbox(id)
	{
		remove_class_element(id,"valid");
	}
	/*
$("body").on('DOMSubtreeModified', "#div_error-dialog", function() {
	
    // code here
	if($('#manage_d_error_log1').text().length > 0)
		{
			
			$('#manage_d_error_log1').show();
		}
	else
		{
			$('#manage_d_error_log1').hide();
			
		}	
	if($('#manage_d_error_log2').text().length > 0)
		{
			$('#manage_d_error_log2').show();
		}
	else
		{
			$('#manage_d_error_log2').hide();
		}	
	if($('#manage_d_error_log3').text().length > 0)
		{
			$('#manage_d_error_log3').show();
		}
	else
		{
			$('#manage_d_error_log3').hide();
		}
});*/
	

function formatAMPM(date) {
  var hours = date.getHours();
  var minutes = date.getMinutes();
  var ampm = hours >= 12 ? 'pm' : 'am';
  hours = hours % 12;
  hours = hours ? hours : 12; // the hour '0' should be '12'
  minutes = minutes < 10 ? '0'+minutes : minutes;
  var strTime = hours + ':' + minutes + ' ' + ampm;
  return strTime;
}
function send_text_js(to,body,channel)
{
	return link ="http://10.49.5.235:8014/TMS_SMS/index.php?slct_sms_mail=SMS&slct_charset=Plain+Text&txt_Channel="+channel+"&txt_to="+to+"&txt_Body="+body+"&btn_send_text=Send+message";
	
}
	
	
function clear_select_options_js(id)
	{
		$('#'+id).empty().append('<option selected="selected" value="">--</option>');
					
	}
function populate_select_option(id,values,texts,selected)
	{
		var set_sel = "";
	
		for(var i = 0; i <= values.length-1; i++ )
			{
					if(selected == values[i])
						{
							set_sel = "Selected";
						}
				$('#'+id).append('<option value="'+values[i]+'" '+set_sel+'>'+texts[i]+'</option>');
				set_sel = "";
			}
		
	}

	
function get_global_var(global_var_name)
	{
		return window.global_var_name;
		
	}
function get_file_name_list_populate_to(location,file_type,id,selected)
{
	
		
	$.ajax({
               type: "GET",
               url: 'created_functions_php.php',
      	   		data: {
                   get_file_name_list_location: location , get_file_name_list_file_type:file_type  },
                 //  query_ : query  },
               success: function(res){
				 //  alert(res);
			       var file_info = jQuery.parseJSON(res);
           			 populate_select_option(id,file_info,file_info,selected);
			   }
			 });
	
}

/*
  function successCallBack(returnData) {
                // the main process have to be here<br>
                alert(returnData);
                confirm('Are you sure you want to delete');
            }

            function getcityvalue(cityid)
            {

                // this will generate another thread to run in another function
                jQuery.ajax({
                    url: 'city.html',
                    type: 'get',
//                    dataType: 'text/html',
                    success: successCallBack
                });
            }
            function cityconfirm()
            {

                alert("here");
                // var cityid = document.getElementById('city').value;
                var cityid = 1;
                getcityvalue(cityid);
            }
*/
</script>
    