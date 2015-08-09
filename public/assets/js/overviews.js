var blocsArray = document.getElementsByClassName('videoOvw');



for (var i = 0; i < blocsArray.length; i++) {

	blocsArray[i].onmouseover = function() {
		var attrSrc = blocsArray[i].children[0].children[0].getAttributeNode('src').value;
		
		
	}
}