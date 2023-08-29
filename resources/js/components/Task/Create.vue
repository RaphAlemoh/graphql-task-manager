<template>
  <div>
    <div class="container mt-2">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              Create Task
              <router-link :to="{ name: 'tasks' }" class="float-right"
                >Back</router-link
              >
            </div>

            <div class="card-body">
              <form @submit.prevent="storeTask">
                <div class="form-group row mb-2">
                  <label
                    for="name"
                    class="col-md-4 col-form-label text-md-right"
                    >Task Name</label
                  >
                  <div class="col-md-6">
                    <input
                      id="name"
                      v-model="form.title"
                      type="text"
                      class="form-control"
                      required
                    />
                  </div>
                </div>

                <div class="form-group row mb-2">
                  <label
                    for="name"
                    class="col-md-4 col-form-label text-md-right"
                    >Task Description</label
                  >
                  <div class="col-md-6">
                    <textarea
                      v-model="form.description"
                      type="text"
                      class="form-control"
                      id="description"
                      cols="30"
                      rows="10"
                      required
                    ></textarea>
                  </div>
                </div>

                <div class="form-group row mb-2">
                  <label
                    for="name"
                    class="col-md-4 col-form-label text-md-right"
                    >Due Date</label
                  >
                  <div class="col-md-6">
                    <input
                      id="name"
                      v-model="form.due_date"
                      type="date"
                      class="form-control"
                      required
                    />
                  </div>
                </div>

                <div class="form-group row mb-2">
                  <label
                    for="name"
                    class="col-md-4 col-form-label text-md-right"
                    >Task Status</label
                  >
                  <div class="col-md-6">
                    <select
                      class="form-select"
                      v-model="form.status"
                      aria-label="Task status"
                    >
                      <option value="not started">Not Started</option>
                      <option value="in progress">In Progress</option>
                      <option value="completed">Completed</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row mb-0 mt-4">
                  <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                      Create
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
        title: "",
        description: "",
        status: "",
        due_date: "",
      },
    };
  },
  created() {
    this.getTasks();
  },
  methods: {
    getTasks() {
      axios
        .get("/api/tasks")
        .then((res) => {
          this.tasks = res.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    storeTask() {
      axios
        .post("/api/tasks", this.form)
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
