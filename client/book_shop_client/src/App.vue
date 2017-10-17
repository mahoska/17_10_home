<template>
  <div id="app" class="clearfix">
    <!--img src="./assets/logo.png"-->
  <nav class="navbar mynav">
    <div class="container-fluid">
      <span class="span-logo">BOOK</span>
      <img class="img-logo" src="./assets/logo.png"/> 
      <span class="span-logo">STORE</span>

      <table class="navbar-form navbar-right nav-table">
      <tr>
        <td>
          <form   role="search">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Search" v-model.trim="search_string">
            </div>
            <button class="btn btn-default" @click="search">Search</button>
          </form>
        </td>
      </tr>
      <tr>
        <td>
          <a class="reg" v-if="is_not_login_check"  @click="openLoginForm">Login</a>
          <a class="reg" v-if="is_not_login_check" @click="openRegistrationForm">Registration</a>
          <!--log form-->
      
          <div class="auth-form" v-if="is_login">
            <div class="bg-danger" id="err" style="width: 100%">{{err_log}}</div>
            <div  class="form-group">
              <label for="login">Login</label>
              <input type="text" class="form-control" id="login"  placeholder="login" v-model.trim="login" >
            </div>
            <div  class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" placeholder="password" v-model.trim="password" >
            </div>
            <button class="btn btn-auth" @click="flogin" >login</button>
          </div>         
        <!--end log form-->
        <!--registration form-->
        <div class="auth-form"  v-if="is_registr">
          <div class="bg-danger" id="err" style="width: 100%">{{err_reg}}</div>
          <div  class="form-group">
            <label for="name">First name</label>
            <input type="text" class="form-control" id="name"  placeholder="name" v-model.trim="name"  @blur="check_name">
          </div>
          <div  class="form-group">
            <label for="sname">Last name</label>
            <input type="text" class="form-control" id="sname" placeholder="last name" v-model.trim="surname"  @blur="check_name">
          </div>
          <div  class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email"  placeholder="email" v-model.trim="email" @blur="check_email">
          </div>
          <div  class="form-group">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" id="phone" placeholder="phone" v-model.trim="phone" @blur="check_phone">
          </div>
          <div  class="form-group">
            <label for="login">Login</label>
            <input type="text" class="form-control" id="login"  placeholder="login" v-model.trim="rlogin">
          </div>
          <div  class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" placeholder="password" v-model.trim="rpassword" >
          </div>
          <button class="btn btn-auth" @click="registration">registration</button> 
          <button class="btn btn-auth" @click="cancel" type="cancel">cancel</button>
        </div>
        <!--end registration-->
        <!--is_login_check form-->
        <div  class="auth-form" v-if="is_login_check">
          <table class="is_check">
            <tr>
              <td><span class="log_span">You login as:</span><br> {{login}}</td>
              <td>
                <button class="btn btn-auth" @click="logout" >Logout</button>
                <button class="btn btn-auth" @click="goToCart">
                  <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true" >{{bag_book_count}}</span>
                </button> 
              </td>
            </tr>
          </table>
        </div>
        <!--is_login_check form-->
        </td>
      </tr>
     </table>
    </div>
  </nav>
      
  <div class = "fon clearfix" v-if="is_login || is_registr"></div>
  <router-view :filterstring="search_param" @clearSearch="clearSearchString"  @changeCountTotal="changeCart"/>

  </div>
</template>

