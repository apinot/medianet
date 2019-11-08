window.addEventListener('load', () => {
    
    const flashMessages = document.querySelectorAll('.flash');
    
    flashMessages.forEach((elem) => {
        elem.addEventListener('click', () => {
            elem.remove();
        });
    });
});
