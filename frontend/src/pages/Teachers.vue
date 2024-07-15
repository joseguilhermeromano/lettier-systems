<template>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <card :title="teachersTable.title" :subTitle="teachersTable.subTitle">
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
                  <i class="fas fa-plus"></i> Novo Professor
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
                    <th @click="setSortColumn('phone_number')">
                      Telefone
                      <i class="fas" :class="sortIcon('phone_number')"></i>
                    </th>
                    <th class="text-center">Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="teacher in paginatedTeachers" :key="teacher.id">
                    <td>{{ teacher.name }}</td>
                    <td>{{ teacher.email }}</td>
                    <td>{{ teacher.phone_number }}</td>
                    <td class="text-center">
                      <a href="#" @click.prevent="viewTeacher(teacher)">
                        <i
                          style="color: deepskyblue; margin: 10px"
                          class="fas fa-eye me-1"
                        ></i>
                      </a>
                      <a href="#" @click.prevent="editTeacher(teacher)">
                        <i
                          style="color: deepskyblue; margin: 10px"
                          class="fas fa-edit me-1"
                        ></i>
                      </a>
                      <a
                        href="#"
                        @click.prevent="confirmDeleteTeacher(teacher)"
                      >
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
      <div>Você tem certeza que deseja excluir o professor?</div>
      <template slot="footer">
        <base-button type="secondary" @click="modals.confirmDelete = false"
          >Cancelar</base-button
        >
        <base-button type="success" @click="deleteTeacherConfirmed"
          >Confirmar</base-button
        >
      </template>
    </modal>

    <!-- Modal de Visualização de Professor -->
    <modal :show.sync="modals.viewTeacher">
      <template slot="header">
        <h5 class="modal-title">Detalhes do Professor</h5>
      </template>
      <div v-if="selectedTeacher">
        <p><strong>Nome:</strong> {{ selectedTeacher.name }}</p>
        <p><strong>Email:</strong> {{ selectedTeacher.email }}</p>
        <p><strong>Telefone:</strong> {{ selectedTeacher.phone_number }}</p>
      </div>
      <template slot="footer">
        <base-button type="secondary" @click="modals.viewTeacher = false"
          >Fechar</base-button
        >
      </template>
    </modal>
  </div>
</template>

<script>
import { Card, Modal } from "@/components/index";

const teachers = [
  {
    id: 1,
    name: "João da Silva",
    email: "joao@silva.com",
    phone_number: "(11) 1234-5678",
  },
  {
    id: 2,
    name: "Maria da Costa",
    email: "maria@costa.com",
    phone_number: "(11) 2345-6789",
  },
  {
    id: 3,
    name: "Pedro da Cunha",
    email: "pedro@cunha.com",
    phone_number: "(11) 3456-7890",
  },
  {
    id: 4,
    name: "Ana da Silva",
    email: "ana@silva.com",
    phone_number: "(11) 4567-8901",
  },
  {
    id: 5,
    name: "José da Costa",
    email: "jose@costa.com",
    phone_number: "(11) 5678-9012",
  },
  {
    id: 6,
    name: "Carlos Pereira",
    email: "carlos@pereira.com",
    phone_number: "(11) 6789-0123",
  },
  {
    id: 7,
    name: "Fernanda Souza",
    email: "fernanda@souza.com",
    phone_number: "(11) 7890-1234",
  },
  {
    id: 8,
    name: "Paulo Oliveira",
    email: "paulo@oliveira.com",
    phone_number: "(11) 8901-2345",
  },
  {
    id: 9,
    name: "Juliana Mendes",
    email: "juliana@mendes.com",
    phone_number: "(11) 9012-3456",
  },
  {
    id: 10,
    name: "Ricardo Lima",
    email: "ricardo@lima.com",
    phone_number: "(11) 0123-4567",
  },
];

export default {
  name: "teachers",
  components: {
    Card,
    Modal,
  },
  data() {
    return {
      teachersTable: {
        title: "Professores",
        subTitle: "Listagem de professores",
        columns: ["Name", "Email", "Phone Number"],
        data: teachers,
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
        viewTeacher: false,
      },
      selectedTeacher: null,
    };
  },
  computed: {
    filteredTeachers() {
      let filtered = this.teachersTable.data;

      if (this.filters.search) {
        filtered = filtered.filter(
          (teacher) =>
            teacher.name
              .toLowerCase()
              .includes(this.filters.search.toLowerCase()) ||
            teacher.email
              .toLowerCase()
              .includes(this.filters.search.toLowerCase()) ||
            teacher.phone_number
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
    paginatedTeachers() {
      const start = (this.currentPage - 1) * this.perPage;
      const end = start + this.perPage;
      return this.filteredTeachers.slice(start, end);
    },
    totalPages() {
      return Math.ceil(this.filteredTeachers.length / this.perPage);
    },
  },
  methods: {
    viewTeacher(teacher) {
      this.selectedTeacher = teacher;
      this.modals.viewTeacher = true;
    },
    editTeacher(teacher) {
      // Implement edit teacher action
    },
    deleteTeacher(teacher) {
      // Implement delete teacher action
      this.teachersTable.data = this.teachersTable.data.filter(
        (u) => u.id !== teacher.id
      );
      this.modals.confirmDelete = false;
    },
    confirmDeleteTeacher(teacher) {
      this.selectedTeacher = teacher;
      this.modals.confirmDelete = true;
    },
    deleteTeacherConfirmed() {
      this.deleteTeacher(this.selectedTeacher);
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
