<template>
  <div class="content">
    <div class="fixed-plugin">
      <base-dropdown
        ref="dropdown"
        tag="li"
        :menu-on-right="!$rtl.isRTL"
        title-tag="a"
        class="nav-item"
        menu-classes="dropdown-navbar"
        style="
          list-style-type: none;
          position: relative;
          background-color: #1e1e2f;
          opacity: 0.8;
          border-top-left-radius: 10px;
          border-bottom-left-radius: 10px;
        "
      >
        <a
          slot="title"
          href="#"
          class="dropdown-toggle nav-link justify-content-center d-flex align-items-center"
          data-toggle="dropdown"
          aria-expanded="true"
          style="position: relative; right: 0"
        >
          <i class="fa fa-cog fa-2x mx-auto"></i>
        </a>
        <div class="dropdown-menu">
          <li class="header-title">Configurações</li>
          <li
            class="adjustments-line text-center d-flex flex-row align-items-center justify-content-center"
          >
            <a
              href="#"
              class="badge-colors text-white d-flex align-items-center"
              @click.prevent="setLightMode"
            >
              <span class="badge light-badge"></span>&nbsp;&nbsp;Light
            </a>
            <span style="margin-left: 25px; margin-right: 25px">&nbsp;</span>
            <a
              href="#"
              class="badge-colors text-white d-flex align-items-center"
              @click.prevent="setDarkMode"
            >
              <span class="badge dark-badge"></span>&nbsp;&nbsp;Dark
            </a>
          </li>
        </div>
      </base-dropdown>
    </div>
    <fade-transition :duration="100" mode="out-in">
      <!-- your content here -->
      <router-view></router-view>
    </fade-transition>
  </div>
</template>

<script>
import { FadeTransition } from "vue2-transitions";

export default {
  components: {
    FadeTransition,
  },
  mounted() {
    this.adjustDropdownPosition();
    const theme = localStorage.getItem("theme");
    if (theme === "dark") {
      this.setDarkMode();
    } else {
      this.setLightMode();
    }
  },
  methods: {
    setLightMode() {
      localStorage.setItem("theme", "light");
      document.body.classList.add("white-content");
    },
    setDarkMode() {
      localStorage.setItem("theme", "dark");
      document.body.classList.remove("white-content");
    },
    adjustDropdownPosition() {
      const dropdown = this.$refs.dropdown.$el.querySelector(".dropdown-menu");
      if (dropdown) {
        dropdown.style.transform = "translateX(-75px) translateY(0px)";
      }
    },
  },
};
</script>

<style scoped>
.fixed-plugin .dropdown-navbar {
  position: absolute;
  transform: translate(-75px, 0px); /* Ajuste conforme necessário */
  padding: 10px;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
  background-color: #1e1e2f;
  opacity: 0.8;
}

.fixed-plugin .dropdown .dropdown-menu {
  top: 25px !important;
  background-color: #1e1e2f;
  opacity: 0.8;
}

.fixed-plugin .dropdown .dropdown-menu::after {
  border-left: 0.4em solid #1e1e2f;
  opacity: 0.8;
}

.fixed-plugin .dropdown-toggle {
  position: relative;
  z-index: 1;
}

.dropdown-menu {
  display: none;
}

.dropdown-toggle[aria-expanded="true"] + .dropdown-menu {
  display: block;
}

/* Remover os carets (triângulos) */
.fixed-plugin .dropdown-toggle::after {
  display: none;
}

.fixed-plugin .dropdown .dropdown-toggle::after {
  display: none;
}
</style>
