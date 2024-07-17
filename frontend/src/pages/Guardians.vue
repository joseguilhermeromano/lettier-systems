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
          <card
            :title="guardiansTable.title"
            :subTitle="guardiansTable.subTitle"
          >
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
                  <i class="fas fa-plus"></i> Novo Responsável
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
                    <th @click="setSortColumn('relationship')">
                      Parentesco
                      <i class="fas" :class="sortIcon('relationship')"></i>
                    </th>
                    <th class="text-center">Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="guardian in paginatedGuardians" :key="guardian.id">
                    <td>{{ guardian.name }}</td>
                    <td>{{ guardian.email }}</td>
                    <td>{{ formatPhoneNumber(guardian.phone_number) }}</td>
                    <td>{{ translateRelationship(guardian.relationship) }}</td>
                    <td class="text-center">
                      <a href="#" @click.prevent="viewGuardian(guardian)">
                        <i
                          style="color: deepskyblue; margin: 10px"
                          class="fas fa-eye me-1"
                        ></i>
                      </a>
                      <a href="#" @click.prevent="editGuardian(guardian)">
                        <i
                          style="color: deepskyblue; margin: 10px"
                          class="fas fa-edit me-1"
                        ></i>
                      </a>
                      <a
                        href="#"
                        @click.prevent="confirmDeleteGuardian(guardian)"
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
      <div>Você tem certeza que deseja excluir o responsável?</div>
      <template slot="footer">
        <base-button type="secondary" @click="modals.confirmDelete = false"
          >Cancelar</base-button
        >
        <base-button type="success" @click="deleteGuardianConfirmed"
          >Confirmar</base-button
        >
      </template>
    </modal>

    <!-- Modal de Visualização de Responsável -->
    <modal :show.sync="modals.viewGuardian">
      <template slot="header">
        <h5 class="modal-title">Detalhes do Responsável</h5>
      </template>
      <div v-if="selectedGuardian">
        <p><strong>Nome:</strong> {{ selectedGuardian.name }}</p>
        <p><strong>Email:</strong> {{ selectedGuardian.email }}</p>
        <p>
          <strong>Telefone:</strong>
          {{ formatPhoneNumber(selectedGuardian.phone_number) }}
        </p>
        <p>
          <strong>Parentesco:</strong>
          {{ translateRelationship(selectedGuardian.relationship) }}
        </p>
      </div>
      <template slot="footer">
        <base-button type="secondary" @click="modals.viewGuardian = false"
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
  name: "guardians",
  components: {
    Card,
    BaseAlert,
    Modal,
  },
  data() {
    return {
      guardiansTable: {
        title: "Pais/Responsáveis",
        subTitle: "Listagem de pais/responsáveis",
        columns: ["Name", "Email", "Phone Number", "Relationship"],
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
        viewGuardian: false,
      },
      selectedGuardian: null,
      alert: {
        visible: false,
        type: "",
        message: "",
      },
    };
  },
  created() {
    this.fetchGuardians();
  },
  computed: {
    filteredGuardians() {
      let filtered = this.guardiansTable.data;

      if (this.filters.search) {
        filtered = filtered.filter(
          (guardian) =>
            guardian.name
              .toLowerCase()
              .includes(this.filters.search.toLowerCase()) ||
            guardian.email
              .toLowerCase()
              .includes(this.filters.search.toLowerCase()) ||
            guardian.phone_number
              .toLowerCase()
              .includes(this.filters.search.toLowerCase()) ||
            this.translateRelationship(guardian.relationship)
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
    paginatedGuardians() {
      const start = (this.currentPage - 1) * this.perPage;
      const end = start + this.perPage;
      return this.filteredGuardians.slice(start, end);
    },
    totalPages() {
      return Math.ceil(this.filteredGuardians.length / this.perPage);
    },
  },
  methods: {
    fetchGuardians() {
      axios
        .get("/guardians/list")
        .then((response) => {
          this.guardiansTable.data = response.data;
        })
        .catch((error) => {
          console.error("Não foi possível carregar os responsáveis.", error);
        });
    },
    formatPhoneNumber(phoneNumber) {
      // Format the phone number as desired, e.g., (XX) XXXX-XXXX
      return phoneNumber.replace(/(\d{2})(\d{4})(\d{4})/, "($1) $2-$3");
    },
    translateRelationship(relationship) {
      const relationships = {
        father: "Pai",
        mother: "Mãe",
        brother: "Irmão",
        sister: "Irmã",
        uncle: "Tio",
        aunt: "Tia",
        grandfather: "Avô",
        grandmother: "Avó",
        cousin: "Primo",
        other: "Outro",
        guardian: "Responsável",
      };
      return relationships[relationship] || relationship;
    },
    viewGuardian(guardian) {
      this.selectedGuardian = guardian;
      this.modals.viewGuardian = true;
    },
    editGuardian(guardian) {
      // Implement edit guardian action
    },
    deleteGuardian(guardian) {
      axios
        .delete(`/guardians/delete/${guardian.id}`)
        .then(() => {
          this.guardiansTable.data = this.guardiansTable.data.filter(
            (u) => u.id !== guardian.id
          );
          this.modals.confirmDelete = false;
          this.showAlert("Responsável excluído com sucesso!", "success");
        })
        .catch((error) => {
          console.error("Erro ao tentar remover um responsável", error);
          this.showAlert("Erro ao excluir um responsável", "danger");
        });
    },
    confirmDeleteGuardian(guardian) {
      this.selectedGuardian = guardian;
      this.modals.confirmDelete = true;
    },
    deleteGuardianConfirmed() {
      this.deleteGuardian(this.selectedGuardian);
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
