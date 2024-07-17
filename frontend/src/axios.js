import axios from "axios";
const instance = axios.create({
  baseURL: "http://lettiere.app.br/api",
  headers: {
    "Content-Type": "application/json",
  },
  origins: ["http://localhost:8081"],
});

// Interceptor de requisições para adicionar o token de autenticação
instance.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem("token");
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

export default instance;
