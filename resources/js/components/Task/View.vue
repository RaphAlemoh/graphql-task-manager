<template>
  <div>
    <div class="container mt-2">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card text-center">
            <div class="card-header">My Task Title</div>
            <div class="card-body" v-if="task != ''">
              <h5 class="card-title">{{ task.title }}</h5>
              <p class="card-text">
                {{ task.description }}
              </p>
              <router-link :to="{ name: 'tasks' }" class="btn btn-primary"
                >Back</router-link
              >
            </div>
            <div class="card-footer text-muted">
              Due Date {{ task.due_date }}
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
      task: {},
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
          this.task = res.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>
  
  <style></style>
  