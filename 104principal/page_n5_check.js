var checked_count = 0;
checked_count = $('#QID_7f2vdq5p').children().children().children().not('div').find('input:checkbox:checked').length;
	
if (checked_count != 3) {
	alert('第2題需填寫最多的三項')
	return false;
}  
