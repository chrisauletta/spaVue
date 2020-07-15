<template>

  <login-template>

    <span slot="menuesquerdo">
      <img src="https://www.designerd.com.br/wp-content/uploads/2013/06/criar-rede-social.png" class="responsive-img">
    </span>

    <span slot="principal">

      <!-- <span v-if="!cadastro">-->
        <h2>Login</h2> 

        <input type="text" placeholder="E-mail" v-model="usuario.email">
        <input type="password" placeholder="Senha" v-model="usuario.senha">
        <button class="btn" v-on:click="login()">Entrar</button>
        <router-link class="btn orange" to="/cadastro">Cadastre-se</router-link>
      <!-- </span>
      <span v-if="cadastro">
        <h2>Cadastro</h2>

        <input type="text" placeholder="Nome" value="">
        <input type="text" placeholder="E-mail" value="">
        <input type="password" placeholder="Senha" value="">
        <input type="password" placeholder="Confirme sua Senha" value="">
        <button class="btn">Enviar</button>
        <router-link class="btn orange" to="/login">Cadastre-se</router-link>
      </span> -->
    </span>



  </login-template>



</template>

<script>
import LoginTemplate from '@/templates/LoginTemplate'
import axios from 'axios';

export default {
  
  name: 'Login',
  data () {
    return {
      usuario:{email:'xxxx',
      senha:'1234'},
      cadastro:false
    }
  },
  components:{
    LoginTemplate
  },
  methods:{
    login(){
      console.log("ok");
      axios.post(`http://localhost:8000/api/login`, {
        email: this.usuario.email,
        password:this.usuario.senha
      })
      .then(response => {
        if(response.data.token){
          alert("opa foi");
         sessionStorage.setItem('usuario', JSON.stringify(response.data));
         this.$router.push('/');
        }else if(response.data.status == false){
          alert("login errado")
        }else{
          let erros = '';
          for(let erro of Object.values(response.data)){
            erros += erro +" ";
          }
          alert(erros);
        }
        console.log(response)
      })
      .catch(e => {
        //this.errors.push(e)
        console.log("foi nao")
      })
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
