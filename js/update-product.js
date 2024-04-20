let subImages = document.querySelectorAll('.update-product .image-container .sub-image img');
let mainImages = document.querySelector('.update-product .image-container .main-image img');
subImages.forEach(images => {
    images.onclick = () => {
        let src = images.getAttribute('src');
        mainImages.src = src;
    }
});