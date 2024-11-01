let path = window.location.pathname;

let pathArray = path.split('/');

if (pathArray[pathArray.length - 1] === 'decks-manager') {
    let navItem = document.getElementById('decks-manager');
    navItem.classList.add('active');
}
else if (pathArray[pathArray.length - 1] === 'backend') {
    let navItem = document.getElementById('dashboard');
    navItem.classList.add('active');
}