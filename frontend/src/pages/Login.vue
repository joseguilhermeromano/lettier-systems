<template>
  <div class="login-container">
    <div class="login-box">
      <div class="logo-container">
        <img src="../../public/img/lettiere.png" alt="Logo" class="logo" />
      </div>
      <h1>
        PORTAL DO <br />
        <span style="font-size: 40px">CIDADÃO</span>
      </h1>
      <form @submit.prevent="login">
        <div class="input-group">
          <i class="fas fa-user"></i>
          <input
            type="email"
            placeholder="Digite o seu E-mail"
            v-model="email"
            required
          />
        </div>
        <div class="input-group">
          <i class="fas fa-lock"></i>
          <input
            type="password"
            placeholder="Digite a sua senha"
            v-model="password"
            required
          />
        </div>
        <button type="submit" class="btn-login">Login</button>
        <a href="#" class="forgot-password">Esqueceu a sua senha?</a>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: "",
      password: "",
    };
  },
  methods: {
    login() {
      // Adicione sua lógica de login aqui
      console.log("Email:", this.email);
      console.log("Password:", this.password);
    },
  },
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Anton&family=Anton+SC&family=Archivo+Black&display=swap");

h1 {
  font-family: "Archivo Black", sans-serif;
  font-weight: 400;
  font-style: normal;
}

.login-container {
  display: flex;
  height: 100vh;
  width: 100vw;
  justify-content: right;
  background: url("../../public/img/background.jpeg") no-repeat center center
    fixed;
  background-size: cover;
}

.login-box {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  width: 30%;
  background: linear-gradient(to right, #0072ff, #1ff2c5);
  padding: 2rem;
}

.logo-container {
  display: flex;
  justify-content: center;
  align-items: center;
  position: fixed;
  top: 23%;
  left: 66.5%;
  background-color: #01080b; /* Cor de fundo próxima ao logo */
  border-radius: 50%;
  width: 100px;
  height: 100px;
  margin-bottom: 1rem;
  overflow: hidden; /* Para garantir que a imagem fique dentro do círculo */
}

.logo {
  width: 80%;
}

h1 {
  color: #fff;
  margin-bottom: 2rem;
}

.input-group {
  display: flex;
  align-items: center;
  background-color: #fff;
  border-radius: 4px;
  padding: 0.5rem;
  margin-bottom: 1rem;
  width: 100%;
}

.input-group i {
  margin-right: 0.5rem;
  color: #0072ff;
}

.input-group input {
  flex: 1;
  border: none;
  outline: none;
}

.btn-login {
  background-color: #fff;
  color: #0072ff;
  border: none;
  padding: 0.75rem 1.5rem;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s;
  width: 100%;
}

.btn-login:hover {
  background-color: #f0f0f0;
}

.forgot-password {
  display: block;
  margin-top: 1rem;
  color: #fff;
}

@media (max-width: 768px) {
  .login-box {
    width: 100%;
    padding: 1rem;
  }
}
</style>
