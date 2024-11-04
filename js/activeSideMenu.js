/* to add active and visited classes*/
buttons.forEach(function(buton) {
  buton.addEventListener("click", function() {
    buttons.forEach(function(btn) {
      btn.classList.remove('active'); 
    });

    buton.classList.add('active', 'visited');
  });
});


