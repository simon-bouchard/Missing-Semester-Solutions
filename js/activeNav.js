const links = document.querySelectorAll('.nav a');
	links.forEach(link => {
	    if (link.pathname === window.location.pathname) {
	        link.parentElement.classList.add('active-nav');
	    }
	});

