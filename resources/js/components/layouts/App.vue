<template>
  <div>
    <nav
      class="navbar navbar-expand-lg navbar-dark bg-dark static-top"
      id="mainNav"
    >
      <div class="container px-4">
        <router-link :to="{ name: 'dashboard' }" class="navbar-brand"
          >Aptiw Dev Task Manager</router-link
        >
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarResponsive"
          aria-controls="navbarResponsive"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ms-auto" v-if="!isLoggedIn">
            <li class="nav-item">
              <router-link :to="{ name: 'login' }" class="nav-link"
                >Login</router-link
              >
            </li>
            <li class="nav-item">
              <router-link :to="{ name: 'register' }" class="nav-link"
                >Register</router-link
              >
            </li>
          </ul>
          <ul class="navbar-nav ms-auto" v-if="isLoggedIn">
            <li class="nav-item">
              <router-link
                :to="{ name: 'dashboard' }"
                class="nav-link"
                v-if="isLoggedIn"
                >Dashboard</router-link
              >
            </li>
            <li class="nav-item">
              <router-link :to="{ name: 'tasks' }" class="nav-link"
                >Tasks Board</router-link
              >
            </li>
          </ul>
          <div class="d-flex">
            <ul class="navbar-nav" v-if="isLoggedIn">
              <li class="nav-item dropdown">
                <a
                  class="nav-link dropdown-toggle"
                  href="#"
                  id="navbarDropdownMenuLink"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >
                  Hi, {{ name }}
                </a>
                <div
                  class="dropdown-menu dropdown-menu-end"
                  aria-labelledby="navbarDropdownMenuLink"
                >
                  <a
                    class="dropdown-item"
                    href="javascript:void(0)"
                    @click="logout"
                    >Logout</a
                  >
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
    <main>
      <router-view></router-view>
    </main>
  </div>
</template>
<script>
export default {
  data() {
    return {
      isLoggedIn: null,
      name: null,
    };
  },
  mounted() {
    const token = localStorage.getItem("token");
    if (token) {
      this.isLoggedIn = token;
      this.name = localStorage.getItem("name");
    }
    
  },
  methods: {
    async logout() {
      await axios.post("/logout").then((response) => {
        localStorage.clear();
        this.$router.go("/login");
      });
    },
  },
};
</script>
