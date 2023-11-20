const pl_result_msg = document.querySelector('.pl-result-msg');
const pl_result_btn = document.querySelector('.pl-result-btn');
const pl_add_modal_window = document.getElementById('pl-add-modal');
const pl_add_page_btn = document.getElementById('pl-add-btn');
const pl_add_form = document.querySelector('#pl-add-modal form');
const pl_add_input_name = document.querySelector('#pl-add-modal input[name="nombre"]');
const pl_add_input_desc = document.querySelector('#pl-add-modal textarea[name="descripcion"]');
const pl_add_submit_btn = document.querySelector('#pl-add-modal button[value="submit"]');
const close_modal_btns = document.querySelectorAll('.closeModal');
const pl_dropdown_btns = document.querySelectorAll('.pl-dropdown-btn');
const pl_dropdown_menus = document.querySelectorAll('.pl-dropdown-menu');
const pl_menu_opt = document.querySelectorAll('.pl-dropdown-item');
const pl_del_modal_window = document.getElementById('pl-del-modal');
const pl_del_form = document.querySelector('#pl-del-modal form');
const pl_del_submit_btn = document.querySelector('#pl-del-modal button[value="submit"]');
const pl_edit_modal_window = document.getElementById('pl-edit-modal');
const pl_edit_form = document.querySelector('#pl-edit-modal form');
const pl_edit_submit_btn = document.querySelector('#pl-edit-modal button[value="submit"]');

pl_add_input_name.addEventListener('keyup', checkAddInputs);
pl_add_input_desc.addEventListener('keyup', checkAddInputs);

pl_result_btn.addEventListener('click', closeResultBox);

pl_add_page_btn.addEventListener('click', () =>{
    pl_add_modal_window.showModal();
});

close_modal_btns.forEach(btn =>{
    btn.addEventListener('click', (ev) =>{
        ev.preventDefault();
        const window = btn.closest('dialog');
        window.close();
    })
});

pl_dropdown_btns.forEach(btn =>{
    btn.addEventListener('click', ev =>{
        ev.stopPropagation();
        openDropdown(btn);
    });
});

pl_menu_opt.forEach(opt =>{
    opt.addEventListener('click', ev =>{
        ev.stopPropagation();
        openOptionModal(opt);
    });
});

function openOptionModal(opt){
    const opt_type = opt.getAttribute('data-target');
    if(opt_type === '#delete'){
        document.querySelector('#pl-del-modal .pl-del-name').innerText = opt.getAttribute('data-name');
        document.querySelector('#pl-del-modal input[name="id"]').value = opt.getAttribute('data-id');
        pl_del_modal_window.showModal();
        return;
    }
    if(opt_type === '#edit'){
        document.querySelector('#pl-edit-modal input[type="hidden"]').value = opt.getAttribute('data-id');
        document.querySelector('#pl-edit-modal #nombre').value = opt.getAttribute('data-name');
        document.querySelector('#pl-edit-modal #descripcion').value = opt.getAttribute('data-desc');

        const img = getCardRoot(opt).querySelector('img');
        const preview = document.querySelector('#pl-edit-modal #imagenPreview');
        preview.src = img.src;
        pl_edit_modal_window.showModal();
        return;
    }
    alert('Bad Opteration');
    return;
}

/* pl_dropdown_menus.forEach(menu =>{
    menu.addEventListener('focusout', ev =>{
        ev.stopPropagation();
        closeMenu(ev);
    });
});

function closeMenu(menu){
    console.log(menu.target);
    console.log(menu.currentTarget);
    console.log(menu.relatedTarget);
    const btn = menu.previousElementSibling;
    console.log(btn);
    toggleMenuVisibility(btn);
} */

function toggleMenuVisibility(btn){
    const menu_target = btn.nextElementSibling;
    btn.classList.toggle('pl-active-btn');
    menu_target.classList.toggle('hide');
    if(btn.classList.contains('pl-active-btn')){
        menu_target.focus();
    }
}

function openDropdown(btn){
    const active = document.querySelector('.pl-active-btn');
    if(active != null){
        if(active.isSameNode(btn)){
            toggleMenuVisibility(btn);
        }
        else{
            toggleMenuVisibility(active);
            toggleMenuVisibility(btn);
        }
    }
    else{
        toggleMenuVisibility(btn);
    }
}

function toggleAddSubmitBtn(){
    pl_add_submit_btn.disabled = !pl_add_submit_btn.disabled;
    pl_add_submit_btn.classList.toggle('disable');
}

function checkAddInputs(){
    const name_l = pl_add_input_name.value.length;
    const desc_l = pl_add_input_desc.value.length;
    
    if( name_l > 0 && name_l < 31 && desc_l < 61){
        if(pl_add_submit_btn.disabled){
            toggleAddSubmitBtn();
        }
    }
    else if(!pl_add_submit_btn.disabled){
        toggleAddSubmitBtn();
    }
}

function stringToJson(string){
    let res = '{"msg":"Error","extra":"Error de lectura de la respuesta del servidor."}';
    try{
        res = JSON.parse(string);
        return res;
    }
    catch (e){
        console.log(e.message);
        console.log(string); //Dev Ops
    }
    return res;
}

async function getServerData(params){
    if(typeof(params.url) !== 'string'){
        throw new Error('Bad url parameter');
    }
    if(typeof(params.form) !== 'object'){
        throw new Error('Bad form data');
    }
    if(!params.form instanceof FormData ){
        throw new Error('Form parameter is invalid');
    }

    try{
        const body = {
            method: 'POST',
            body: params.form
        }
        const res = await fetch(params.url, body);
        const string = await res.text();
        return stringToJson(string);
    }
    catch (e){
        console.log(e.message);
    }
}

