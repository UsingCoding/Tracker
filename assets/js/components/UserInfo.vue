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

            <div class="create_project_label">
                <label for="password">Password</label>
                <input v-model="password" class="project_input password_margin" type="text" id="password">
            </div>

            <div class="create_project_label grade_div">
                <label for="grade">Grade</label>
                <select v-model="grade" class="project_input grade" type="text" id="grade">
                    <option value="0">Junior</option>
                    <option value="1">Middle</option>
                    <option value="2">Senior</option>
                    <option value="3">Architect</option>
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
            grade: '',
            password: '',
            createFlag: false,
            userInfo: {}
        }
    },
    methods: {
        edit_user: async function() {
            let response;
            if(this.$route.name == 'user_info') {
                response = await this.store.editUserInfo();
            }
            else {
                response = await this.store.createUser({
                    'email': this.email,
                    'password': this.password,
                    'username': this.username,
                    'grade': this.grade
                })
            }
        },
        cancel: function() {
            this.$router.push({ name: 'users_list'});
        },
        getUserInfo: async function() {
            this.username = "root";
            this.email = "root@gmail.com";
            this.grade = "Junior";
            this.password = "1234";
            this.grade = 0;
        }
    },
    async beforeMount() {
        if(this.$route.name == 'user_info') {
            this.getUserInfo();
            this.createFlag = false;
        }
        else
            this.createFlag = true;
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

.password_margin
{
    margin-left: 62px;
}

.grade_div
{
    margin-bottom: 110px;
}

</style>