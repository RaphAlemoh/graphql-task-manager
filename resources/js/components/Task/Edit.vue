<template>
  <div>
    <div class="container mt-2">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              Update Task
              <router-link :to="{ name: 'tasks' }" class="float-right"
                >Back</router-link
              >
            </div>

            <div class="card-body">
              <form @submit.prevent="updateTask">
                <div class="form-group row">
                  <label
                    for="name"
                    class="col-md-4 col-form-label text-md-right"
                    >Task Description</label
                  >

                  <div class="col-md-6">
                    <input
                      id="name"
                      v-model="form.name"
                      type="text"
                      class="form-control"
                      required
                    />
                  </div>
                </div>

                <div class="form-group row mb-0 mt-4">
                  <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                      Update Task
                    </button>
                  </div>
                </div>
              </form>
            </div>
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
      tasks: [],
      form: {
        name: "",
      },
    };
  },
  created() {
    this.getTask();
  },
  methods: {
    getTask() {
      axios
        .get("/api/tasks/" + this.$route.params.id)
        .then((res) => {
          this.form = res.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    updateTask() {
      axios
        .put("/api/tasks/" + this.$route.params.id, {
          name: this.form.name,
        })
        .then((res) => {
          this.$router.push({ name: "tasks" });
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>

<style></style>
