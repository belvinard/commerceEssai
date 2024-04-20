document.addEventListener('DOMContentLoaded', () => {
    const userBtn = document.querySelector('#user-btn');
    const profile = document.querySelector('.profile');
    const navbar = document.querySelector('.navbar');
    const menuBtn = document.querySelector('#menu-btn');

    menuBtn.onclick = () => {
        navbar.classList.toggle('active');
        profile.classList.remove('active');
        toggleScroll();
    };

    userBtn.onclick = () => {
        profile.classList.toggle('active');
        navbar.classList.remove('active');
        toggleScroll();
    };

    // Function to toggle scroll
    function toggleScroll() {
        document.body.classList.toggle('no-scroll');
    }

    // Close navbar when a navigation link is clicked
    const navLinks = document.querySelectorAll('.navbar a');
    navLinks.forEach((link) => {
        link.addEventListener('click', () => {
            navbar.classList.remove('active');
            toggleScroll();
        });
    });

    // Close navbar when scrolling

    window.onscroll = () => {
        profile.classList.remove('active');
        navbar.classList.remove('active');
        toggleScroll();
    }
    


});
