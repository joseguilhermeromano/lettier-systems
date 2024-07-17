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
          <card :title="studentsTable.title" :subTitle="studentsTable.subTitle">
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
                  <i class="fas fa-plus"></i> Novo Estudante
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
                    <th @click="setSortColumn('cpf')">
                      CPF <i class="fas" :class="sortIcon('cpf')"></i>
                    </th>
                    <th @click="setSortColumn('birthday')">
                      Data de Nascimento
                      <i class="fas" :class="sortIcon('birthday')"></i>
                    </th>
                    <th @click="setSortColumn('gender')">
                      Gênero <i class="fas" :class="sortIcon('gender')"></i>
                    </th>
                    <th @click="setSortColumn('phone_number')">
                      Telefone
                      <i class="fas" :class="sortIcon('phone_number')"></i>
                    </th>
                    <th class="text-center">Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="student in paginatedStudents" :key="student.id">
                    <td>{{ student.name }}</td>
                    <td>{{ student.email }}</td>
                    <td>{{ formatCPF(student.cpf) }}</td>
                    <td>{{ formatDate(student.birthday) }}</td>
                    <td>{{ translateGender(student.gender) }}</td>
                    <td>{{ formatPhone(student.phone_number) }}</td>
                    <td class="text-center">
                      <a href="#" @click.prevent="viewStudent(student)">
                        <i
                          style="color: deepskyblue; margin: 10px"
                          class="fas fa-eye me-1"
                        ></i>
                      </a>
                      <a href="#" @click.prevent="editStudent(student)">
                        <i
                          style="color: deepskyblue; margin: 10px"
                          class="fas fa-edit me-1"
                        ></i>
                      </a>
                      <a
                        href="#"
                        @click.prevent="confirmDeleteStudent(student)"
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
      <div>Você tem certeza que deseja excluir o estudante?</div>
      <template slot="footer">
        <base-button type="secondary" @click="modals.confirmDelete = false"
          >Cancelar</base-button
        >
        <base-button type="success" @click="deleteStudentConfirmed"
          >Confirmar</base-button
        >
      </template>
    </modal>

    <!-- Modal de Visualização de Estudante -->
    <modal :show.sync="modals.viewStudent">
      <template slot="header">
        <h5 class="modal-title">Detalhes do Estudante</h5>
      </template>
      <div v-if="selectedStudent">
        <p><strong>Nome:</strong> {{ selectedStudent.name }}</p>
        <p><strong>Email:</strong> {{ selectedStudent.email }}</p>
        <p><strong>CPF:</strong> {{ formatCPF(selectedStudent.cpf) }}</p>
        <p>
          <strong>Data de Nascimento:</strong>
          {{ formatDate(selectedStudent.birthday) }}
        </p>
        <p>
          <strong>Gênero:</strong> {{ translateGender(selectedStudent.gender) }}
        </p>
        <p>
          <strong>Telefone:</strong>
          {{ formatPhone(selectedStudent.phone_number) }}
        </p>
      </div>
      <template slot="footer">
        <base-button type="secondary" @click="modals.viewStudent = false"
          >Fechar</base-button
        >
      </template>
    </modal>
  </div>
</template>

<script>
import { Card, Modal } from "@/components/index";
import BaseAlert from "@/components/BaseAlert.vue";
import axios from "@/axios";

export default {
  name: "students",
  components: {
    Card,
    Modal,
    BaseAlert,
  },
  data() {
    return {
      studentsTable: {
        title: "Estudantes",
        subTitle: "Listagem de estudantes",
        columns: ["Name", "Email", "CPF", "Birthday", "Gender", "Phone Number"],
        data: [],
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
        viewStudent: false,
      },
      selectedStudent: null,
      alert: {
        visible: false,
        message: "",
        type: "success",
      },
    };
  },
  computed: {
    filteredStudents() {
      let filtered = this.studentsTable.data;

      if (this.filters.search) {
        filtered = filtered.filter(
          (student) =>
            student.name
              .toLowerCase()
              .includes(this.filters.search.toLowerCase()) ||
            student.email
              .toLowerCase()
              .includes(this.filters.search.toLowerCase()) ||
            student.cpf
              .toLowerCase()
              .includes(this.filters.search.toLowerCase()) ||
            student.birthday
              .toLowerCase()
              .includes(this.filters.search.toLowerCase()) ||
            student.gender
              .toLowerCase()
              .includes(this.filters.search.toLowerCase()) ||
            student.phone_number
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
    paginatedStudents() {
      const start = (this.currentPage - 1) * this.perPage;
      const end = start + this.perPage;
      return this.filteredStudents.slice(start, end);
    },
    totalPages() {
      return Math.ceil(this.filteredStudents.length / this.perPage);
    },
  },
  methods: {
    async listStudents() {
      try {
        const response = await axios.get("/students/list");
        this.studentsTable.data = response.data;
      } catch (error) {
        console.error("Erro ao listar os estudantes:", error);
      }
    },
    viewStudent(student) {
      this.selectedStudent = student;
      this.modals.viewStudent = true;
    },
    editStudent(student) {
      // Implement edit student action
    },
    async deleteStudent(student) {
      // Implement delete student action
      this.studentsTable.data = this.studentsTable.data.filter(
        (u) => u.id !== student.id
      );
      this.modals.confirmDelete = false;

      try {
        const response = await axios.delete("/students/delete/" + student.id);
        if (response.data.id) {
          this.showAlert("Estudante removido com sucesso!", "success");
        }
      } catch (error) {
        this.showAlert("Erro ao remover estudante", "error");
      }
    },
    confirmDeleteStudent(student) {
      this.selectedStudent = student;
      this.modals.confirmDelete = true;
    },
    deleteStudentConfirmed() {
      this.deleteStudent(this.selectedStudent);
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
    showAlert(message, type) {
      this.alert.message = message;
      this.alert.type = type;
      this.alert.visible = true;
      setTimeout(() => {
        this.alert.visible = false;
      }, 3000);
    },
    formatCPF(cpf) {
      return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
    },
    formatPhone(phone) {
      return phone.replace(/(\d{2})(\d{5})(\d{4})/, "($1) $2-$3");
    },
    formatDate(date) {
      return new Date(date).toLocaleDateString("pt-BR", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
      });
    },
    translateGender(gender) {
      const genderMap = {
        male: "Masculino",
        female: "Feminino",
        other: "Outro",
      };
      return genderMap[gender] || gender;
    },
  },
  mounted() {
    this.listStudents();
  },
};
</script>

<style scoped>
.alert-top {
  position: fixed;
  top: 0;
  width: 100%;
  z-index: 1000;
}

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
