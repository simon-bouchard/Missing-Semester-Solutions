/*To load lecture from index page*/
const params = new URLSearchParams(window.location.search);

if (params.has('link')) {
  const link = params.get('link');

  document.getElementById(link).click();
  
  iframe.scrollIntoView({ behavior: 'smooth' });
}


