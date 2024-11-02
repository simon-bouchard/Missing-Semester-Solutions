/*Add copy button */
document.querySelectorAll('.code-container button.copy').forEach(button => {
  button.addEventListener("click", function() {
    const code = this.previousElementSibling.textContent;

    navigator.clipboard.writeText(code).then(() => {
      this.textContent = "Copied";
      this.classList.add("copied");
      
      setTimeout(() => {
        this.textContent = "Copy";
        this.classList.remove("copied");
      }, 2000);
    }).catch(err => {
      console.error("failed to copy text: ", err);
    });
  });
});


/*Make copy button apear on hover*/
const codeBlocks = document.querySelectorAll('div.code-container');

codeBlocks.forEach(function(code) {
  code.addEventListener('mouseover', function() {
    code.lastElementChild.classList.add('display');
  });

  code.addEventListener('mouseout', function() {
    code.lastElementChild.classList.remove('display');
  });
});
