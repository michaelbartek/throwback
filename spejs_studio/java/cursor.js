const cursor = document.querySelector('.cursor');

/* stop if touch device */
if (window.matchMedia("(hover: none) and (pointer: coarse)").matches) {
    cursor.remove();
} else {

    document.addEventListener('mousemove', e => {
        cursor.style.left = e.clientX + 'px';
        cursor.style.top = e.clientY + 'px';
    });

    document.addEventListener('mousedown', () => {
        cursor.classList.add('click');
    });

    document.addEventListener('mouseup', () => {
        cursor.classList.remove('click');
    });

}