<script>
import axios from 'axios'
export default {
  name: 'app',
  data () { 
    return{
      is_login: false,
      is_registr: false,
      is_login_check: false,
      is_not_login_check: true,
      login: "",
      password: "",

      name: "",
      surname: "",
      rlogin: "",
      rpassword: "",
      email: "",
      phone: "",
      err_reg: "",
      err_log: "",
      search_string: "",
      search_param: "",

      bag_book_count: 0
    }
  },
  created(){
    var self = this
    if(localStorage['hash_log'] && localStorage['user']){
        axios.get('http://localhost:88/BOOK_SHOP/client/api/auth/'+localStorage['hash_log']+"/"+localStorage['user'], this.config)
        //axios.get('http://192.168.0.15/~user15/BOOK_SHOP/client/api/auth/'+localStorage['hash_log']+"/"+localStorage['user'], this.config)
            .then(function (response) {
              //console.log(response.data.data)
              if(parseInt(response.data.data)>0){
                self.is_login_check = true
                self.is_not_login_check = false
                self.is_login = false
                self.is_registr = false
                self.login = localStorage['user']

                //запрос на определение кол-ва книг в корзине
              } 
            })
            .catch(function (error) {
              console.log(error);
        });
    }
  },
  methods:{
    openLoginForm(){
      this.is_login = !this.is_login
      this.is_registr = false
      this.is_login_check = false
      this.is_not_kogin_check = true

    },

    openRegistrationForm(){
      this.is_login = false
      this.is_registr = !this.is_registr
      this.is_login_check = false
      this.is_not_kogin_check = true
    },

    flogin(){
      if(this.login=="" || this.password=="" ){
				this.err_log = "not all fields are filled";
			}else{
         var self = this
        this.err_log = ""
        //axios.put('http://192.168.0.15/~user15/BOOK_SHOP/client/api/auth/', 
        axios.put('http://localhost:88/BOOK_SHOP/client/api/auth/', 
        {
          login: this.login,
          password: this.password
        }, this.config)
        .then(function (response) {
           if(response.data.err && response.data.err ==true){
              self.err_log = response.data.data
              setTimeout(function () {
                self.err_log = ""
              },2500);
            }else{
              self.is_login_check = true
              self.is_not_login_check = false
              self.is_login = false
              self.is_registr = false
              //console.log(response.data['data']);
              localStorage['hash_log'] = response.data['data']
              localStorage['user'] = self.login
            }
        })
        .catch(function (error) {
            console.log(error);
        });
      }
    },

    check_phone(){
      var re = /^[\d]{10}$/;
      if (isNaN(this.phone) || re.test(this.phone) != true) {
        this.err_reg = "wrong phone format"
        return false
      }
      else {
        this.err_reg = ""
        return true
      }
	  },

    check_email() {
      var re = /^[\.\-_A-Za-z0-9]+?@[\.\-A-Za-z0-9]+?(\.)[A-Za-z0-9]{2,3}$/
      if (re.test(this.email) != true) {
        this.err_reg = "wrong email format"
        return false
      }
      else {
        this.err_reg = ""
        return true
      }
    },

    check_login(){
      var re = /^[\-_A-Za-z0-9]+$/
      if (re.test(this.rlogin) !== true){
        this.err_reg = 'login contains invalid characters'
        return false
      }
      else if (this.rlogin.length < 6){
        this.err_reg ='login is too short'
        return false
      }else {
        this.err_reg = ""
        return true
      }     
    },

    check_name(){
      var re1 = /^[A-Za-z]+$/
      if (re1.test(this.name) !== true){
          this.err_reg = 'name contains invalid characters'
          return false
      }else if(re1.test(this.surname) !== true){
        this.err_reg = 'surname contains invalid characters'
        return false
      }else {
        this.err_reg = ""
        return true
      }
    },

    registration(){
      if (this.check_phone()  && this.check_email() && this.check_name() && this.check_login()) {
			if(this.rlogin=="" || this.rpassword=="" || this.name=="" || this.surname=="" || this.phone=="" || this.email==""){
				this.err_reg = "not all fields are filled";
			}else{

        this.err_reg = ""    
        var self = this
        var data = new FormData()
        data.append("login", this.rlogin)
        data.append("password",this.rpassword)
        data.append("name",this.name)
        data.append("surname",this.surname)
        data.append("email",this.email)
        data.append("phone",this.phone)

        axios.post('http://localhost:88/BOOK_SHOP/client/api/auth/', data, this.config)         
        //axios.post('http://192.168.0.15/~user15/BOOK_SHOP/client/api/auth/', data, this.config)
          .then(function (response) {
            console.log(response.data.err)
            if(response.data.err && response.data.err ==true){
              self.err_reg = response.data['data']
              setTimeout(function () {
                self.err_reg = ""
              },2500);
            }else{
              self.is_login_check = true
              self.is_not_login_check = false
              self.is_login = false
              self.is_registr = false
              self.login = self.rlogin
              self.err_reg = ""
              localStorage['hash_log'] = response.data['data']
              localStorage['user'] = self.login
            }
          })
          .catch(function (error) {
              self.err_reg = "sorry, there was a server error.Try again later"
          });
      }
      }
      setTimeout(function () {
         this.err_reg = ""
      },2500);  
    },

    cancel(){
      this.is_login_check = false
      this.is_not_login_check = true
      this.is_login = false
      this.is_registr = false
      this.rlogin = this.rpassword = this.name = this.sname = this.phone = this.email = this.err_reg = ""
    },

    logout(){
      localStorage['hash_log'] = ""
      localStorage['user'] = ""
      localStorage['cart'] = ""
      this.is_login_check = false
      this.is_not_login_check = true
      this.is_login = false
      this.is_registr = false
      this.login = ""
      this.password = ""
      this.err_reg = ""
    },

    goToCart(){},

    search(){
      this.search_param =  this.search_string
    },

    clearSearchString(){
      this.search_string = ""
      this.search_param = ""
    },

    changeCart(count){
      this.bag_book_count += parseInt(count)
    }
  }
}
</script>

