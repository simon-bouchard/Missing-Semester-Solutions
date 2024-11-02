/*For next and prev buttons in lecture page*/
	/*To send the current lecture id to the lecture page*/
	const iframe = document.getElementById('exo');
	const buttons = document.querySelectorAll('div.menu ul li');
	
	buttons.forEach(function(button) {
		button.addEventListener('click', (event) => {
			const clickedId = event.target.id;
				
			iframe.addEventListener('load', () => {
				iframe.contentWindow.postMessage(clickedId, '*');
			});
		});
	});

	/*To change the lecture*/
window.addEventListener('message', (event) => {
		if(event.data.lect) {
			const lectNum = event.data.lect;
			
			document.getElementById(lectNum).click();
		};
});


