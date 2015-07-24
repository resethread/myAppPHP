var tags_array = [];
$('.btn_tag').on('click', function() {
	var thisTag = $(this).text(),
		index = tags_array.indexOf(thisTag);

	// if the tag is already in the array, delete it	
	if (index > -1) {
		tags_array.splice(index, 1);
		$(this).toggleClass('tagged');
	}
	// else, insert it in the array
	else {
		if (tags_array.length < 9) {
			tags_array.push(thisTag);
			$(this).toggleClass('tagged');
		}
	}
	var stringfied = tags_array.join();
	document.getElementById('tags').value = stringfied;
	
});
