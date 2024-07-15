<template>
  <div class="content">
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
                    <th @click="setSortColumn('name')">
                      Nome <i class="fas" :class="sortIcon('name')"></i>
                    </th>
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
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.creationDate }}</td>
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
        <p><strong>Nome:</strong> {{ selectedUser.name }}</p>
        <p><strong>Email:</strong> {{ selectedUser.email }}</p>
        <p><strong>Data de Criação:</strong> {{ selectedUser.creationDate }}</p>
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
import { Card, Modal } from "@/components/index";

const users = [
  {
    id: 1,
    name: "João da Silva",
    email: "joao@silva.com",
    creationDate: "2020-01-01 10:00:00",
  },
  {
    id: 2,
    name: "Maria da Costa",
    email: "maria@costa.com",
    creationDate: "2020-01-02 11:00:00",
  },
  {
    id: 3,
    name: "Pedro da Cunha",
    email: "pedro@cunha.com",
    creationDate: "2020-01-03 12:00:00",
  },
  {
    id: 4,
    name: "Ana da Silva",
    email: "ana@silva.com",
    creationDate: "2020-01-04 13:00:00",
  },
  {
    id: 5,
    name: "José da Costa",
    email: "jose@costa.com",
    creationDate: "2020-01-05 14:00:00",
  },
  {
    id: 6,
    name: "Carlos Pereira",
    email: "carlos@pereira.com",
    creationDate: "2020-01-06 15:00:00",
  },
  {
    id: 7,
    name: "Fernanda Souza",
    email: "fernanda@souza.com",
    creationDate: "2020-01-07 16:00:00",
  },
  {
    id: 8,
    name: "Paulo Oliveira",
    email: "paulo@oliveira.com",
    creationDate: "2020-01-08 17:00:00",
  },
  {
    id: 9,
    name: "Juliana Mendes",
    email: "juliana@mendes.com",
    creationDate: "2020-01-09 18:00:00",
  },
  {
    id: 10,
    name: "Ricardo Lima",
    email: "ricardo@lima.com",
    creationDate: "2020-01-10 19:00:00",
  },
  {
    id: 11,
    name: "Rafaela Campos",
    email: "rafaela@campos.com",
    creationDate: "2020-01-11 20:00:00",
  },
  {
    id: 12,
    name: "Mariana Rocha",
    email: "mariana@rocha.com",
    creationDate: "2020-01-12 21:00:00",
  },
  {
    id: 13,
    name: "Gustavo Ribeiro",
    email: "gustavo@ribeiro.com",
    creationDate: "2020-01-13 22:00:00",
  },
  {
    id: 14,
    name: "Patrícia Silva",
    email: "patricia@silva.com",
    creationDate: "2020-01-14 23:00:00",
  },
  {
    id: 15,
    name: "Roberto Almeida",
    email: "roberto@almeida.com",
    creationDate: "2020-01-15 24:00:00",
  },
];

export default {
  name: "users",
  components: {
    Card,
    Modal,
  },
  data() {
    return {
      usersTable: {
        title: "Usuários",
        subTitle: "Listagem de usuários",
        columns: ["Name", "Email", "Creation Date"],
        data: users,
      },
      filters: {
        search: "",
        sortColumn: null,
        sortDirection: "asc",
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
    viewUser(user) {
      this.selectedUser = user;
      this.modals.viewUser = true;
    },
    editUser(user) {
      // Implement edit user action
    },
    deleteUser(user) {
      // Implement delete user action
      this.usersTable.data = this.usersTable.data.filter(
        (u) => u.id !== user.id
      );
      this.modals.confirmDelete = false;
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
