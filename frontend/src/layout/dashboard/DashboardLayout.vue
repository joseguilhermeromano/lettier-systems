<template>
  <div class="wrapper">
    <side-bar>
      <template slot="links">
        <sidebar-link
          to="/dashboard"
          :name="$t('sidebar.dashboard')"
          icon="tim-icons icon-chart-pie-36"
        />
        <sidebar-link
          to="/students"
          :name="$t('sidebar.students')"
          icon="fa fa-graduation-cap"
        />
        <sidebar-link
          to="/guardians"
          :name="$t('sidebar.guardians')"
          icon="fa fa-user-secret"
        />
        <sidebar-link
          to="/teachers"
          :name="$t('sidebar.teachers')"
          icon="fa fa-address-card"
        />
        <sidebar-link
          to="/courses"
          :name="$t('sidebar.courses')"
          icon="fa fa-book"
        />
        <sidebar-link
          to="/classes"
          :name="$t('sidebar.classes')"
          icon="fa fa-comments"
        />
        <sidebar-link
          to="/users"
          :name="$t('sidebar.users')"
          icon="fa fa-users"
        />
      </template>
    </side-bar>
    <div data="green" class="main-panel">
      <top-navbar></top-navbar>

      <dashboard-content @click.native="toggleSidebar"> </dashboard-content>

      <content-footer></content-footer>
    </div>
  </div>
</template>
<style lang="scss"></style>
<script>
import TopNavbar from "./TopNavbar.vue";
import ContentFooter from "./ContentFooter.vue";
import DashboardContent from "./Content.vue";
import MobileMenu from "./MobileMenu";
export default {
  components: {
    TopNavbar,
    ContentFooter,
    DashboardContent,
  },
  methods: {
    toggleSidebar() {
      if (this.$sidebar.showSidebar) {
        this.$sidebar.displaySidebar(false);
      }
    },
  },
};
</script>