<style>
body{
  background-color: #F2F4F5;
}
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  width: 1200px;
  margin: 10px auto;  
	-webkit-border-radius: 5px;
  border-radius: 5px;	
  /*border:1px solid red; */
  background: -webkit-linear-gradient(#B4D2D8, #142427);
  background: -moz-linear-gradient(#B4D2D8, #142427);
  background: linear-gradient(#B4D2D8, #142427);
  padding-top: 10px;
}


.clearfix:after{
	content: ".";
	display: block;
	height: 0;
	clear: both;
	visibility: hidden;
}

.fon{
  position:absolute;
  z-index: 5;
  width: 1200px;
  margin: -8px auto; 
  background-color: #1D2E31;
  opacity: 0.5;
  height: 177%; 
}

.mynav{
  height: 95px;
  background-color: #4A838C;
  margin: 10px;
  -webkit-border-radius: 5px;
  border-radius: 5px;	
  text-align:left;
}

.img-logo{
  max-height: 90px;
  margin-top: -40px;
}

.span-logo{
  font-size: 60px;
  font-weight: bold;
  line-height: 100px;
  color: #2C3E50;
}

.mynav:first-child{
padding-left: 100px;
}

a.reg{
  font-weight: bold;
  color: #2C3E50;
  margin-right: 60px;
  
}

.log_span{
  font-weight: bold;
  color: #2C3E50;
  text-align:left;
}

.nav-table tr{
  height: 40px;
  line-height: 40px;
  font-size: 16px;
  cursor: pointer;
}

.nav-table{
width: 300px;
position: absolute;
top: -5px;
right: 10px;
}

.auth-form{
position: relative;
text-align: right;
padding-right:10px;
z-index: 9998;
}

.btn-auth{
  background-color: #2C3E50;
  color: #D8EEFA;
}

.auth-form label{
  font-size: 14px;
  font-weight: none;
}

#err{
font-weight:bold;
font-size:14px;
color:red;
line-height:16px;
padding: 0 5px;
text-align:center;
}

.is_check td{
  line-height:17px;
  text-align:center;
  width: 150px;
}

.is_check{
  margin-top:5px;
  margin-left:-25px;
}
</style>
