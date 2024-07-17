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
          <card :title="coursesTable.title" :subTitle="coursesTable.subTitle">
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
                  <i class="fas fa-plus"></i> Novo Curso
                </button>
              </div>
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th @click="setSortColumn('name')">
                      Nome <i class="fas" :class="sortIcon('name')"></i>
                    </th>
                    <th @click="setSortColumn('description')">
                      Descrição
                      <i class="fas" :class="sortIcon('description')"></i>
                    </th>
                    <th @click="setSortColumn('start_date')">
                      Data de Início
                      <i class="fas" :class="sortIcon('start_date')"></i>
                    </th>
                    <th @click="setSortColumn('end_date')">
                      Data Final
                      <i class="fas" :class="sortIcon('end_date')"></i>
                    </th>
                    <th class="text-center">Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="course in paginatedCourses" :key="course.id">
                    <td>{{ course.name }}</td>
                    <td>{{ course.description }}</td>
                    <td>{{ formatDate(course.start_date) }}</td>
                    <td>{{ formatDate(course.end_date) }}</td>
                    <td class="text-center">
                      <a href="#" @click.prevent="viewCourse(course)">
                        <i
                          style="color: deepskyblue; margin: 10px"
                          class="fas fa-eye me-1"
                        ></i>
                      </a>
                      <a href="#" @click.prevent="editCourse(course)">
                        <i
                          style="color: deepskyblue; margin: 10px"
                          class="fas fa-edit me-1"
                        ></i>
                      </a>
                      <a href="#" @click.prevent="confirmDeleteCourse(course)">
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
      <div>Você tem certeza que deseja excluir o curso?</div>
      <template slot="footer">
        <base-button type="secondary" @click="modals.confirmDelete = false"
          >Cancelar</base-button
        >
        <base-button type="success" @click="deleteCourseConfirmed"
          >Confirmar</base-button
        >
      </template>
    </modal>

    <!-- Modal de Visualização de Curso -->
    <modal :show.sync="modals.viewCourse">
      <template slot="header">
        <h5 class="modal-title">Detalhes do Curso</h5>
      </template>
      <div v-if="selectedCourse">
        <p><strong>Nome:</strong> {{ selectedCourse.name }}</p>
        <p><strong>Descrição:</strong> {{ selectedCourse.description }}</p>
        <p>
          <strong>Data de Início:</strong>
          {{ formatDate(selectedCourse.start_date) }}
        </p>
        <p>
          <strong>Data Final:</strong> {{ formatDate(selectedCourse.end_date) }}
        </p>
      </div>
      <template slot="footer">
        <base-button type="secondary" @click="modals.viewCourse = false"
          >Fechar</base-button
        >
      </template>
    </modal>
  </div>
</template>

<script>
import { Card, Modal, BaseAlert, BaseButton } from "@/components/index";
import axios from "@/axios";

export default {
  name: "courses",
  components: {
    Card,
    Modal,
    BaseAlert,
    BaseButton,
  },
  data() {
    return {
      coursesTable: {
        title: "Cursos",
        subTitle: "Listagem de cursos",
        columns: ["Name", "Description", "Start Date", "End Date"],
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
        viewCourse: false,
      },
      selectedCourse: null,
    };
  },
  computed: {
    filteredCourses() {
      let filtered = this.coursesTable.data;

      if (this.filters.search) {
        filtered = filtered.filter(
          (course) =>
            course.name
              .toLowerCase()
              .includes(this.filters.search.toLowerCase()) ||
            course.description
              .toLowerCase()
              .includes(this.filters.search.toLowerCase()) ||
            course.start_date
              .toLowerCase()
              .includes(this.filters.search.toLowerCase()) ||
            course.end_date
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
    paginatedCourses() {
      const start = (this.currentPage - 1) * this.perPage;
      const end = start + this.perPage;
      return this.filteredCourses.slice(start, end);
    },
    totalPages() {
      return Math.ceil(this.filteredCourses.length / this.perPage);
    },
  },
  methods: {
    loadCourses() {
      axios
        .get("/courses/list")
        .then((response) => {
          this.coursesTable.data = response.data;
        })
        .catch((error) => {
          console.error("Não foi possível carregar os cursos.", error);
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
    viewCourse(course) {
      this.selectedCourse = course;
      this.modals.viewCourse = true;
    },
    editCourse(course) {
      // Implement edit course action
      this.showAlert(`Curso ${course.name} editado com sucesso!`, "info");
    },
    deleteCourse(course) {
      axios
        .delete(`/courses/delete/${course.id}`)
        .then(() => {
          this.coursesTable.data = this.coursesTable.data.filter(
            (u) => u.id !== course.id
          );
          this.modals.confirmDelete = false;
          this.showAlert("Curso excluído com sucesso!", "success");
        })
        .catch((error) => {
          console.error("Erro ao tentar remover um curso", error);
          this.showAlert("Erro ao excluir um curso", "danger");
        });
    },
    confirmDeleteCourse(course) {
      this.selectedCourse = course;
      this.modals.confirmDelete = true;
    },
    deleteCourseConfirmed() {
      this.deleteCourse(this.selectedCourse);
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
    this.loadCourses();
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
