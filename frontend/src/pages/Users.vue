<template>
  <div class="content">
    <!-- Alerta de Notificação no Topo -->
    <base-alert
      v-if="alert.visible"
      :type="alert.type"
      dismissible
      @dismiss="alert.visible = false"
      class="alert-top"
    >
      {{ alert.message }}
    </base-alert>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <card :title="usersTable.title" :subTitle="usersTable.subTitle">
            <div
              slot="raw-content"
              class="table-responsive"
              style="padding: 25px; overflow: hidden"
            >
              <div class="d-flex flex-row justify-content-between">
                <input
                  type="text"
                  v-model="filters.search"
                  placeholder="Pesquisar..."
                  class="success-input form-control mb-3"
                  style="width: 30%"
                />
                <button
                  type="button"
                  class="btn btn-sm btn-success"
                  data-toggle="modal"
                  data-target="#exampleModal"
                  style="top: -10px"
                >
                  <i class="fas fa-plus"></i> Novo Usuário
                </button>
              </div>
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th @click="setSortColumn('email')">
                      Email <i class="fas" :class="sortIcon('email')"></i>
                    </th>
                    <th @click="setSortColumn('creationDate')">
                      Data de Criação
                      <i class="fas" :class="sortIcon('creationDate')"></i>
                    </th>
                    <th class="text-center">Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="user in paginatedUsers" :key="user.id">
                    <td>{{ user.email }}</td>
                    <td>{{ formatDate(user.created_at) }}</td>
                    <td class="text-center">
                      <a href="#" @click.prevent="viewUser(user)">
                        <i
                          style="color: deepskyblue; margin: 10px"
                          class="fas fa-eye me-1"
                        ></i>
                      </a>
                      <a href="#" @click.prevent="editUser(user)">
                        <i
                          style="color: deepskyblue; margin: 10px"
                          class="fas fa-edit me-1"
                        ></i>
                      </a>
                      <a href="#" @click.prevent="confirmDeleteUser(user)">
                        <i
                          style="color: deepskyblue; margin: 10px"
                          class="fas fa-trash-alt"
                        ></i>
                      </a>
                    </td>
                  </tr>
                </tbody>
              </table>
              <nav aria-label="Paginação">
                <ul
                  class="pagination justify-content-center"
                  style="padding: 10px"
                >
                  <li
                    class="page-item"
                    :class="{ disabled: currentPage === 1 }"
                  >
                    <a class="page-link" href="#" @click.prevent="prevPage"
                      >Anterior</a
                    >
                  </li>
                  <li
                    class="page-item"
                    :class="{ active: page === currentPage }"
                    v-for="page in totalPages"
                    :key="page"
                  >
                    <a
                      class="page-link"
                      href="#"
                      @click.prevent="goToPage(page)"
                      >{{ page }}</a
                    >
                  </li>
                  <li
                    class="page-item"
                    :class="{ disabled: currentPage === totalPages }"
                  >
                    <a class="page-link" href="#" @click.prevent="nextPage"
                      >Próximo</a
                    >
                  </li>
                </ul>
              </nav>
            </div>
          </card>
        </div>
      </div>
    </div>

    <!-- Modal de Confirmação de Exclusão -->
    <modal :show.sync="modals.confirmDelete">
      <template slot="header">
        <h5 class="modal-title">Confirmar Exclusão</h5>
      </template>
      <div>Você tem certeza que deseja excluir o usuário?</div>
      <template slot="footer">
        <base-button type="secondary" @click="modals.confirmDelete = false"
          >Cancelar</base-button
        >
        <base-button type="success" @click="deleteUserConfirmed"
          >Confirmar</base-button
        >
      </template>
    </modal>

    <!-- Modal de Visualização de Usuário -->
    <modal :show.sync="modals.viewUser">
      <template slot="header">
        <h5 class="modal-title">Detalhes do Usuário</h5>
      </template>
      <div v-if="selectedUser">
        <p><strong>Email:</strong> {{ selectedUser.email }}</p>
        <p>
          <strong>Data de Criação:</strong>
          {{ formatDate(selectedUser.created_at) }}
        </p>
      </div>
      <template slot="footer">
        <base-button type="secondary" @click="modals.viewUser = false"
          >Fechar</base-button
        >
      </template>
    </modal>
  </div>
</template>

<script>
import { Card, BaseAlert, Modal } from "@/components/index";
import axios from "@/axios";

