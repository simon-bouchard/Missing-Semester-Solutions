const links = document.querySelectorAll('.nav a');
	links.forEach(link => {
	    if (link.href === window.location.href) {
	        link.parentElement.classList.add('active-nav');
	    }
	});

