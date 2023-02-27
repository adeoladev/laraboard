<template>
<div>
    <div id='header'>
    <a href="/"><p class='name'>{{ app_name }}</p></a>
    <p class='name' v-bind:class="{ hidden: hiddenButton }"><a :href="main_board_path">/{{ tag }}/ - {{ board }}</a></p>
    <button class='postButton' id='postThread' v-bind:class="{ hidden: hiddenButton }" v-on:click="toggleForm"> {{ buttonType }} </button>
    <form class='form' :action="form_action" v-bind:class="{ hidden: hiddenForm }" method='post' enctype="multipart/form-data">
    <input type="hidden" name="_token" :value="csrf">
    <input type='text' name='name' placeholder='name (optional)'>
    <input type='text' name='title' v-bind:class="{ hidden: hiddenTitle }" placeholder='title (optional)' maxlength="48">
    <br>
    <textarea type='text' name='message' required></textarea><br>
    <div style="display:flex;justify-content:space-between">
    <input type='text' v-bind:class="{ hidden: hiddenLinkUpload }" name='linkupload' placeholder='Enter a URL'>
    <input type='file' v-bind:class="{ hidden: hiddenFileUpload }" name='upload'>
    <button type='button' v-on:click="toggleLinkUpload" style="height:fit-content">{{ uploadType }} File</button>
    </div>
    <br>
    <button type='submit'>SUBMIT</button>
    </form>
    </div>
    <div id='status' v-bind:class="{ hidden: hiddenStatus }">
    <p>{{status}}</p>
    </div>
</div>
</template>

<script>
    export default {
        props: ['board','tag','current_page','board_path','thread_path','csrf','status','app_name','main_board_path'],
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
        hiddenStatus: true
        }
        },
        methods: { 
        toggleForm:function(){
        this.hiddenForm = !this.hiddenForm;
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
        } else if (this.current_page == 'thread') {
        this.form_action = this.thread_path;
        this.buttonType = 'NEW REPLY';
        } else {
        this.hiddenButton = true;
        }
        if(this.status) {
        this.hiddenStatus = false;
        }
        }
        
    }
</script>
