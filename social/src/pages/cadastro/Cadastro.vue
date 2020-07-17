<template>

  <login-template>

    <span slot="menuesquerdo">
      <img src="https://www.designerd.com.br/wp-content/uploads/2013/06/criar-rede-social.png" class="responsive-img">
    </span>

    <span slot="principal">

        <h2>Cadastro</h2>

        <input type="text" placeholder="Nome" v-model="name">
        <input type="text" placeholder="E-mail" v-model="email">
        <input type="password" placeholder="Senha" v-model="password">
        <input type="password" placeholder="Confirme sua Senha" v-model="password_confirmation">
        <button class="btn" v-on:click="cadastro()">Enviar</button>
        <router-link class="btn orange" to="/login">Já tenho conta</router-link>

    </span>



  </login-template>



</template>

<script>
import LoginTemplate from '@/templates/LoginTemplate'
import axios from 'axios';

export default {
  
  name: 'Cadastro',
  data () {
    return {
      name:'',
      email:'',
      password:'',
      password_confirmation:'',
    }
  },
  components:{
    LoginTemplate
  },
  methods:{
    cadastro(){
      console.log("ok");
      axios.post(`http://localhost:8000/api/cadastro`, {
        name: this.name,
        email: this.email,
        password:this.password,
        password_confirmation: this.password_confirmation
      })
      .then(response => {
        if(response.data.token){
          alert("opa cadastrou");
         sessionStorage.setItem('usuario', JSON.stringify(response.data));
         this.$router.push('/');
        }else if(response.data.status == false){
          alert("usuario ou senha invalido errado")
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
