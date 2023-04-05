var elements = document.getElementsByClassName("file");
var replies = document.getElementsByClassName("reply_id");
var other_replies = document.getElementsByClassName("other_reply");
var container = document.getElementById('file_container');
var image = document.getElementById('main_image');
var video = document.getElementById('main_video');
var textBox = document.getElementById('textbox');
var scrollies = document.getElementsByClassName('scrollto');
var height = window.innerHeight;

/*--------------HOVER TINGS--------------*/

window.onload = function() {
  container.style.maxHeight = (80/100)*height;
};

window.addEventListener('mousemove', follow, false);

for (var i = 0; i < elements.length; i++) {
    elements[i].addEventListener("mouseenter", function(){
    var attribute = this.getAttribute("media");
    if(attribute == 'video') {
    video.src = this.getAttribute("href");
    video.muted = true;
    video.play();
    } else {
    image.src = this.getAttribute("href");
    }
    });

    elements[i].addEventListener("mouseleave", function(){
    image.src = 'http://127.0.0.1:8000/files/system/nothing.png';
    video.src = '#';
    });
}

function follow(e) {
	TweenLite.to(container, 0, {
    css: {
      left: e.pageX+10,
      top: e.pageY-1373/4
    }
  });
}

/*--------------------------------------*/

/*-------------REPLY TINGS--------------*/

for (var i = 0; i < replies.length; i++) {
    replies[i].addEventListener("click", function(){ 
      document.querySelector('.form').classList.remove("hidden");
      var textBox = document.getElementById('textbox');
      textBox.value += '>>'+this.innerText + '\r\n';     
      });
}

for (var i = 0; i < other_replies.length; i++) {
    other_replies[i].addEventListener("mouseenter", function(e){ 
    const node = document.getElementById(this.innerText);
    const clone = node.cloneNode(true);
    container.append(clone);
    });

    other_replies[i].addEventListener("mouseleave", function(e){ 
    container.lastChild.remove();
    });
}

for (var i = 0; i < scrollies.length; i++) {
    scrollies[i].addEventListener("click", function(){ 
      var ting = document.getElementById('container-'+this.innerText);
      ting.scrollIntoView(); 
      ting.style.boxShadow = '0px 0px 0px 2px #E8392C';
      setTimeout(function(){ ting.style.boxShadow = 'none'; }, 500);
      });
}
