window.addEventListener('load', () => {
    const addTakedDocument = document.getElementById("addTakedDocument");
    const takedDoc = document.getElementById("takedDoc");

    addTakedDocument.addEventListener('click', () => {
        const elem = document.createElement('input');
        elem.setAttribute('class', 'itemref');
        elem.setAttribute('type', 'text');
        elem.setAttribute('patern', '\d+');
        elem.setAttribute('name', 'documents[]');
        elem.setAttribute('placeholder', 'Référence');
        takedDoc.appendChild(elem);
    });

    const addReturnedDocument = document.getElementById("addReturnedDocument");
    const returnedDoc = document.getElementById("returnedDoc");

    addReturnedDocument.addEventListener('click', () => {
        const elem = document.createElement('input');
        elem.setAttribute('class', 'itemref');
        elem.setAttribute('type', 'text');
        elem.setAttribute('patern', '\d+');
        elem.setAttribute('name', 'documents[]');
        elem.setAttribute('placeholder', 'Référence');
        returnedDoc.appendChild(elem);
    });
});