(function hoverImg() {
	var thumbs = document.querySelectorAll('.thumb')

	for (var i = 0; i < thumbs.length; i++) {
		var thumb = thumbs[i]
		var slider
		var count = 1
		var img_1

		thumb.addEventListener('mouseover', function(i) {
			var img_src = i.target.src // http://domain.com/src/toto-1.jpg
			var last_slash = img_src.lastIndexOf('/') // 44
			var start_src = img_src.slice(0, img_src.lastIndexOf('/')) + '/' // http://domaine.com/src/
			var img_id_src = img_src.substr(last_slash + 1, 30) // toto-1.jpg
			var img_id = img_id_src.slice(0, img_id_src.lastIndexOf('-')) + '-'

			img_1 = start_src + img_id + 1 + '.jpg'
			
			var img_2 = start_src + img_id + 2 + '.jpg'

			i.target.src = img_2

			
			slider = setInterval(function() {
				i.target.src = start_src + img_id + count + '.jpg'
				count++
				if (count > 12) {
					count = 0
					i.target.src = img_1
					
				}
				console.log(count)
			}, 1000)

			
		})

		thumb.addEventListener('mouseleave', function(i) {
			clearInterval(slider)
			slider = null
			count = 1
			i.target.src = img_1
		})
	}
})()




