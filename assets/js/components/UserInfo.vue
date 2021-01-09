<template>
  <div class="project_view_width">
      <h1 v-if="createFlag" class="administration_path">New User</h1>
      <h1 v-else class="administration_path">{{username}}</h1>
      <form class="create_project">

            <div class="create_project_label">
                <label for="email">EMAIL</label>
                <input v-model="email" class="project_input email_margin" type="text" id="email">
            </div>

            <div class="create_project_label">
                <label for="username">Username</label>
                <input v-model="username" class="project_input username_margin" type="text" id="username">
            </div>

            <div class="create_project_label avatar_div">
                <label for="avatar">Avatar</label>
                <div v-if="createFlag && !this.avatar" v-on:click="addAvatar()" class="add_avatar add_avatar_background">
                    <i class="plus_icon fas fa-plus-circle"></i>
                </div>
                <div v-if="createFlag" v-on:click="addAvatar()" class="preview_avatar_div" id="preview_div">
                    <img src="" alt="sorry(" class="preview_avatar" id="preview">
                </div>
                <div v-if="!createFlag" v-on:click="addAvatar()" class="add_avatar">
                    <img :src="userInfo.avatar_url" alt="sorry(" class="avatar">
                </div>
                <input class="user_avatar" title="some test" v-on:change="preloadFile()" type="file" ref="file" id="avatar"/>
            </div>

            <div class="create_project_label">
                <label for="password">Password</label>
                <input v-model="password" class="project_input password_margin" type="text" id="password">
            </div>

            <div class="create_project_label grade_div">
                <label for="grade">Grade</label>
                <select v-model="grade" class="project_input grade" type="text" id="grade">
                    <option value="1">Junior</option>
                    <option value="2">Middle</option>
                    <option value="3">Senior</option>
                    <option value="4">Architect</option>
                </select>
            </div>

            <button v-on:click="edit_user()" type="button" class="project_form_btn create_project_btn">Save</button>
            <button v-on:click="cancel()" type="button" class="project_form_btn cancel_btn">Cancel</button>
      </form>
  </div>
</template>

<script>

export default {
    props: ['factory'],
    data() {
        return {
            store: this.factory.createUserStore(),
            email: '',
            username: '',
            avatar: '',
            grade: '',
            password: '',
            createFlag: false,
            userInfo: {}
        }
    },
    methods: {
        edit_user: async function() {
            let response;
            if(!this.validate()){
                let formData = new FormData()
                formData.append('email', this.email);
                formData.append('password', this.password);
                formData.append('username', this.username);
                formData.append('grade', this.grade - 1);
                formData.append('avatar', this.avatar);

                if(this.$route.name == 'user_info') {
                    formData.append('user_id', this.$route.params.code);
                    response = await this.store.editUserInfo(formData);
                }
                else {
                    response = await this.store.createUser(formData);
                }
                
                if(response.result === 1)
                   this.$router.push({name: 'users_list'});
                else
                    this.$emit('error');
            }
        },
        cancel: function() {
            this.$router.push({ name: 'users_list'});
        },
        getUserInfo: async function() {
            this.userInfo = await this.store.getUserInfo(this.$route.params.code);
            if(this.userInfo && !this.userInfo.hasOwnProperty('error'))
            {
                this.username = this.userInfo.username;
                this.email = this.userInfo.email;
                this.password = this.userInfo.password;
                this.grade = this.userInfo.grade + 1;
            }
            else    
                this.$emit('error');
        },
        showError: function(container) {
            container.style ['border-color'] = '#ff0000';
	        container.setAttribute('onclick', 'this.style=""');
        },
        validate: function() {
            var emailRegex = /[^@]+@[^\.]+\..+/g;
            var email = document.getElementById('email');
            var username = document.getElementById('username');
            var password = document.getElementById('password');
            var grade = document.getElementById('grade');
            var error = false;        
            if(!emailRegex.test(this.email))
            {
                error = true;
                this.showError(email);
            }

            if(!this.username)
            {
                error = true;
                this.showError(username);
            }

            if(!this.password)
            {
                error = true;
                this.showError(password);
            }

            if(!this.grade)
            {
                error = true;
                this.showError(grade);
            }

            return error;
        },
        addAvatar: function() {
            var input = document.getElementById('avatar');
            input.click();
        },
        preloadFile: function() {
            this.avatar = this.$refs.file.files[0];
            var preview = document.getElementById('preview');
            var reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
            }

            reader.onerror = function() {
                preview.src = "";
            }

            if(this.avatar) 
                reader.readAsDataURL(this.avatar);
            else
                preview.src = "";
        }
    },
    computed: {
        previewComp: function() {
            if(this.avatar && this.createFlag)
            {
                var preview = document.getElementById('preview');
                var previewDiv = document.getElementById('preview_div');

                preview.style['width'] = '60px';
                preview.style['height'] = '60px';

                previewDiv.style['width'] = '60px';
                previewDiv.style['height'] = '60px';

                preview.style['display'] ='block';
            }
        }
    },
    async beforeMount() {
        if(this.$route.name == 'user_info')
        {
            this.getUserInfo();
            this.createFlag = false;
        }
        else
            this.createFlag = true;
    },
    beforeUpdate() {
        this.previewComp;
    }
}
</script>

<style>

.email_margin
{
    margin-left: 91px;
}

.grade
{
    width: 233px;
    margin-left: 94px;
    background-color: #ffffff;
}

.username_margin
{
    margin-left: 55px;
}

.avatar_div
{
    display: flex;
}

.add_avatar
{
    width: 60px;
    height: 60px;
    display: inline-block;
    cursor: pointer;
    position: relative;
    margin-left: 96px;
}

.add_avatar_background
{
    background: #5e5e5e;
}

.preview_avatar_div
{
    width: 0px;
    height: 0px;
    display: inline-block;
    cursor: pointer;
    margin-left: 96px;
}

.preview_avatar
{
    width: 0px;
    height: 0px;
    border-radius: 5px;
    display: none;
}


.avatar
{
    width: 60px;
    height: 60px;
    border-radius: 5px;
}

.plus_icon
{
    font-size: 30px;
    position: absolute;
    top: 15px;
    left: 15px;
}

input[type='file']
{
    display: none;
}

.password_margin
{
    margin-left: 62px;
}

.grade_div
{
    margin-bottom: 110px;
}

</style>