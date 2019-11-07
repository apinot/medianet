window.addEventListener('load', () => {
    const addTakedDocument = document.getElementById("addTakedDocument");
    const takedDoc = document.getElementById("takedDoc");
    const btn_list = document.getElementById("buttons");
    const btn_list_return = document.getElementById("buttons_return");

    takedDoc.addEventListener('DOMNodeInserted',()=> {
        const number_of_children_addTakedDocument = $('#takedDoc').children().length;
        const number_of_children_addTakedButton = $('#buttons').children().length;

        console.log("zinzin");
        if (number_of_children_addTakedDocument >1 && number_of_children_addTakedButton === 1){
            const elem =  document.createElement('div');
            elem.setAttribute('class','btn ');
            elem.setAttribute('id','suprr_emprunt ');
            elem.innerText = "Supprimer";
            btn_list.appendChild(elem);

            btn_list.lastChild.addEventListener('click', () => {
                takedDoc.removeChild(takedDoc.lastChild);
                console.log(number_of_children_addTakedDocument);
                if (number_of_children_addTakedDocument < 1){
                    btn_list.removeChild(btn_list.lastChild);
                }
            });
        }

        if (number_of_children_addTakedDocument < 2){
            btn_list.removeChild(btn_list.lastChild);
        }

    });


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


    returnedDoc.addEventListener('DOMNodeInserted',()=> {
        const number_of_children_addTakedButton = $('#buttons_return').children().length;
        const number_of_children_addTakedDocument = $('#returnedDoc').children().length;
        console.log(number_of_children_addTakedButton);

        if (number_of_children_addTakedDocument >1 && number_of_children_addTakedButton === 1){
            const elem =  document.createElement('div');
            elem.setAttribute('class','btn ');
            elem.setAttribute('id','suprr_emprunt ');
            elem.innerText = "Supprimer";
            btn_list_return.appendChild(elem);

            btn_list_return.lastChild.addEventListener('click', () => {
                returnedDoc.removeChild(returnedDoc.lastChild);
                console.log(number_of_children_addTakedDocument);
                if (number_of_children_addTakedDocument < 1){
                    btn_list_return.removeChild(btn_list_return.lastChild);
                }
            });
        }

        if (number_of_children_addTakedDocument < 2){
            btn_list_return.removeChild(btn_list_return.lastChild);
        }


    });
});