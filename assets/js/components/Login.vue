<template>
    <div class="all_screen center">
        <div class="container">
            <span class="greeting"> Welcome to Tracker</span>
            <form class="login_form" action="index.html" method="post">
                <input required placeholder="Username" v-model="username" class="login_style width_100" type="text" name="username"/>
                <input v-if="sign_up_flag" v-model="email" required placeholder="Email" class="login_style width_100" type="text" name="email"/>
                <input required placeholder="Password" v-model="password" class="login_style width_100" type="password" name="password"/>
                <input v-if="sign_up_flag" v-model="confirm_password" required placeholder="Confirm password" class="login_style width_100" type="password" name="password"/>
                <button v-if="!sign_up_flag" v-on:click="login()" class="log_in" type="button" name="log_in">Login</button>
                <button v-if="!sign_up_flag" v-on:click="sign_up_flag = !sign_up_flag" class="sign_up" type="button" name="sign_up">Sign Up</button>
                <button v-if="sign_up_flag" v-on:click="register()" class="register" type="button" name="register">Register and log in</button>
                <span class="return_log_in" v-if="sign_up_flag" v-on:click="sign_up_flag = !sign_up_flag">I alredy have account</span>
            </form>
        </div>
        <div class="spacer"></div>
    </div>
</template>

<script>

export default{
    data() {
        return {
            sign_up_flag: false,
            username: "",
            password: ""
        }
    },
    //'/api/auth?username=jojo%40pidor.com&password=1234'
    methods: {
        login: async function() {
            let response = await fetch('/api/auth?username=' + encodeURIComponent(this.username) + '&password=' + this.password, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8'
                }
                // body: JSON.stringify({
                //     'username' : encodeURIComponent(this.username),
                //     'password' : this.password
                // })
            });

            let result = await response.json();
            if(result.isLogin === 1) {
                console.log("woooo! You inside =)");
                this.$router.push({path: '/issues'});
                // sessionStorage.setItem("name", "test");
            }
            else {
                alert("Wrong username or password!");
            }
        }
    }

}
</script>

<style scoped>

</style>