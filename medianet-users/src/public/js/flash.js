let flash_sucess = document.querySelector('.success');
let flash_danger = document.querySelector('.danger');
let flash_info = document.querySelector('.info');

if(flash_sucess!=null){
    setTimeout(function () {
        $("[class=success]").hide();
    },1000)
}

if(flash_danger!=null){
    setTimeout(function () {
        $("[class=danger]").hide();
    },1000)
}

if(flash_info!=null){
    setTimeout(function () {
        $("[class=info]").hide();
    },1000)
}

