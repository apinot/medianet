window.addEventListener('load', () => {
    const addTakedDocument = document.getElementById("addTakedDocument");
    const takedDoc = document.getElementById("takedDoc");

    addTakedDocument.addEventListener('click', () => {
        const elem = document.createElement('input');
        elem.setAttribute('type', 'text');
        elem.setAttribute('name', 'documents[]');
        elem.setAttribute('placeholder', 'Référence');
        takedDoc.appendChild(elem);
    });
});