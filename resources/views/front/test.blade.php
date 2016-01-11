<script>

function closure(x) {
	var num = x;
	return function(y) {
		num += y;
		return num;
	}
}

var c1 = closure(10);

console.log(c1(1), c1(1), c1(1), c1(1), c1(1));



</script>