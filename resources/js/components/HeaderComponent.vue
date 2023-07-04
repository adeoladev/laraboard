<template>
<div>
    <div id='header'>
    <a href="/"><p class='name'>{{ app_name }}</p></a>
    <p class='name' id='boardTitle' v-bind:class="{ hidden: hiddenButton }"><a :href="main_board_path">/{{ tag }}/ - {{ board }}</a></p>

    <div style='display:flex'>
    <form method='get' style='margin:0' v-bind:class="{ hidden: searchBar }">
    <input id='search' name='search' type='text' placeholder='search' style='margin-right: 10px;'>
    </form>
    <button class='postButton' id='postThread' v-bind:class="{ hidden: hiddenButton }" v-on:click="showForm"> {{ buttonType }} </button>
    </div>

    <form class='form' :action="form_action" v-bind:class="{ hidden: hiddenForm }" method='post' enctype="multipart/form-data">
    <input type="hidden" name="_token" :value="csrf">
    <div style="width: 100%;display: flex;justify-content: space-between;">
    <input type='text' name='name' placeholder='name (optional)' style='width:100%'><a id='closeForm' class='replies' title='Close' v-on:click="hideForm">×</a>
    <input type='text' name='title' style='width:100%' v-bind:class="{ hidden: hiddenTitle }" placeholder='title (optional)' maxlength="48">
    </div>
    <textarea id='textbox' type='text' name='message' required></textarea>
    <br>
    <div style="display:flex;">
    <span style="width: 220px;">
    <input type='text' v-bind:class="{ hidden: hiddenLinkUpload }" name='linkupload' placeholder='Enter a URL' style='width: 100%;'>
    <input type='file' v-bind:class="{ hidden: hiddenFileUpload }" name='upload'>
    </span>
    <label for='spoiler'> spoiler</label>
    <input id='spoiler' name='spoiler' type='checkbox' title='Spoiler'>
    <button type='button' v-on:click="toggleLinkUpload" style="height:fit-content">{{ uploadType }} File</button>
    </div>
    <br>
    <button type='submit' :disabled='isDisabled'>SUBMIT</button>
    </form>
    </div>
    <div id='status' v-bind:class="{ hidden: hiddenStatus }">
    <p>{{status}}</p>
    </div>
</div>
</template>

<script>
    export default {
        props: ['board','tag','current_page','board_path','thread_path','csrf','status','app_name','main_board_path','archived'],
        data() {
        return {
        hiddenForm: true,
        hiddenLinkUpload: true,
        hiddenFileUpload: false,
        hiddenTitle: true,
        uploadType: 'Link',
        buttonType: 'NEW THREAD',
        form_action: '',
        hiddenButton: false,
        hiddenStatus: true,
        searchBar: true,
        isDisabled: false
        }
        },
        methods: { 
        showForm:function(){
        this.hiddenForm = false;
        },
        hideForm:function(){
        this.hiddenForm = true;
        },
        toggleLinkUpload:function(){
        this.hiddenLinkUpload = !this.hiddenLinkUpload;  
        this.hiddenFileUpload = !this.hiddenFileUpload;  
        if (this.hiddenFileUpload) {
        this.uploadType = 'Upload';
        } else {
        this.uploadType = 'Link';    
        }
        }
        },
        created: function(){
        if(this.current_page == 'board') {
        this.form_action = this.board_path;
        this.buttonType = 'NEW THREAD';
        this.hiddenTitle = false;
        this.searchBar = false;
        } else if (this.current_page == 'thread') {
        this.form_action = this.thread_path;
        this.buttonType = 'NEW REPLY';
        } else {
        this.hiddenButton = true;
        }
        if(this.status) {
        this.hiddenStatus = false;
        setTimeout(function(){ document.getElementById('status').style.display = 'none'; }, 3000);
        }
        if(this.archived == true) {
        this.isDisabled = true;
        }
        }
        
    }

var elements = document.getElementsByClassName("file");
var replies = document.getElementsByClassName("reply_id");
var other_replies = document.getElementsByClassName("other_reply");
var container = document.getElementById('file_container');
var image = document.getElementById('main_image');
var video = document.getElementById('main_video');
var textBox = document.getElementById('textbox');
var scroll_from = document.getElementsByClassName('scrollFrom');
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
    image.src = domain+'/files/system/nothing.png';
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
      document.querySelector('#postThread').click();
      var textBox = document.getElementById('textbox');
      textBox.value += '>>'+this.innerText + '\r\n';     
    });
}

for (var i = 0; i < other_replies.length; i++) {
    other_replies[i].addEventListener("mouseenter", function(e){ 
      const node = document.getElementById(this.innerText.replace(/\>>/, ''));
      const clone = node.cloneNode(true);
      container.append(clone);
      clone.style.marginTop = '50px';
    });

    other_replies[i].addEventListener("mouseleave", function(e){ 
      container.lastChild.remove();
    });
}

for (var i = 0; i < scroll_from.length; i++) {
    scroll_from[i].addEventListener("click", function(){ 
      var ting = document.getElementById('container-'+this.innerText.replace(/\>>/, ''));
      ting.scrollIntoView(); 
      ting.style.boxShadow = '0px 0px 0px 2px #E8392C';
      setTimeout(function(){ ting.style.boxShadow = 'none'; }, 500);
    });
}

/*-------------------------------------*/
</script>
