
<template>
  <div class="container mt-2">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card card-default">
          <div class="card-header">Login</div>

          <div class="card-body">
            <form>
              <div class="form-group row mt-2">
                <label for="email" class="col-sm-4 col-form-label text-md-right"
                  >E-Mail Address</label
                >

                <div class="col-md-6">
                  <input
                    id="email"
                    type="email"
                    class="form-control"
                    v-model="email"
                    required
                    autofocus
                  />
                </div>
              </div>

              <div class="form-group row mt-2">
                <label
                  for="password"
                  class="col-md-4 col-form-label text-md-right"
                  >Password</label
                >

                <div class="col-md-6">
                  <input
                    id="password"
                    type="password"
                    class="form-control"
                    v-model="password"
                    required
                  />
                </div>
              </div>

              <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4 mt-2">
                  <button
                    type="submit"
                    class="btn btn-primary"
                    @click="handleSubmit"
                  >
                    Login
                  </button>
                </div>
              </div>
            </form>
          </div>
          <div class="col-12 text-center">
            <label
              >Don't have an account?
              <router-link :to="{ name: 'register' }"
                >Register Now!</router-link
              ></label
            >
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
export default {
  data() {
    return {
      email: "",
      password: "",
    };
  },
  methods: {
    handleSubmit(e) {
      e.preventDefault();
      if (this.password.length > 0) {
        axios
          .post("login", {
            email: this.email,
            password: this.password,
          })
          .then((res) => {
            const response = res.data.data;
            if (response.success) {
              localStorage.setItem("name", response.name);
              localStorage.setItem("token", response.token);
              if (localStorage.getItem("token") != null) {
                this.$router.go("/dashboard");
              }
            }
          })
          .catch(function (error) {
            console.error(error);
          });
      }
    },
  },
  beforeRouteEnter(to, from, next) {
    if (localStorage.getItem("token")) {
      return next("dashboard");
    }
    next();
  },
};
</script>
