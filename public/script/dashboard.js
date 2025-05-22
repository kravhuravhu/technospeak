document.querySelectorAll('.card button').forEach(button => {
  button.addEventListener('click', () => {
    alert('You have enrolled in this course!');
  });
});
