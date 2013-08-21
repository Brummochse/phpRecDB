function stretchToAspectRatio(arText) {
	w = arText.substring(0, arText.indexOf(":"));
	h = arText.substring(arText.indexOf(":") + 1, arText.length);

	for ( var i = 0; i < screens.length; i++) {
		var currentScreen = screens[i];

		var tempImg = new Image();
		tempImg.src = currentScreen.src;
		
		currentScreen.style.width = tempImg.width;
		
		if (document.getElementById('stretch').checked) {
			newHeight=tempImg.width / w * h;
		} else {
			newHeight=tempImg.height;
		}
		currentScreen.style.height = newHeight;
	}

}

screens = document.getElementById('screenshots')
.getElementsByTagName('img');

var allScreens = screens.length, loadedScreens = 0;
function loadHandler () {
loadedScreens++;
   if (loadedScreens == allScreens) {
	   stretchToAspectRatio(aspectRatioText)
   }
}
for ( var i = 0; i < screens.length; i++) {
	var currentScreen = screens[i];
	var tempImg = new Image();
	tempImg.src = currentScreen.src;
	tempImg.onload = loadHandler;
}
