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
          <card :title="classesTable.title" :subTitle="classesTable.subTitle">
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
                  <i class="fas fa-plus"></i> Nova Turma
                </button>
              </div>
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th @click="setSortColumn('name')">
                      Nome <i class="fas" :class="sortIcon('name')"></i>
                    </th>
                    <th @click="setSortColumn('start_time')">
                      Horário de Início
                      <i class="fas" :class="sortIcon('start_time')"></i>
                    </th>
                    <th @click="setSortColumn('end_time')">
                      Horário de Término
                      <i class="fas" :class="sortIcon('end_time')"></i>
                    </th>
                    <th class="text-center">Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="classItem in paginatedClasses" :key="classItem.id">
                    <td>{{ classItem.name }}</td>
                    <td>{{ classItem.start_time }}</td>
                    <td>{{ classItem.end_time }}</td>
                    <td class="text-center">
                      <a href="#" @click.prevent="viewClass(classItem)">
                        <i
                          style="color: deepskyblue; margin: 10px"
                          class="fas fa-eye me-1"
                        ></i>
                      </a>
                      <a href="#" @click.prevent="editClass(classItem)">
                        <i
                          style="color: deepskyblue; margin: 10px"
                          class="fas fa-edit me-1"
                        ></i>
                      </a>
                      <a
                        href="#"
                        @click.prevent="confirmDeleteClass(classItem)"
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
      <div>Você tem certeza que deseja excluir a turma?</div>
      <template slot="footer">
        <base-button type="secondary" @click="modals.confirmDelete = false"
          >Cancelar</base-button
        >
        <base-button type="success" @click="deleteClassConfirmed"
          >Confirmar</base-button
        >
      </template>
    </modal>

    <!-- Modal de Visualização de Turma -->
    <modal :show.sync="modals.viewClass">
      <template slot="header">
        <h5 class="modal-title">Detalhes da Turma</h5>
      </template>
      <div v-if="selectedClass">
        <p><strong>Nome:</strong> {{ selectedClass.name }}</p>
        <p>
          <strong>Horário de Início:</strong>
          {{ selectedClass.start_time }}
        </p>
        <p><strong>Horário de Término:</strong> {{ selectedClass.end_time }}</p>
      </div>
      <template slot="footer">
        <base-button type="secondary" @click="modals.viewClass = false"
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
  name: "classes",
  components: {
    Card,
    BaseAlert,
    Modal,
  },
  data() {
    return {
      classesTable: {
        title: "Turmas",
        subTitle: "Listagem de turmas",
        columns: ["Name", "Start Time", "End Time"],
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
        viewClass: false,
      },
      selectedClass: null,
    };
  },
  computed: {
    filteredClasses() {
      let filtered = this.classesTable.data;

      if (this.filters.search) {
        filtered = filtered.filter(
          (classItem) =>
            classItem.name
              .toLowerCase()
              .includes(this.filters.search.toLowerCase()) ||
            classItem.start_time
              .toLowerCase()
              .includes(this.filters.search.toLowerCase()) ||
            classItem.end_time
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
    paginatedClasses() {
      const start = (this.currentPage - 1) * this.perPage;
      const end = start + this.perPage;
      return this.filteredClasses.slice(start, end);
    },
    totalPages() {
      return Math.ceil(this.filteredClasses.length / this.perPage);
    },
  },
  methods: {
    loadClasses() {
      axios
        .get("/classes/list")
        .then((response) => {
          this.classesTable.data = response.data;
        })
        .catch((error) => {
          console.error("Não foi possível carregar as turmas.", error);
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
    viewClass(classItem) {
      this.selectedClass = classItem;
      this.modals.viewClass = true;
    },
    editClass(classItem) {
      // Implement edit class action
    },
    deleteClass(classItem) {
      axios
        .delete(`/classes/delete/${classItem.id}`)
        .then(() => {
          this.classesTable.data = this.classesTable.data.filter(
            (u) => u.id !== classItem.id
          );
          this.modals.confirmDelete = false;
          this.showAlert("Turma excluída com sucesso!", "success");
        })
        .catch((error) => {
          console.error("Erro ao tentar remover uma turma", error);
          this.showAlert("Erro ao excluir uma turma", "danger");
        });
    },
    confirmDeleteClass(classItem) {
      this.selectedClass = classItem;
      this.modals.confirmDelete = true;
    },
    deleteClassConfirmed() {
      this.deleteClass(this.selectedClass);
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
    this.loadClasses();
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
