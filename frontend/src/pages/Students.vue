<template>
  <div class="content">
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
                    <td>{{ student.cpf }}</td>
                    <td>{{ student.birthday }}</td>
                    <td>{{ student.gender }}</td>
                    <td>{{ student.phone_number }}</td>
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
        <p><strong>CPF:</strong> {{ selectedStudent.cpf }}</p>
        <p>
          <strong>Data de Nascimento:</strong> {{ selectedStudent.birthday }}
        </p>
        <p><strong>Gênero:</strong> {{ selectedStudent.gender }}</p>
        <p><strong>Telefone:</strong> {{ selectedStudent.phone_number }}</p>
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

const students = [
  {
    id: 1,
    name: "João da Silva",
    email: "joao@silva.com",
    cpf: "123.456.789-00",
    birthday: "2000-01-01",
    gender: "Masculino",
    phone_number: "(11) 1234-5678",
  },
  {
    id: 2,
    name: "Maria da Costa",
    email: "maria@costa.com",
    cpf: "234.567.890-11",
    birthday: "2001-02-02",
    gender: "Feminino",
    phone_number: "(11) 2345-6789",
  },
  {
    id: 3,
    name: "Pedro da Cunha",
    email: "pedro@cunha.com",
    cpf: "345.678.901-22",
    birthday: "2002-03-03",
    gender: "Masculino",
    phone_number: "(11) 3456-7890",
  },
  {
    id: 4,
    name: "Ana da Silva",
    email: "ana@silva.com",
    cpf: "456.789.012-33",
    birthday: "2003-04-04",
    gender: "Feminino",
    phone_number: "(11) 4567-8901",
  },
  {
    id: 5,
    name: "José da Costa",
    email: "jose@costa.com",
    cpf: "567.890.123-44",
    birthday: "2004-05-05",
    gender: "Masculino",
    phone_number: "(11) 5678-9012",
  },
  {
    id: 6,
    name: "Carlos Pereira",
    email: "carlos@pereira.com",
    cpf: "678.901.234-55",
    birthday: "2005-06-06",
    gender: "Masculino",
    phone_number: "(11) 6789-0123",
  },
  {
    id: 7,
    name: "Fernanda Souza",
    email: "fernanda@souza.com",
    cpf: "789.012.345-66",
    birthday: "2006-07-07",
    gender: "Feminino",
    phone_number: "(11) 7890-1234",
  },
  {
    id: 8,
    name: "Paulo Oliveira",
    email: "paulo@oliveira.com",
    cpf: "890.123.456-77",
    birthday: "2007-08-08",
    gender: "Masculino",
    phone_number: "(11) 8901-2345",
  },
  {
    id: 9,
    name: "Juliana Mendes",
    email: "juliana@mendes.com",
    cpf: "901.234.567-88",
    birthday: "2008-09-09",
    gender: "Feminino",
    phone_number: "(11) 9012-3456",
  },
  {
    id: 10,
    name: "Ricardo Lima",
    email: "ricardo@lima.com",
    cpf: "012.345.678-99",
    birthday: "2009-10-10",
    gender: "Masculino",
    phone_number: "(11) 0123-4567",
  },
  {
    id: 11,
    name: "Rafaela Campos",
    email: "rafaela@campos.com",
    cpf: "123.456.789-00",
    birthday: "2010-11-11",
    gender: "Feminino",
    phone_number: "(11) 1234-5678",
  },
  {
    id: 12,
    name: "Mariana Rocha",
    email: "mariana@rocha.com",
    cpf: "234.567.890-11",
    birthday: "2011-12-12",
    gender: "Feminino",
    phone_number: "(11) 2345-6789",
  },
  {
    id: 13,
    name: "Gustavo Ribeiro",
    email: "gustavo@ribeiro.com",
    cpf: "345.678.901-22",
    birthday: "2012-01-01",
    gender: "Masculino",
    phone_number: "(11) 3456-7890",
  },
  {
    id: 14,
    name: "Patrícia Silva",
    email: "patricia@silva.com",
    cpf: "456.789.012-33",
    birthday: "2013-02-02",
    gender: "Feminino",
    phone_number: "(11) 4567-8901",
  },
  {
    id: 15,
    name: "Roberto Almeida",
    email: "roberto@almeida.com",
    cpf: "567.890.123-44",
    birthday: "2014-03-03",
    gender: "Masculino",
    phone_number: "(11) 5678-9012",
  },
];

export default {
  name: "students",
  components: {
    Card,
    Modal,
  },
  data() {
    return {
      studentsTable: {
        title: "Estudantes",
        subTitle: "Listagem de estudantes",
        columns: ["Name", "Email", "CPF", "Birthday", "Gender", "Phone Number"],
        data: students,
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
    viewStudent(student) {
      this.selectedStudent = student;
      this.modals.viewStudent = true;
    },
    editStudent(student) {
      // Implement edit student action
    },
    deleteStudent(student) {
      // Implement delete student action
      this.studentsTable.data = this.studentsTable.data.filter(
        (u) => u.id !== student.id
      );
      this.modals.confirmDelete = false;
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