pl_add_form.addEventListener('submit', async (ev)=>{
    ev.preventDefault();
    const url = pl_add_form.action;
    const form = new FormData(ev.target);
    try{
        const res = await getServerData({url, form});
        if(res.msg === 'Success'){
            pl_add_modal_window.close();
            setResultMsg('Lista de reproduccion guardado');
            displayResultBox();
            addPlaylistItem(res);
        }
        else{
            const name = document.querySelector('#pl-add-modal .pl-err-name');
            const desc = document.querySelector('#pl-add-modal .pl-err-desc');
            const img  = document.querySelector('#pl-add-modal .pl-err-img');
            name.innerText = res.name;
            desc.innerText = res.desc;
            img.innerText = res.img;
        }
    }
    catch (e){
        console.log(e.message);
    }
});

function addPlaylistItem(params){
    const pl_container = document.querySelector('.pl-items');
    const div = document.createElement('div');
    div.classList.add('pl-card');
    div.appendChild( createCardImg(params.img) );
    div.appendChild( createCardInfo(params.extra, params.name) );
    pl_container.appendChild(div);
}

function createCardImg(source){
    const img = document.createElement('img');
    if(source.length > 0){
        img.src = source;
    }
    else{
        img.src = './images/playlists/default.png';
    }
    return img;
}

function createCardInfo(id, name){
    const info = document.createElement('div');
    info.classList.add('pl-card-info');
    const h5 = document.createElement('h5');
    h5.innerText = name;
    info.appendChild(h5);

    const dropdown = document.createElement('div');
    dropdown.classList.add('pl-dropdown');

    const button = document.createElement('button');
    button.classList.add('pl-dropdown-btn');
    button.innerText = '...';
    button.addEventListener('click', ()=>{
        openDropdown(button);
    });
    dropdown.appendChild(button);

    const menu = document.createElement('div');
    menu.classList.add('pl-dropdown-menu', 'hide');
    menu.tabIndex = -1;
    menu.appendChild(createCardOption(id, name, 'edit') );
    menu.appendChild(createCardOption(id, name, 'delete') );
    dropdown.appendChild(menu);
    info.appendChild(dropdown);
    return info;
}

function createCardOption(id, name, type){
    const a = document.createElement('a');
    const i = document.createElement('i');
    a.classList.add('pl-dropdown-item');
    a.setAttribute('data-id', id);
    a.setAttribute('data-name', name);
    a.href = '#';
    if(type === 'edit'){
        a.setAttribute('data-target', '#edit');
        i.classList.add('fas', 'fa-edit');
        a.appendChild(i);
        a.innerHTML += 'Editar';
    }
    else{
        a.setAttribute('data-target', '#delete');  
        i.classList.add('fa', 'fa-trash');
        a.appendChild(i);
        a.innerHTML += 'Eliminar';
    }

    a.addEventListener('click', () =>{
        openOptionModal(a);
    });

    return a;
}

pl_del_form.addEventListener('submit', async (ev)=>{
    ev.preventDefault();
    const url = pl_del_form.action;
    const form = new FormData(ev.target);
    try{
        const res = await getServerData({url, form});
        if(res.msg === 'Success'){
            pl_del_modal_window.close();
            setResultMsg('Lista de reproduccion eliminada');
            displayResultBox();
            deletePlaylistItem(res.extra);
        }
        else{
            const err = document.querySelector('#pl-del-modal .pl-del-err');
            err.innerText = 'Error al eliminar lista de reproduccion';
        }
    }
    catch(e){
        console.log(e.message);
    }    
});

pl_edit_form.addEventListener('submit', async (ev)=>{
    ev.preventDefault();
    const url = pl_edit_form.action;
    const form = new FormData(ev.target);
    try{
        const res = await getServerData({url, form});
        if(res.msg === 'Success'){
            pl_edit_modal_window.close();
            setResultMsg('Se actualizo la lista de reproduccion');
            displayResultBox();
            updateCardItem(res);
        }
        else{
            const err = document.querySelector('#pl-del-modal .pl-del-err');
            err.innerText = 'Error al editar lista de reproduccion';
        }
    }
    catch(e){
        console.log(e.message);
    }    
});

function updateCardItem(params){
    const card = getCardRoot(document.querySelector('a[data-id="' + params.extra + '"]'));
    if(params.img !== ''){
        card.querySelector('img').src = params.img;
    }
    card.querySelector('h5').innerText = params.name;

    const edit = card.querySelector('a[data-target="#edit"]');
    edit.setAttribute('data-name', params.name);
    edit.setAttribute('data-desc', params.desc);

    const del = card.querySelector('a[data-target="#delete"]');
    del.setAttribute('data-name', params.name);
    del.setAttribute('data-desc', params.desc);
    return;
}

function getCardRoot(element){
    let root = element;
    while(!root.classList.contains('pl-card')){
        root = root.parentNode;
    }
    return root;
}

function deletePlaylistItem(id){
    const item = '.pl-dropdown-item[data-id="' + id + '"]';
    const element = document.querySelector(item);
    getCardRoot(element).remove();
}

function setResultMsg(msg){
    pl_result_msg.innerText = msg;
}

function displayResultBox(){
    const box = pl_result_btn.parentElement;
    if(box.classList.contains('hide')){
        box.classList.toggle('hide');
    }
}

function closeResultBox(){
    setResultMsg('');
    pl_result_btn.parentElement.classList.toggle('hide');
}