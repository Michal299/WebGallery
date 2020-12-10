document.addEventListener('DOMContentLoaded',function() {
   var messages=document.querySelectorAll(".message");
   hide(messages);
   var messagesLength=messages.length;
   var button1=document.getElementById("clickable");
   var index=message_get(localization());
   message_set(localization(),index);
   for(var i=0; i<index; i++)
   {
       messages[i].style.display="block";
   }

   var dice=document.getElementById("dice");
   var counter=document.createElement("div");
   counter.innerText=messagesLength - index + " do końca";
   counter.classList.add("count");
   dice.insertBefore(counter,dice.firstElementChild);
   button1.addEventListener('click', function(){
        if (index !== messages.length) {
            messages[index].style.display = "block";
            index++;
            counter.innerText=messagesLength-index + " do końca";
            message_set(localization(),index);
        }
    });
   var darkModeButton=document.getElementById("DarkMode");
   var mode;
   if(localStorage.getItem('mode')!==null) {
       mode = localStorage.getItem('mode');
   }
   else{
       localStorage.setItem('mode', 'light');
       mode='light';
   }
   mode_load(mode);
   darkModeButton.addEventListener('click', function () {
       if (mode === 'dark') {
           localStorage.setItem('mode', 'light');
           to_light();
           mode='light';
       } else {
           localStorage.setItem('mode', 'dark');
           to_dark();
           mode='dark';
       }
   });
});
function hide(message) {
    for(let i=1; i<message.length; i++)
    {
        message[i].style.display="none";
    }
}

function localization()
{
    var key=document.querySelector(".page");
    return key.getAttribute('id');
}
function message_set(key,number)
{
        sessionStorage.setItem(key, JSON.stringify(number));
}
function message_get(key){
    var number=1;
    if(sessionStorage.getItem(key)!==null)
    {
        number=sessionStorage.getItem(key);
    }
    return JSON.parse(number);
}
function to_light(){
    $('body').css({
        "background-color":"white"
    });
    $(".text").css({
        "background-color":"#DCDCDC",
        "color":"black"
    });
    $(".paging").css({
        "background-color":"#DCDCDC",
        "color":"black"
    });
    $(".photo").css({
       "background-color":"white",
    });
    $(".form").css({
        "background-color":"#DCDCDC",
        "color":"black"
    });
    $(".info").css({
        "background-color":"#DCDCDC",
        "color":"#B22222"
    });
    $(".gallery").css({
        "background-color":"#DCDCDC",
        "color":"#B22222"
    });
    $("nav>div>ol").css({
        "border-color":"white"
    });
    $("header").css({
        "border-color":"white"
    });
    $("#DarkMode").text("Tryb nocny");
}
function to_dark(){
    $('body').css({
        "background-color":"black"
    });
    $(".photo").css({
       "background-color":"#DCDCDC",
    });
    $(".gallery").css({
        "background-color":"#202020",
        "color":"white"
    });
    $(".text").css({
        "background-color":"#202020",
        "color":"white"
    });
    $(".info").css({
        "background-color":"#202020",
        "color":"white"
    });
    $(".paging").css({
        "background-color":"#202020",
        "color":"white"
    });
    $(".form").css({
        "background-color":"#202020",
        "color":"white"
    });
    $("nav>div>ol").css({
        "border-color":"black"
    });
    $("header").css({
        "border-color":"black"
    });
    $("#DarkMode").text("Tryb dzienny");
}
function mode_load(mode){
    if(mode==='dark')
        to_dark();
    else
        to_light();
}