/* to add active and visited classes*/
buttons.forEach(function(button) {
  button.addEventListener("click", function() {
    buttons.forEach(function(btn) {
      btn.classList.remove('active'); 
    });

    button.classList.add('active', 'visited');
  });
});


