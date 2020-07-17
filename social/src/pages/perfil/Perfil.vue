<template>
  <site-template>
    <p>teste</p>
    <span slot="menuesquerdo">
      <img
        src="https://www.designerd.com.br/wp-content/uploads/2013/06/criar-rede-social.png"
        class="responsive-img"
      />
    </span>

    <span slot="principal">
      <h2>Perfil</h2>

      <input type="text" placeholder="Nome" v-model="name" />
      <input type="text" placeholder="E-mail" v-model="email" />
      <div class="file-field input-field">
        <div class="btn">
          <span>File</span>
          <input type="file" />
        </div>
        <div class="file-path-wrapper">
          <input class="file-path validate" type="text" />
        </div>
      </div>
      <!-- <input type="password" placeholder="Senha" v-model="password" />
      <input type="password" placeholder="Confirme sua Senha" v-model="password_confirmation" /> -->
      <button class="btn" v-on:click="atualizar()">Enviar</button>
    </span>
  </site-template>
</template>

<script>
import SiteTemplate from "@/templates/SiteTemplate";
import axios from "axios";

export default {
  name: "Perfil",
  data() {
    return {
      usuario: false,
      name: "",
      email: "",
      password: "",
      password_confirmation: ""
    };
  },
  created(){
    console.log('created()');
    let usuarioAux = sessionStorage.getItem('usuario');
    if(usuarioAux){
      this.usuario = JSON.parse(usuarioAux);
      this.name = this.usuario.name;
      this.email = this.usuario.email
    }
  },
  methods:{
    atualizar(){
      console.log("ok");
      axios.put(`http://localhost:8000/api/perfil`, {
        name: this.name,
        email: this.email,
        password:this.password,
        password_confirmation: this.password_confirmation
      },{
        "headers":{"Authorization": "Bearer "+this.usuario.token}
      })
      .then(response => {
        if(response.data.token){
          alert("opa cadastrou");
          console.log(response.data);
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
  },
  components: {
    SiteTemplate
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
