window.addEventListener("load", function(){
	function stpr_getParameterByName(name, url) {
		if (!url) url = window.location.href;
		name = name.replace(/[\[\]]/g, "\\$&");
		var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
			results = regex.exec(url);
		if (!results) return null;
		if (!results[2]) return '';
		return decodeURIComponent(results[2].replace(/\+/g, " "));
	}
	
	var preview_theme = stpr_getParameterByName('theme_preview');	
	if (preview_theme) {
		var findlink = document.getElementsByTagName("a");
		var arrayLength = findlink.length;
		var string = '';
		for (var i = 0; i < arrayLength; i++) {
			findlink[i].onclick = function() {
				string = this.href;
				if (string.indexOf("theme_preview=") == -1) {
					if (string.indexOf(window.location.host) !== -1) {
						if (string.indexOf("?") !== -1) {
							this.href = this.href + "&theme_preview=" + preview_theme;
						} else {
							this.href = this.href + "?theme_preview=" + preview_theme;
						}
					}
				}
			}
		}
	}
	
});