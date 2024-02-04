window.addEventListener('scroll', function() {
    var navbar = document.querySelector('.navbar');
    if (window.scrollY > 0) {
        navbar.classList.add('bg-dark');
    } else {
        navbar.classList.remove('bg-dark');
    }
});

let navButton = document.querySelector('.navbar-toggler');

navButton.addEventListener('click', function() {
    let navbar = document.querySelector('.navbar');
    if (navbar.classList.contains('bg-dark')) {
        navbar.classList.remove('bg-dark');
    }
    else {
        navbar.classList.add('bg-dark');
    }
});