export default {
  name: "users",
  components: {
    Card,
    BaseAlert,
    Modal,
  },
  data() {
    return {
      usersTable: {
        title: "Usuários",
        subTitle: "Listagem de usuários",
        columns: ["Email", "Creation Date"],
        data: [],
      },
      filters: {
        search: "",
        sortColumn: null,
        sortDirection: "asc",
      },
      alert: {
        visible: false,
        type: "success",
        message: "",
      },
      perPage: 10,
      currentPage: 1,
      modals: {
        confirmDelete: false,
        viewUser: false,
      },
      selectedUser: null,
    };
  },
  computed: {
    filteredUsers() {
      let filtered = this.usersTable.data;

      if (this.filters.search) {
        filtered = filtered.filter(
          (user) =>
            user.name
              .toLowerCase()
              .includes(this.filters.search.toLowerCase()) ||
            user.email
              .toLowerCase()
              .includes(this.filters.search.toLowerCase()) ||
            user.creationDate
              .toLowerCase()
              .includes(this.filters.search.toLowerCase())
        );
      }

      if (this.filters.sortColumn) {
        filtered.sort((a, b) => {
          if (a[this.filters.sortColumn] < b[this.filters.sortColumn])
            return this.filters.sortDirection === "asc" ? -1 : 1;
          if (a[this.filters.sortColumn] > b[this.filters.sortColumn])
            return this.filters.sortDirection === "asc" ? 1 : -1;
          return 0;
        });
      }

      return filtered;
    },
    paginatedUsers() {
      const start = (this.currentPage - 1) * this.perPage;
      const end = start + this.perPage;
      return this.filteredUsers.slice(start, end);
    },
    totalPages() {
      return Math.ceil(this.filteredUsers.length / this.perPage);
    },
  },
  methods: {
    loadUsers() {
      axios
        .get("/users/list")
        .then((response) => {
          this.usersTable.data = response.data;
        })
        .catch((error) => {
          console.error("Não foi possível carregar os usuários.", error);
        });
    },
    showAlert(message, type = "success") {
      this.alert.message = message;
      this.alert.type = type;
      this.alert.visible = true;
      setTimeout(() => {
        this.alert.visible = false;
      }, 3000);
    },
    formatDate(date) {
      return new Date(date).toLocaleDateString("pt-BR", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
      });
    },
    viewUser(user) {
      this.selectedUser = user;
      this.modals.viewUser = true;
    },
    editUser(user) {
      // Implement edit user action
    },
    deleteUser(user) {
      axios
        .delete(`/users/delete/${user.id}`)
        .then(() => {
          this.usersTable.data = this.usersTable.data.filter(
            (u) => u.id !== user.id
          );
          this.modals.confirmDelete = false;
          this.showAlert("Usuário excluído com sucesso!", "success");
        })
        .catch((error) => {
          console.error("Erro ao tentar remover um usuário", error);
          this.showAlert("Erro ao excluir um usuário", "danger");
        });
    },
    confirmDeleteUser(user) {
      this.selectedUser = user;
      this.modals.confirmDelete = true;
    },
    deleteUserConfirmed() {
      this.deleteUser(this.selectedUser);
    },
    sortChanged({ sortColumn, sortDirection }) {
      this.filters.sortColumn = sortColumn;
      this.filters.sortDirection = sortDirection;
    },
    prevPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
      }
    },
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
      }
    },
    goToPage(page) {
      this.currentPage = page;
    },
    setSortColumn(column) {
      if (this.filters.sortColumn === column) {
        this.filters.sortDirection =
          this.filters.sortDirection === "asc" ? "desc" : "asc";
      } else {
        this.filters.sortColumn = column;
        this.filters.sortDirection = "asc";
      }
    },
    sortIcon(column) {
      if (this.filters.sortColumn === column) {
        return this.filters.sortDirection === "asc"
          ? "fa-sort-up"
          : "fa-sort-down";
      }
      return "fa-sort";
    },
  },
  mounted() {
    this.loadUsers();
  },
};
</script>

<style scoped>
.pagination {
  justify-content: center;
}

.pagination > li > a {
  padding: 10px;
  color: grey;
}

.page-item.active .page-link {
  background-color: deepskyblue;
  border-color: deepskyblue;
}

.success-input:hover {
  border-color: cyan;
}

.success-input:focus {
  border-color: cyan;
}
</style>
